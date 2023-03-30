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
        $this->call(StatusEffectsTableSeeder::class);
        $this->call(StatsTableSeeder::class);
        $this->call(ElementsTableSeeder::class);
        $this->call(ItemsTableSeeder::class);
        $this->call(LocationsTableSeeder::class);
        $this->call(ItemStatusEffectTableSeeder::class);
    }
}
