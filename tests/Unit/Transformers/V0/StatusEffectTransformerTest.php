<?php

namespace Tests\Unit\Transformers\V0;

use App\Http\Transformers\V0\StatusEffectTransformer;
use App\Models\StatusEffect;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class StatusEffectTransformerTest extends TestCase
{
    /** @test */
    public function it_will_transform_a_single_record()
    {
        $statusEffect = StatusEffect::factory()->make([
            'id' => 'some-random-uuid',
            'name' => 'zombie',
            'type' => 'harmful',
            'description' => 'The Zombie status causes the target to act as if undead. This effect does not wear off on its own.',
            'arbitrary' => 'data',
        ]);

        $transformer = new StatusEffectTransformer();

        $transformedRecord = $transformer->transformRecord($statusEffect->toArray());

        $this->assertEquals([
            'id' => $statusEffect->id,
            'name' => $statusEffect->name,
            'type' => $statusEffect->type,
            'description' => $statusEffect->description,
        ], $transformedRecord);
    }

    /** @test */
    public function it_will_transform_a_collection_of_records()
    {
        $statusEffects = StatusEffect::factory()->count(3)->make(new Sequence(
            ['id' => 'one'],
            ['id' => 'two'],
            ['id' => 'three']
        ));

        $transformer = new StatusEffectTransformer();

        $transformedRecords = $transformer->transformCollection($statusEffects->toArray());

        $this->assertEquals([
            [
                'id' => $statusEffects[0]->id,
                'name' => $statusEffects[0]->name,
                'type' => $statusEffects[0]->type,
                'description' => $statusEffects[0]->description,
            ],
            [
                'id' => $statusEffects[1]->id,
                'name' => $statusEffects[1]->name,
                'type' => $statusEffects[1]->type,
                'description' => $statusEffects[1]->description,
            ],
            [
                'id' => $statusEffects[2]->id,
                'name' => $statusEffects[2]->name,
                'type' => $statusEffects[2]->type,
                'description' => $statusEffects[2]->description,
            ],
        ], $transformedRecords);
    }
}
