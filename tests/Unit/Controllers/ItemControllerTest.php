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
        $items = factory(Item::class, 10)->create();

        $itemController = new ItemController(new Item());

        $response = $itemController->index(new Request());

        // Controller should return a collection of Items.
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(10, $response);
    }

    /** @test */
    public function it_will_return_an_individual_item()
    {
        $item = factory(Item::class)->create();

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
        $item = new Item();
        factory(Item::class)->create(['position' => 1]);
        factory(Item::class)->create(['position' => 2]);
        factory(Item::class)->create(['position' => 3]);
        factory(Item::class)->create(['position' => 13]);

        // Equals
        $request = new Request(['position' => '1']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('position', 1));

        // Less Than
        $request = new Request(['position' => 'lt:2']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('position', 1));

        // Less Than or Equal To
        $request = new Request(['position' => 'lte:2']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('position', 1));
        $this->assertTrue($response->contains('position', 2));

        // Greater Than
        $request = new Request(['position' => 'gt:2']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('position', 3));
        $this->assertTrue($response->contains('position', 13));

        // Greater Than or Equal To
        $request = new Request(['position' => 'gte:2']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('position', 2));
        $this->assertTrue($response->contains('position', 3));
        $this->assertTrue($response->contains('position', 13));

        // Like
        $request = new Request(['position' => 'like:1']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('position', 1));
        $this->assertTrue($response->contains('position', 13));

        // Not
        $request = new Request(['position' => 'not:13']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('position', 1));
        $this->assertTrue($response->contains('position', 2));
        $this->assertTrue($response->contains('position', 3));
    }

    /** @test */
    public function it_can_filter_items_by_the_name_column()
    {
        $item = new Item();
        factory(Item::class)->create(['name' => 'Potion']);
        factory(Item::class)->create(['name' => 'Potion+']);
        factory(Item::class)->create(['name' => 'Elixir']);
        factory(Item::class)->create(['name' => 'Phoenix Down']);

        // Equals
        $request = new Request(['name' => 'Potion']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('name', 'Potion'));

        // Like
        $request = new Request(['name' => 'like:Potion']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('name', 'Potion'));
        $this->assertTrue($response->contains('name', 'Potion+'));

        // Not
        $request = new Request(['name' => 'not:Elixir']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('name', 'Potion'));
        $this->assertTrue($response->contains('name', 'Potion+'));
        $this->assertTrue($response->contains('name', 'Phoenix Down'));
    }

    /** @test */
    public function it_can_filter_items_by_the_type_column()
    {
        $item = new Item();
        factory(Item::class)->create(['type' => 'Medicine']);
        factory(Item::class)->create(['type' => 'Ammo']);
        factory(Item::class)->create(['type' => 'Tool']);
        factory(Item::class)->create(['type' => 'Magazine']);

        // Equals
        $request = new Request(['type' => 'Medicine']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('type', 'Medicine'));

        // Like
        $request = new Request(['type' => 'like:ine']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('type', 'Medicine'));
        $this->assertTrue($response->contains('type', 'Magazine'));

        // Not
        $request = new Request(['type' => 'not:Magazine']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('type', 'Medicine'));
        $this->assertTrue($response->contains('type', 'Ammo'));
        $this->assertTrue($response->contains('type', 'Tool'));
    }

    /** @test */
    public function it_can_filter_items_by_the_description_column()
    {
        $item = new Item();
        factory(Item::class)->create(['description' => 'Restores HP by 200']);
        factory(Item::class)->create(['description' => 'Raises HP']);
        factory(Item::class)->create(['description' => 'Poisonous monster fang']);
        factory(Item::class)->create(['description' => 'Cures Poison']);

        // Equals
        $request = new Request(['description' => 'Raises HP']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('description', 'Raises HP'));

        // Like
        $request = new Request(['description' => 'like:Poison']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('description', 'Poisonous monster fang'));
        $this->assertTrue($response->contains('description', 'Cures Poison'));

        // Not
        $request = new Request(['description' => 'not:Restores HP by 200']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('description', 'Raises HP'));
        $this->assertTrue($response->contains('description', 'Poisonous monster fang'));
        $this->assertTrue($response->contains('description', 'Cures Poison'));
    }

    /** @test */
    public function it_can_filter_items_by_the_menu_effect_column()
    {
        $item = new Item();
        factory(Item::class)->create(['menu_effect' => 'One party member']);
        factory(Item::class)->create(['menu_effect' => 'One GF']);
        factory(Item::class)->create(['menu_effect' => 'All party members']);
        factory(Item::class)->create(['menu_effect' => null]);

        // Equals
        $request = new Request(['menu_effect' => 'One party member']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('menu_effect', 'One party member'));

        // Like
        $request = new Request(['menu_effect' => 'like:One']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('menu_effect', 'One party member'));
        $this->assertTrue($response->contains('menu_effect', 'One GF'));

        // Not
        $request = new Request(['menu_effect' => 'not:One GF']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('menu_effect', 'One party member'));
        $this->assertTrue($response->contains('menu_effect', 'All party members'));
    }

    /** @test */
    public function it_can_filter_items_by_the_price_column()
    {
        $item = new Item();
        factory(Item::class)->create(['price' => 25]);
        factory(Item::class)->create(['price' => 125]);
        factory(Item::class)->create(['price' => 750]);
        factory(Item::class)->create(['price' => 20000]);

        // Equals
        $request = new Request(['price' => 750]);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('price', 750));

        // Less Than
        $request = new Request(['price' => 'lt:125']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('price', 25));

        // Less Than or Equal To
        $request = new Request(['price' => 'lte:125']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('price', 25));
        $this->assertTrue($response->contains('price', 125));

        // Greater Than
        $request = new Request(['price' => 'gt:125']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('price', 750));
        $this->assertTrue($response->contains('price', 20000));

        // Greater Than or Equal To
        $request = new Request(['price' => 'gte:125']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('price', 125));
        $this->assertTrue($response->contains('price', 750));
        $this->assertTrue($response->contains('price', 20000));

        // Like
        $request = new Request(['price' => 'like:25']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('price', 25));
        $this->assertTrue($response->contains('price', 125));

        // Not
        $request = new Request(['price' => 'not:125']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('price', 25));
        $this->assertTrue($response->contains('price', 750));
        $this->assertTrue($response->contains('price', 20000));
    }

    /** @test */
    public function it_can_filter_items_by_the_value_column()
    {
        $item = new Item();
        factory(Item::class)->create(['value' => 25]);
        factory(Item::class)->create(['value' => 125]);
        factory(Item::class)->create(['value' => 750]);
        factory(Item::class)->create(['value' => 20000]);

        // Equals
        $request = new Request(['value' => 750]);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('value', 750));

        // Less Than
        $request = new Request(['value' => 'lt:125']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('value', 25));

        // Less Than or Equal To
        $request = new Request(['value' => 'lte:125']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('value', 25));
        $this->assertTrue($response->contains('value', 125));

        // Greater Than
        $request = new Request(['value' => 'gt:125']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('value', 750));
        $this->assertTrue($response->contains('value', 20000));

        // Greater Than or Equal To
        $request = new Request(['value' => 'gte:125']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('value', 125));
        $this->assertTrue($response->contains('value', 750));
        $this->assertTrue($response->contains('value', 20000));

        // Like
        $request = new Request(['value' => 'like:25']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('value', 25));
        $this->assertTrue($response->contains('value', 125));

        // Not
        $request = new Request(['value' => 'not:125']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('value', 25));
        $this->assertTrue($response->contains('value', 750));
        $this->assertTrue($response->contains('value', 20000));
    }

    /** @test */
    public function it_can_filter_items_by_the_haggle_column()
    {
        $item = new Item();
        factory(Item::class)->create(['haggle' => 25]);
        factory(Item::class)->create(['haggle' => 125]);
        factory(Item::class)->create(['haggle' => 750]);
        factory(Item::class)->create(['haggle' => 20000]);

        // Equals
        $request = new Request(['haggle' => 750]);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('haggle', 750));

        // Less Than
        $request = new Request(['haggle' => 'lt:125']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('haggle', 25));

        // Less Than or Equal To
        $request = new Request(['haggle' => 'lte:125']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('haggle', 25));
        $this->assertTrue($response->contains('haggle', 125));

        // Greater Than
        $request = new Request(['haggle' => 'gt:125']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('haggle', 750));
        $this->assertTrue($response->contains('haggle', 20000));

        // Greater Than or Equal To
        $request = new Request(['haggle' => 'gte:125']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('haggle', 125));
        $this->assertTrue($response->contains('haggle', 750));
        $this->assertTrue($response->contains('haggle', 20000));

        // Like
        $request = new Request(['haggle' => 'like:25']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('haggle', 25));
        $this->assertTrue($response->contains('haggle', 125));

        // Not
        $request = new Request(['haggle' => 'not:125']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('haggle', 25));
        $this->assertTrue($response->contains('haggle', 750));
        $this->assertTrue($response->contains('haggle', 20000));
    }

    /** @test */
    public function it_can_filter_items_by_the_sell_high_column()
    {
        $item = new Item();
        factory(Item::class)->create(['sell_high' => 25]);
        factory(Item::class)->create(['sell_high' => 125]);
        factory(Item::class)->create(['sell_high' => 750]);
        factory(Item::class)->create(['sell_high' => 20000]);

        // Equals
        $request = new Request(['sell_high' => 750]);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('sell_high', 750));

        // Less Than
        $request = new Request(['sell_high' => 'lt:125']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('sell_high', 25));

        // Less Than or Equal To
        $request = new Request(['sell_high' => 'lte:125']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('sell_high', 25));
        $this->assertTrue($response->contains('sell_high', 125));

        // Greater Than
        $request = new Request(['sell_high' => 'gt:125']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('sell_high', 750));
        $this->assertTrue($response->contains('sell_high', 20000));

        // Greater Than or Equal To
        $request = new Request(['sell_high' => 'gte:125']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('sell_high', 125));
        $this->assertTrue($response->contains('sell_high', 750));
        $this->assertTrue($response->contains('sell_high', 20000));

        // Like
        $request = new Request(['sell_high' => 'like:25']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('sell_high', 25));
        $this->assertTrue($response->contains('sell_high', 125));

        // Not
        $request = new Request(['sell_high' => 'not:125']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('sell_high', 25));
        $this->assertTrue($response->contains('sell_high', 750));
        $this->assertTrue($response->contains('sell_high', 20000));
    }

    /** @test */
    public function it_can_filter_items_by_the_used_in_menu_column()
    {
        $item = new Item();
        factory(Item::class)->create(['used_in_menu' => true]);
        factory(Item::class)->create(['used_in_menu' => false]);
        factory(Item::class)->create(['used_in_menu' => true]);

        // Equals
        $request = new Request(['used_in_menu' => 'true']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('used_in_menu', true));

        // Like
        $request = new Request(['used_in_menu' => 'like:ue']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('used_in_menu', true));

        // Not
        $request = new Request(['used_in_menu' => 'not:true']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('used_in_menu', false));
    }

    /** @test */
    public function it_can_filter_items_by_the_used_in_battle_column()
    {
        $item = new Item();
        factory(Item::class)->create(['used_in_battle' => true]);
        factory(Item::class)->create(['used_in_battle' => false]);
        factory(Item::class)->create(['used_in_battle' => true]);

        // Equals
        $request = new Request(['used_in_battle' => 'true']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('used_in_battle', true));

        // Like
        $request = new Request(['used_in_battle' => 'like:ue']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('used_in_battle', true));

        // Not
        $request = new Request(['used_in_battle' => 'not:true']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('used_in_battle', false));
    }

    /** @test */
    public function it_can_filter_items_by_the_notes_column()
    {
        $item = new Item();
        factory(Item::class)->create(['notes' => 'GF Compatibility: Ifrit +1']);
        factory(Item::class)->create(['notes' => 'GF Compatibility: Ifrit +3']);
        factory(Item::class)->create(['notes' => 'GF Compatibility: Shiva +3']);
        factory(Item::class)->create(['notes' => 'All Guardian Forces +20']);

        // Equals
        $request = new Request(['notes' => 'All Guardian Forces +20']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('notes', 'All Guardian Forces +20'));

        // Equals -- With Colon
        $request = new Request(['notes' => 'GF Compatibility: Ifrit +3']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('notes', 'GF Compatibility: Ifrit +3'));

        // Like
        $request = new Request(['notes' => 'like:Ifrit']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('notes', 'GF Compatibility: Ifrit +1'));
        $this->assertTrue($response->contains('notes', 'GF Compatibility: Ifrit +3'));

        // Like -- With Colon
        $request = new Request(['notes' => 'like:GF Compatibility: Ifrit']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('notes', 'GF Compatibility: Ifrit +1'));
        $this->assertTrue($response->contains('notes', 'GF Compatibility: Ifrit +3'));

        // Not
        $request = new Request(['notes' => 'not:All Guardian Forces +20']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('notes', 'GF Compatibility: Ifrit +1'));
        $this->assertTrue($response->contains('notes', 'GF Compatibility: Ifrit +3'));
        $this->assertTrue($response->contains('notes', 'GF Compatibility: Shiva +3'));

        // Not -- With Colon
        $request = new Request(['notes' => 'not:GF Compatibility: Ifrit +1']);
        $itemController = new ItemController($item);
        $response = $itemController->index($request);
        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('notes', 'GF Compatibility: Ifrit +3'));
        $this->assertTrue($response->contains('notes', 'GF Compatibility: Shiva +3'));
        $this->assertTrue($response->contains('notes', 'All Guardian Forces +20'));
    }
}
