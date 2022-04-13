<?php

namespace Tests\Unit\Console\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\PendingCommand;
use MeiliSearch\Client;
use Tests\TestCase;

class SeedSearchServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_seed_and_initialize_search_indexes(): void
    {
        $this->mock(Client::class, function ($mock) {
            $mock->shouldReceive('index->updateSearchableAttributes');
            $mock->shouldReceive('index->updateSortableAttributes');
            $mock->shouldReceive('index->updateRankingRules');
        });

        /** @var PendingCommand */
        $command = $this->artisan('search:seed');

        $command->assertExitCode(0);
    }
}
