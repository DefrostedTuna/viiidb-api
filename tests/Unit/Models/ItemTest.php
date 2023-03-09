<?php

namespace Tests\Unit\Models;

use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_the_proper_database_table(): void
    {
        $item = new Item();

        $this->assertEquals('items', $item->getTable());
    }

    /** @test */
    public function it_explicitly_defines_the_column_that_results_should_use_for_ordering(): void
    {
        $item = new Item();

        $this->assertEquals('position', $item->getOrderByField());
    }

    /** @test */
    public function it_explicitly_defines_the_visible_fields_for_api_consumption(): void
    {
        $item = new Item();

        $visibleFields = [
            'id',
            'slug',
            'position',
            'name',
            'type',
            'description',
            'menu_effect',
            'value',
            'price',
            'sell_high',
            'haggle',
            'used_in_menu',
            'used_in_battle',
            'notes',
        ];

        $this->assertEquals($visibleFields, $item->getVisible());
    }

    /** @test */
    public function it_explicitly_defines_the_cast_type_for_each_field(): void
    {
        $item = new Item();
        $fields = $item->getCasts();

        $expected = [
            'id' => 'string',
            'slug' => 'string',
            'position' => 'integer',
            'name' => 'string',
            'type' => 'string',
            'description' => 'string',
            'menu_effect' => 'string',
            'value' => 'integer',
            'price' => 'integer',
            'sell_high' => 'integer',
            'haggle' => 'integer',
            'used_in_menu' => 'boolean',
            'used_in_battle' => 'boolean',
            'notes' => 'string',
        ];

        $this->assertEquals($expected, $fields);
    }

    /** @test */
    public function it_explicitly_defines_the_fields_that_are_searchable(): void
    {
        $item = new Item();

        $expected = [
            'slug',
            'position',
            'name',
            'type',
            'description',
            'menu_effect',
            'value',
            'price',
            'sell_high',
            'haggle',
            'used_in_menu',
            'used_in_battle',
            'notes',
        ];

        $this->assertEquals($expected, $item->getSearchableFields());
    }

    /** @test */
    public function it_explicitly_defines_the_route_key_name(): void
    {
        $item = new Item();

        $this->assertEquals('slug', $item->getRouteKeyName());
    }
}
