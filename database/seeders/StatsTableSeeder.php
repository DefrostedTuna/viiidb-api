<?php

namespace Database\Seeders;

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
        $stats = $this->getStats();

        foreach ($stats as $key => $value) {
            $stats[$key]['id'] = Uuid::generate(4);
            $stats[$key]['created_at'] = Carbon::now();
            $stats[$key]['updated_at'] = Carbon::now();
        }

        $stat = new Stat();

        $stat->insert($stats);
    }

    /**
     * The Stats to be inserted into the database.
     *
     * @return array
     */
    public function getStats(): array
    {
        return [
            [
                'sort_id' => 1,
                'name' => 'hit points',
                'abbreviation' => 'hp',
            ],
            [
                'sort_id' => 2,
                'name' => 'strength',
                'abbreviation' => 'str',
            ],
            [
                'sort_id' => 3,
                'name' => 'vitality',
                'abbreviation' => 'vit',
            ],
            [
                'sort_id' => 4,
                'name' => 'magic',
                'abbreviation' => 'mag',
            ],
            [
                'sort_id' => 5,
                'name' => 'spirit',
                'abbreviation' => 'spr',
            ],
            [
                'sort_id' => 6,
                'name' => 'speed',
                'abbreviation' => 'spd',
            ],
            [
                'sort_id' => 7,
                'name' => 'luck',
                'abbreviation' => 'luck',
            ],
            [
                'sort_id' => 8,
                'name' => 'evade',
                'abbreviation' => 'eva',
            ],
            [
                'sort_id' => 9,
                'name' => 'hit',
                'abbreviation' => 'hit',
            ],
        ];
    }
}
