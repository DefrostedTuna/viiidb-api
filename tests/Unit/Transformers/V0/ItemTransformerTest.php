<?php

namespace Tests\Unit\Transformers\V0;

use App\Http\Transformers\V0\ItemTransformer;
use App\Http\Transformers\V0\StatusEffectTransformer;
use App\Models\Item;
use App\Models\StatusEffect;
use Tests\TestCase;

class ItemTransformerTest extends TestCase
{
    /** @test */
    public function it_will_transform_a_single_record(): void
    {
        $item = Item::factory()->make([
            'id' => 'some-random-string',
            'slug' => 'potion-plus',
            'position' => 2,
            'name' => 'Potion+',
            'type' => 'Medicine',
            'description' => 'Restores HP by 400',
            'menu_effect' => 'One party member',
            'value' => 100,
            'price' => null,
            'sell_high' => 150,
            'haggle' => null,
            'used_in_menu' => true,
            'used_in_battle' => true,
            'notes' => null,
        ])->toArray();

        $transformer = new ItemTransformer();

        $transformedRecord = $transformer->transformRecord($item);

        $this->assertEquals([
            'id' => $item['id'],
            'slug' => $item['slug'],
            'position' => $item['position'],
            'name' => $item['name'],
            'type' => $item['type'],
            'description' => $item['description'],
            'menu_effect' => $item['menu_effect'],
            'value' => $item['value'],
            'price' => $item['price'],
            'sell_high' => $item['sell_high'],
            'haggle' => $item['haggle'],
            'used_in_menu' => $item['used_in_menu'],
            'used_in_battle' => $item['used_in_battle'],
            'notes' => $item['notes'],
        ], $transformedRecord);
    }

    /** @test */
    public function it_will_transform_a_collection_of_records(): void
    {
        $items = Item::factory()->count(3)->sequence(
            ['id' => 'one'],
            ['id' => 'two'],
            ['id' => 'three']
        )->make()->toArray();

        $transformer = new ItemTransformer();

        $transformedRecords = $transformer->transformCollection($items);

        $this->assertEquals([
            [
                'id' => $items[0]['id'],
                'slug' => $items[0]['slug'],
                'position' => $items[0]['position'],
                'name' => $items[0]['name'],
                'type' => $items[0]['type'],
                'description' => $items[0]['description'],
                'menu_effect' => $items[0]['menu_effect'],
                'value' => $items[0]['value'],
                'price' => $items[0]['price'],
                'sell_high' => $items[0]['sell_high'],
                'haggle' => $items[0]['haggle'],
                'used_in_menu' => $items[0]['used_in_menu'],
                'used_in_battle' => $items[0]['used_in_battle'],
                'notes' => $items[0]['notes'],
            ],
            [
                'id' => $items[1]['id'],
                'slug' => $items[1]['slug'],
                'position' => $items[1]['position'],
                'name' => $items[1]['name'],
                'type' => $items[1]['type'],
                'description' => $items[1]['description'],
                'menu_effect' => $items[1]['menu_effect'],
                'value' => $items[1]['value'],
                'price' => $items[1]['price'],
                'sell_high' => $items[1]['sell_high'],
                'haggle' => $items[1]['haggle'],
                'used_in_menu' => $items[1]['used_in_menu'],
                'used_in_battle' => $items[1]['used_in_battle'],
                'notes' => $items[1]['notes'],
            ],
            [
                'id' => $items[2]['id'],
                'slug' => $items[2]['slug'],
                'position' => $items[2]['position'],
                'name' => $items[2]['name'],
                'type' => $items[2]['type'],
                'description' => $items[2]['description'],
                'menu_effect' => $items[2]['menu_effect'],
                'value' => $items[2]['value'],
                'price' => $items[2]['price'],
                'sell_high' => $items[2]['sell_high'],
                'haggle' => $items[2]['haggle'],
                'used_in_menu' => $items[2]['used_in_menu'],
                'used_in_battle' => $items[2]['used_in_battle'],
                'notes' => $items[2]['notes'],
            ],
        ], $transformedRecords);
    }

    /** @test */
    public function it_will_transform_the_status_effect_records_if_they_are_present(): void
    {
        $item = Item::factory()->make([
            'id' => 'some-random-string',
            'slug' => 'remedy-plus',
            'position' => 17,
            'name' => 'Remedy+',
            'type' => 'Medicine',
            'description' => 'Cures abnormal status',
            'menu_effect' => 'One party member',
            'value' => 1000,
            'price' => null,
            'haggle' => null,
            'sell_high' => 1500,
            'used_in_menu' => true,
            'used_in_battle' => true,
            'notes' => null,
        ])->toArray();

        $statusEffect = StatusEffect::factory()->make([
            'id' => 'some-random-uuid',
            'sort_id' => 1,
            'name' => 'zombie',
            'type' => 'harmful',
            'description' => 'The Zombie status causes the target to act as if undead. This effect does not wear off on its own.',
            'arbitrary' => 'data',
        ])->toArray();

        // Manually append the child Status Effects to the record since we're not using the database.
        $item['status_effects'] = [$statusEffect];

        $itemTransformer = new ItemTransformer();
        $statusEffectTransformer = new StatusEffectTransformer();

        $transformedItem = $itemTransformer->transformRecord($item);
        $transformedStatusEffect = $statusEffectTransformer->transformRecord($statusEffect);

        $this->assertEquals([$transformedStatusEffect], $transformedItem['status_effects']);
    }

    /** @test */
    public function it_will_include_the_status_effects_key_in_the_event_no_records_are_returned_from_the_relation(): void
    {
        $item = Item::factory()->make(['id' => 'some-uuid'])->toArray();

        // Manually append the Status Effects to the record since we're not using the database.
        $item['status_effects'] = null;

        $itemTransformer = new ItemTransformer();

        $transformedItem = $itemTransformer->transformRecord($item);

        $this->assertArraySubset([
            'status_effects' => null,
        ], $transformedItem);
    }
}
