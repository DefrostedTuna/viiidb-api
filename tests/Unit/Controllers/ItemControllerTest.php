<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\ItemController;
use App\Models\Item;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ItemControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_items()
    {
        $items = Item::factory()->count(10)->create();

        $itemController = new ItemController(new Item());

        $response = $itemController->index(new Request());

        // Controller should return a collection of Items.
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(10, $response);
    }

    /** @test */
    public function it_will_return_an_individual_item()
    {
        $item = Item::factory()->create();

        $itemController = new ItemController(new Item());

        $response = $itemController->show(new Request(), $item->name);

        // The controller should return the instance of an Item that was found via
        // route model binding. Since we are mocking this result by injecting the
        // Item into the method, we should get the same Item back.
        $this->assertInstanceOf(Item::class, $response);
        $this->assertEquals($item->toArray(), $response->toArray());
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found()
    {
        $this->expectException(ModelNotFoundException::class);

        $itemController = new ItemController(new Item());

        $response = $itemController->show(new Request(), 'not-found');
    }

    /** @test */
    public function it_can_filter_items_by_the_position_column()
    {
        Item::factory()->create([ 'position' => 1 ]);
        Item::factory()->create([ 'position' => 2 ]);
        Item::factory()->create([ 'position' => 3 ]);
        Item::factory()->create([ 'position' => 13 ]);

        // Equals
        $request = new Request([ 'position' => '1' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('position', 1));

        // Less Than
        $request = new Request([ 'position' => 'lt:2' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('position', 1));

        // Less Than or Equal To
        $request = new Request([ 'position' => 'lte:2' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('position', 1));
        $this->assertTrue($response->contains('position', 2));

        // Greater Than
        $request = new Request([ 'position' => 'gt:2' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('position', 3));
        $this->assertTrue($response->contains('position', 13));

        // Greater Than or Equal To
        $request = new Request([ 'position' => 'gte:2' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('position', 2));
        $this->assertTrue($response->contains('position', 3));
        $this->assertTrue($response->contains('position', 13));

        // Like
        $request = new Request([ 'position' => 'like:1' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('position', 1));
        $this->assertTrue($response->contains('position', 13));

        // Not
        $request = new Request([ 'position' => 'not:13' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('position', 1));
        $this->assertTrue($response->contains('position', 2));
        $this->assertTrue($response->contains('position', 3));
    }

    /** @test */
    public function it_can_filter_items_by_the_name_column()
    {
        Item::factory()->create([ 'name' => 'Potion' ]);
        Item::factory()->create([ 'name' => 'Potion+' ]);
        Item::factory()->create([ 'name' => 'Elixir' ]);
        Item::factory()->create([ 'name' => 'Phoenix Down' ]);

        // Equals
        $request = new Request([ 'name' => 'Potion' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('name', 'Potion'));

        // Like
        $request = new Request([ 'name' => 'like:Potion' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('name', 'Potion'));
        $this->assertTrue($response->contains('name', 'Potion+'));

        // Not
        $request = new Request([ 'name' => 'not:Elixir' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('name', 'Potion'));
        $this->assertTrue($response->contains('name', 'Potion+'));
        $this->assertTrue($response->contains('name', 'Phoenix Down'));
    }

    /** @test */
    public function it_can_filter_items_by_the_type_column()
    {
        Item::factory()->create([ 'type' => 'Medicine' ]);
        Item::factory()->create([ 'type' => 'Ammo' ]);
        Item::factory()->create([ 'type' => 'Tool' ]);
        Item::factory()->create([ 'type' => 'Magazine' ]);

        // Equals
        $request = new Request([ 'type' => 'Medicine' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('type', 'Medicine'));

        // Like
        $request = new Request([ 'type' => 'like:ine' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('type', 'Medicine'));
        $this->assertTrue($response->contains('type', 'Magazine'));

        // Not
        $request = new Request([ 'type' => 'not:Magazine' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('type', 'Medicine'));
        $this->assertTrue($response->contains('type', 'Ammo'));
        $this->assertTrue($response->contains('type', 'Tool'));
    }

    /** @test */
    public function it_can_filter_items_by_the_description_column()
    {
        Item::factory()->create([ 'description' => 'Restores HP by 200' ]);
        Item::factory()->create([ 'description' => 'Raises HP' ]);
        Item::factory()->create([ 'description' => 'Poisonous monster fang' ]);
        Item::factory()->create([ 'description' => 'Cures Poison' ]);

        // Equals
        $request = new Request([ 'description' => 'Raises HP' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('description', 'Raises HP'));

        // Like
        $request = new Request([ 'description' => 'like:Poison' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('description', 'Poisonous monster fang'));
        $this->assertTrue($response->contains('description', 'Cures Poison'));

        // Not
        $request = new Request([ 'description' => 'not:Restores HP by 200' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('description', 'Raises HP'));
        $this->assertTrue($response->contains('description', 'Poisonous monster fang'));
        $this->assertTrue($response->contains('description', 'Cures Poison'));
    }

    /** @test */
    public function it_can_filter_items_by_the_menu_effect_column()
    {
        Item::factory()->create([ 'menu_effect' => 'One party member' ]);
        Item::factory()->create([ 'menu_effect' => 'One GF' ]);
        Item::factory()->create([ 'menu_effect' => 'All party members' ]);
        Item::factory()->create([ 'menu_effect' => null ]);

        // Equals
        $request = new Request([ 'menu_effect' => 'One party member' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('menu_effect', 'One party member'));

        // Like
        $request = new Request([ 'menu_effect' => 'like:One' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('menu_effect', 'One party member'));
        $this->assertTrue($response->contains('menu_effect', 'One GF'));

        // Not
        $request = new Request([ 'menu_effect' => 'not:One GF' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('menu_effect', 'One party member'));
        $this->assertTrue($response->contains('menu_effect', 'All party members'));
    }

    /** @test */
    public function it_can_filter_items_by_the_price_column()
    {
        Item::factory()->create([ 'price' => 25 ]);
        Item::factory()->create([ 'price' => 125 ]);
        Item::factory()->create([ 'price' => 750 ]);
        Item::factory()->create([ 'price' => 20000 ]);

        // Equals
        $request = new Request([ 'price' => 750 ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('price', 750));

        // Less Than
        $request = new Request([ 'price' => 'lt:125' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('price', 25));

        // Less Than or Equal To
        $request = new Request([ 'price' => 'lte:125' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('price', 25));
        $this->assertTrue($response->contains('price', 125));

        // Greater Than
        $request = new Request([ 'price' => 'gt:125' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('price', 750));
        $this->assertTrue($response->contains('price', 20000));

        // Greater Than or Equal To
        $request = new Request([ 'price' => 'gte:125' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('price', 125));
        $this->assertTrue($response->contains('price', 750));
        $this->assertTrue($response->contains('price', 20000));

        // Like
        $request = new Request([ 'price' => 'like:25' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('price', 25));
        $this->assertTrue($response->contains('price', 125));

        // Not
        $request = new Request([ 'price' => 'not:125' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('price', 25));
        $this->assertTrue($response->contains('price', 750));
        $this->assertTrue($response->contains('price', 20000));
    }

    /** @test */
    public function it_can_filter_items_by_the_value_column()
    {
        Item::factory()->create([ 'value' => 25 ]);
        Item::factory()->create([ 'value' => 125 ]);
        Item::factory()->create([ 'value' => 750 ]);
        Item::factory()->create([ 'value' => 20000 ]);

        // Equals
        $request = new Request([ 'value' => 750 ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('value', 750));

        // Less Than
        $request = new Request([ 'value' => 'lt:125' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('value', 25));

        // Less Than or Equal To
        $request = new Request([ 'value' => 'lte:125' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('value', 25));
        $this->assertTrue($response->contains('value', 125));

        // Greater Than
        $request = new Request([ 'value' => 'gt:125' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('value', 750));
        $this->assertTrue($response->contains('value', 20000));

        // Greater Than or Equal To
        $request = new Request([ 'value' => 'gte:125' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('value', 125));
        $this->assertTrue($response->contains('value', 750));
        $this->assertTrue($response->contains('value', 20000));

        // Like
        $request = new Request([ 'value' => 'like:25' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('value', 25));
        $this->assertTrue($response->contains('value', 125));

        // Not
        $request = new Request([ 'value' => 'not:125' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('value', 25));
        $this->assertTrue($response->contains('value', 750));
        $this->assertTrue($response->contains('value', 20000));
    }

    /** @test */
    public function it_can_filter_items_by_the_haggle_column()
    {
        Item::factory()->create([ 'haggle' => 25 ]);
        Item::factory()->create([ 'haggle' => 125 ]);
        Item::factory()->create([ 'haggle' => 750 ]);
        Item::factory()->create([ 'haggle' => 20000 ]);

        // Equals
        $request = new Request([ 'haggle' => 750 ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('haggle', 750));

        // Less Than
        $request = new Request([ 'haggle' => 'lt:125' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('haggle', 25));

        // Less Than or Equal To
        $request = new Request([ 'haggle' => 'lte:125' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('haggle', 25));
        $this->assertTrue($response->contains('haggle', 125));

        // Greater Than
        $request = new Request([ 'haggle' => 'gt:125' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('haggle', 750));
        $this->assertTrue($response->contains('haggle', 20000));

        // Greater Than or Equal To
        $request = new Request([ 'haggle' => 'gte:125' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('haggle', 125));
        $this->assertTrue($response->contains('haggle', 750));
        $this->assertTrue($response->contains('haggle', 20000));

        // Like
        $request = new Request([ 'haggle' => 'like:25' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('haggle', 25));
        $this->assertTrue($response->contains('haggle', 125));

        // Not
        $request = new Request([ 'haggle' => 'not:125' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('haggle', 25));
        $this->assertTrue($response->contains('haggle', 750));
        $this->assertTrue($response->contains('haggle', 20000));
    }

    /** @test */
    public function it_can_filter_items_by_the_sell_high_column()
    {
        Item::factory()->create([ 'sell_high' => 25 ]);
        Item::factory()->create([ 'sell_high' => 125 ]);
        Item::factory()->create([ 'sell_high' => 750 ]);
        Item::factory()->create([ 'sell_high' => 20000 ]);

        // Equals
        $request = new Request([ 'sell_high' => 750 ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('sell_high', 750));

        // Less Than
        $request = new Request([ 'sell_high' => 'lt:125' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('sell_high', 25));

        // Less Than or Equal To
        $request = new Request([ 'sell_high' => 'lte:125' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('sell_high', 25));
        $this->assertTrue($response->contains('sell_high', 125));

        // Greater Than
        $request = new Request([ 'sell_high' => 'gt:125' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('sell_high', 750));
        $this->assertTrue($response->contains('sell_high', 20000));

        // Greater Than or Equal To
        $request = new Request([ 'sell_high' => 'gte:125' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('sell_high', 125));
        $this->assertTrue($response->contains('sell_high', 750));
        $this->assertTrue($response->contains('sell_high', 20000));

        // Like
        $request = new Request([ 'sell_high' => 'like:25' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('sell_high', 25));
        $this->assertTrue($response->contains('sell_high', 125));

        // Not
        $request = new Request([ 'sell_high' => 'not:125' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('sell_high', 25));
        $this->assertTrue($response->contains('sell_high', 750));
        $this->assertTrue($response->contains('sell_high', 20000));
    }

    /** @test */
    public function it_can_filter_items_by_the_used_in_menu_column()
    {
        Item::factory()->create([ 'used_in_menu' => true ]);
        Item::factory()->create([ 'used_in_menu' => false ]);
        Item::factory()->create([ 'used_in_menu' => true ]);

        // Equals
        $request = new Request([ 'used_in_menu' => 'true' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('used_in_menu', true));

        // Like
        $request = new Request([ 'used_in_menu' => 'like:ue' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('used_in_menu', true));

        // Not
        $request = new Request([ 'used_in_menu' => 'not:true' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('used_in_menu', false));
    }

    /** @test */
    public function it_can_filter_items_by_the_used_in_battle_column()
    {
        Item::factory()->create([ 'used_in_battle' => true ]);
        Item::factory()->create([ 'used_in_battle' => false ]);
        Item::factory()->create([ 'used_in_battle' => true ]);

        // Equals
        $request = new Request([ 'used_in_battle' => 'true' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('used_in_battle', true));

        // Like
        $request = new Request([ 'used_in_battle' => 'like:ue' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('used_in_battle', true));

        // Not
        $request = new Request([ 'used_in_battle' => 'not:true' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('used_in_battle', false));
    }

    /** @test */
    public function it_can_filter_items_by_the_notes_column()
    {
        Item::factory()->create([ 'notes' => 'GF Compatibility: Ifrit +1' ]);
        Item::factory()->create([ 'notes' => 'GF Compatibility: Ifrit +3' ]);
        Item::factory()->create([ 'notes' => 'GF Compatibility: Shiva +3' ]);
        Item::factory()->create([ 'notes' => 'All Guardian Forces +20' ]);

        // Equals
        $request = new Request([ 'notes' => 'All Guardian Forces +20' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('notes', 'All Guardian Forces +20'));

        // Equals -- With Colon
        $request = new Request([ 'notes' => 'GF Compatibility: Ifrit +3' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('notes', 'GF Compatibility: Ifrit +3'));

        // Like
        $request = new Request([ 'notes' => 'like:Ifrit' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('notes', 'GF Compatibility: Ifrit +1'));
        $this->assertTrue($response->contains('notes', 'GF Compatibility: Ifrit +3'));

        // Like -- With Colon
        $request = new Request([ 'notes' => 'like:GF Compatibility: Ifrit' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('notes', 'GF Compatibility: Ifrit +1'));
        $this->assertTrue($response->contains('notes', 'GF Compatibility: Ifrit +3'));

        // Not
        $request = new Request([ 'notes' => 'not:All Guardian Forces +20' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('notes', 'GF Compatibility: Ifrit +1'));
        $this->assertTrue($response->contains('notes', 'GF Compatibility: Ifrit +3'));
        $this->assertTrue($response->contains('notes', 'GF Compatibility: Shiva +3'));

        // Not -- With Colon
        $request = new Request([ 'notes' => 'not:GF Compatibility: Ifrit +1' ]);
        $itemController = new ItemController(new Item());
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('notes', 'GF Compatibility: Ifrit +3'));
        $this->assertTrue($response->contains('notes', 'GF Compatibility: Shiva +3'));
        $this->assertTrue($response->contains('notes', 'All Guardian Forces +20'));
    }
}
