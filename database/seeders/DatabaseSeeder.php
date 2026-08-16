<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\IncidentCategory;
use App\Models\Incident;
use App\Models\SafePlace;
use App\Models\Alert;
use App\Models\SosRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create System Users (Admins, Moderators, Authorities, Citizens)
        $admin = User::create([
            'name' => 'Master System Admin',
            'email' => 'admin@safora.lk',
            'phone' => '0771234567',
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);

        $moderator = User::create([
            'name' => 'Safety Review Moderator',
            'email' => 'moderator@safora.lk',
            'phone' => '0777654321',
            'role' => 'moderator',
            'password' => Hash::make('password123'),
        ]);

        $authority = User::create([
            'name' => 'Habarana Police Station',
            'email' => 'police@safora.lk',
            'phone' => '0662270222',
            'role' => 'authority',
            'password' => Hash::make('password123'),
        ]);

        $authorityKandy = User::create([
            'name' => 'Kandy Central Police Station',
            'email' => 'kandy_police@safora.lk',
            'phone' => '0812222222',
            'role' => 'authority',
            'password' => Hash::make('password123'),
        ]);

        $publicUser = User::create([
            'name' => 'Kavindu Perera',
            'email' => 'user@safora.lk',
            'phone' => '0719876543',
            'role' => 'public_user',
            'password' => Hash::make('password123'),
        ]);

        $anusha = User::create([
            'name' => 'Anusha Perera',
            'email' => 'anusha@safora.lk',
            'phone' => '0781122334',
            'role' => 'public_user',
            'password' => Hash::make('password123'),
        ]);

        $sanduni = User::create([
            'name' => 'Sanduni Silva',
            'email' => 'sanduni@safora.lk',
            'phone' => '0759988776',
            'role' => 'public_user',
            'password' => Hash::make('password123'),
        ]);

        // 2. Incident Categories (Wildlife, Crime, Disaster, Road Safety)
        $categories = [
            // Wildlife Hazards
            ['name' => 'Elephant Crossing', 'type' => 'wildlife', 'icon' => 'bi-bounding-box-circles', 'risk_level' => 'high'],
            ['name' => 'Leopard Sighting', 'type' => 'wildlife', 'icon' => 'bi-eye-fill', 'risk_level' => 'high'],
            ['name' => 'Crocodile Sighting', 'type' => 'wildlife', 'icon' => 'bi-water', 'risk_level' => 'high'],
            ['name' => 'Wild Boar Attack', 'type' => 'wildlife', 'icon' => 'bi-shield-exclamation', 'risk_level' => 'medium'],
            ['name' => 'Snake Sighting', 'type' => 'wildlife', 'icon' => 'bi-bug', 'risk_level' => 'medium'],

            // Public Safety / Crime
            ['name' => 'Theft / Snatching', 'type' => 'crime', 'icon' => 'bi-bag-dash', 'risk_level' => 'medium'],
            ['name' => 'Harassment Zone', 'type' => 'crime', 'icon' => 'bi-exclamation-octagon', 'risk_level' => 'high'],
            ['name' => 'Robbery', 'type' => 'crime', 'icon' => 'bi-slash-circle', 'risk_level' => 'critical'],
            ['name' => 'Suspicious Activity', 'type' => 'crime', 'icon' => 'bi-question-circle', 'risk_level' => 'low'],

            // Disasters
            ['name' => 'Flood Warning', 'type' => 'disaster', 'icon' => 'bi-tsunami', 'risk_level' => 'critical'],
            ['name' => 'Landslide Risk', 'type' => 'disaster', 'icon' => 'bi-triangle-half', 'risk_level' => 'critical'],
            ['name' => 'Fallen Trees', 'type' => 'disaster', 'icon' => 'bi-tree', 'risk_level' => 'medium'],
            ['name' => 'Fire Hazard', 'type' => 'disaster', 'icon' => 'bi-fire', 'risk_level' => 'critical'],

            // Road Safety
            ['name' => 'Road Accident', 'type' => 'road', 'icon' => 'bi-car-front', 'risk_level' => 'high'],
            ['name' => 'Traffic Block', 'type' => 'road', 'icon' => 'bi-stop-sign', 'risk_level' => 'low'],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[$cat['name']] = IncidentCategory::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'type' => $cat['type'],
                'icon' => $cat['icon'],
                'risk_level' => $cat['risk_level'],
            ]);
        }

        // 3. Incidents Across Sri Lanka with High Precision Coordinates (Pending, Verified, Resolved, Rejected)
        Incident::create([
            'user_id' => $publicUser->id,
            'category_id' => $categoryModels['Elephant Crossing']->id,
            'title' => 'Wild Elephants crossing Habarana-Trinco Main Road',
            'description' => 'A herd of three wild elephants including a young calf spotted crossing the main highway near 14th Mile Post.',
            'latitude' => 8.0372000,
            'longitude' => 80.7517000,
            'address' => 'Habarana Highway, North Central Province',
            'area_name' => 'Habarana',
            'severity' => 'high',
            'status' => 'verified',
            'verified_by' => $moderator->id,
            'views_count' => 142,
        ]);

        Incident::create([
            'user_id' => $anusha->id,
            'category_id' => $categoryModels['Crocodile Sighting']->id,
            'title' => 'Crocodile spotted near Bentota Riverbank',
            'description' => 'Large mugger crocodile seen resting on the grassy bank near local bathing spot.',
            'latitude' => 6.4251000,
            'longitude' => 79.9984000,
            'address' => 'River Road, Bentota',
            'area_name' => 'Bentota',
            'severity' => 'high',
            'status' => 'verified',
            'verified_by' => $moderator->id,
            'views_count' => 98,
        ]);

        Incident::create([
            'user_id' => $sanduni->id,
            'category_id' => $categoryModels['Harassment Zone']->id,
            'title' => 'Poorly lit walkway near Fort Station',
            'description' => 'Streetlights non-functional for past 3 days. Frequent harassment reported by evening commuters.',
            'latitude' => 6.9344000,
            'longitude' => 79.8504000,
            'address' => 'Station Road, Colombo Fort',
            'area_name' => 'Colombo Fort',
            'severity' => 'medium',
            'status' => 'verified',
            'verified_by' => $moderator->id,
            'views_count' => 210,
        ]);

        Incident::create([
            'user_id' => $publicUser->id,
            'category_id' => $categoryModels['Flood Warning']->id,
            'title' => 'Flash Flooding on Kandy-Colombo Road',
            'description' => 'Water level rising quickly near Kiribathgoda junction due to heavy monsoon downpour.',
            'latitude' => 6.9801000,
            'longitude' => 79.9234000,
            'address' => 'Kandy Road, Kiribathgoda',
            'area_name' => 'Kiribathgoda',
            'severity' => 'critical',
            'status' => 'pending',
            'views_count' => 45,
        ]);

        Incident::create([
            'user_id' => $anusha->id,
            'category_id' => $categoryModels['Suspicious Activity']->id,
            'title' => 'Suspicious vehicle lurking near Yatihalagala School',
            'description' => 'Unregistered van parked near school gate during evening dismissal hours.',
            'latitude' => 7.3095438,
            'longitude' => 80.5694720,
            'address' => 'Yatihalagala Road, Katugastota, Kandy',
            'area_name' => 'Katugastota',
            'severity' => 'medium',
            'status' => 'pending',
            'views_count' => 62,
        ]);

        Incident::create([
            'user_id' => $publicUser->id,
            'category_id' => $categoryModels['Leopard Sighting']->id,
            'title' => 'Leopard spotted near tea estate boundary',
            'description' => 'Local villagers reported an adult leopard near the forest buffer line in Hatton.',
            'latitude' => 6.8924000,
            'longitude' => 80.5968000,
            'address' => 'Norwood Estate, Hatton',
            'area_name' => 'Hatton',
            'severity' => 'high',
            'status' => 'verified',
            'verified_by' => $moderator->id,
            'views_count' => 310,
        ]);

        Incident::create([
            'user_id' => $anusha->id,
            'category_id' => $categoryModels['Fallen Trees']->id,
            'title' => 'Tree Fallen on Peradeniya Main Road',
            'description' => 'Large banyan tree branch cleared by RDA emergency team.',
            'latitude' => 7.2642000,
            'longitude' => 80.5930000,
            'address' => 'Peradeniya Road, Kandy',
            'area_name' => 'Peradeniya',
            'severity' => 'medium',
            'status' => 'resolved',
            'resolved_by' => $authorityKandy->id,
            'views_count' => 180,
        ]);

        Incident::create([
            'user_id' => $sanduni->id,
            'category_id' => $categoryModels['Road Accident']->id,
            'title' => 'False Alarm / Duplicate Traffic Accident Report',
            'description' => 'Report submitted with incorrect coordinates and fake image.',
            'latitude' => 6.9271000,
            'longitude' => 79.8612000,
            'address' => 'Galle Road, Colombo',
            'area_name' => 'Colombo',
            'severity' => 'low',
            'status' => 'rejected',
            'moderator_notes' => 'Flagged as duplicate fake report by Safety Review Moderator',
            'views_count' => 12,
        ]);

        Incident::create([
            'user_id' => $anusha->id,
            'category_id' => $categoryModels['Harassment Zone']->id,
            'title' => 'Unlit corridor near Yatihalagala Boarding Area',
            'description' => 'Dark stretch of road behind medical center requires immediate streetlight installation.',
            'latitude' => 7.3095438,
            'longitude' => 80.5694720,
            'address' => 'Yatihalagala Medical Center Lane, Katugastota, Kandy',
            'area_name' => 'Katugastota',
            'severity' => 'medium',
            'status' => 'pending',
            'views_count' => 74,
        ]);

        Incident::create([
            'user_id' => $publicUser->id,
            'category_id' => $categoryModels['Landslide Risk']->id,
            'title' => 'Minor Earth Slip on Ella Pass Highway',
            'description' => 'Loose rocks sliding near turn 4. RDA road sign posted.',
            'latitude' => 6.8667000,
            'longitude' => 81.0466000,
            'address' => 'Ella-Wellawaya Pass',
            'area_name' => 'Ella',
            'severity' => 'high',
            'status' => 'verified',
            'verified_by' => $moderator->id,
            'views_count' => 240,
        ]);

        // 4. Safe Places & Havens
        SafePlace::create([
            'name' => 'Yatihalagala Medical Center & Safe Haven',
            'type' => 'hospital',
            'address' => 'Yatihalagala Road, Katugastota, Kandy',
            'area_name' => 'Yatihalagala',
            'latitude' => 7.3095438,
            'longitude' => 80.5694720,
            'phone' => '081-2244555',
            'is_24_7' => true,
        ]);

        SafePlace::create([
            'name' => 'Katugastota Police Station',
            'type' => 'police',
            'address' => 'Kurunegala Road, Katugastota, Kandy',
            'area_name' => 'Katugastota',
            'latitude' => 7.3140000,
            'longitude' => 80.6210000,
            'phone' => '081-2492222',
            'is_24_7' => true,
        ]);

        SafePlace::create([
            'name' => 'Habarana Police Station',
            'type' => 'police',
            'address' => 'Trincomalee Road, Habarana',
            'area_name' => 'Habarana',
            'latitude' => 8.0360000,
            'longitude' => 80.7530000,
            'phone' => '066-2270222',
            'is_24_7' => true,
        ]);

        SafePlace::create([
            'name' => 'Colombo National Hospital',
            'type' => 'hospital',
            'address' => 'E.W. Perera Mawatha, Colombo 10',
            'area_name' => 'Colombo',
            'latitude' => 6.9189000,
            'longitude' => 79.8687000,
            'phone' => '011-2691111',
            'is_24_7' => true,
        ]);

        SafePlace::create([
            'name' => 'Fort Police Station',
            'type' => 'police',
            'address' => 'Chaithya Road, Colombo 01',
            'area_name' => 'Colombo Fort',
            'latitude' => 6.9350000,
            'longitude' => 79.8460000,
            'phone' => '011-2433333',
            'is_24_7' => true,
        ]);

        SafePlace::create([
            'name' => 'Kandy General Hospital',
            'type' => 'hospital',
            'address' => 'William Gopallawa Mawatha, Kandy',
            'area_name' => 'Kandy',
            'latitude' => 7.2906000,
            'longitude' => 80.6337000,
            'phone' => '081-2222261',
            'is_24_7' => true,
        ]);

        SafePlace::create([
            'name' => 'Peradeniya Teaching Hospital & Emergency Clinic',
            'type' => 'hospital',
            'address' => 'Gaborone Road, Peradeniya',
            'area_name' => 'Peradeniya',
            'latitude' => 7.2612000,
            'longitude' => 80.5925000,
            'phone' => '081-2388000',
            'is_24_7' => true,
        ]);

        SafePlace::create([
            'name' => 'Galle Fire Station',
            'type' => 'fire_station',
            'address' => 'Main Street, Galle Fort',
            'area_name' => 'Galle',
            'latitude' => 6.0329000,
            'longitude' => 80.2168000,
            'phone' => '091-2234000',
            'is_24_7' => true,
        ]);

        // 5. Active Safety Alerts
        Alert::create([
            'title' => '🐘 Wild Elephant Highway Warning',
            'message' => 'Active wild elephant movement reported along Habarana-Trincomalee main road. Motorists are strictly advised to maintain safe speed and avoid night travel.',
            'category' => 'wildlife',
            'area_name' => 'Habarana',
            'severity' => 'warning',
            'published_by' => $admin->id,
            'is_active' => true,
        ]);

        Alert::create([
            'title' => '🐊 Crocodile Warning - Bentota River',
            'message' => 'Increased crocodile sightings reported near river banks. Residents and tourists are advised to avoid swimming or entering the water.',
            'category' => 'wildlife',
            'area_name' => 'Bentota',
            'severity' => 'danger',
            'published_by' => $admin->id,
            'is_active' => true,
        ]);

        Alert::create([
            'title' => '🌧️ Heavy Rainfall & Flash Flood Advisory',
            'message' => 'Severe weather forecast for Western and Sabaragamuwa provinces. Stay alert for low-lying water logging.',
            'category' => 'weather',
            'area_name' => 'Western Province',
            'severity' => 'info',
            'published_by' => $admin->id,
            'is_active' => true,
        ]);

        // 6. SOS Emergency Requests with Precise Coordinates
        SosRequest::create([
            'user_id' => $publicUser->id,
            'user_name' => 'Kavindu Perera',
            'user_phone' => '0719876543',
            'latitude' => 6.9271000,
            'longitude' => 79.8612000,
            'address' => 'Town Hall, Colombo 07',
            'status' => 'active',
            'notes' => 'Emergency SOS triggered via mobile button',
        ]);

        SosRequest::create([
            'user_id' => $anusha->id,
            'user_name' => 'Anusha Perera',
            'user_phone' => '0781122334',
            'latitude' => 7.3095438,
            'longitude' => 80.5694720,
            'address' => 'Yatihalagala Road, Katugastota, Kandy',
            'status' => 'resolved',
            'notes' => 'Resolved by Police Dispatcher',
        ]);
    }
}
