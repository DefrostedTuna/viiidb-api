<?php

use App\Models\Stat;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class StatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stats = [
            [
                'name' => 'hit points',
                'abbreviation' => 'hp',
            ],
            [
                'name' => 'strength',
                'abbreviation' => 'str',
            ],
            [
                'name' => 'vitality',
                'abbreviation' => 'vit',
            ],
            [
                'name' => 'magic',
                'abbreviation' => 'mag',
            ],
            [
                'name' => 'spirit',
                'abbreviation' => 'spr',
            ],
            [
                'name' => 'speed',
                'abbreviation' => 'spd',
            ],
            [
                'name' => 'luck',
                'abbreviation' => 'luck',
            ],
            [
                'name' => 'evade',
                'abbreviation' => 'eva',
            ],
            [
                'name' => 'hit',
                'abbreviation' => 'hit',
            ],
        ];

        // Assign a UUID and timestamp to each record.
        // Do this in bulk to maintain readability.
        foreach ($stats as $key => $value) {
            $stats[$key]['id'] = Uuid::generate(4);
            $stats[$key]['created_at'] = Carbon::now();
            $stats[$key]['updated_at'] = Carbon::now();
        }

        $stat = new Stat();

        $stat->insert($stats);
    }
}
