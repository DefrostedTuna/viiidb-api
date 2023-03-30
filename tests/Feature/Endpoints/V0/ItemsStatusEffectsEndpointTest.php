<?php

namespace Tests\Feature\Endpoints\V0;

use App\Models\Item;
use App\Models\StatusEffect;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Middleware\ThrottleRequestsWithRedis;
use Tests\TestCase;

class ItemsStatusEffectsEndpointTest extends TestCase
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
    public function it_will_return_a_list_of_status_effects_related_to_an_item_using_the_id_key(): void
    {
        $item = Item::factory()
            ->has(StatusEffect::factory()->count(3))
            ->create()
            ->toArray();

        $response = $this->get("/v0/items/{$item['id']}/status-effects");

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
    public function it_will_return_a_list_of_status_effects_related_to_an_item_using_the_slug_key(): void
    {
        $item = Item::factory()
            ->has(StatusEffect::factory()->count(3))
            ->create()
            ->toArray();

        $response = $this->get("/v0/items/{$item['slug']}/status-effects");

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