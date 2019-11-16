<?php

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
        // $this->call(UsersTableSeeder::class);
        $this->call(SeedRanksTableSeeder::class);
        $this->call(ElementsTableSeeder::class);
        $this->call(LocationsTableSeeder::class);
        $this->call(StatsTableSeeder::class);
        $this->call(StatusEffectsTableSeeder::class);
        $this->call(SeedTestsTableSeeder::class);
        $this->call(TestQuestionsTableSeeder::class);
    }
}
