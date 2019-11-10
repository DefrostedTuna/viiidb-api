<?php

namespace Tests\Unit\Models;

use App\Models\StatusEffect;
use App\Traits\Filterable;
use Tests\TestCase;

class StatusEffectTest extends TestCase
{
    /** @test */
    public function it_uses_the_proper_database_table()
    {
        $statusEffect = new StatusEffect();

        $this->assertEquals('status_effects', $statusEffect->getTable());
    }

    /** @test */
    public function it_sets_the_primary_key_type_to_string()
    {
        $statusEffect = new StatusEffect();

        $this->assertEquals('string', $statusEffect->getKeyType());
    }

    /** @test */
    public function it_does_not_allow_properties_to_be_assigned_in_mass()
    {
        $statusEffect = new StatusEffect();

        $this->assertEquals([], $statusEffect->getFillable());
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
    public function it_explicitly_defines_the_hidden_fields_for_api_consumption()
    {
        $statusEffect = new StatusEffect();

        $hiddenFields = [
            'created_at',
            'updated_at',
            'deleted_at',    
        ];

        $this->assertEquals($hiddenFields, $statusEffect->getHidden());
    }

    /** @test */
    public function it_casts_the_name_column_to_a_string()
    {
        $statusEffect = new StatusEffect();
        $casts = $statusEffect->getCasts();

        $this->assertArrayHasKey('name', $casts);
        $this->assertEquals('string', $casts['name']);
    }

    /** @test */
    public function it_casts_the_type_column_to_a_string()
    {
        $statusEffect = new StatusEffect();
        $casts = $statusEffect->getCasts();

        $this->assertArrayHasKey('type', $casts);
        $this->assertEquals('string', $casts['type']);
    }

    /** @test */
    public function it_casts_the_description_column_to_a_string()
    {
        $statusEffect = new StatusEffect();
        $casts = $statusEffect->getCasts();

        $this->assertArrayHasKey('description', $casts);
        $this->assertEquals('string', $casts['description']);
    }

    /** @test */
    public function it_is_able_to_filter_records()
    {
        $this->assertTrue(in_array(
            Filterable::class, 
            class_uses(StatusEffect::class)
        ));
    }

    /** @test */
    public function it_allows_specific_fields_to_be_filtered()
    {
        $statusEffect = new StatusEffect();
        $shouldBeFilterable = [
            'name',
            'type',
        ];

        $this->assertEquals($shouldBeFilterable, $statusEffect->getFilterableFields());
    }

    /** @test */
    public function it_orders_results_by_name()
    {
        $statusEffect = new StatusEffect();

        $this->assertEquals('name', $statusEffect->getOrderByField());
    }

    /** @test */
    public function it_explicitly_defines_the_order_results_should_be_returned_by()
    {
        $statusEffect = new StatusEffect();

        $this->assertEquals('asc', $statusEffect->getOrderByDirection());
    }
}
