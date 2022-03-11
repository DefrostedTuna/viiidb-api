<?php

namespace Tests\Unit\Transformers\V0;

use App\Http\Transformers\V0\StatusEffectTransformer;
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
}
