<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CrimeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seeds mock crime data specifically for the Kandy region.
     */
    public function run(): void
    {
        $crimes = [
            // Original 6
            [
                'category_slug' => 'theft-snatching',
                'title' => 'Gold Chain Snatched Near Kandy Lake',
                'description' => 'A motorbike rider snatched a gold chain from a tourist walking along the Kandy Lake round. The suspect fled towards Ampitiya.',
                'latitude' => 7.2912,
                'longitude' => 80.6405,
                'location' => 'Kandy Lake Round',
                'severity' => 'medium'
            ],
            [
                'category_slug' => 'suspicious-activity',
                'title' => 'Suspicious Group Near Old Bogambara Prison',
                'description' => 'A group of unidentified individuals seen repeatedly monitoring parked vehicles late at night near the old prison grounds.',
                'latitude' => 7.2895,
                'longitude' => 80.6342,
                'location' => 'Bogambara, Kandy',
                'severity' => 'low'
            ],
            [
                'category_slug' => 'harassment-zone',
                'title' => 'Harassment at Goods Shed Bus Stand',
                'description' => 'Multiple reports of verbal harassment targeting female commuters during evening rush hours near the main entrance.',
                'latitude' => 7.2908,
                'longitude' => 80.6315,
                'location' => 'Kandy Main Bus Stand (Goods Shed)',
                'severity' => 'high'
            ],
            [
                'category_slug' => 'robbery',
                'title' => 'Shop Break-in on Dalada Veediya',
                'description' => 'An electronic store was broken into past midnight. Suspects disabled the CCTV cameras before entering.',
                'latitude' => 7.2936,
                'longitude' => 80.6380,
                'location' => 'Dalada Veediya, Kandy',
                'severity' => 'critical'
            ],
            [
                'category_slug' => 'theft-snatching',
                'title' => 'Pickpocketing near Temple of the Tooth',
                'description' => 'Several visitors reported their wallets and phones missing while in the crowded queuing area.',
                'latitude' => 7.2930,
                'longitude' => 80.6415,
                'location' => 'Sri Dalada Maligawa Entrance',
                'severity' => 'medium'
            ],
            [
                'category_slug' => 'harassment-zone',
                'title' => 'Unlit Pathway Causing Safety Concerns',
                'description' => 'The pathway connecting Peradeniya Road to the residential area has broken streetlights, leading to incidents of harassment.',
                'latitude' => 7.2840,
                'longitude' => 80.6190,
                'location' => 'Gatambe / Peradeniya Road',
                'severity' => 'medium'
            ],
            
            // 10 New Crimes Added for Kandy
            [
                'category_slug' => 'theft-snatching',
                'title' => 'Bag Snatching Near Kandy Railway Station',
                'description' => 'A commuter\'s handbag was snatched by a passing trishaw while waiting outside the station.',
                'latitude' => 7.2902,
                'longitude' => 80.6300,
                'location' => 'Kandy Railway Station',
                'severity' => 'medium'
            ],
            [
                'category_slug' => 'suspicious-activity',
                'title' => 'Suspicious Individuals at Wales Park',
                'description' => 'Unidentified persons gathering in a secluded, unlit corner of Wales Park during evening hours.',
                'latitude' => 7.2935,
                'longitude' => 80.6390,
                'location' => 'Wales Park, Kandy',
                'severity' => 'low'
            ],
            [
                'category_slug' => 'harassment-zone',
                'title' => 'Street Harassment Near KCC Entrance',
                'description' => 'Shoppers reported ongoing verbal harassment from a group loitering outside the Kandy City Centre.',
                'latitude' => 7.2933,
                'longitude' => 80.6375,
                'location' => 'Kandy City Centre (KCC)',
                'severity' => 'high'
            ],
            [
                'category_slug' => 'robbery',
                'title' => 'House Break-in in Ampitiya',
                'description' => 'A residential property was burgled during the day. Valuables and electronics were stolen.',
                'latitude' => 7.2801,
                'longitude' => 80.6558,
                'location' => 'Ampitiya Road, Kandy',
                'severity' => 'critical'
            ],
            [
                'category_slug' => 'theft-snatching',
                'title' => 'Pickpocketing Inside Crowded Katugastota Bus',
                'description' => 'A passenger lost their wallet while traveling in a heavily congested bus heading towards Katugastota.',
                'latitude' => 7.3115,
                'longitude' => 80.6278,
                'location' => 'Katugastota Bridge',
                'severity' => 'medium'
            ],
            [
                'category_slug' => 'suspicious-activity',
                'title' => 'Suspicious Van Parked Near Mahamaya Girls College',
                'description' => 'A heavily tinted, unmarked van was reported parked suspiciously near the school gates during dismissal time.',
                'latitude' => 7.2882,
                'longitude' => 80.6480,
                'location' => 'Mahamaya Road, Kandy',
                'severity' => 'medium'
            ],
            [
                'category_slug' => 'harassment-zone',
                'title' => 'Drunk Group Causing Nuisance at Lewella',
                'description' => 'A group of intoxicated individuals harassing pedestrians crossing the Lewella suspension bridge at dusk.',
                'latitude' => 7.3005,
                'longitude' => 80.6495,
                'location' => 'Lewella Bridge',
                'severity' => 'high'
            ],
            [
                'category_slug' => 'robbery',
                'title' => 'Jewelry Shop Robbery in Colombo Street',
                'description' => 'Armed suspects attempted a smash-and-grab robbery at a prominent jewelry store on Colombo Street.',
                'latitude' => 7.2941,
                'longitude' => 80.6355,
                'location' => 'Colombo Street, Kandy',
                'severity' => 'critical'
            ],
            [
                'category_slug' => 'theft-snatching',
                'title' => 'Mobile Phone Snatched in Peradeniya Gardens',
                'description' => 'A visitor had their smartphone stolen from a park bench while distracted taking photographs.',
                'latitude' => 7.2685,
                'longitude' => 80.5962,
                'location' => 'Peradeniya Botanical Gardens',
                'severity' => 'medium'
            ],
            [
                'category_slug' => 'harassment-zone',
                'title' => 'Harassment at Unlit Bahirawakanda Road Curve',
                'description' => 'A notoriously dark curve on the road up to Bahirawakanda has become a hotspot for street harassment.',
                'latitude' => 7.2965,
                'longitude' => 80.6315,
                'location' => 'Bahirawakanda Road',
                'severity' => 'high'
            ]
        ];

        // Retrieve existing crime category IDs based on slugs
        $categories = DB::table('incident_categories')
            ->whereIn('type', ['crime'])
            ->get()
            ->keyBy('slug');

        $categoryIds = $categories->pluck('id')->toArray();

        // Wipe old Kandy crimes to avoid duplication
        if (!empty($categoryIds)) {
            DB::table('incidents')
                ->whereIn('category_id', $categoryIds)
                ->where('area_name', 'Kandy')
                ->delete();
        }

        foreach ($crimes as $crime) {
            $categoryId = null;
            if (isset($categories[$crime['category_slug']])) {
                $categoryId = $categories[$crime['category_slug']]->id;
            }

            // Only insert if the category exists
            if ($categoryId) {
                DB::table('incidents')->insert([
                    'title' => $crime['title'],
                    'description' => $crime['description'],
                    'category_id' => $categoryId,
                    'user_id' => null, // Publicly reported or anonymous
                    'latitude' => $crime['latitude'],
                    'longitude' => $crime['longitude'],
                    'address' => $crime['location'],
                    'area_name' => 'Kandy',
                    'severity' => $crime['severity'],
                    'status' => 'verified',
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now()
                ]);
            }
        }

        $this->command->info("Successfully seeded 16 extended Kandy crime records!");
    }
}
