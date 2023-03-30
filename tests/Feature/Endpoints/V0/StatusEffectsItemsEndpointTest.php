<?php

namespace Tests\Feature\Endpoints\V0;

use App\Models\Item;
use App\Models\StatusEffect;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Middleware\ThrottleRequestsWithRedis;
use Tests\TestCase;

class StatusEffectsItemsEndpointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The middleware to exclude when running tests.
     *
     * @var array<int, class-string>
     */
    protected $excludedMiddleware = [
        ThrottleRequestsWithRedis::class,
    ];

    /** @test */
    public function it_will_return_a_list_of_items_related_to_a_status_effect_using_the_id_key(): void
    {
        $statusEffect = StatusEffect::factory()
            ->has(Item::factory()->count(3))
            ->create()
            ->toArray();

        $response = $this->get("/v0/status-effects/{$statusEffect['id']}/items");

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
        $response->assertJsonCount(3, 'data');
    }

    /** @test */
    public function it_will_return_a_list_of_itemss_related_to_a_status_effect_using_the_name_key(): void
    {
        $statusEffect = StatusEffect::factory()
            ->has(Item::factory()->count(3))
            ->create()
            ->toArray();

        $response = $this->get("/v0/status-effects/{$statusEffect['name']}/items");

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
        $response->assertJsonCount(3, 'data');
    }
}