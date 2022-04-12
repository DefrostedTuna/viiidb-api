<?php

namespace Tests\Feature\Endpoints\V0;

use App\Models\StatusEffect;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatusEffectEndpointTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_status_effects(): void
    {
        StatusEffect::factory()->count(10)->create();

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
    public function it_will_return_an_individual_status_effect_using_the_id_key(): void
    {
        $statusEffect = StatusEffect::factory()->create()->toArray();

        $response = $this->get("/v0/status-effects/{$statusEffect['id']}");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $statusEffect['id'],
                'sort_id' => $statusEffect['sort_id'],
                'name' => $statusEffect['name'],
                'type' => $statusEffect['type'],
                'description' => $statusEffect['description'],
            ],
        ]);
    }

    /** @test */
    public function it_will_return_an_individual_status_effect_using_the_name_key(): void
    {
        $statusEffect = StatusEffect::factory()->create()->toArray();

        $response = $this->get("/v0/status-effects/{$statusEffect['name']}");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $statusEffect['id'],
                'sort_id' => $statusEffect['sort_id'],
                'name' => $statusEffect['name'],
                'type' => $statusEffect['type'],
                'description' => $statusEffect['description'],
            ],
        ]);
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found(): void
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
}
