<?php

namespace Tests\Feature\Endpoints\V0;

use App\Http\Transformers\V0\LocationTransformer;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Middleware\ThrottleRequestsWithRedis;
use Tests\TestCase;

class LocationEndpointTest extends TestCase
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
    public function it_will_return_a_list_of_locations(): void
    {
        Location::factory()->count(10)->create();

        $response = $this->get('/v0/locations');

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
    public function it_will_return_an_individual_location_using_the_id_key(): void
    {
        $location = Location::factory()->create()->toArray();

        $response = $this->get("/v0/locations/{$location['id']}");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $location['id'],
                'region_id' => $location['region_id'],
                'parent_id' => $location['parent_id'],
                'sort_id' => $location['sort_id'],
                'slug' => $location['slug'],
                'name' => $location['name'],
                'notes' => $location['notes'],
            ],
        ]);
    }

    /** @test */
    public function it_will_return_an_individual_location_using_the_slug_key(): void
    {
        $location = Location::factory()->create()->toArray();

        $response = $this->get("/v0/locations/{$location['slug']}");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $location['id'],
                'region_id' => $location['region_id'],
                'parent_id' => $location['parent_id'],
                'sort_id' => $location['sort_id'],
                'slug' => $location['slug'],
                'name' => $location['name'],
                'notes' => $location['notes'],
            ],
        ]);
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found(): void
    {
        $response = $this->get('/v0/locations/invalid');

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
    public function it_can_load_the_region_relation_on_a_list_of_locations(): void
    {
        Location::factory()
            ->count(10)
            ->for(Location::factory(), 'region')
            ->create();

        $response = $this->get('/v0/locations?include=region');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status_code',
            'data' => [
                [
                    'region' => [
                        // An array of Region Location data on each record...
                    ],
                ],
            ],
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
        ]);
        // This count will be skewed compared to others since it is a same-resource relation.
        // 10 + 1 = 11
        $response->assertJsonCount(11, 'data');
    }

    /** @test */
    public function it_can_load_the_region_relation_on_an_individual_location(): void
    {
        $location = Location::factory()
            ->for(Location::factory(), 'region')
            ->create()
            ->load('region')
            ->toArray();

        $locationTransformer = $this->app->make(LocationTransformer::class);
        $response = $this->get("/v0/locations/{$location['id']}?include=region");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $location['id'],
                'region_id' => $location['region_id'],
                'parent_id' => $location['parent_id'],
                'sort_id' => $location['sort_id'],
                'slug' => $location['slug'],
                'name' => $location['name'],
                'notes' => $location['notes'],
                'region' => $locationTransformer->transformRecord($location['region']),
            ],
        ]);
    }

    /** @test */
    public function it_can_load_the_parent_relation_on_a_list_of_locations(): void
    {
        Location::factory()
            ->count(10)
            ->for(Location::factory(), 'parent')
            ->create();

        $response = $this->get('/v0/locations?include=parent');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status_code',
            'data' => [
                [
                    'parent' => [
                        // An array of Parent Location data on each record...
                    ],
                ],
            ],
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
        ]);
        // This count will be skewed compared to others since it is a same-resource relation.
        // 10 + 1 = 11
        $response->assertJsonCount(11, 'data');
    }

    /** @test */
    public function it_can_load_the_parent_relation_on_an_individual_location(): void
    {
        $location = Location::factory()
            ->for(Location::factory(), 'parent')
            ->create()
            ->load('parent')
            ->toArray();

        $locationTransformer = $this->app->make(LocationTransformer::class);
        $response = $this->get("/v0/locations/{$location['id']}?include=parent");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $location['id'],
                'region_id' => $location['region_id'],
                'parent_id' => $location['parent_id'],
                'sort_id' => $location['sort_id'],
                'slug' => $location['slug'],
                'name' => $location['name'],
                'notes' => $location['notes'],
                'parent' => $locationTransformer->transformRecord($location['parent']),
            ],
        ]);
    }

    /** @test */
    public function it_can_load_the_locations_relation_on_a_list_of_locations(): void
    {
        Location::factory()
            ->count(10)
            ->has(Location::factory()->count(10))
            ->create();

        $response = $this->get('/v0/locations?include=locations');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status_code',
            'data' => [
                [
                    'locations' => [
                        // An array of Locations on each record...
                    ],
                ],
            ],
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
        ]);
        // This count will be skewed compared to others since it is a same-resource relation.
        // (10 * 10) + 10 = 110
        $response->assertJsonCount(110, 'data');
    }

    /** @test */
    public function it_can_load_the_locations_relation_on_an_individual_location(): void
    {
        $location = Location::factory()
            ->has(Location::factory()->count(10))
            ->create()
            ->load('locations')
            ->toArray();

        $locationTransformer = $this->app->make(LocationTransformer::class);
        $response = $this->get("/v0/locations/{$location['id']}?include=locations");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $location['id'],
                'region_id' => $location['region_id'],
                'parent_id' => $location['parent_id'],
                'sort_id' => $location['sort_id'],
                'slug' => $location['slug'],
                'name' => $location['name'],
                'notes' => $location['notes'],
                'locations' => $locationTransformer->transformCollection($location['locations']),
            ],
        ]);
    }
}
