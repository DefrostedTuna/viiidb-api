<?php

namespace Tests\Feature\Endpoints\V0;

use App\Models\StatusEffect;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatusEffectEndpointTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_status_effects()
    {
        $statusEffects = StatusEffect::factory()->count(10)->create();

        $response = $this->get('/v0/status-effects');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status_code',
            'data',
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
        ]);
        $response->assertJsonCount(10, 'data');
    }

    /** @test */
    public function it_will_return_an_individual_status_effect_using_the_id_key()
    {
        $statusEffect = StatusEffect::factory()->create();

        $response = $this->get("/v0/status-effects/{$statusEffect->id}");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $statusEffect->id,
                'sort_id' => $statusEffect->sort_id,
                'name' => $statusEffect->name,
                'type' => $statusEffect->type,
                'description' => $statusEffect->description,
            ],
        ]);
    }

    /** @test */
    public function it_will_return_an_individual_status_effect_using_the_name_key()
    {
        $statusEffect = StatusEffect::factory()->create();

        $response = $this->get("/v0/status-effects/{$statusEffect->name}");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $statusEffect->id,
                'sort_id' => $statusEffect->sort_id,
                'name' => $statusEffect->name,
                'type' => $statusEffect->type,
                'description' => $statusEffect->description,
            ],
        ]);
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found()
    {
        $response = $this->get('/v0/status-effects/invalid');

        $response->assertStatus(404);
        $response->assertExactJson([
            'success' => false,
            'message' => 'The requested record could not be found.',
            'status_code' => 404,
            'errors' => [
                'message' => 'The requested record could not be found.',
            ],
        ]);
    }

    /** @test */
    public function it_can_search_for_status_effects_via_the_name_column()
    {
        StatusEffect::factory()->create(['sort_id' => 1, 'name' => 'sleep', 'type' => 'harmful']);
        $two = StatusEffect::factory()->create(['sort_id' => 2, 'name' => 'slow', 'type' => 'harmful']);
        StatusEffect::factory()->create(['sort_id' => 3, 'name' => 'haste', 'type' => 'beneficial']);

        $response = $this->get('/v0/status-effects?search=slow');

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $two->id,
                    'sort_id' => $two->sort_id,
                    'name' => $two->name,
                    'type' => $two->type,
                    'description' => $two->description,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_search_for_status_effects_via_the_type_column()
    {
        $one = StatusEffect::factory()->create(['sort_id' => 1, 'name' => 'sleep', 'type' => 'harmful']);
        $two = StatusEffect::factory()->create(['sort_id' => 2, 'name' => 'slow', 'type' => 'harmful']);
        StatusEffect::factory()->create(['sort_id' => 3, 'name' => 'haste', 'type' => 'beneficial']);

        $response = $this->get('/v0/status-effects?search=harmful');

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'sort_id' => $one->sort_id,
                    'name' => $one->name,
                    'type' => $one->type,
                    'description' => $one->description,
                ],
                [
                    'id' => $two->id,
                    'sort_id' => $two->sort_id,
                    'name' => $two->name,
                    'type' => $two->type,
                    'description' => $two->description,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_search_for_status_effects_via_the_description_column()
    {
        StatusEffect::factory()->create([
            'sort_id' => 1,
            'name' => 'sleep',
            'type' => 'harmful',
            'description' => 'Group One',
        ]);
        StatusEffect::factory()->create([
            'sort_id' => 2,
            'name' => 'slow',
            'type' => 'harmful',
            'description' => 'Group One',
        ]);
        $three = StatusEffect::factory()->create([
            'sort_id' => 3,
            'name' => 'haste',
            'type' => 'beneficial',
            'description' => 'Group Two',
        ]);

        $response = $this->get('/v0/status-effects?search=two');

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $three->id,
                    'sort_id' => $three->sort_id,
                    'name' => $three->name,
                    'type' => $three->type,
                    'description' => $three->description,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_filter_status_effects_via_the_name_column()
    {
        $one = StatusEffect::factory()->create(['sort_id' => 1, 'name' => 'sleep', 'type' => 'harmful']);
        StatusEffect::factory()->create(['sort_id' => 2, 'name' => 'slow', 'type' => 'harmful']);
        StatusEffect::factory()->create(['sort_id' => 3, 'name' => 'haste', 'type' => 'beneficial']);

        $response = $this->get('/v0/status-effects?name=sleep');

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'sort_id' => $one->sort_id,
                    'name' => $one->name,
                    'type' => $one->type,
                    'description' => $one->description,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_filter_status_effects_via_the_name_column_using_the_like_statement()
    {
        $one = StatusEffect::factory()->create(['sort_id' => 1, 'name' => 'sleep', 'type' => 'harmful']);
        $two = StatusEffect::factory()->create(['sort_id' => 2, 'name' => 'slow', 'type' => 'harmful']);
        StatusEffect::factory()->create(['sort_id' => 3, 'name' => 'haste', 'type' => 'beneficial']);

        $response = $this->get('/v0/status-effects?name=like:sl');

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'sort_id' => $one->sort_id,
                    'name' => $one->name,
                    'type' => $one->type,
                    'description' => $one->description,
                ],
                [
                    'id' => $two->id,
                    'sort_id' => $two->sort_id,
                    'name' => $two->name,
                    'type' => $two->type,
                    'description' => $two->description,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_filter_status_effects_via_the_type_column()
    {
        $one = StatusEffect::factory()->create(['sort_id' => 1, 'name' => 'sleep', 'type' => 'harmful']);
        $two = StatusEffect::factory()->create(['sort_id' => 2, 'name' => 'slow', 'type' => 'harmful']);
        StatusEffect::factory()->create(['sort_id' => 3, 'name' => 'haste', 'type' => 'beneficial']);

        $response = $this->get('/v0/status-effects?type=harmful');

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'sort_id' => $one->sort_id,
                    'name' => $one->name,
                    'type' => $one->type,
                    'description' => $one->description,
                ],
                [
                    'id' => $two->id,
                    'sort_id' => $two->sort_id,
                    'name' => $two->name,
                    'type' => $two->type,
                    'description' => $two->description,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_filter_status_effects_via_the_type_column_using_the_like_statement()
    {
        $one = StatusEffect::factory()->create(['sort_id' => 1, 'name' => 'sleep', 'type' => 'harmful']);
        $two = StatusEffect::factory()->create(['sort_id' => 2, 'name' => 'slow', 'type' => 'harmful']);
        StatusEffect::factory()->create(['sort_id' => 3, 'name' => 'haste', 'type' => 'beneficial']);

        $response = $this->get('/v0/status-effects?type=like:harm');

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'sort_id' => $one->sort_id,
                    'name' => $one->name,
                    'type' => $one->type,
                    'description' => $one->description,
                ],
                [
                    'id' => $two->id,
                    'sort_id' => $two->sort_id,
                    'name' => $two->name,
                    'type' => $two->type,
                    'description' => $two->description,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_filter_status_effects_via_the_description_column()
    {
        $one = StatusEffect::factory()->create([
            'sort_id' => 1,
            'name' => 'sleep',
            'type' => 'harmful',
            'description' => 'Group One',
        ]);
        $two = StatusEffect::factory()->create([
            'sort_id' => 2,
            'name' => 'slow',
            'type' => 'harmful',
            'description' => 'Group One',
        ]);
        StatusEffect::factory()->create([
            'sort_id' => 3,
            'name' => 'haste',
            'type' => 'beneficial',
            'description' => 'Group Two',
        ]);

        $response = $this->get('/v0/status-effects?description=Group%20One');

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'sort_id' => $one->sort_id,
                    'name' => $one->name,
                    'type' => $one->type,
                    'description' => $one->description,
                ],
                [
                    'id' => $two->id,
                    'sort_id' => $two->sort_id,
                    'name' => $two->name,
                    'type' => $two->type,
                    'description' => $two->description,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_filter_status_effects_via_the_description_column_using_the_like_statement()
    {
        $one = StatusEffect::factory()->create([
            'sort_id' => 1,
            'name' => 'sleep',
            'type' => 'harmful',
            'description' => 'Group One',
        ]);
        $two = StatusEffect::factory()->create([
            'sort_id' => 2,
            'name' => 'slow',
            'type' => 'harmful',
            'description' => 'Group One',
        ]);
        StatusEffect::factory()->create([
            'sort_id' => 3,
            'name' => 'haste',
            'type' => 'beneficial',
            'description' => 'Group Two',
        ]);

        $response = $this->get('/v0/status-effects?description=like:one');

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'sort_id' => $one->sort_id,
                    'name' => $one->name,
                    'type' => $one->type,
                    'description' => $one->description,
                ],
                [
                    'id' => $two->id,
                    'sort_id' => $two->sort_id,
                    'name' => $two->name,
                    'type' => $two->type,
                    'description' => $two->description,
                ],
            ],
        ]);
    }
}
