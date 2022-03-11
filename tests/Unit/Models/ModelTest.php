<?php

namespace Tests\Unit\Models;

use App\Models\Model;
use App\Models\SeedRank;
use App\Traits\FiltersRecordsByFields;
use App\Traits\LoadsRelationsThroughServices;
use App\Traits\OrdersQueryResults;
use App\Traits\Searchable;
use App\Traits\Uuids;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase as TestCase;

class ModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_explicitly_disables_incrementing_primary_keys(): void
    {
        $model = new Model();

        $this->assertFalse($model->getIncrementing());
    }

    /** @test */
    public function it_sets_the_primary_key_column_explicitly(): void
    {
        $model = new Model();

        $this->assertEquals('id', $model->getKeyName());
    }

    /** @test */
    public function it_sets_the_primary_key_type_to_string(): void
    {
        $model = new Model();

        $this->assertEquals('string', $model->getKeyType());
    }

    /** @test */
    public function it_explicitly_defines_the_order_results_should_be_returned_by(): void
    {
        $model = new Model();

        $this->assertEquals('asc', $model->getOrderByDirection());
    }

    /** @test */
    public function it_does_not_allow_properties_to_be_assigned_in_mass(): void
    {
        $model = new Model();

        $this->assertEquals([], $model->getFillable());
    }

    /** @test */
    public function it_explicitly_defines_the_hidden_fields_for_api_consumption(): void
    {
        $model = new Model();

        $hiddenFields = [
            'created_at',
            'updated_at',
            'deleted_at',
        ];

        $this->assertEquals($hiddenFields, $model->getHidden());
    }

    /** @test */
    public function it_uses_uuids_for_the_primary_key(): void
    {
        $this->assertTrue(in_array(
            Uuids::class,
            class_uses(Model::class) ?: []
        ));
    }

    /** @test */
    public function it_will_not_allow_the_uuid_to_be_changed(): void
    {
        $seedRank = SeedRank::factory()->create();

        $seedRank->id = 'not-original-value';
        $seedRank->save();

        $this->assertFalse($seedRank->id === 'not-original-value');
    }

    /** @test */
    public function it_can_order_query_results(): void
    {
        $this->assertTrue(in_array(
            OrdersQueryResults::class,
            class_uses(Model::class) ?: []
        ));
    }

    /** @test */
    public function it_includes_search_functionality(): void
    {
        $this->assertTrue(in_array(
            Searchable::class,
            class_uses(Model::class) ?: []
        ));
    }

    /** @test */
    public function it_includes_the_ability_to_filter_records_by_fields(): void
    {
        $this->assertTrue(in_array(
            FiltersRecordsByFields::class,
            class_uses(Model::class) ?: []
        ));
    }

    /** @test */
    public function it_loads_relations_through_services(): void
    {
        $this->assertTrue(in_array(
            LoadsRelationsThroughServices::class,
            class_uses(Model::class) ?: []
        ));
    }
}
