<?php

namespace Tests\Unit\Models;

use App\Models\StatusEffect;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatusEffectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_the_proper_database_table(): void
    {
        $statusEffect = new StatusEffect();

        $this->assertEquals('status_effects', $statusEffect->getTable());
    }

    /** @test */
    public function it_explicitly_defines_the_column_that_results_should_use_for_ordering(): void
    {
        $statusEffect = new StatusEffect();

        $this->assertEquals('sort_id', $statusEffect->getOrderByField());
    }

    /** @test */
    public function it_explicitly_defines_the_visible_fields_for_api_consumption(): void
    {
        $statusEffect = new StatusEffect();

        $visibleFields = [
            'id',
            'sort_id',
            'name',
            'type',
            'description',
        ];

        $this->assertEquals($visibleFields, $statusEffect->getVisible());
    }

    /** @test */
    public function it_explicitly_defines_the_cast_type_for_each_field(): void
    {
        $statusEffect = new StatusEffect();
        $fields = $statusEffect->getCasts();

        $expected = [
            'id'          => 'string',
            'sort_id'     => 'integer',
            'name'        => 'string',
            'type'        => 'string',
            'description' => 'string',
        ];

        $this->assertEquals($expected, $fields);
    }

    /** @test */
    public function it_explicitly_defines_the_fields_that_are_searchable(): void
    {
        $statusEffect = new StatusEffect();

        $expected = [
            'name',
            'type',
            'description',
        ];

        $this->assertEquals($expected, $statusEffect->getSearchableFields());
    }

    /** @test */
    public function it_explicitly_defines_the_route_key_name(): void
    {
        $statusEffect = new StatusEffect();

        $this->assertEquals('name', $statusEffect->getRouteKeyName());
    }
}
