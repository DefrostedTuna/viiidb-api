<?php

namespace Tests\Unit\Transformers\V0;

use App\Http\Transformers\V0\ItemTransformer;
use App\Http\Transformers\V0\StatusEffectTransformer;
use App\Models\Item;
use App\Models\StatusEffect;
use Tests\TestCase;

class StatusEffectTransformerTest extends TestCase
{
    /** @test */
    public function it_will_transform_a_single_record(): void
    {
        $statusEffect = StatusEffect::factory()->make([
            'id' => 'some-random-uuid',
            'sort_id' => 1,
            'name' => 'zombie',
            'type' => 'harmful',
            'description' => 'The Zombie status causes the target to act as if undead. This effect does not wear off on its own.',
            'arbitrary' => 'data',
        ])->toArray();

        $transformer = new StatusEffectTransformer();

        $transformedRecord = $transformer->transformRecord($statusEffect);

        $this->assertEquals([
            'id' => $statusEffect['id'],
            'sort_id' => $statusEffect['sort_id'],
            'name' => $statusEffect['name'],
            'type' => $statusEffect['type'],
            'description' => $statusEffect['description'],
        ], $transformedRecord);
    }

    /** @test */
    public function it_will_transform_a_collection_of_records(): void
    {
        $statusEffects = StatusEffect::factory()->count(3)->sequence(
            ['id' => 'one', 'sort_id' => 1],
            ['id' => 'two', 'sort_id' => 2],
            ['id' => 'three', 'sort_id' => 3],
        )->make()->toArray();

        $transformer = new StatusEffectTransformer();

        $transformedRecords = $transformer->transformCollection($statusEffects);

        $this->assertEquals([
            [
                'id' => $statusEffects[0]['id'],
                'sort_id' => $statusEffects[0]['sort_id'],
                'name' => $statusEffects[0]['name'],
                'type' => $statusEffects[0]['type'],
                'description' => $statusEffects[0]['description'],
            ],
            [
                'id' => $statusEffects[1]['id'],
                'sort_id' => $statusEffects[1]['sort_id'],
                'name' => $statusEffects[1]['name'],
                'type' => $statusEffects[1]['type'],
                'description' => $statusEffects[1]['description'],
            ],
            [
                'id' => $statusEffects[2]['id'],
                'sort_id' => $statusEffects[2]['sort_id'],
                'name' => $statusEffects[2]['name'],
                'type' => $statusEffects[2]['type'],
                'description' => $statusEffects[2]['description'],
            ],
        ], $transformedRecords);
    }

    /** @test */
    public function it_will_transform_the_item_records_if_they_are_present(): void
    {
        $statusEffect = StatusEffect::factory()->make([
            'id' => 'some-random-uuid',
            'sort_id' => 1,
            'name' => 'zombie',
            'type' => 'harmful',
            'description' => 'The Zombie status causes the target to act as if undead. This effect does not wear off on its own.',
            'arbitrary' => 'data',
        ])->toArray();

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

        // Manually append the child Items to the record since we're not using the database.
        $statusEffect['items'] = [$item];

        $statusEffectTransformer = new StatusEffectTransformer();
        $itemTransformer = new ItemTransformer();

        $transformedStatusEffect = $statusEffectTransformer->transformRecord($statusEffect);
        $transformedItem = $itemTransformer->transformRecord($item);

        $this->assertEquals([$transformedItem], $transformedStatusEffect['items']);
    }

    /** @test */
    public function it_will_include_the_items_key_in_the_event_no_records_are_returned_from_the_relation(): void
    {
        $statusEffect = StatusEffect::factory()->make(['id' => 'some-uuid'])->toArray();

        // Manually append the Items to the record since we're not using the database.
        $statusEffect['items'] = null;

        $statusEffectTransformer = new StatusEffectTransformer();

        $transformedStatusEffect = $statusEffectTransformer->transformRecord($statusEffect);

        $this->assertArraySubset([
            'items' => null,
        ], $transformedStatusEffect);
    }
}
