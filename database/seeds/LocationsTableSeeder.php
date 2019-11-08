<?php

use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
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
        // Base Regions
        $balambRegion = (new Location())->create([
            'id' => Uuid::generate(4),
            'name' => 'Balamb Region',
            'region_id' => null,
            'description' => '',
            'area' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $timberRegion = (new Location())->create([
            'id' => Uuid::generate(4),
            'name' => 'Timber Region',
            'region_id' => null,
            'description' => '',
            'area' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $dolletRegion = (new Location())->create([
            'id' => Uuid::generate(4),
            'name' => 'Dollet Region',
            'region_id' => null,
            'description' => '',
            'area' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $timberForest = (new Location())->create([
            'id' => Uuid::generate(4),
            'name' => 'Timber Forest',
            'region_id' => null,
            'description' => '',
            'area' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $galbadiaRegion = (new Location())->create([
            'id' => Uuid::generate(4),
            'name' => 'Galbadia Region',
            'region_id' => null,
            'description' => '',
            'area' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $centraExcavationSite = (new Location())->create([
            'id' => Uuid::generate(4),
            'name' => 'Centra Excavation Site',
            'region_id' => null,
            'description' => '',
            'area' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $winhillRegion = (new Location())->create([
            'id' => Uuid::generate(4),
            'name' => 'Winhill Region',
            'region_id' => null,
            'description' => '',
            'area' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $desert = (new Location())->create([
            'id' => Uuid::generate(4),
            'name' => 'Desert',
            'region_id' => null,
            'description' => '',
            'area' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $fishermansHorizon = (new Location())->create([
            'id' => Uuid::generate(4),
            'name' => 'Fishermans Horizon',
            'region_id' => null,
            'description' => '',
            'area' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $trabiaRegion = (new Location())->create([
            'id' => Uuid::generate(4),
            'name' => 'Trabia Region',
            'region_id' => null,
            'description' => '',
            'area' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $centraRegion = (new Location())->create([
            'id' => Uuid::generate(4),
            'name' => 'Centra Region',
            'region_id' => null,
            'description' => '',
            'area' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $estharRegion = (new Location())->create([
            'id' => Uuid::generate(4),
            'name' => 'Esthar Region',
            'region_id' => null,
            'description' => '',
            'area' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $lunarBase = (new Location())->create([
            'id' => Uuid::generate(4),
            'name' => 'Lunar Base',
            'region_id' => null,
            'description' => '',
            'area' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $deepSeaResearchCenter = (new Location())->create([
            'id' => Uuid::generate(4),
            'name' => 'Deep Sea Research Center',
            'region_id' => null,
            'description' => '',
            'area' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $islandClosestToHeaven = (new Location())->create([
            'id' => Uuid::generate(4),
            'name' => 'Island Closest to Heaven',
            'region_id' => null,
            'description' => '',
            'area' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $islandClosestToHell = (new Location())->create([
            'id' => Uuid::generate(4),
            'name' => 'Island Closest to Hell',
            'region_id' => null,
            'description' => '',
            'area' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Special Considerations
        $esthar = (new Location())->create([
            'id' => Uuid::generate(4),
            'name' => 'Esthar',
            'region_id' => $estharRegion->id,
            'description' => '',
            'area' => 'Esthar City',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $lunaticPandora = (new Location())->create([
            'id' => Uuid::generate(4),
            'name' => 'Lunatic Pandora',
            'region_id' => $estharRegion->id,
            'description' => '',
            'area' => 'Great Plains of Esthar',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $greatSaltLake = (new Location())->create([
            'id' => Uuid::generate(4),
            'name' => 'Great Salt Lake',
            'region_id' => $estharRegion->id,
            'description' => '',
            'area' => 'Great Salt Lake',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $mysteryBuilding = (new Location())->create([
            'id' => Uuid::generate(4),
            'name' => 'Mystery Building',
            'region_id' => $greatSaltLake->id,
            'description' => '',
            'area' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $commencementRoom = (new Location())->create([
            'id' => Uuid::generate(4),
            'name' => 'Commencement Room',
            'region_id' => $lunaticPandora->id,
            'description' => '',
            'area' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $wilderness = (new Location())->create([
            'id' => Uuid::generate(4),
            'name' => 'Wilderness',
            'region_id' => $commencementRoom->id,
            'description' => '',
            'area' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $ultimeciaCastle = (new Location())->create([
            'id' => Uuid::generate(4),
            'name' => 'Ultimecia Castle',
            'region_id' => $wilderness->id,
            'description' => '',
            'area' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Locations
        $balambLocations = (new Location())->insert([
            [
                'id' => Uuid::generate(4),
                'name' => 'Balamb Garden',
                'region_id' => $balambRegion->id,
                'description' => '',
                'area' => 'Alcauld Plains',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Fire Cavern',
                'region_id' => $balambRegion->id,
                'description' => '',
                'area' => 'Alcauld Plains',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Balamb',
                'region_id' => $balambRegion->id,
                'description' => '',
                'area' => 'Alcauld Plains',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        $centraLocations = (new Location())->insert([
            [
                'id' => Uuid::generate(4),
                'name' => "Edea's House",
                'region_id' => $centraRegion->id,
                'description' => '',
                'area' => 'Cape of Good Hope',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Centra Ruins',
                'region_id' => $centraRegion->id,
                'description' => '',
                'area' => 'Centra Crater',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Chocobo Forest (Lenown Plains)',
                'region_id' => $centraRegion->id,
                'description' => '',
                'area' => 'Lenown Plains',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Chocobo Forest (Nectar Peninsula)',
                'region_id' => $centraRegion->id,
                'description' => '',
                'area' => 'Nectar Peninsula',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'White SeeD Ship',
                'region_id' => $centraRegion->id,
                'description' => '',
                'area' => 'Cape of Good Hope',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        $deepSeaResearchCenterLocations = (new Location())->insert([
            [
                'id' => Uuid::generate(4),
                'name' => 'Deep Sea Deposit',
                'region_id' => $deepSeaResearchCenter->id,
                'description' => '',
                'area' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        $dolletRegionLocations = (new Location())->insert([
            [
                'id' => Uuid::generate(4),
                'name' => 'Dollet',
                'region_id' => $dolletRegion->id,
                'description' => '',
                'area' => 'Hasberry Plains',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Dollet Station',
                'region_id' => $dolletRegion->id,
                'description' => '',
                'area' => 'Hasberry Plains',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        $estharLocations = (new Location())->insert([
            [
                'id' => Uuid::generate(4),
                'name' => "Dr. Odine's Laboratory",
                'region_id' => $esthar->id,
                'description' => '',
                'area' => "Odine's Laboratory",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Presidential Palace',
                'region_id' => $esthar->id,
                'description' => '',
                'area' => 'Presidential Palace',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        $estharRegionLocations = (new Location())->insert([
            [
                'id' => Uuid::generate(4),
                'name' => 'Crash Site',
                'region_id' => $estharRegion->id,
                'description' => '',
                'area' => 'Abadan Plains',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Esthar',
                'region_id' => $estharRegion->id,
                'description' => '',
                'area' => 'Esthar City',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Chocobo Forest (Grandidi Forest)',
                'region_id' => $estharRegion->id,
                'description' => '',
                'area' => 'Grandidi Forest',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Lunatic Pandora Laboratory',
                'region_id' => $estharRegion->id,
                'description' => '',
                'area' => 'Great Plains of Esthar',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Esthar Sorceress Memorial',
                'region_id' => $estharRegion->id,
                'description' => '',
                'area' => 'Great Plains of Esthar',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => "Tears' Point",
                'region_id' => $estharRegion->id,
                'description' => '',
                'area' => 'Great Plains of Esthar',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Lunar Gate',
                'region_id' => $estharRegion->id,
                'description' => '',
                'area' => 'Great Plains of Esthar',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Ragnarok',
                'region_id' => $estharRegion->id,
                'description' => '',
                'area' => 'Kashkabald Desert',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Chocobo Forest (Talle Mountains)',
                'region_id' => $estharRegion->id,
                'description' => '',
                'area' => 'Talle Mountains',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Seaside Station',
                'region_id' => $estharRegion->id,
                'description' => '',
                'area' => 'West Coast',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        $galbadiaRegionLocations = (new Location())->insert([
            [
                'id' => Uuid::generate(4),
                'name' => 'Galbadia D-District Prison',
                'region_id' => $galbadiaRegion->id,
                'description' => '',
                'area' => 'Dingo Desert',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Tomb of the Unknown King',
                'region_id' => $galbadiaRegion->id,
                'description' => '',
                'area' => 'Gotland Peninsula',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Deling City',
                'region_id' => $galbadiaRegion->id,
                'description' => '',
                'area' => 'Great Plains of Galbadia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Desert Prison Station',
                'region_id' => $galbadiaRegion->id,
                'description' => '',
                'area' => 'Great Plains of Galbadia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Galbadia Missile Base',
                'region_id' => $galbadiaRegion->id,
                'description' => '',
                'area' => 'Great Plains of Galbadia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Galbadia Garden',
                'region_id' => $galbadiaRegion->id,
                'description' => '',
                'area' => 'Monterosa Plateau',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Galbadia Garden Station',
                'region_id' => $galbadiaRegion->id,
                'description' => '',
                'area' => 'Monterosa Plateau',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        $timberRegionLocation = (new Location())->insert([
            [
                'id' => Uuid::generate(4),
                'name' => 'Timber',
                'region_id' => $timberRegion->id,
                'description' => '',
                'area' => 'Lanker Plains',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'East Academy Station',
                'region_id' => $timberRegion->id,
                'description' => '',
                'area' => 'Yaulny Canyon',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        $trabiaRegionLocation = (new Location())->insert([
            [
                'id' => Uuid::generate(4),
                'name' => 'Trabia Garden',
                'region_id' => $trabiaRegion->id,
                'description' => '',
                'area' => 'Bika Snowfield',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Chocobo Forest (Bika Snowfield)',
                'region_id' => $trabiaRegion->id,
                'description' => '',
                'area' => 'Bika Snowfield',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Chocobo Forest (Sorbald Snowfield)',
                'region_id' => $trabiaRegion->id,
                'description' => '',
                'area' => 'Sorbald Snowfield',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Trabia Canyon',
                'region_id' => $trabiaRegion->id,
                'description' => '',
                'area' => 'Vienne Mountains',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Shumi Village',
                'region_id' => $trabiaRegion->id,
                'description' => '',
                'area' => 'Winter Island',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Uuid::generate(4),
                'name' => 'Chocobo Forest (Winter Island)',
                'region_id' => $trabiaRegion->id,
                'description' => '',
                'area' => 'Winter Island',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        $winhillRegion = (new Location())->insert([
            [
                'id' => Uuid::generate(4),
                'name' => 'Winhill',
                'region_id' => $winhillRegion->id,
                'description' => '',
                'area' => 'Winhill Bluffs',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
