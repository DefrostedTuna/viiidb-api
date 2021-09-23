<?php

namespace Tests\Unit\Models;

use App\Models\StatusEffect;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase as TestCase;

class StatusEffectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_the_proper_database_table()
    {
        $statusEffect = new StatusEffect();

        $this->assertEquals('status_effects', $statusEffect->getTable());
    }

    /** @test */
    public function it_explicitly_defines_the_column_that_results_should_use_for_ordering()
    {
        $statusEffect = new StatusEffect();

        $this->assertEquals('name', $statusEffect->getOrderByField());
    }

    /** @test */
    public function it_explicitly_defines_the_visible_fields_for_api_consumption()
    {
        $statusEffect = new StatusEffect();

        $visibleFields = [
            'id',
            'name',
            'type',
            'description',
        ];

        $this->assertEquals($visibleFields, $statusEffect->getVisible());
    }

    /** @test */
    public function it_explicitly_defines_the_cast_type_for_each_field()
    {
        $statusEffect = new StatusEffect();
        $fields = $statusEffect->getCasts();

        $expected = [
            'id'          => 'string',
            'name'        => 'string',
            'type'        => 'string',
            'description' => 'string',
        ];

        $this->assertEquals($expected, $fields);
    }

    /** @test */
    public function it_explicitly_defines_the_fields_that_are_searchable()
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
    public function it_explicitly_defines_the_fields_that_are_filterable()
    {
        $statusEffect = new StatusEffect();

        $expected = [
            'name',
            'type',
            'description',
        ];

        $this->assertEquals($expected, $statusEffect->getFilterableFields());
    }

    /** @test */
    public function it_explicitly_defines_the_route_key_name()
    {
        $statusEffect = new StatusEffect();

        $this->assertEquals('name', $statusEffect->getRouteKeyName());
    }
}