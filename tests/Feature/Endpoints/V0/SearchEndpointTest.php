<?php

namespace Tests\Feature\Endpoints\V0;

use App\Models\Element;
use App\Models\Item;
use App\Models\Location;
use App\Models\SeedRank;
use App\Models\SeedTest;
use App\Models\StatusEffect;
use App\Models\TestQuestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Middleware\ThrottleRequestsWithRedis;
use Tests\TestCase;

class SearchEndpointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The middleware to exclude when running tests.
     *
     * @var array<int, class-string>
     */
    protected $excludedMiddlware = [
        ThrottleRequestsWithRedis::class,
    ];

    /** @test */
    public function it_will_search_for_records(): void
    {
        // Scout is disabled during testing, so search queries won't hit the actual service.
        // Fallback SQL queries return slightly different results; `query%` vs `%query%`.
        SeedRank::factory(3)->sequence(
            ['rank' => 2, 'salary' => 1000],
            ['rank' => 12, 'salary' => 10000],
            ['rank' => 15, 'salary' => 12500],
        )->create()->toArray();

        $response = $this->get('/v0/search?q=1000');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status_code',
            'data' => [
                'seed_ranks' => [],
            ],
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
        ]);
        $response->assertJsonCount(2, 'data.seed_ranks');
    }

    /** @test */
    public function it_will_search_for_records_within_a_subset_of_resources(): void
    {
        // Scout is disabled during testing, so search queries won't hit the actual service.
        // Fallback SQL queries return slightly different results; `query%` vs `%query%`.
        SeedRank::factory(3)->sequence(
            ['rank' => 2, 'salary' => 1000],
            ['rank' => 12, 'salary' => 10000],
            ['rank' => 15, 'salary' => 12500],
        )->create();
        TestQuestion::factory(5)->create();

        $response = $this->get('/v0/search?q=1000&only=seed-ranks');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status_code',
            'data' => [
                'seed_ranks' => [],
            ],
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
        ]);
        $response->assertJsonCount(2, 'data.seed_ranks');
    }

    /** @test */
    public function it_will_exclude_a_subset_of_resources_when_searching_for_records(): void
    {
        // Scout is disabled during testing, so search queries won't hit the actual service.
        // Fallback SQL queries return slightly different results; `query%` vs `%query%`.
        SeedRank::factory(3)->sequence(
            ['rank' => 2, 'salary' => 1000],
            ['rank' => 12, 'salary' => 10000],
            ['rank' => 15, 'salary' => 12500],
        )->create();
        TestQuestion::factory(5)->create();

        $response = $this->get('/v0/search?q=1000&exclude=test-questions');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status_code',
            'data' => [
                'seed_ranks' => [],
            ],
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
        ]);
        $response->assertJsonCount(2, 'data.seed_ranks');
    }

    /** @test */
    public function it_will_search_for_items(): void
    {
        Item::factory()->create([
            'name' => 'Potion',
        ]);

        $response = $this->get('/v0/search?q=potion');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status_code',
            'data' => [
                'items' => [],
            ],
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
        ]);
        $response->assertJsonCount(1, 'data.items');
    }

    /** @test */
    public function it_will_search_for_locations(): void
    {
        Location::factory()->create([
            'name' => 'Balamb - Alcauld Plains',
        ]);

        $response = $this->get('/v0/search?q=Balamb');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status_code',
            'data' => [
                'locations' => [],
            ],
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
        ]);
        $response->assertJsonCount(1, 'data.locations');
    }

    /** @test */
    public function it_will_search_for_seed_tests(): void
    {
        SeedTest::factory()->create([
            'level' => 30,
        ]);

        $response = $this->get('/v0/search?q=30');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status_code',
            'data' => [
                'seed_tests' => [],
            ],
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
        ]);
        $response->assertJsonCount(1, 'data.seed_tests');
    }

    /** @test */
    public function it_will_search_for_test_questions(): void
    {
        TestQuestion::factory()->create([
            'question' => 'The Draw command extracts magic from enemies.',
        ]);

        $response = $this->get('/v0/search?q=draw');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status_code',
            'data' => [
                'test_questions' => [],
            ],
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
        ]);
        $response->assertJsonCount(1, 'data.test_questions');
    }

    /** @test */
    public function it_will_search_for_status_effects(): void
    {
        StatusEffect::factory()->create([
            'name' => 'Poison',
        ]);

        $response = $this->get('/v0/search?q=poison');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status_code',
            'data' => [
                'status_effects' => [],
            ],
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
        ]);
        $response->assertJsonCount(1, 'data.status_effects');
    }

    /** @test */
    public function it_will_search_for_elements(): void
    {
        Element::factory()->create([
            'name' => 'Fire',
        ]);

        $response = $this->get('/v0/search?q=fire');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status_code',
            'data' => [
                'elements' => [],
            ],
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
        ]);
        $response->assertJsonCount(1, 'data.elements');
    }

    /** @test */
    public function it_will_search_for_seed_ranks(): void
    {
        SeedRank::factory()->create([
            'salary' => 30000,
        ]);

        $response = $this->get('/v0/search?q=30000');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status_code',
            'data' => [
                'seed_ranks' => [],
            ],
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
        ]);
        $response->assertJsonCount(1, 'data.seed_ranks');
    }
}
