<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SeedRanksTableSeeder::class);
        $this->call(SeedTestsTableSeeder::class);
        $this->call(TestQuestionsTableSeeder::class);
    }
}
