<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\IncidentCategory;
use App\Models\SafePlace;
use App\Models\Alert;
use App\Models\SosRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    // Main Dashboard Router based on User Role
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'moderator') {
            return redirect()->route('moderator.dashboard');
        } elseif ($user->role === 'authority') {
            return redirect()->route('authority.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }

    // 👨💼 1. ADMIN DASHBOARD
    public function adminDashboard()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access to Admin Dashboard.');
        }

        $users = User::latest()->get();
        $staffCount = User::whereIn('role', ['admin', 'moderator', 'authority'])->count();
        $publicUserCount = User::where('role', 'public_user')->count();
        
        $totalIncidents = Incident::count();
        $verifiedIncidents = Incident::where('status', 'verified')->count();
        $pendingIncidents = Incident::where('status', 'pending')->count();
        $resolvedIncidents = Incident::where('status', 'resolved')->count();
        $activeSosCount = SosRequest::where('status', 'active')->count();

        $categoryBreakdown = IncidentCategory::withCount('incidents')->get();
        $statusCounts = [
            'Pending' => $pendingIncidents,
            'Verified' => $verifiedIncidents,
            'Resolved' => $resolvedIncidents,
            'Rejected' => Incident::where('status', 'rejected')->count(),
        ];

        return view('dashboards.admin', compact(
            'users',
            'staffCount',
            'publicUserCount',
            'totalIncidents',
            'verifiedIncidents',
            'pendingIncidents',
            'resolvedIncidents',
            'activeSosCount',
            'categoryBreakdown',
            'statusCounts'
        ));
    }

    // 👨💼 Admin Action: Add Staff (Admin, Moderator, Authority)
    public function storeStaff(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Only Admins can create staff accounts.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'role' => 'required|in:admin,moderator,authority',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->back()->with('success', "New " . strtoupper($validated['role']) . " account created for {$user->name}!");
    }

    // 🛡️ 2. MODERATOR DASHBOARD
    public function moderatorDashboard()
    {
        if (!in_array(Auth::user()->role, ['moderator', 'admin'])) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access to Moderator Dashboard.');
        }

        $pendingIncidents = Incident::with(['category', 'user', 'images'])->where('status', 'pending')->latest()->get();
        $recentVerified = Incident::with(['category', 'user'])->where('status', 'verified')->latest()->take(10)->get();
        $alerts = Alert::latest()->get();

        $stats = [
            'pending' => count($pendingIncidents),
            'verified' => Incident::where('status', 'verified')->count(),
            'rejected' => Incident::where('status', 'rejected')->count(),
        ];

        return view('dashboards.moderator', compact('pendingIncidents', 'recentVerified', 'alerts', 'stats'));
    }

    // 🚔 3. AUTHORITY DASHBOARD (Police / Emergency Response)
    public function authorityDashboard()
    {
        if (!in_array(Auth::user()->role, ['authority', 'admin'])) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access to Authority Dashboard.');
        }

        $activeSos = SosRequest::where('status', 'active')->latest()->get();
        $resolvedSos = SosRequest::where('status', 'resolved')->latest()->take(10)->get();
        
        $verifiedIncidents = Incident::with(['category', 'user'])->where('status', 'verified')->latest()->get();
        $resolvedIncidents = Incident::with(['category', 'user'])->where('status', 'resolved')->latest()->get();
        
        $safePlaces = SafePlace::all();

        return view('dashboards.authority', compact('activeSos', 'resolvedSos', 'verifiedIncidents', 'resolvedIncidents', 'safePlaces'));
    }

    // 👤 4. PUBLIC USER DASHBOARD
    public function userDashboard()
    {
        $user = Auth::user();

        $myIncidents = Incident::with(['category', 'images'])->where('user_id', $user->id)->latest()->get();
        $mySosRequests = SosRequest::where('user_id', $user->id)->latest()->get();

        $categories = IncidentCategory::all();

        return view('dashboards.user', compact('myIncidents', 'mySosRequests', 'categories'));
    }

    // Update Incident Status (Approve / Reject / Resolve)
    public function updateIncidentStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,verified,rejected,resolved',
            'moderator_notes' => 'nullable|string',
        ]);

        $incident = Incident::findOrFail($id);
        $user = Auth::user();

        $incident->status = $request->input('status');
        $incident->moderator_notes = $request->input('moderator_notes');

        if ($request->input('status') === 'verified') {
            $incident->verified_by = $user->id;
        } elseif ($request->input('status') === 'resolved') {
            $incident->resolved_by = $user->id;
        }

        $incident->save();

        return redirect()->back()->with('success', "Incident #{$id} status updated to " . strtoupper($incident->status) . "!");
    }

    // Add Safe Place (Authority / Admin)
    public function storeSafePlace(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:police,hospital,fire_station,shelter,pharmacy',
            'address' => 'required|string|max:255',
            'area_name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'phone' => 'required|string|max:20',
        ]);

        SafePlace::create($validated);

        return redirect()->back()->with('success', "New Safe Place {$validated['name']} added successfully!");
    }
}
