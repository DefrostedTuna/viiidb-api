<?php

namespace Tests\Unit\Models;

use App\Models\Item;
use App\Traits\Filterable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_the_proper_database_table()
    {
        $item = new Item();
    
        $this->assertEquals('items', $item->getTable());
    }
    
    /** @test */
    public function it_sets_the_primary_key_type_to_string()
    {
        $item = new Item();
    
        $this->assertEquals('string', $item->getKeyType());
    }
    
    /** @test */
    public function it_does_not_allow_properties_to_be_assigned_in_mass()
    {
        $item = new Item();
    
        $this->assertEquals([], $item->getFillable());
    }
    
    /** @test */
    public function it_explicitly_defines_the_visible_fields_for_api_consumption()
    {
        $item = new Item();
    
        $visibleFields = [
            'id',
            'position',
            'name',
            'type',
            'description',
            'menu_effect',
            'price',
            'value',
            'haggle',
            'sell_high',
            'used_in_menu',
            'used_in_battle',
            'notes',
        ];
    
        $this->assertEquals($visibleFields, $item->getVisible());
    }
    
    /** @test */
    public function it_explicitly_defines_the_hidden_fields_for_api_consumption()
    {
        $item = new Item();
    
        $hiddenFields = [
                'created_at',
                'updated_at',
                'deleted_at',
            ];
    
        $this->assertEquals($hiddenFields, $item->getHidden());
    }
    
    /** @test */
    public function it_explicitly_defines_the_cast_type_for_each_field()
    {
        $item = new Item();
        $fields = $item->getCasts();

        $expected = [
            'id'                => 'string',
            'position'          => 'integer',
            'name'              => 'string',
            'type'              => 'string',
            'description'       => 'string',
            'menu_effect'       => 'string',
            'price'             => 'integer',
            'value'             => 'integer',
            'haggle'            => 'integer',
            'sell_high'         => 'integer',
            'used_in_menu'      => 'boolean',
            'used_in_battle'    => 'boolean',
            'notes'             => 'string',
        ];
    
        $this->assertEquals($expected, $fields);
    }
    
    /** @test */
    public function it_is_able_to_filter_records()
    {
        $this->assertTrue(in_array(
            Filterable::class,
            class_uses(Item::class)
        ));
    }
    
    /** @test */
    public function it_allows_specific_fields_to_be_filtered()
    {
        $item = new Item();
        $shouldBeFilterable = [
            'position',
            'name',
            'type',
            'description',
            'menu_effect',
            'price',
            'value',
            'haggle',
            'sell_high',
            'used_in_menu',
            'used_in_battle',
            'notes',
        ];
    
        $this->assertEquals($shouldBeFilterable, $item->getFilterableFields());
    }
    
    /** @test */
    public function it_orders_results_by_position()
    {
        $item = new Item();
    
        $this->assertEquals('position', $item->getOrderByField());
    }
    
    /** @test */
    public function it_explicitly_defines_the_order_results_should_be_returned_by()
    {
        $item = new Item();
    
        $this->assertEquals('asc', $item->getOrderByDirection());
    }
}
