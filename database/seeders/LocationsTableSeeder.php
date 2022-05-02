<?php

namespace Database\Seeders;

use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Webpatser\Uuid\Uuid;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = [
            ['name' => 'Balamb (Region)'],
            ['name' => 'Dollet (Region)'],
            ['name' => 'Timber (Region)'],
            ['name' => 'Galbadia (Region)'],
            ['name' => 'Winhill (Region)'],
            ['name' => 'International (Region)'],
            ['name' => 'Trabia (Region)'],
            ['name' => 'Centra (Region)'],
            ['name' => 'Esthar (Region)'],
            ['name' => 'Wilderness (Region)'],
            ['name' => 'None'],
        ];

        $balambRegionLocations = [
            // Overworld Areas.
            [
                'name' => 'Balamb - Alcauld Plains',
                'parent' => 'balamb-region',
            ],
            [
                'name' => 'Balamb - Galug Mountains',
                'parent' => 'balamb-region',
            ],
            [
                'name' => 'Balamb - Raha Cape',
                'parent' => 'balamb-region',
            ],
            [
                'name' => 'Balamb - Rinaul Cost',
                'parent' => 'balamb-region',
            ],
            // Overworld Locations.
            [
                'name' => 'Fire Cavern',
                'parent' => 'balamb-alcauld-plains',
            ],
            // Towns.
            [
                'name' => 'Balamb Town',
                'parent' => 'balamb-alcauld-plains',
                'notes' => 'This is not an in-game location. It is used as a container for a subset of child locations.',
            ],
            [
                'name' => 'Balamb - Town Square',
                'parent' => 'balamb-town',
            ],
            [
                'name' => 'Balamb - Residence',
                'parent' => 'balamb-town',
            ],
            [
                'name' => "Balamb -  The Dincht's",
                'parent' => 'balamb-town',
            ],
            [
                'name' => 'Balamb - Station Yard',
                'parent' => 'balamb-town',
            ],
            [
                'name' => 'Balamb Hotel',
                'parent' => 'balamb-town',
            ],
            [
                'name' => 'Balamb Harbor',
                'parent' => 'balamb-town',
            ],
            [
                'name' => 'Balamb Garden',
                'parent' => 'balamb-alcauld-plains',
                'notes' => 'This is not an in-game location. It is used as a container for a subset of child locations.',
            ],
            [
                'name' => 'B-Garden - Front Gate',
                'parent' => 'balamb-garden',
            ],
            [
                'name' => 'B-Garden - Hall',
                'parent' => 'balamb-garden',
            ],
            [
                'name' => 'B-Garden - Hallway',
                'parent' => 'balamb-garden',
            ],
            [
                'name' => 'B-Garden - Infirmary',
                'parent' => 'balamb-garden',
            ],
            [
                'name' => 'B-Garden - Quad',
                'parent' => 'balamb-garden',
            ],
            [
                'name' => 'B-Garden - Cafeteria',
                'parent' => 'balamb-garden',
            ],
            [
                'name' => 'B-Garden - Dormitory Single',
                'parent' => 'balamb-garden',
            ],
            [
                'name' => 'B-Garden - Dormitory Double',
                'parent' => 'balamb-garden',
            ],
            [
                'name' => 'B-Garden - Parking Lot',
                'parent' => 'balamb-garden',
            ],
            [
                'name' => 'B-Garden - Training Center',
                'parent' => 'balamb-garden',
            ],
            [
                'name' => 'B-Garden - Secret Area',
                'parent' => 'balamb-garden',
            ],
            [
                'name' => 'B-Garden - Library',
                'parent' => 'balamb-garden',
            ],
            [
                'name' => 'B-Garden - 2F Hallway',
                'parent' => 'balamb-garden',
            ],
            [
                'name' => 'B-Garden - Classroom',
                'parent' => 'balamb-garden',
            ],
            [
                'name' => 'B-Garden - Deck',
                'parent' => 'balamb-garden',
            ],
            [
                'name' => "B-Garden - Headmaster's Office",
                'parent' => 'balamb-garden',
            ],
            [
                'name' => 'B-Garden - Ballroom',
                'parent' => 'balamb-garden',
            ],
            [
                'name' => 'B-Garden - Master Room',
                'parent' => 'balamb-garden',
            ],
            [
                'name' => 'B-Garden - MD Level',
                'parent' => 'balamb-garden',
            ],
        ];

        $dolletRegionLocations = [
            // Overworld Areas.
            [
                'name' => 'Dollet - Hasberry Plains',
                'parent' => 'dollet-region',
            ],
            [
                'name' => 'Dollet - Holy Glory Cape',
                'parent' => 'dollet-region',
            ],
            [
                'name' => 'Dollet - Long Horn Island',
                'parent' => 'dollet-region',
            ],
            [
                'name' => 'Dollet - Malgo Peninsula',
                'parent' => 'dollet-region',
            ],
            // Towns.
            [
                'name' => 'Dollet',
                'parent' => 'dollet-hasberry-plains',
                'notes' => 'This is not an in-game location. It is used as a container for a subset of child locations.',
            ],
            [
                'name' => 'Dollet - Town Square',
                'parent' => 'dollet',
            ],
            [
                'name' => 'Dollet - Residence',
                'parent' => 'dollet',
            ],
            [
                'name' => 'Dollet - Lapin Beach',
                'parent' => 'dollet',
            ],
            [
                'name' => 'Dollet Harbor',
                'parent' => 'dollet',
            ],
            [
                'name' => 'Dollet Pub',
                'parent' => 'dollet',
            ],
            [
                'name' => 'Dollet Hotel',
                'parent' => 'dollet',
            ],
            // Special Areas.
            [
                'name' => 'Dollet - Comm Tower',
                'parent' => 'dollet',
                'notes' => 'This area is only accessible during the SeeD training mission.',
            ],
            [
                'name' => 'Dollet - Mountain Hideout',
                'parent' => 'dollet',
                'notes' => 'This area is only accessible during the SeeD training mission.',
            ],
        ];

        $timberRegionLocations = [
            // Overworld Areas.
            [
                'name' => 'Timber - Lanker Plains',
                'parent' => 'timber-region',
            ],
            [
                'name' => 'Timber - Mandy Beach',
                'parent' => 'timber-region',
            ],
            [
                'name' => 'Timber - Nanchucket Island',
                'parent' => 'timber-region',
            ],
            [
                'name' => 'Timber - Obel Lake',
                'parent' => 'timber-region',
            ],
            [
                'name' => 'Timber - Roshfall Forest',
                'parent' => 'timber-region',
            ],
            [
                'name' => 'Timber - Shenand Island',
                'parent' => 'timber-region',
            ],
            [
                'name' => 'Timber - Yaulny Canyon',
                'parent' => 'timber-region',
            ],
            // Towns.
            [
                'name' => 'Timber',
                'parent' => 'timber-region',
                'notes' => 'This is not an in-game location. It is used as a container for a subset of child locations.',
            ],
            [
                'name' => 'Timber - City Square',
                'parent' => 'timber',
            ],
            [
                'name' => 'Timber - Editorial Department',
                'parent' => 'timber',
            ],
            [
                'name' => 'Timber - Residence (1)',
                'parent' => 'timber',
                'notes' => 'This area is next to the Timber Maniacs building and is the home that shelters the party after the TV broadcast.',
            ],
            [
                'name' => 'Timber - Residence (2)',
                'parent' => 'timber',
                'notes' => "This area is near the train tracks on the outskirts of town and is where the Owl's Tear is found.",
            ],
            [
                'name' => 'Timber - TV Screen',
                'parent' => 'timber',
            ],
            [
                'name' => 'Timber TV Station',
                'parent' => 'timber',
            ],
            [
                'name' => 'Timber Hotel',
                'parent' => 'timber',
            ],
            [
                'name' => 'Timber Pub',
                'parent' => 'timber',
            ],
            // Special Areas.
            [
                'name' => "Timber - Forest Owl's Base",
                'parent' => 'timber',
                'notes' => 'This area is only available during the Forest Owls mission when first arriving in Timber.',
            ],
            [
                'name' => 'Timber - Train',
                'parent' => 'timber',
                'notes' => 'This area is only available during the Forest Owls mission when first arriving in Timber, and is only used for the Gerogero boss fight.',
            ],
            [
                'name' => 'Timber Forest',
                'parent' => 'timber-region',
                'notes' => "This area is only accessible via Laguna's dream sequence.",
            ],
        ];

        $galbadiaRegionLocations = [
            // Overworld Areas.
            [
                'name' => 'Galbadia - Dingo Desert',
                'parent' => 'galbadia-region',
            ],
            [
                'name' => 'Galbadia - Gotland Peninsula',
                'parent' => 'galbadia-region',
            ],
            [
                'name' => 'Galbadia - Lallapalooza Canyon',
                'parent' => 'galbadia-region',
            ],
            [
                'name' => 'Galbadia - Monterosa Plateau',
                'parent' => 'galbadia-region',
            ],
            [
                'name' => 'Galbadia - Rem Archipelago',
                'parent' => 'galbadia-region',
            ],
            [
                'name' => 'Galbadia - Wilburn Hill',
                'parent' => 'galbadia-region',
            ],
            [
                'name' => 'Great Plains of Galbadia',
                'parent' => 'galbadia-region',
            ],
            [
                'name' => 'Island Closest to Hell',
                'parent' => 'galbadia-region',
            ],
            // Overworld Locations.
            [
                'name' => 'G-Garden - Station',
                'parent' => 'galbadia-monterosa-plateau',
            ],
            [
                'name' => 'Tomb of the Unknown King',
                'parent' => 'galbadia-gotland-peninsula',
            ],
            [
                'name' => 'Galbadia D-District Prison',
                'parent' => 'galbadia-dingo-desert',
            ],
            [
                'name' => 'Galbadia Missile Base',
                'parent' => 'great-plains-of-galbadia',
            ],
            // Towns.
            [
                'name' => 'Deling City',
                'parent' => 'great-plains-of-galbadia',
                'notes' => 'This is not an in-game location. It is used as a container for a subset of child locations.',
            ],
            [
                'name' => 'Deling City - City Square',
                'parent' => 'deling-city',
            ],
            [
                'name' => 'Deling City - Hotel',
                'parent' => 'deling-city',
            ],
            [
                'name' => 'Deling City - Club',
                'parent' => 'deling-city',
            ],
            [
                'name' => 'Deling City - Gateway',
                'parent' => 'deling-city',
            ],
            [
                'name' => 'Deling - Presidential Residence',
                'parent' => 'deling-city',
            ],
            [
                'name' => 'Deling City - Parade',
                'parent' => 'deling-city',
            ],
            [
                'name' => "Deling City - Caraway's Mansion",
                'parent' => 'deling-city',
            ],
            [
                'name' => 'Deling City - Sewer',
                'parent' => 'deling-city',
            ],
            [
                'name' => 'Deling City - Station Yard',
                'parent' => 'deling-city',
            ],
            [
                'name' => 'Galbadia Garden',
                'parent' => 'deling-city',
                'notes' => 'This is not an in-game location. It is used as a container for a subset of child locations.',
            ],
            [
                'name' => 'Galbadia Garden - Front Gate',
                'parent' => 'galbadia-garden',
            ],
            [
                'name' => 'G-Garden - Hall',
                'parent' => 'galbadia-garden',
            ],
            [
                'name' => 'G-Garden - Hallway',
                'parent' => 'galbadia-garden',
            ],
            [
                'name' => 'G-Garden - Reception Room',
                'parent' => 'galbadia-garden',
            ],
            [
                'name' => 'G-Garden - Classroom',
                'parent' => 'galbadia-garden',
            ],
            [
                'name' => 'G-Garden - Clubroom',
                'parent' => 'galbadia-garden',
            ],
            [
                'name' => 'G-Garden - Dormitory',
                'parent' => 'galbadia-garden',
            ],
            [
                'name' => 'G-Garden - Elevator Hall',
                'parent' => 'galbadia-garden',
            ],
            [
                'name' => 'G-Garden - Back Entrance',
                'parent' => 'galbadia-garden',
            ],
            [
                'name' => 'G-Garden - Stand',
                'parent' => 'galbadia-garden',
            ],
            [
                'name' => 'G-Garden - Gymnasium',
                'parent' => 'galbadia-garden',
            ],
            [
                'name' => 'G-Garden - Athletic Track',
                'parent' => 'galbadia-garden',
            ],
            [
                'name' => 'G-Garden - Master Room',
                'parent' => 'galbadia-garden',
            ],
            [
                'name' => 'G-Garden - Auditorium',
                'parent' => 'galbadia-garden',
            ],
            // Special Areas.
            [
                'name' => 'Desert',
                'parent' => 'galbadia-dingo-desert',
                'notes' => 'This area is where the party splits up after the prison escape at the beginning of disc 2.',
            ],
        ];

        $winhillRegionLocations = [
            // Overworld Areas.
            [
                'name' => 'Winhill - Humphrey Archipelago',
                'parent' => 'winhill-region',
            ],
            [
                'name' => 'Winhill - Winhill Bluffs',
                'parent' => 'winhill-region',
            ],
            // Towns.
            [
                'name' => 'Winhill',
                'parent' => 'winhill-winhill-bluffs',
                'notes' => 'This is not an in-game location. It is used as a container for a subset of child locations.',
            ],
            [
                'name' => 'Winhill Village',
                'parent' => 'winhill',
            ],
            [
                'name' => 'Winhill - Hotel',
                'parent' => 'winhill',
            ],
            [
                'name' => 'Winhill Pub',
                'parent' => 'winhill',
            ],
            [
                'name' => 'Winhill - Mansion',
                'parent' => 'winhill',
            ],
            [
                'name' => 'Winhill Vacant House',
                'parent' => 'winhill',
            ],
            [
                'name' => 'Winhill - Residence (1)',
                'parent' => 'winhill',
                'notes' => 'This area is located near the hotel and is home to an old couple.',
            ],
            [
                'name' => 'Winhill - Residence (2)',
                'parent' => 'winhill',
                'notes' => 'This area is located in the middle of town, past the chocobo crossing.',
            ],
        ];

        $internationalRegionLocations = [
            // Towns.
            [
                'name' => "Fisherman's Horizon",
                'slug' => "Fisherman's Horizon (1)",
                'parent' => 'international-region',
                'notes' => 'This is not an in-game location. It is used as a container for a subset of child locations.',
            ],
            [
                'name' => 'B-Garden - Deck (2)',
                'parent' => 'fishermans-horizon-1',
                'notes' => "This area is the section of Balamb Garden that connects to the Factory in Fisherman's Horizon.",
            ],
            [
                'name' => 'FH - Factory',
                'parent' => 'fishermans-horizon-1',
            ],
            [
                'name' => "Fisherman's Horizon",
                'slug' => "Fisherman's Horizon (2)",
                'parent' => 'fishermans-horizon-1',
            ],
            [
                'name' => 'FH - Sun Panel',
                'parent' => 'fishermans-horizon-1',
            ],
            [
                'name' => "FH - Mayor's House",
                'parent' => 'fishermans-horizon-1',
            ],
            [
                'name' => 'FH - Festival Grounds',
                'parent' => 'fishermans-horizon-1',
                'notes' => "This area is only available during the festival that takes place in Fisherman's Horizon",
            ],
            [
                'name' => 'FH - Residential Area',
                'parent' => 'fishermans-horizon-1',
            ],
            [
                'name' => 'FH - Hotel',
                'parent' => 'fishermans-horizon-1',
            ],
            [
                'name' => 'FH - Residence',
                'parent' => 'fishermans-horizon-1',
                'notes' => 'This area is home to Grease Monkey.',
            ],
            [
                'name' => 'FH - Station Yard',
                'parent' => 'fishermans-horizon-1',
            ],
            [
                'name' => 'Horizon Bridge',
                'parent' => 'fishermans-horizon-1',
            ],
            [
                'name' => 'Seaside Station',
                'parent' => 'fishermans-horizon-1',
            ],
        ];

        $trabiaRegionLocations = [
            // Overworld Areas.
            [
                'name' => 'Trabia - Albatross Archipelago',
                'parent' => 'trabia-region',
            ],
            [
                'name' => 'Trabia - Hawkwind Plains',
                'parent' => 'trabia-region',
            ],
            [
                'name' => 'Trabia - Bika Snowfield',
                'parent' => 'trabia-region',
            ],
            [
                'name' => 'Trabia - Thor Peninsula',
                'parent' => 'trabia-region',
            ],
            [
                'name' => 'Trabia - Heath Peninsula',
                'parent' => 'trabia-region',
            ],
            [
                'name' => 'Trabia - Trabia Crater',
                'parent' => 'trabia-region',
            ],
            [
                'name' => 'Trabia - Eldbeak Peninsula',
                'parent' => 'trabia-region',
            ],
            [
                'name' => 'Trabia - Sorbald Snowfield',
                'parent' => 'trabia-region',
            ],
            [
                'name' => 'Trabia - Winter Island',
                'parent' => 'trabia-region',
            ],
            [
                'name' => 'Trabia - Vienne Mountains',
                'parent' => 'trabia-region',
            ],
            // Overworld Locations.
            [
                'name' => 'Trabia Canyon',
                'parent' => 'trabia-vienne-mountains',
            ],
            // Towns.
            [
                'name' => 'Shumi Village',
                'parent' => 'trabia-winter-island',
                'notes' => 'This is not an in-game location. It is used as a container for a subset of child locations.',
            ],
            [
                'name' => 'Mystery Dome',
                'parent' => 'shumi-village',
            ],
            [
                'name' => 'Shumi Village - Desert Village',
                'parent' => 'shumi-village',
            ],
            [
                'name' => 'Shumi Village - Elevator',
                'parent' => 'shumi-village',
            ],
            [
                'name' => 'Shumi Village - Village',
                'parent' => 'shumi-village',
            ],
            [
                'name' => 'Shumi Village - Hotel',
                'parent' => 'shumi-village',
            ],
            [
                'name' => 'Shumi Village - Residence (1)',
                'parent' => 'shumi-village',
                'notes' => 'This is the area where the occupant is washing dishes.',
            ],
            [
                'name' => 'Shumi Village - Residence (2)',
                'parent' => 'shumi-village',
                'notes' => 'This is the area with the artisans and the statue of Laguna.',
            ],
            [
                'name' => 'Shumi Village - Residence (3)',
                'parent' => 'shumi-village',
                'notes' => 'This is the area where the elder resides.',
            ],
            [
                'name' => 'Trabia Garden',
                'parent' => 'trabia-bika-snowfield',
                'notes' => 'This is not an in-game location. It is used as a container for a subset of child locations.',
            ],
            [
                'name' => 'Trabia Garden - Front Gate',
                'parent' => 'trabia-garden',
            ],
            [
                'name' => 'T-Garden - Cemetery',
                'parent' => 'trabia-garden',
            ],
            [
                'name' => 'T-Garden - Garage',
                'parent' => 'trabia-garden',
            ],
            [
                'name' => 'T-Garden - Classroom',
                'parent' => 'trabia-garden',
            ],
            [
                'name' => 'T-Garden - Festival Stage',
                'parent' => 'trabia-garden',
            ],
            [
                'name' => 'T-Garden - Athletic Ground',
                'parent' => 'trabia-garden',
            ],
            // Special Areas.
            [
                'name' => "Chocobo Forest (The Beginner's Forest)",
                'parent' => 'trabia-winter-island',
                'notes' => 'This area is located right next to Shumi Village.',
            ],
            [
                'name' => 'Chocobo Forest (The Basics Forest)',
                'parent' => 'trabia-sorbald-snowfield',
                'notes' => 'This area is located just South of Shumi Village.',
            ],
            [
                'name' => 'Chocobo Forest (The Roaming Forest)',
                'parent' => 'trabia-bika-snowfield',
                'notes' => 'This area is located just North of Trabia Garden.',
            ],
        ];

        $centraRegionLocations = [
            // Overworld Areas.
            [
                'name' => 'Centra - Almaj Mountains',
                'parent' => 'centra-region',
            ],
            [
                'name' => 'Centra - Cape of Good Hope',
                'parent' => 'centra-region',
            ],
            [
                'name' => 'Centra - Centra Crater',
                'parent' => 'centra-region',
            ],
            [
                'name' => 'Centra - Lenown Plains',
                'parent' => 'centra-region',
            ],
            [
                'name' => 'Centra - Lolestern Plains',
                'parent' => 'centra-region',
            ],
            [
                'name' => 'Centra - Nectar Peninsula',
                'parent' => 'centra-region',
            ],
            [
                'name' => 'Centra - Poccarahi island',
                'parent' => 'centra-region',
            ],
            [
                'name' => 'Centra - Serengetti Plains',
                'parent' => 'centra-region',
            ],
            [
                'name' => 'Centra - Yorn Mountains',
                'parent' => 'centra-region',
            ],
            // Overworld Locations.
            [
                'name' => 'Centra Ruins',
                'parent' => 'centra-centra-crater',
            ],
            [
                'name' => "Edea's House",
                'parent' => 'centra-cape-of-good-hope',
            ],
            [
                'name' => "Edea's House",
                'slug' => "Edea's House (1)",
                'parent' => 'centra-cape-of-good-hope',
                'notes' => 'This is not an in-game location. It is used as a container for a subset of child locations.',
            ],
            [
                'name' => "Edea's House",
                'slug' => "Edea's House (2)",
                'parent' => 'edeas-house-1',
            ],
            [
                'name' => "Edea's House - Bedroom",
                'parent' => 'edeas-house-1',
            ],
            [
                'name' => "Edea's House - Backyard",
                'parent' => 'edeas-house-1',
            ],
            [
                'name' => "Edea's House - Playroom",
                'parent' => 'edeas-house-1',
            ],
            [
                'name' => "Edea's House - Oceanside",
                'parent' => 'edeas-house-1',
            ],
            [
                'name' => "Edea's House - Flower Field",
                'parent' => 'edeas-house-1',
            ],
            // Special Areas.
            [
                'name' => 'Centra - Excavation Site',
                'parent' => 'centra-region',
                'notes' => 'This are is only available during the Laguna dream sequence.',
            ],
            [
                'name' => 'White SeeD Ship',
                'slug' => 'White SeeD Ship (1)',
                'parent' => 'centra-region',
                'notes' => 'This is not an in-game location. It is used as a container for a subset of child locations.',
            ],
            [
                'name' => 'White SeeD Ship',
                'slug' => 'White SeeD Ship (2)',
                'parent' => 'white-seed-ship-1',
            ],
            [
                'name' => 'White SeeD Ship - Cabin',
                'parent' => 'white-seed-ship-1',
            ],
            [
                'name' => 'Chocobo Forest (The Forest of Solitude)',
                'parent' => 'centra-nectar-peninsula',
                'notes' => 'This area is located on the Northeastern side of the Centra continent, on Nectar Peninsula.',
            ],
            [
                'name' => 'Chocobo Forest (The Forest of Fun)',
                'parent' => 'centra-lenown-plains',
                'notes' => "This area is located right next to Edea's House.",
            ],
        ];

        $estharRegionLocations = [
            //Overworld Areas.
            [
                'name' => 'Esthar - Abadan Plains',
                'parent' => 'esthar-region',
            ],
            [
                'name' => 'Esthar - Cactuar Island',
                'parent' => 'esthar-region',
                'notes' => 'This area is located to the Southeast of Esthar and requires the Ragnarok. However, there is a bug in the game that will allow the player to encounter Cactuars if they run along the edge of the continent directly to the West of the island, which is accessible as soon as the player controls Balamb Garden.',
            ],
            [
                'name' => 'Esthar - Fulcura Archipelago',
                'parent' => 'esthar-region',
            ],
            [
                'name' => 'Esthar - Grandidi forest',
                'parent' => 'esthar-region',
            ],
            [
                'name' => 'Esthar - Great Salt Lake',
                'parent' => 'esthar-region',
            ],
            [
                'name' => 'Esthar - Kashkabald Desert',
                'parent' => 'esthar-region',
            ],
            [
                'name' => 'Esthar - Millefeuille Archipelago',
                'parent' => 'esthar-region',
            ],
            [
                'name' => 'Esthar - Minde Island',
                'parent' => 'esthar-region',
            ],
            [
                'name' => 'Esthar - Mordred Plains',
                'parent' => 'esthar-region',
            ],
            [
                'name' => 'Esthar - Nortes Mountains',
                'parent' => 'esthar-region',
            ],
            [
                'name' => 'Esthar - Shalmal Peninsula',
                'parent' => 'esthar-region',
            ],
            [
                'name' => 'Esthar - Sollet mountains',
                'parent' => 'esthar-region',
            ],
            [
                'name' => 'Esthar - Talle Mountains',
                'parent' => 'esthar-region',
            ],
            [
                'name' => 'Esthar - West Coast',
                'parent' => 'esthar-region',
            ],
            [
                'name' => 'Esthar City',
                'slug' => 'Esthar City (1)',
                'parent' => 'esthar-region',
            ],
            [
                'name' => 'Great Plains of Esthar',
                'parent' => 'esthar-region',
            ],
            [
                'name' => 'Island Closest to Heaven',
                'parent' => 'esthar-region',
            ],
            // Overworld Locations.
            [
                'name' => 'Great Salt Lake',
                'slug' => 'Great Salt Lake (1)',
                'parent' => 'esthar-great-salt-lake',
                'notes' => 'This is not an in-game location. It is used as a container for a subset of child locations.',
            ],
            [
                'name' => 'Great Salt Lake',
                'parent' => 'great-salt-lake-1',
            ],
            [
                'name' => 'Mystery Building',
                'parent' => 'great-salt-lake-1',
            ],
            [
                'name' => "Tears' Point",
                'parent' => 'great-plains-of-esthar',
            ],
            [
                'name' => 'Lunatic Pandora Laboratory',
                'parent' => 'great-plains-of-esthar',
            ],
            [
                'name' => 'Esthar Sorceress Memorial',
                'slug' => 'Esthar Sorceress Memorial (1)',
                'parent' => 'great-plains-of-esthar',
                'notes' => 'This is not an in-game location. It is used as a container for a subset of child locations.',
            ],
            [
                'name' => 'Esthar Sorceress Memorial',
                'slug' => 'Esthar Sorceress Memorial (2)',
                'parent' => 'esthar-sorceress-memorial-1',
            ],
            [
                'name' => 'Sorceress Memorial - Entrance',
                'parent' => 'esthar-sorceress-memorial-1',
            ],
            [
                'name' => 'Sorceress Memorial - Hall',
                'parent' => 'esthar-sorceress-memorial-1',
            ],
            [
                'name' => 'Sorceress Memorial - Pod',
                'parent' => 'esthar-sorceress-memorial-1',
            ],
            [
                'name' => 'Sorceress Memorial - Ctrl Room',
                'parent' => 'esthar-sorceress-memorial-1',
            ],
            [
                'name' => 'Lunar Base',
                'slug' => 'Lunar Base (1)',
                'parent' => 'great-plains-of-esthar',
                'notes' => 'This is not an in-game location. It is used as a container for a subset of child locations.',
            ],
            [
                'name' => 'Lunar Base',
                'slug' => 'Lunar Base (2)',
                'parent' => 'lunar-base-1',
            ],
            [
                'name' => 'Lunar Base - Concourse',
                'parent' => 'lunar-base-1',
            ],
            [
                'name' => 'Lunar Base - Deep Freeze',
                'parent' => 'lunar-base-1',
            ],
            [
                'name' => 'Lunatic Pandora',
                'parent' => 'great-plains-of-esthar',
            ],
            [
                'name' => 'Commencement Room',
                'parent' => 'lunatic-pandora',
                'notes' => 'This area is only accessible on disc 4, and is the location that the party finds themselves during time compression.',
            ],
            // Towns.
            [
                'name' => 'Esthar City',
                'slug' => 'Esthar City (2)',
                'parent' => 'esthar-city-1',
                'notes' => 'This is not an in-game location. It is used as a container for a subset of child locations.',
            ],
            [
                'name' => 'Esthar - City',
                'slug' => 'Esthar City (3)',
                'parent' => 'esthar-city-2',
            ],
            [
                'name' => 'Esthar - Airstation',
                'parent' => 'esthar-city-2',
            ],
            [
                'name' => 'Presidential Palace',
                'parent' => 'esthar-city-2',
                'notes' => 'This is not an in-game location. It is used as a container for a subset of child locations.',
            ],
            [
                'name' => 'Presidential Palace - Hall',
                'parent' => 'presidential-palace',
            ],
            [
                'name' => 'Presidential Palace - Hallway',
                'parent' => 'presidential-palace',
            ],
            [
                'name' => 'Presidential Palace - Office',
                'parent' => 'presidential-palace',
            ],
            [
                'name' => "Dr. Odine's Laboratory",
                'parent' => 'esthar-city-2',
                'notes' => 'This is not an in-game location. It is used as a container for a subset of child locations.',
            ],
            [
                'name' => "Esthar - Odine's Laboratory",
                'parent' => 'dr-odines-laboratory',
            ],
            [
                'name' => "Dr. Odine's Laboratory - Lobby",
                'parent' => 'dr-odines-laboratory',
            ],
            [
                'name' => "Dr. Odine's Laboratory - Lab",
                'parent' => 'dr-odines-laboratory',
            ],
            // Special Areas.
            [
                'name' => 'Spaceship Landing Zone',
                'parent' => 'esthar-kashkabald-desert',
                'notes' => 'This is where Rinoa is taken from the Ragnarok upon returning from space.',
            ],
            [
                'name' => 'Emergency Landing Zone',
                'parent' => 'esthar-abadan-plains',
                'notes' => "This area is where Piet is located after the events in space. It is labeled as 'Esthar - Abadan Plains' in the game menu.",
            ],
            [
                'name' => 'Lunar Base',
                'parent' => 'esthar-region',
                'notes' => 'This is not an in-game location. It is used as a container for a subset of child locations.',
            ],
            [
                'name' => 'Lunar Base - Control Room',
                'parent' => 'lunar-base',
            ],
            [
                'name' => 'Lunar Base - Medical Room',
                'parent' => 'lunar-base',
            ],
            [
                'name' => 'Lunar Base - Pod',
                'parent' => 'lunar-base',
            ],
            [
                'name' => 'Lunar Base - Dock',
                'parent' => 'lunar-base',
            ],
            [
                'name' => 'Lunar Base - Passageway',
                'parent' => 'lunar-base',
            ],
            [
                'name' => 'Lunar Base - Locker',
                'parent' => 'lunar-base',
            ],
            [
                'name' => 'Lunar Base - Residential Zone',
                'parent' => 'lunar-base',
            ],
            [
                'name' => 'Chocobo Forest (The Enclosed Forest)',
                'parent' => 'esthar-talle-mountains',
                'notes' => 'This area is located on the Southeastern tip of the Esthar continent, just East of the Centra continent.',
            ],
            [
                'name' => 'Chocobo Forest (The Chocobo Sanctuary)',
                'parent' => 'esthar-grandidi-forest',
                'notes' => 'This area is located within the lower section of Grandidi Forest. In order to reach this location, the player must catch all 6 chocobos from the other forests. Once this has been completed, they must return to the Roaming Forest in Bika Snowfield on the Trabia continent to catch a chocobo and make their way to this one.',
            ],
        ];

        $wildernessRegionLocations = [
            // Special Locations.
            [
                'name' => 'Wilderness',
                'parent' => 'wilderness-region',
                'notes' => "This is the rea outside of Ultimecia's Castle",
            ],
            [
                'name' => "Ultimecia's Castle",
                'parent' => 'wilderness-region',
                'notes' => 'This is not an in-game location. It is used as a container for a subset of child locations.',
            ],
            [
                'name' => 'Ultimecia Castle',
                'parent' => 'ultimecias-castle',
            ],
            [
                'name' => 'Ultimecia Castle - Hall',
                'parent' => 'ultimecias-castle',
            ],
            [
                'name' => 'Ultimecia Castle - Grand Hall',
                'parent' => 'ultimecias-castle',
            ],
            [
                'name' => 'Ultimecia Castle - Terrace',
                'parent' => 'ultimecias-castle',
            ],
            [
                'name' => 'Ultimecia Castle - Wine Cellar',
                'parent' => 'ultimecias-castle',
            ],
            [
                'name' => 'Ultimecia Castle - Passageway',
                'parent' => 'ultimecias-castle',
            ],
            [
                'name' => 'Ultimecia Castle - Elevator Hall',
                'parent' => 'ultimecias-castle',
            ],
            [
                'name' => 'Ultimecia Castle - Stairway Hall',
                'parent' => 'ultimecias-castle',
            ],
            [
                'name' => 'Ultimecia Castle - Treasure Rm',
                'parent' => 'ultimecias-castle',
            ],
            [
                'name' => 'Ultimecia Castle - Storage Room',
                'parent' => 'ultimecias-castle',
            ],
            [
                'name' => 'Ultimecia Castle - Art Gallery',
                'parent' => 'ultimecias-castle',
            ],
            [
                'name' => 'Ultimecia Castle - Flood Gate',
                'parent' => 'ultimecias-castle',
            ],
            [
                'name' => 'Ultimecia Castle - Armory',
                'parent' => 'ultimecias-castle',
            ],
            [
                'name' => 'Ultimecia Castle - Prison Cell',
                'parent' => 'ultimecias-castle',
            ],
            [
                'name' => 'Ultimecia Castle - Waterway',
                'parent' => 'ultimecias-castle',
            ],
            [
                'name' => 'Ultimecia Castle - Courtyard',
                'parent' => 'ultimecias-castle',
            ],
            [
                'name' => 'Ultimecia Castle - Chapel',
                'parent' => 'ultimecias-castle',
            ],
            [
                'name' => 'Ultimecia Castle - Clock Tower',
                'parent' => 'ultimecias-castle',
            ],
            [
                'name' => 'Ultimecia Castle - Master Room',
                'parent' => 'ultimecias-castle',
            ],
        ];

        $noneRegionLocations = [
            // Special Locations.
            [
                'name' => 'Ragnarok',
                'parent' => 'none',
                'notes' => 'This is not an in-game location. It is used as a container for a subset of child locations.',
            ],
            [
                'name' => 'Ragnarok - Entrance',
                'parent' => 'ragnarok',
            ],
            [
                'name' => 'Ragnarok - Aisle',
                'parent' => 'ragnarok',
            ],
            [
                'name' => 'Ragnarok - Passenger Seat',
                'parent' => 'ragnarok',
            ],
            [
                'name' => 'Ragnarok - Cockpit',
                'parent' => 'ragnarok',
            ],
            [
                'name' => 'Ragnarok - Hangar',
                'parent' => 'ragnarok',
            ],
            [
                'name' => 'Ragnarok - Air Room',
                'parent' => 'ragnarok',
            ],
            [
                'name' => 'Ragnarok - Space Hatch',
                'parent' => 'ragnarok',
            ],
            [
                'name' => 'Deep Sea Research Center',
                'slug' => 'Deep Sea Research Center (1)',
                'parent' => 'none',
                'notes' => 'This is not an in-game location. It is used as a container for a subset of child locations.',
            ],
            [
                'name' => 'Deep Sea Research Center',
                'slug' => 'Deep Sea Research Center (2)',
                'parent' => 'deep-sea-research-center-1',
            ],
            [
                'name' => 'Deep Sea Research Center - Lb',
                'parent' => 'deep-sea-research-center-1',
            ],
            [
                'name' => 'Deep Sea Research Center - Lv (1)',
                'parent' => 'deep-sea-research-center-1',
            ],
            [
                'name' => 'Deep Sea Research Center - Lv (2)',
                'parent' => 'deep-sea-research-center-1',
            ],
            [
                'name' => 'Deep Sea Research Center - Lv (3)',
                'parent' => 'deep-sea-research-center-1',
            ],
            [
                'name' => 'Deep Sea Research Center - Lv (4)',
                'parent' => 'deep-sea-research-center-1',
            ],
            [
                'name' => 'Deep Sea Research Center - Lv (5)',
                'parent' => 'deep-sea-research-center-1',
            ],
            [
                'name' => 'Deep Sea Deposit',
                'parent' => 'deep-sea-research-center-1',
            ],
        ];

        // Loop through all of the regions first so that we can
        // make sure they are always sorted at the top of the list.
        $sortId = 1;
        foreach ($regions as $regionKey => $region) {
            $regions[$regionKey]['id'] = Uuid::generate(4);
            $regions[$regionKey]['region_id'] = null;
            $regions[$regionKey]['parent_id'] = null;
            $regions[$regionKey]['sort_id'] = $sortId;
            $regions[$regionKey]['slug'] = Str::slug($region['name']);
            $regions[$regionKey]['notes'] = 'This is not an in-game location. It is used as a container for a subset of child locations.';
            $regions[$regionKey]['created_at'] = Carbon::now();
            $regions[$regionKey]['updated_at'] = Carbon::now();
            $sortId++;
        }

        // Next, set up all of the data required for each area as it is associated with each region.
        // We're using "variable variables" here to make things easier to digest within loops.
        foreach ($regions as $region) {
            $regionKey = explode('-', $region['slug'])[0];
            $regionRecord = "{$regionKey}Region";
            $regionLocations = "{$regionKey}RegionLocations";

            ${$regionRecord} = $this->getLocationBySlug("{$regionKey}-region", $regions) ?: $this->getLocationBySlug("{$regionKey}", $regions);
            foreach (${$regionLocations} as $locationKey => $area) {
                $parentId = null;
                if (array_key_exists('parent', $area)) {
                    $parentLocation = $area['parent'] === ${$regionRecord}['slug']
                        ? ${$regionRecord}
                        : $this->getLocationBySlug($area['parent'], ${$regionLocations});

                    $parentId = $parentLocation['id'];
                    unset(${$regionLocations}[$locationKey]['parent']);
                }

                $slug = array_key_exists('slug', $area) ? Str::slug($area['slug']) : Str::slug($area['name']);
                $notes = array_key_exists('notes', $area) ? $area['notes'] : null;

                ${$regionLocations}[$locationKey]['id'] = Uuid::generate(4);
                ${$regionLocations}[$locationKey]['region_id'] = ${$regionRecord}['id'];
                ${$regionLocations}[$locationKey]['parent_id'] = $parentId;
                ${$regionLocations}[$locationKey]['sort_id'] = $sortId;
                ${$regionLocations}[$locationKey]['slug'] = $slug;
                ${$regionLocations}[$locationKey]['notes'] = $notes;
                ${$regionLocations}[$locationKey]['created_at'] = Carbon::now();
                ${$regionLocations}[$locationKey]['updated_at'] = Carbon::now();
                $sortId++;
            }
        }

        // Insert the records in bulk.
        $location = new Location();
        $location->insert($regions);
        foreach ($regions as $region) {
            $regionKey = explode('-', $region['slug'])[0];
            $regionLocations = "{$regionKey}RegionLocations";
            $location->insert(${$regionLocations});
        }
    }

    /**
     * Find a location array using a given slug.
     *
     * @param string                           $slug      The slug to search for
     * @param array<int, array<string, mixed>> $locations The locations to search through
     *
     * @return array<string, mixed>
     */
    protected function getLocationBySlug(string $slug, array $locations): array
    {
        $key = array_search($slug, array_column($locations, 'slug'));

        return $key === false ? [] : $locations[$key];
    }
}
