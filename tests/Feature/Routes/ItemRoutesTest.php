<?php

namespace Tests\Feature\Routes;

use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemRoutesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_items()
    {
        Item::factory()->count(10)->create();

        $response = $this->get('/api/items');

        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }

    /** @test */
    public function it_will_return_an_individual_item()
    {
        $item = Item::factory()->create();

        $response = $this->get("/api/items/{$item->name}");

        $response->assertStatus(200);
        $response->assertJson($item->toArray());
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found()
    {
        $response = $this->get('/api/items/invalid');

        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_filter_items_by_the_position_column()
    {
        Item::factory()->create(['position' => 1]);
        Item::factory()->create(['position' => 2]);
        Item::factory()->create(['position' => 3]);
        Item::factory()->create(['position' => 13]);

        // Equals
        $response = $this->get('/api/items?position=1');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'position' => 1 ]);

        // Less Than
        $response = $this->get('/api/items?position=lt:2');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'position' => 1 ]);

        // Less Than or Equal To
        $response = $this->get('/api/items?position=lte:2');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'position' => 1 ]);
        $response->assertJsonFragment([ 'position' => 2 ]);

        // Greater Than
        $response = $this->get('/api/items?position=gt:2');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'position' => 3 ]);
        $response->assertJsonFragment([ 'position' => 13 ]);

        // Greater Than or Equal To
        $response = $this->get('/api/items?position=gte:2');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
        $response->assertJsonFragment([ 'position' => 2 ]);
        $response->assertJsonFragment([ 'position' => 3 ]);
        $response->assertJsonFragment([ 'position' => 13 ]);

        // Like
        $response = $this->get('/api/items?position=like:1');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'position' => 1 ]);
        $response->assertJsonFragment([ 'position' => 13 ]);

        // Not
        $response = $this->get('/api/items?position=not:13');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
        $response->assertJsonFragment([ 'position' => 1 ]);
        $response->assertJsonFragment([ 'position' => 2 ]);
        $response->assertJsonFragment([ 'position' => 3 ]);
    }

    /** @test */
    public function it_can_filter_items_by_the_name_column()
    {
        Item::factory()->create(['name' => 'Potion']);
        Item::factory()->create(['name' => 'Potion+']);
        Item::factory()->create(['name' => 'Elixir']);
        Item::factory()->create(['name' => 'Phoenix Down']);

        // Equals
        $response = $this->get('/api/items?name=Potion');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'name' => 'Potion' ]);

        // Like
        $response = $this->get('/api/items?name=like:Potion');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'name' => 'Potion' ]);
        $response->assertJsonFragment([ 'name' => 'Potion+' ]);

        // Not
        $response = $this->get('/api/items?name=not:Elixir');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
        $response->assertJsonFragment([ 'name' => 'Potion' ]);
        $response->assertJsonFragment([ 'name' => 'Potion+' ]);
        $response->assertJsonFragment([ 'name' => 'Phoenix Down' ]);
    }

    /** @test */
    public function it_can_filter_items_by_the_type_column()
    {
        Item::factory()->create(['type' => 'Medicine']);
        Item::factory()->create(['type' => 'Ammo']);
        Item::factory()->create(['type' => 'Tool']);
        Item::factory()->create(['type' => 'Magazine']);

        // Equals
        $response = $this->get('/api/items?type=Medicine');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'type' => 'Medicine' ]);

        // Like
        $response = $this->get('/api/items?type=like:ine');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment(['type' => 'Medicine']);
        $response->assertJsonFragment(['type' => 'Magazine']);

        // Not
        $response = $this->get('/api/items?type=not:Magazine');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
        $response->assertJsonFragment(['type' => 'Medicine']);
        $response->assertJsonFragment(['type' => 'Ammo']);
        $response->assertJsonFragment(['type' => 'Tool']);
    }

    /** @test */
    public function it_can_filter_items_by_the_description_column()
    {
        Item::factory()->create(['description' => 'Restores HP by 200']);
        Item::factory()->create(['description' => 'Raises HP']);
        Item::factory()->create(['description' => 'Poisonous monster fang']);
        Item::factory()->create(['description' => 'Cures Poison']);

        // Equals
        $response = $this->get('/api/items?description=Raises HP');

        $response->assertJsonCount(1);
        $response->assertJsonFragment(['description' => 'Raises HP']);

        // Like
        $response = $this->get('/api/items?description=like:Poison');

        $response->assertJsonCount(2);
        $response->assertJsonFragment(['description' => 'Poisonous monster fang']);
        $response->assertJsonFragment(['description' => 'Cures Poison']);

        // Not
        $response = $this->get('/api/items?description=not:Restores HP by 200');

        $response->assertJsonCount(3);
        $response->assertJsonFragment(['description' => 'Raises HP']);
        $response->assertJsonFragment(['description' => 'Poisonous monster fang']);
        $response->assertJsonFragment(['description' => 'Cures Poison']);
    }

    /** @test */
    public function it_can_filter_items_by_the_menu_effect_column()
    {
        Item::factory()->create(['menu_effect' => 'One party member']);
        Item::factory()->create(['menu_effect' => 'One GF']);
        Item::factory()->create(['menu_effect' => 'All party members']);
        Item::factory()->create(['menu_effect' => null]);

        // Equals
        $response = $this->get('/api/items?menu_effect=One party member');

        $response->assertJsonCount(1);
        $response->assertJsonFragment(['menu_effect' => 'One party member']);

        // Like
        $response = $this->get('/api/items?menu_effect=like:One');

        $response->assertJsonCount(2);
        $response->assertJsonFragment(['menu_effect' => 'One party member']);
        $response->assertJsonFragment(['menu_effect' => 'One GF']);

        // Not
        $response = $this->get('/api/items?menu_effect=not:One GF');

        $response->assertJsonCount(2);
        $response->assertJsonFragment(['menu_effect' => 'One party member']);
        $response->assertJsonFragment(['menu_effect' => 'All party members']);
    }

    /** @test */
    public function it_can_filter_items_by_the_price_column()
    {
        Item::factory()->create(['price' => 25]);
        Item::factory()->create(['price' => 125]);
        Item::factory()->create(['price' => 750]);
        Item::factory()->create(['price' => 20000]);

        // Equals
        $response = $this->get('/api/items?price=750');

        $response->assertJsonCount(1);
        $response->assertJsonFragment(['price' => 750]);

        // Less Than
        $response = $this->get('/api/items?price=lt:125');

        $response->assertJsonCount(1);
        $response->assertJsonFragment(['price' => 25]);

        // Less Than or Equal To
        $response = $this->get('/api/items?price=lte:125');

        $response->assertJsonCount(2);
        $response->assertJsonFragment(['price' => 25]);
        $response->assertJsonFragment(['price' => 125]);

        // Greater Than
        $response = $this->get('/api/items?price=gt:125');

        $response->assertJsonCount(2);
        $response->assertJsonFragment(['price' => 750]);
        $response->assertJsonFragment(['price' => 20000]);

        // Greater Than or Equal To
        $response = $this->get('/api/items?price=gte:125');

        $response->assertJsonCount(3);
        $response->assertJsonFragment(['price' => 125]);
        $response->assertJsonFragment(['price' => 750]);
        $response->assertJsonFragment(['price' => 20000]);

        // Like
        $response = $this->get('/api/items?price=like:25');

        $response->assertJsonCount(2);
        $response->assertJsonFragment(['price' => 25]);
        $response->assertJsonFragment(['price' => 125]);

        // Not
        $response = $this->get('/api/items?price=not:125');

        $response->assertJsonCount(3);
        $response->assertJsonFragment(['price' => 25]);
        $response->assertJsonFragment(['price' => 750]);
        $response->assertJsonFragment(['price' => 20000]);
    }

    /** @test */
    public function it_can_filter_items_by_the_value_column()
    {
        Item::factory()->create(['value' => 25]);
        Item::factory()->create(['value' => 125]);
        Item::factory()->create(['value' => 750]);
        Item::factory()->create(['value' => 20000]);

        // Equals
        $response = $this->get('/api/items?value=750');
        
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['value' => 750]);

        // Less Than
        $response = $this->get('/api/items?value=lt:125');

        $response->assertJsonCount(1);
        $response->assertJsonFragment(['value' => 25]);

        // Less Than or Equal To
        $response = $this->get('/api/items?value=lte:125');

        $response->assertJsonCount(2);
        $response->assertJsonFragment(['value' => 25]);
        $response->assertJsonFragment(['value' => 125]);

        // Greater Than
        $response = $this->get('/api/items?value=gt:125');

        $response->assertJsonCount(2);
        $response->assertJsonFragment(['value' => 750]);
        $response->assertJsonFragment(['value' => 20000]);

        // Greater Than or Equal To
        $response = $this->get('/api/items?value=gte:125');

        $response->assertJsonCount(3);
        $response->assertJsonFragment(['value' => 125]);
        $response->assertJsonFragment(['value' => 750]);
        $response->assertJsonFragment(['value' => 20000]);

        // Like
        $response = $this->get('/api/items?value=like:25');

        $response->assertJsonCount(2);
        $response->assertJsonFragment(['value' => 25]);
        $response->assertJsonFragment(['value' => 125]);

        // Not
        $response = $this->get('/api/items?value=not:125');

        $response->assertJsonCount(3);
        $response->assertJsonFragment(['value' => 25]);
        $response->assertJsonFragment(['value' => 750]);
        $response->assertJsonFragment(['value' => 20000]);
    }

    /** @test */
    public function it_can_filter_items_by_the_haggle_column()
    {
        Item::factory()->create(['haggle' => 25]);
        Item::factory()->create(['haggle' => 125]);
        Item::factory()->create(['haggle' => 750]);
        Item::factory()->create(['haggle' => 20000]);

        // Equals
        $response = $this->get('/api/items?haggle=750');

        $response->assertJsonCount(1);
        $response->assertJsonFragment(['haggle' => 750]);

        // Less Than
        $response = $this->get('/api/items?haggle=lt:125');

        $response->assertJsonCount(1);
        $response->assertJsonFragment(['haggle' => 25]);

        // Less Than or Equal To
        $response = $this->get('/api/items?haggle=lte:125');

        $response->assertJsonCount(2);
        $response->assertJsonFragment(['haggle' => 25]);
        $response->assertJsonFragment(['haggle' => 125]);

        // Greater Than
        $response = $this->get('/api/items?haggle=gt:125');

        $response->assertJsonCount(2);
        $response->assertJsonFragment(['haggle' => 750]);
        $response->assertJsonFragment(['haggle' => 20000]);

        // Greater Than or Equal To
        $response = $this->get('/api/items?haggle=gte:125');

        $response->assertJsonCount(3);
        $response->assertJsonFragment(['haggle' => 125]);
        $response->assertJsonFragment(['haggle' => 750]);
        $response->assertJsonFragment(['haggle' => 20000]);

        // Like
        $response = $this->get('/api/items?haggle=like:25');

        $response->assertJsonCount(2);
        $response->assertJsonFragment(['haggle' => 25]);
        $response->assertJsonFragment(['haggle' => 125]);

        // Not
        $response = $this->get('/api/items?haggle=not:125');

        $response->assertJsonCount(3);
        $response->assertJsonFragment(['haggle' => 25]);
        $response->assertJsonFragment(['haggle' => 750]);
        $response->assertJsonFragment(['haggle' => 20000]);
    }

    /** @test */
    public function it_can_filter_items_by_the_sell_high_column()
    {
        Item::factory()->create(['sell_high' => 25]);
        Item::factory()->create(['sell_high' => 125]);
        Item::factory()->create(['sell_high' => 750]);
        Item::factory()->create(['sell_high' => 20000]);

        // Equals
        $response = $this->get('/api/items?sell_high=750');

        $response->assertJsonCount(1);
        $response->assertJsonFragment(['sell_high' => 750]);

        // Less Than
        $response = $this->get('/api/items?sell_high=lt:125');

        $response->assertJsonCount(1);
        $response->assertJsonFragment(['sell_high' => 25]);

        // Less Than or Equal To
        $response = $this->get('/api/items?sell_high=lte:125');

        $response->assertJsonCount(2);
        $response->assertJsonFragment(['sell_high' => 25]);
        $response->assertJsonFragment(['sell_high' => 125]);

        // Greater Than
        $response = $this->get('/api/items?sell_high=gt:125');

        $response->assertJsonCount(2);
        $response->assertJsonFragment(['sell_high' => 750]);
        $response->assertJsonFragment(['sell_high' => 20000]);

        // Greater Than or Equal To
        $response = $this->get('/api/items?sell_high=gte:125');

        $response->assertJsonCount(3);
        $response->assertJsonFragment(['sell_high' => 125]);
        $response->assertJsonFragment(['sell_high' => 750]);
        $response->assertJsonFragment(['sell_high' => 20000]);

        // Like
        $response = $this->get('/api/items?sell_high=like:25');

        $response->assertJsonCount(2);
        $response->assertJsonFragment(['sell_high' => 25]);
        $response->assertJsonFragment(['sell_high' => 125]);

        // Not
        $response = $this->get('/api/items?sell_high=not:125');

        $response->assertJsonCount(3);
        $response->assertJsonFragment(['sell_high' => 25]);
        $response->assertJsonFragment(['sell_high' => 750]);
        $response->assertJsonFragment(['sell_high' => 20000]);
    }

    /** @test */
    public function it_can_filter_items_by_the_used_in_menu_column()
    {
        Item::factory()->create(['used_in_menu' => true]);
        Item::factory()->create(['used_in_menu' => false]);
        Item::factory()->create(['used_in_menu' => true]);

        // Equals
        $response = $this->get('/api/items?used_in_menu=true');

        $response->assertJsonCount(2);
        $response->assertJsonFragment(['used_in_menu' => true]);

        // // Like
        $response = $this->get('/api/items?used_in_menu=like:ue');

        $response->assertJsonCount(2);
        $response->assertJsonFragment(['used_in_menu' => true]);

        // // Not
        $response = $this->get('/api/items?used_in_menu=not:true');

        $response->assertJsonCount(1);
        $response->assertJsonFragment(['used_in_menu' => false]);
    }

    /** @test */
    public function it_can_filter_items_by_the_used_in_battle_column()
    {
        Item::factory()->create(['used_in_battle' => true]);
        Item::factory()->create(['used_in_battle' => false]);
        Item::factory()->create(['used_in_battle' => true]);

        // Equals
        $response = $this->get('/api/items?used_in_battle=true');

        $response->assertJsonCount(2);
        $response->assertJsonFragment(['used_in_battle' => true]);

        // Like
        $response = $this->get('/api/items?used_in_battle=like:ue');

        $response->assertJsonCount(2);
        $response->assertJsonFragment(['used_in_battle' => true]);

        // Not
        $response = $this->get('/api/items?used_in_battle=not:true');

        $response->assertJsonCount(1);
        $response->assertJsonFragment(['used_in_battle' => false]);
    }

    /** @test */
    public function it_can_filter_items_by_the_notes_column_1()
    {
        Item::factory()->create(['notes' => 'GF Compatibility: Ifrit +1']);
        Item::factory()->create(['notes' => 'GF Compatibility: Ifrit +3']);
        Item::factory()->create(['notes' => 'GF Compatibility: Shiva +3']);
        Item::factory()->create(['notes' => 'All Guardian Forces +20']);

        // Equals
        $response = $this->get('/api/items?notes=All Guardian Forces +20');

        $response->assertJsonCount(1);
        $response->assertJsonFragment(['notes' => 'All Guardian Forces +20']);

        // Equals -- With Colon
        $response = $this->get('/api/items?notes=GF Compatibility: Ifrit +3');

        $response->assertJsonCount(1);
        $response->assertJsonFragment(['notes' => 'GF Compatibility: Ifrit +3']);

        // Like
        $response = $this->get('/api/items?notes=like:Ifrit');

        $response->assertJsonCount(2);
        $response->assertJsonFragment(['notes' => 'GF Compatibility: Ifrit +1']);
        $response->assertJsonFragment(['notes' => 'GF Compatibility: Ifrit +3']);

        // Like -- With Colon
        $response = $this->get('/api/items?notes=like:GF Compatibility: Ifrit');

        $response->assertJsonCount(2);
        $response->assertJsonFragment(['notes' => 'GF Compatibility: Ifrit +1']);
        $response->assertJsonFragment(['notes' => 'GF Compatibility: Ifrit +3']);

        // Not
        $response = $this->get('/api/items?notes=not:All Guardian Forces +20');

        $response->assertJsonCount(3);
        $response->assertJsonFragment(['notes' => 'GF Compatibility: Ifrit +1']);
        $response->assertJsonFragment(['notes' => 'GF Compatibility: Ifrit +3']);
        $response->assertJsonFragment(['notes' => 'GF Compatibility: Shiva +3']);

        // Not -- With Colon
        $response = $this->get('/api/items?notes=not:GF Compatibility: Ifrit +1');

        $response->assertJsonCount(3);
        $response->assertJsonFragment(['notes' => 'GF Compatibility: Ifrit +3']);
        $response->assertJsonFragment(['notes' => 'GF Compatibility: Shiva +3']);
        $response->assertJsonFragment(['notes' => 'All Guardian Forces +20']);
    }
}
