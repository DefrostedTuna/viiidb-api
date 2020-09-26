<?php

namespace Database\Seeders;

use App\Models\SeedTest;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class SeedTestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seedTests = [];

        for ($i = 1; $i <= 30; $i++) {
            $seedTests[] = [
                'id' => Uuid::generate(4),
                'level' => $i,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        $seedTest = new SeedTest();

        $seedTest->insert($seedTests);
    }
}
