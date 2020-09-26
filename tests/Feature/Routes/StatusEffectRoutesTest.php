<?php

namespace Tests\Feature\Routes;

use App\Models\StatusEffect;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatusEffectRoutesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_status_effects()
    {
        StatusEffect::factory()->count(10)->create();

        $response = $this->get('/api/status-effects');

        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }

    /** @test */
    public function it_will_return_an_individual_statusEffect()
    {
        $statusEffect = StatusEffect::factory()->create();

        $response = $this->get("/api/status-effects/{$statusEffect->name}");

        $response->assertStatus(200);
        $response->assertJson($statusEffect->toArray());
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found()
    {
        $response = $this->get('/api/status-effects/invalid');

        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_filter_status_effects_by_the_name_column()
    {
        StatusEffect::factory()->create([ 'name' => 'Death', 'type' => 'harmful' ]);
        StatusEffect::factory()->create([ 'name' => 'Double', 'type' => 'beneficial' ]);
        StatusEffect::factory()->create([ 'name' => 'Triple', 'type' => 'beneficial' ]);

        // Equals
        $response = $this->get('/api/status-effects?name=Death');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'name' => 'Death' ]);

        // Like
        $response = $this->get('/api/status-effects?name=like:le');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'name' => 'Double' ]);
        $response->assertJsonFragment([ 'name' => 'Triple' ]);

        // Not
        $response = $this->get('/api/status-effects?name=not:Double');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'name' => 'Death' ]);
        $response->assertJsonFragment([ 'name' => 'Triple' ]);
    }

    /** @test */
    public function it_can_filter_status_effects_by_the_type_column()
    {
        StatusEffect::factory()->create([ 'name' => 'Death', 'type' => 'harmful' ]);
        StatusEffect::factory()->create([ 'name' => 'Double', 'type' => 'beneficial' ]);
        StatusEffect::factory()->create([ 'name' => 'Triple', 'type' => 'beneficial' ]);

        // Equals
        $response = $this->get('/api/status-effects?type=harmful');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'name' => 'Death', 'type'  => 'harmful' ]);

        // Like
        $response = $this->get('/api/status-effects?type=like:cial');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'name' => 'Double', 'type' => 'beneficial' ]);
        $response->assertJsonFragment([ 'name' => 'Triple', 'type' => 'beneficial' ]);

        // Not
        $response = $this->get('/api/status-effects?type=not:beneficial');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'name' => 'Death', 'type' => 'harmful' ]);
    }
}
