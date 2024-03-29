<?php

namespace Tests\Feature\Endpoints\V0;

use App\Http\Transformers\V0\StatusEffectTransformer;
use App\Models\Item;
use App\Models\StatusEffect;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Middleware\ThrottleRequestsWithRedis;
use Tests\TestCase;

class ItemEndpointTest extends TestCase
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
    public function it_will_return_a_list_of_items(): void
    {
        Item::factory()->count(10)->create();

        $response = $this->get('/v0/items');

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
    public function it_will_return_an_individual_item_using_the_id_key(): void
    {
        $item = Item::factory()->create()->toArray();

        $response = $this->get("/v0/items/{$item['id']}");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
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
            ],
        ]);
    }

    /** @test */
    public function it_will_return_an_individual_item_using_the_slug_key(): void
    {
        $item = Item::factory()->create()->toArray();

        $response = $this->get("/v0/items/{$item['slug']}");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
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
            ],
        ]);
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found(): void
    {
        $response = $this->get('/v0/items/invalid');

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
    public function it_can_load_the_status_effects_relation_on_a_list_of_items(): void
    {
        Item::factory()
            ->count(10)
            ->has(StatusEffect::factory()->count(2))
            ->create();

        $response = $this->get('/v0/items?include=status-effects');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status_code',
            'data' => [
                [
                    'status_effects' => [
                        // An array of Status Effects on each record...
                    ],
                ],
            ],
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
        ]);
        $response->assertJsonCount(10, 'data');
    }

    /** @test */
    public function it_can_load_the_status_effects_relation_on_an_individual_item(): void
    {
        $item = Item::factory()
            ->has(StatusEffect::factory()->count(10))
            ->create()
            ->load('statusEffects')
            ->toArray();

        $statusEffectTransformer = $this->app->make(StatusEffectTransformer::class);
        $response = $this->get("/v0/items/{$item['id']}?include=status-effects");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
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
                'status_effects' => $statusEffectTransformer->transformCollection($item['status_effects']),
            ],
        ]);
    }
}
