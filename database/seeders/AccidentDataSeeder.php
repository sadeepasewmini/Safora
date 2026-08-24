<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccidentDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Inserts all 59 extracted traffic accident records from Accident_Reports_Safora.xlsx (English) into safora_db.
     * Replaces previous entries in the incidents table.
     */
    public function run(): void
    {
        $accidents = [
            [
                'date_time' => '2026-01-02 21:47:00',
                'location' => 'Kandy Suwasewana Hospital',
                'severity' => 'Medium Risk',
                'route' => 'Kandy to Gatambe',
                'vehicles' => 'Bicycle -> Female Commuter',
                'cause' => 'Rider lost control of the bicycle on an unlit sidewalk at night, colliding with a female pedestrian.',
                'lat' => 7.2882,
                'lng' => 80.6275
            ],
            [
                'date_time' => '2026-01-03 17:30:00',
                'location' => 'Ampitiya',
                'severity' => 'Medium Risk',
                'route' => 'Kandy to Ampitiya',
                'vehicles' => 'Threewheel -> Truck',
                'cause' => "Three-wheeler driver attempted a risky overtake into the heavy truck's blind spot.",
                'lat' => 7.2831,
                'lng' => 80.6558
            ],
            [
                'date_time' => '2026-01-03 21:30:00',
                'location' => 'Sri Ramya Hotel',
                'severity' => 'Low Risk',
                'route' => 'Sri Ramya Hotel Area',
                'vehicles' => 'Threewheel -> Bicycle',
                'cause' => 'Three-wheeler driver turned abruptly into a side road without prior signaling, striking a bicycle behind.',
                'lat' => 7.2915,
                'lng' => 80.6350
            ],
            [
                'date_time' => '2026-01-05 21:35:00',
                'location' => 'Kegalle Motors',
                'severity' => 'Medium Risk',
                'route' => 'Kegalle Motors to Gate',
                'vehicles' => 'Truck -> Gate',
                'cause' => 'Truck driver reversed without checking rear clearance adequately, crashing into the gate.',
                'lat' => 7.2965,
                'lng' => 80.6320
            ],
            [
                'date_time' => '2026-01-08 20:10:00',
                'location' => 'Cargills Food City',
                'severity' => 'Medium Risk',
                'route' => 'Food City to Aruppola',
                'vehicles' => 'Threewheel -> Van',
                'cause' => 'Three-wheeler driver exited supermarket carpark without yielding to oncoming van traffic on the main road.',
                'lat' => 7.3010,
                'lng' => 80.6410
            ],
            [
                'date_time' => '2026-01-08 10:00:00',
                'location' => 'Queens Hotel',
                'severity' => 'Low Risk',
                'route' => 'Dalada Veediya to Wells Park',
                'vehicles' => 'Car -> Female Commuter',
                'cause' => 'Car driver was distracted at the pedestrian crossing, delaying braking upon spotting a female pedestrian.',
                'lat' => 7.2936,
                'lng' => 80.6380
            ],
            [
                'date_time' => '2026-01-11 07:50:00',
                'location' => 'Dodamwala Junction',
                'severity' => 'Low Risk',
                'route' => 'Peradeniya to Kandy',
                'vehicles' => 'Bicycle -> Female Commuter (2)',
                'cause' => 'Cyclist rode dangerously at high speed along a sidewalk reserved for pedestrians.',
                'lat' => 7.2805,
                'lng' => 80.6150
            ],
            [
                'date_time' => '2026-01-11 03:10:00',
                'location' => 'Bogambara Bus Station',
                'severity' => 'High Risk',
                'route' => 'Keppetipola Road to Bogambara Road',
                'vehicles' => 'Car -> Female Commuter',
                'cause' => 'Car driver operated at excessive speed in early morning darkness without streetlights, striking a female pedestrian.',
                'lat' => 7.2900,
                'lng' => 80.6335
            ],
            [
                'date_time' => '2026-01-11 13:20:00',
                'location' => 'Vidyartha Primary School',
                'severity' => 'Low Risk',
                'route' => 'Greenhill School to Vidyartha Primary School',
                'vehicles' => 'Child Commuter -> Car',
                'cause' => 'School child darted onto the main road unexpectedly during end-of-school traffic congestion.',
                'lat' => 7.3050,
                'lng' => 80.6310
            ],
            [
                'date_time' => '2026-01-13 10:30:00',
                'location' => 'Bogambara Old Prison',
                'severity' => 'High Risk',
                'route' => 'Udurawana Junction to Bogambara Roundabout',
                'vehicles' => 'Bus -> Female Commuter',
                'cause' => "Bus driver navigated near the roundabout at excessive speed, hitting a pedestrian positioned in the bus's front blind spot.",
                'lat' => 7.2895,
                'lng' => 80.6342
            ],
            [
                'date_time' => '2026-01-13 14:00:00',
                'location' => 'Bahirawakanda Ajantha Ayurveda Center',
                'severity' => 'Low Risk',
                'route' => 'Bahirawakanda Junction to Asgiriya',
                'vehicles' => 'Car -> Ayurveda Center Wall',
                'cause' => 'Car brakes failed suddenly while descending a steep gradient mountain road, causing a collision with a wall.',
                'lat' => 7.2970,
                'lng' => 80.6300
            ],
            [
                'date_time' => '2026-01-13 18:45:00',
                'location' => 'SWRD Bandaranayake Train Station',
                'severity' => 'Medium Risk',
                'route' => 'Viliyam Gopallawa Mawatha to Kandy',
                'vehicles' => 'Car -> Bicycle',
                'cause' => 'Car driver failed to maintain a safe trailing distance behind a preceding bicycle.',
                'lat' => 7.2910,
                'lng' => 80.6315
            ],
            [
                'date_time' => '2026-01-16 13:15:00',
                'location' => 'TB Thennakoon Road',
                'severity' => 'Low Risk',
                'route' => 'Viliyam Gopallawa Mawatha to TB Thennakoon Road',
                'vehicles' => 'Car -> Male Commuter',
                'cause' => 'Car driver reversed without checking side mirrors for pedestrians, injuring a male pedestrian.',
                'lat' => 7.2870,
                'lng' => 80.6280
            ],
            [
                'date_time' => '2026-01-16 18:30:00',
                'location' => 'Kandy Srimath Kudarathwatha Road',
                'severity' => 'Low Risk',
                'route' => 'Dodamwala Junction to Katugastota',
                'vehicles' => 'Car -> House Gate',
                'cause' => 'Car driver accidentally pressed the accelerator pedal instead of the brake near a residential gate.',
                'lat' => 7.3020,
                'lng' => 80.6250
            ],
            [
                'date_time' => '2026-01-19 16:40:00',
                'location' => 'Kandy A9 Road Vidyartha Primary School',
                'severity' => 'Medium Risk',
                'route' => 'Kandy to A9 Road',
                'vehicles' => 'Bus -> Building',
                'cause' => 'Bus driver swerved into a building to prevent colliding with other vehicles following brake system failure.',
                'lat' => 7.3060,
                'lng' => 80.6315
            ],
            [
                'date_time' => '2026-01-19 21:00:00',
                'location' => 'AOL Singer Mega',
                'severity' => 'Medium Risk',
                'route' => 'Sirimavo Bandaranayake Road to Gatambe',
                'vehicles' => 'Car -> Commuter',
                'cause' => 'Car driver exceeded speed limits near an unlit pedestrian crossing at night, hitting a pedestrian.',
                'lat' => 7.2840,
                'lng' => 80.6190
            ],
            [
                'date_time' => '2026-01-21 17:00:00',
                'location' => 'Heerassagala Junction',
                'severity' => 'Low Risk',
                'route' => 'Peradeniya to Kandy',
                'vehicles' => 'Bicycle -> Car',
                'cause' => 'Cyclist entered the main road from a side street abruptly without checking oncoming traffic.',
                'lat' => 7.2790,
                'lng' => 80.6210
            ],
            [
                'date_time' => '2026-01-22 11:10:00',
                'location' => 'Rajans School',
                'severity' => 'Medium Risk',
                'route' => 'Rajans School to Dharmaraja Road',
                'vehicles' => 'Bicycle -> Commuter',
                'cause' => 'Cyclist lost control and crashed while attempting to maneuver around a pedestrian during school rush hour.',
                'lat' => 7.2910,
                'lng' => 80.6480
            ],
            [
                'date_time' => '2026-01-24 08:45:00',
                'location' => 'Kandy A26 Thannekumbura Pre School',
                'severity' => 'Medium Risk',
                'route' => 'Thannekumbura to Kandy',
                'vehicles' => 'Bus -> Car',
                'cause' => 'Bus driver following too closely was unable to brake in time when the lead car stopped suddenly.',
                'lat' => 7.2880,
                'lng' => 80.6650
            ],
            [
                'date_time' => '2026-01-25 13:00:00',
                'location' => 'Kandy Dharmashoka Road',
                'severity' => 'Low Risk',
                'route' => 'Gaalkaduwa Road to Dharmashoka Road',
                'vehicles' => 'Threewheel -> Commuter (Passenger)',
                'cause' => 'Three-wheeler driver negotiated a sharp bend at excessive speed, causing the vehicle to overturn and injure the passenger.',
                'lat' => 7.2940,
                'lng' => 80.6410
            ],
            [
                'date_time' => '2026-01-26 23:05:00',
                'location' => 'Kandy Clock Tower',
                'severity' => 'Medium Risk',
                'route' => 'Kandy Police Station to Kandy Clock Tower',
                'vehicles' => 'Bus -> Car & Commuter',
                'cause' => 'Bus driver fell asleep at the wheel late at night, running through traffic signals.',
                'lat' => 7.2923,
                'lng' => 80.6340
            ],
            [
                'date_time' => '2026-01-26 15:10:00',
                'location' => 'Vidyartha Primary School',
                'severity' => 'Medium Risk',
                'route' => 'Katugastota to Kandy',
                'vehicles' => 'Car -> Female Commuter',
                'cause' => 'Car driver exceeded the mandated 30 km/h speed limit in a school zone, striking a female pedestrian.',
                'lat' => 7.3050,
                'lng' => 80.6310
            ],
            [
                'date_time' => '2026-01-27 07:10:00',
                'location' => 'Aruppola Bowalawa Roundabout',
                'severity' => 'Medium Risk',
                'route' => 'Watapuluwa to Aruppola',
                'vehicles' => 'Bicycle -> Car',
                'cause' => 'Cyclist entering the roundabout failed to yield the right-of-way to a car approaching from the right.',
                'lat' => 7.3080,
                'lng' => 80.6430
            ],
            [
                'date_time' => '2026-01-28 17:20:00',
                'location' => 'A142 Viliyam Gopallawa Road',
                'severity' => 'Low Risk',
                'route' => 'Gatambe to Kandy',
                'vehicles' => 'Truck -> Car',
                'cause' => 'Heavy truck driver lost traction and skidded on a wet road due to unadjusted speed.',
                'lat' => 7.2860,
                'lng' => 80.6230
            ],
            [
                'date_time' => '2026-02-02 12:56:00',
                'location' => 'Tele-fix',
                'severity' => 'Medium Risk',
                'route' => 'Kandy Police Station to Peradeniya',
                'vehicles' => 'Car -> Bicycle',
                'cause' => 'Parked car driver opened the door suddenly without checking side mirrors for approaching cyclists.',
                'lat' => 7.2910,
                'lng' => 80.6320
            ],
            [
                'date_time' => '2026-02-02 09:55:00',
                'location' => 'KPH Road STP Votes',
                'severity' => 'Low Risk',
                'route' => 'Katugastota to Kandy',
                'vehicles' => 'Truck -> Threewheel',
                'cause' => 'Truck driver attempted to overtake a three-wheeler on a narrow road without observing oncoming traffic.',
                'lat' => 7.3100,
                'lng' => 80.6280
            ],
            [
                'date_time' => '2026-02-03 14:55:00',
                'location' => 'Bogambara Hospital',
                'severity' => 'Low Risk',
                'route' => 'Kandy Hospital to Hospital Car Park',
                'vehicles' => 'Car -> Ambulance',
                'cause' => 'Car driver failed to yield priority to an emergency ambulance operating with active sirens.',
                'lat' => 7.2890,
                'lng' => 80.6330
            ],
            [
                'date_time' => '2026-02-03 17:15:00',
                'location' => 'Kandy A26 Hewahata Thalwatta',
                'severity' => 'Low Risk',
                'route' => 'Thalwatta to Bangalawatta',
                'vehicles' => 'Threewheel -> Wall',
                'cause' => 'Sudden mechanical failure in the three-wheeler steering mechanism caused it to veer off road into a wall.',
                'lat' => 7.2860,
                'lng' => 80.6520
            ],
            [
                'date_time' => '2026-02-06 08:00:00',
                'location' => 'No 141 Rohana Iron Works',
                'severity' => 'Low Risk',
                'route' => 'Kandy to Rohana Iron Works',
                'vehicles' => 'Bus -> Car',
                'cause' => 'Bus driver abruptly switched lanes when pulling up to a stop, cutting off a trailing car.',
                'lat' => 7.2950,
                'lng' => 80.6380
            ],
            [
                'date_time' => '2026-02-06 14:15:00',
                'location' => 'Sirimavo Bandaranayake Tourist Police',
                'severity' => 'Low Risk',
                'route' => 'Police Station to Clock Tower',
                'vehicles' => 'Commuter -> Bicycle',
                'cause' => 'Pedestrian stepped onto the middle of the road unexpectedly without looking, colliding with a bicycle.',
                'lat' => 7.2918,
                'lng' => 80.6338
            ],
            [
                'date_time' => '2026-02-08 22:00:00',
                'location' => 'Sirimavo Bandaranayake Road Central',
                'severity' => 'Low Risk',
                'route' => 'Peradeniya to Clock Tower',
                'vehicles' => 'Car -> Car',
                'cause' => 'Car driver used a mobile phone while driving, rear-ending the preceding vehicle.',
                'lat' => 7.2905,
                'lng' => 80.6325
            ],
            [
                'date_time' => '2026-02-10 12:00:00',
                'location' => 'Kandy Pushpadhana School',
                'severity' => 'Medium Risk',
                'route' => 'Bahirawakanda Road to Pushpadhana College',
                'vehicles' => 'Car -> School Gate',
                'cause' => 'Car brakes overheated and failed during a steep downhill descent on Bahirawakanda Road.',
                'lat' => 7.2960,
                'lng' => 80.6290
            ],
            [
                'date_time' => '2026-02-11 12:28:00',
                'location' => 'Muslim Jathika Hotel',
                'severity' => 'Low Risk',
                'route' => 'Church Road to Clock Tower',
                'vehicles' => 'Bus -> Car',
                'cause' => 'Bus driver swerved to clear a parked vehicle, sideswiping an adjacent moving car.',
                'lat' => 7.2940,
                'lng' => 80.6360
            ],
            [
                'date_time' => '2026-02-14 19:00:00',
                'location' => 'Heerassagala Junction',
                'severity' => 'Low Risk',
                'route' => 'Kandy to Viliyam Gopallawa Road',
                'vehicles' => 'Truck -> Car',
                'cause' => 'Truck driver was blinded by oncoming headlight glare while turning at a junction at night.',
                'lat' => 7.2790,
                'lng' => 80.6210
            ],
            [
                'date_time' => '2026-02-17 07:45:00',
                'location' => 'Ampitiya Main Road',
                'severity' => 'Low Risk',
                'route' => 'Ampitiya to Kandy',
                'vehicles' => 'Van -> Bicycle',
                'cause' => 'Van driver operated the vehicle under the influence of alcohol, striking a cyclist.',
                'lat' => 7.2835,
                'lng' => 80.6560
            ],
            [
                'date_time' => '2026-02-17 14:40:00',
                'location' => 'Ampitiya Ceylinco',
                'severity' => 'Medium Risk',
                'route' => 'Kandy to Ampitiya',
                'vehicles' => 'Bus -> Bicycle',
                'cause' => "Bus passed too closely to a bicycle, causing a wind draft that unsettled the cyclist's balance.",
                'lat' => 7.2840,
                'lng' => 80.6570
            ],
            [
                'date_time' => '2026-02-19 09:45:00',
                'location' => 'Viliyam Gopallawa Fire Brigade',
                'severity' => 'Medium Risk',
                'route' => 'Kandy to Gatambe',
                'vehicles' => 'Car -> 2 Commuters',
                'cause' => "Car driver's negligence caused the vehicle to mount the pavement, hitting two pedestrians.",
                'lat' => 7.2855,
                'lng' => 80.6225
            ],
            [
                'date_time' => '2026-02-20 09:40:00',
                'location' => 'Ampitiya Diwrum Bodhiya',
                'severity' => 'Low Risk',
                'route' => 'Ampitiya to Kandy',
                'vehicles' => 'Car -> Bicycle',
                'cause' => 'Car driver failed to maintain sufficient lateral clearance when passing a bicycle.',
                'lat' => 7.2845,
                'lng' => 80.6580
            ],
            [
                'date_time' => '2026-02-26 07:50:00',
                'location' => 'Nalawatta Viliyam Gopallawa',
                'severity' => 'Medium Risk',
                'route' => 'Kandy to Thannekumbura',
                'vehicles' => 'Threewheel -> Bus',
                'cause' => 'Three-wheeler driver attempted an illegal U-turn unexpectedly, colliding with an oncoming bus.',
                'lat' => 7.2875,
                'lng' => 80.6260
            ],
            [
                'date_time' => '2026-02-26 19:45:00',
                'location' => 'Asiri Hospital',
                'severity' => 'Low Risk',
                'route' => 'Clock Tower to Kandy',
                'vehicles' => 'Car -> Female Commuter',
                'cause' => 'Car driver failed to reduce speed when approaching a pedestrian crossing at night.',
                'lat' => 7.2885,
                'lng' => 80.6278
            ],
            [
                'date_time' => '2026-02-27 17:35:00',
                'location' => 'A26 Hewahata Road Fuel Station',
                'severity' => 'Low Risk',
                'route' => 'Thannekumbura to A26 Road',
                'vehicles' => 'Van -> Car',
                'cause' => 'Van driver braked sharply to turn right into a fuel station, causing a trailing car to collide.',
                'lat' => 7.2870,
                'lng' => 80.6610
            ],
            [
                'date_time' => '2026-02-28 11:45:00',
                'location' => 'Bogambara Junction',
                'severity' => 'Low Risk',
                'route' => 'Kandy to Bogambara',
                'vehicles' => 'Van -> Female Commuter',
                'cause' => "Van driver failed to notice a pedestrian positioned in the vehicle's left front blind spot while turning into a side road.",
                'lat' => 7.2898,
                'lng' => 80.6345
            ],
            [
                'date_time' => '2026-03-04 08:10:00',
                'location' => 'Thannekumbura Driving School',
                'severity' => 'Low Risk',
                'route' => 'Thannekumbura Clock Tower to Thalathuoya',
                'vehicles' => 'Van -> Bicycle',
                'cause' => 'Van driver was distracted by a mobile phone/object, striking a bicycle ahead.',
                'lat' => 7.2882,
                'lng' => 80.6660
            ],
            [
                'date_time' => '2026-03-04 12:40:00',
                'location' => 'Edwin Silva Play Ground',
                'severity' => 'High Risk',
                'route' => 'Gatambe to Kandy',
                'vehicles' => 'Bus -> Female Commuter',
                'cause' => 'Bus driver approached a pedestrian crossing at lethal speed with extreme negligence, causing a fatal injury.',
                'lat' => 7.2820,
                'lng' => 80.6120
            ],
            [
                'date_time' => '2026-03-07 19:35:00',
                'location' => 'A09 Road No.62 Kandy',
                'severity' => 'Medium Risk',
                'route' => 'Katugastota to A9 Road Kandy',
                'vehicles' => 'Threewheel -> Bicycle',
                'cause' => 'Bicycle lacked rear reflectors at night, rendering it unnoticeable to a trailing three-wheeler.',
                'lat' => 7.3070,
                'lng' => 80.6305
            ],
            [
                'date_time' => '2026-03-08 13:20:00',
                'location' => 'Viliyam Gopallawa Road',
                'severity' => 'Low Risk',
                'route' => 'Kandy to Viliyam Gopallawa Road',
                'vehicles' => 'Car -> Electricity Tower',
                'cause' => 'Car driver suffered a sudden medical emergency while driving, losing steering control and hitting an electric tower.',
                'lat' => 7.2865,
                'lng' => 80.6240
            ],
            [
                'date_time' => '2026-03-09 22:00:00',
                'location' => 'SWRD Bandaranayake Education Center',
                'severity' => 'Low Risk',
                'route' => 'Bogambara to Clock Tower',
                'vehicles' => 'Bus (1) -> Bus (2)',
                'cause' => 'Drivers of two buses engaged in reckless competitive racing to overtake each other for passengers.',
                'lat' => 7.2912,
                'lng' => 80.6322
            ],
            [
                'date_time' => '2026-03-13 06:30:00',
                'location' => 'Bogambara Play Ground',
                'severity' => 'Low Risk',
                'route' => 'Kandy to Bogambara Prison',
                'vehicles' => 'Car -> Female Commuter',
                'cause' => 'Dense early morning fog severely restricted driver visibility, leading to a pedestrian collision.',
                'lat' => 7.2890,
                'lng' => 80.6338
            ],
            [
                'date_time' => '2026-03-14 13:45:00',
                'location' => 'Church Road',
                'severity' => 'Low Risk',
                'route' => 'Rajina Hotel to Wells Park Junction',
                'vehicles' => 'Car -> Threewheel',
                'cause' => 'Lead car driver applied handbrakes abruptly without warning, causing a trailing three-wheeler to hit.',
                'lat' => 7.2950,
                'lng' => 80.6370
            ],
            [
                'date_time' => '2026-03-15 13:40:00',
                'location' => 'Thannekumbura Sathosa',
                'severity' => 'Low Risk',
                'route' => 'Thannekumbura to Kandy',
                'vehicles' => 'Car -> Bicycle',
                'cause' => 'Car driver attempted to squeeze past a bicycle on a narrow road without adequate lateral space.',
                'lat' => 7.2878,
                'lng' => 80.6640
            ],
            [
                'date_time' => '2026-03-16 14:05:00',
                'location' => 'Dodamwala Junction',
                'severity' => 'Low Risk',
                'route' => 'Kandy to Dodamwala',
                'vehicles' => 'Bicycle -> Commuter',
                'cause' => 'Bicycle brake cable snapped unexpectedly, causing the rider to collide with a pedestrian.',
                'lat' => 7.2805,
                'lng' => 80.6150
            ],
            [
                'date_time' => '2026-03-16 17:10:00',
                'location' => 'Kandy Lewalla Road',
                'severity' => 'Medium Risk',
                'route' => 'Lewalla to Kandy',
                'vehicles' => 'Bicycle (1) -> Bicycle (2)',
                'cause' => 'Two cyclists rode abreast dangerously close to each other in the middle of the road.',
                'lat' => 7.3000,
                'lng' => 80.6500
            ],
            [
                'date_time' => '2026-03-17 16:15:00',
                'location' => 'Watapuluwa',
                'severity' => 'Low Risk',
                'route' => 'Watapuluwa to Watapuluwa Main Road',
                'vehicles' => 'Bicycle -> Van',
                'cause' => 'Cyclist rode out of a side street onto the main road without stopping, colliding with a van.',
                'lat' => 7.3120,
                'lng' => 80.6400
            ],
            [
                'date_time' => '2026-03-17 18:05:00',
                'location' => 'Kandy Anagarika Road',
                'severity' => 'Low Risk',
                'route' => 'Kandy to Anagarika Dharmapala Road',
                'vehicles' => 'Truck -> Car',
                'cause' => 'Heavy truck experienced pneumatic brake system lag, colliding with the lead car.',
                'lat' => 7.2930,
                'lng' => 80.6420
            ],
            [
                'date_time' => '2026-03-25 16:00:00',
                'location' => 'Asgiriya',
                'severity' => 'Low Risk',
                'route' => 'Kandy to Gamini Dissanayake Road',
                'vehicles' => 'Car -> Ambulance',
                'cause' => 'Car driver refused to pull over or yield priority to an approaching emergency ambulance.',
                'lat' => 7.2980,
                'lng' => 80.6310
            ],
            [
                'date_time' => '2026-03-30 16:35:00',
                'location' => 'Kandy Traffic Police',
                'severity' => 'Medium Risk',
                'route' => 'Batugoda Pitiya Road to Sirimavo Bandaranayake Road',
                'vehicles' => 'Truck -> Female Commuter',
                'cause' => 'Pedestrian was caught in the rear wheel off-tracking zone while the heavy truck was negotiating a sharp turn.',
                'lat' => 7.2915,
                'lng' => 80.6330
            ],
            [
                'date_time' => '2026-03-31 15:40:00',
                'location' => 'Kandy Ranwan Rasen Devi College',
                'severity' => 'High Risk',
                'route' => 'Ranwan Rasen Devi College area',
                'vehicles' => 'Bus -> Bicycle',
                'cause' => 'Bus driver executed an extremely reckless, close-proximity overtake on a cyclist.',
                'lat' => 7.2965,
                'lng' => 80.6390
            ],
            [
                'date_time' => '2026-04-02 08:30:00',
                'location' => 'Heerassagala',
                'severity' => 'Low Risk',
                'route' => 'Heerassagala to Viliyam Gopallawa Road',
                'vehicles' => 'Threewheel -> Self / Road Barrier',
                'cause' => 'Three-wheeler driver lost control and hydroplaned on a slippery bend during heavy rainfall.',
                'lat' => 7.2780,
                'lng' => 80.6200
            ],
            [
                'date_time' => '2026-04-02 17:52:00',
                'location' => 'Thannekumbura Sudarshanaramya Temple',
                'severity' => 'High Risk',
                'route' => 'Kandy to Heerassagala',
                'vehicles' => 'Bus -> Female Commuter',
                'cause' => 'High-speed bus driver struck a female pedestrian on a pedestrian crossing.',
                'lat' => 7.2885,
                'lng' => 80.6670
            ]
        ];

        // Ensure Road Accident Category ID exists
        $categoryId = DB::table('incident_categories')->where('slug', 'road-accidents')->value('id');

        if (!$categoryId) {
            $categoryId = DB::table('incident_categories')->insertGetId([
                'name' => 'Road Accident Log',
                'slug' => 'road-accidents',
                'type' => 'road',
                'icon' => 'bi-car-front-fill',
                'risk_level' => 'high',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Wipe previous seeded logs to maintain fresh, clean English dataset
        DB::table('incidents')->where('category_id', $categoryId)->delete();

        foreach ($accidents as $acc) {
            $title = "Road Incident: " . $acc['location'] . " (" . explode(' ', $acc['date_time'])[0] . ")";
            $description = "【Route】: " . $acc['route'] . "\n"
                . "【Involved Entities (Offender -> Victim)】: " . $acc['vehicles'] . "\n"
                . "【Primary Cause】: " . $acc['cause'] . "\n"
                . "【Severity】: " . $acc['severity'];

            $riskLevel = 'low';
            if (str_contains(strtolower($acc['severity']), 'high')) {
                $riskLevel = 'high';
            } elseif (str_contains(strtolower($acc['severity']), 'medium')) {
                $riskLevel = 'medium';
            }

            DB::table('incidents')->insert([
                'title' => $title,
                'description' => $description,
                'category_id' => $categoryId,
                'user_id' => null,
                'latitude' => $acc['lat'],
                'longitude' => $acc['lng'],
                'address' => $acc['location'],
                'area_name' => $acc['location'],
                'severity' => $riskLevel,
                'status' => 'verified',
                'created_at' => $acc['date_time'],
                'updated_at' => now()
            ]);
        }

        $this->command->info("Successfully replaced and seeded all 59 English accident records into safora_db!");
    }
}
