<?php

namespace Tests\Feature\Routes;

use App\Models\StatusEffect;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatusEffectRoutesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_a_list_of_status_effects()
    {
        $statusEffects = StatusEffect::factory()->count(10)->create();

        $response = $this->get('/api/status-effects');

        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }

    /** @test */
    public function it_returns_an_individual_statusEffect()
    {
        $statusEffect = StatusEffect::factory()->create();

        $response = $this->get("/api/status-effects/{$statusEffect->id}");

        $response->assertStatus(200);
        $response->assertJson($statusEffect->toArray());
    }

    /** @test */
    public function it_throws_an_exception_when_an_individual_record_is_not_found()
    {
        $response = $this->get('/api/status-effects/invalid');

        $response->assertStatus(404);
    }

    /** @test */
    public function the_name_column_can_be_filtered_by_the_equals_operator()
    {
        StatusEffect::factory()->create([ 'name' => 'Death', 'type' => 'harmful' ]);
        StatusEffect::factory()->create([ 'name' => 'Double', 'type' => 'beneficial' ]);
        StatusEffect::factory()->create([ 'name' => 'Triple', 'type' => 'beneficial' ]);

        $response = $this->get('/api/status-effects?name=Death');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'name' => 'Death' ]);
    }

    /** @test */
    public function the_name_column_can_be_filtered_by_the_like_operator()
    {
        StatusEffect::factory()->create([ 'name' => 'Death', 'type' => 'harmful' ]);
        StatusEffect::factory()->create([ 'name' => 'Double', 'type' => 'beneficial' ]);
        StatusEffect::factory()->create([ 'name' => 'Triple', 'type' => 'beneficial' ]);

        $response = $this->get('/api/status-effects?name=like:le');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'name' => 'Double' ]);
        $response->assertJsonFragment([ 'name' => 'Triple' ]);
    }

    /** @test */
    public function the_name_column_can_be_filtered_by_the_not_operator()
    {
        StatusEffect::factory()->create([ 'name' => 'Death', 'type' => 'harmful' ]);
        StatusEffect::factory()->create([ 'name' => 'Double', 'type' => 'beneficial' ]);
        StatusEffect::factory()->create([ 'name' => 'Triple', 'type' => 'beneficial' ]);

        $response = $this->get('/api/status-effects?name=not:Double');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'name' => 'Death' ]);
        $response->assertJsonFragment([ 'name' => 'Triple' ]);
    }

    /** @test */
    public function the_type_column_can_be_filtered_by_the_equals_operator()
    {
        StatusEffect::factory()->create([ 'name' => 'Death', 'type' => 'harmful' ]);
        StatusEffect::factory()->create([ 'name' => 'Double', 'type' => 'beneficial' ]);
        StatusEffect::factory()->create([ 'name' => 'Triple', 'type' => 'beneficial' ]);

        $response = $this->get('/api/status-effects?type=harmful');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'name' => 'Death' ]);
        $response->assertJsonFragment([ 'type' => 'harmful' ]);
    }

    /** @test */
    public function the_type_column_can_be_filtered_by_the_like_operator()
    {
        StatusEffect::factory()->create([ 'name' => 'Death', 'type' => 'harmful' ]);
        StatusEffect::factory()->create([ 'name' => 'Double', 'type' => 'beneficial' ]);
        StatusEffect::factory()->create([ 'name' => 'Triple', 'type' => 'beneficial' ]);

        $response = $this->get('/api/status-effects?type=like:cial');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'name' => 'Double' ]);
        $response->assertJsonFragment([ 'name' => 'Triple' ]);
    }

    /** @test */
    public function the_type_column_can_be_filtered_by_the_not_operator()
    {
        StatusEffect::factory()->create([ 'name' => 'Death', 'type' => 'harmful' ]);
        StatusEffect::factory()->create([ 'name' => 'Double', 'type' => 'beneficial' ]);
        StatusEffect::factory()->create([ 'name' => 'Triple', 'type' => 'beneficial' ]);

        $response = $this->get('/api/status-effects?type=not:beneficial');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'name' => 'Death' ]);
        $response->assertJsonFragment([ 'type' => 'harmful' ]);
    }

    /** @test */
    public function the_name_and_type_columns_can_both_be_filtered_together()
    {
        StatusEffect::factory()->create([ 'name' => 'Death', 'type' => 'harmful' ]);
        StatusEffect::factory()->create([ 'name' => 'Double', 'type' => 'beneficial' ]);
        StatusEffect::factory()->create([ 'name' => 'Triple', 'type' => 'beneficial' ]);

        $response = $this->get('/api/status-effects?name=like:Dou&type=like:ficial');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([
            'name' => 'Double',
            'type' => 'beneficial',
        ]);
    }
}
