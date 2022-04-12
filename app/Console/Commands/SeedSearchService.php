<?php

namespace App\Console\Commands;

use App\Models\Element;
use App\Models\SearchableModel;
use App\Models\SeedRank;
use App\Models\SeedTest;
use App\Models\StatusEffect;
use App\Models\TestQuestion;
use Illuminate\Console\Command;
use MeiliSearch\Client;

class SeedSearchService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the search service and set up the indexes.';

    /**
     * The resources that are searchable.
     *
     * @var string[]
     */
    protected $searchable = [
        Element::class,
        SeedRank::class,
        SeedTest::class,
        StatusEffect::class,
        TestQuestion::class,
    ];

    /**
     * Execute the console command.
     *
     * @param Client $client The Meilisearch client
     *
     * @return int
     */
    public function handle(Client $client): int
    {
        foreach ($this->searchable as $model) {
            $this->line("Updating search index for {$model}...");

            /** @var SearchableModel */
            $instance = new $model();

            $instance->makeAllSearchable();
            $client->index($instance->getTable())->updateSearchableAttributes($instance->getSearchableFields());
            $client->index($instance->getTable())->updateSortableAttributes([$instance->getOrderByField()]);
            $client->index($instance->getTable())->updateRankingRules([
                'words',
                'typo',
                'sort',
                'proximity',
                'attribute',
                'exactness',
            ]);
        }

        return 0;
    }
}
