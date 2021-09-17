<?php

namespace Database\Seeders;

use App\Models\SeedRank;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class SeedRanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seedRanks = [
            ['rank' => 1, 'salary' => 500],
            ['rank' => 2, 'salary' => 1000],
            ['rank' => 3, 'salary' => 1500],
            ['rank' => 4, 'salary' => 2000],
            ['rank' => 5, 'salary' => 3000],
            ['rank' => 6, 'salary' => 4000],
            ['rank' => 7, 'salary' => 5000],
            ['rank' => 8, 'salary' => 6000],
            ['rank' => 9, 'salary' => 7000],
            ['rank' => 10, 'salary' => 8000],
            ['rank' => 11, 'salary' => 9000],
            ['rank' => 12, 'salary' => 10000],
            ['rank' => 13, 'salary' => 11000],
            ['rank' => 14, 'salary' => 12000],
            ['rank' => 15, 'salary' => 12500],
            ['rank' => 16, 'salary' => 13000],
            ['rank' => 17, 'salary' => 13500],
            ['rank' => 18, 'salary' => 14000],
            ['rank' => 19, 'salary' => 14500],
            ['rank' => 20, 'salary' => 15000],
            ['rank' => 21, 'salary' => 15500],
            ['rank' => 22, 'salary' => 16000],
            ['rank' => 23, 'salary' => 16500],
            ['rank' => 24, 'salary' => 17000],
            ['rank' => 25, 'salary' => 17500],
            ['rank' => 26, 'salary' => 18000],
            ['rank' => 27, 'salary' => 18500],
            ['rank' => 28, 'salary' => 19000],
            ['rank' => 29, 'salary' => 19500],
            ['rank' => 30, 'salary' => 20000],
            ['rank' => 'A', 'salary' => 30000],
        ];

        foreach ($seedRanks as $key => $value) {
            $seedRanks[$key]['id'] = Uuid::generate(4);
            $seedRanks[$key]['created_at'] = Carbon::now();
            $seedRanks[$key]['updated_at'] = Carbon::now();
        }

        $seedRank = new SeedRank();

        $seedRank->insert($seedRanks);
    }
}
