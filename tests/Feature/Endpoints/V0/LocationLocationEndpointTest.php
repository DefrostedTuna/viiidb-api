<?php

namespace Tests\Feature\Endpoints\V0;

use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Middleware\ThrottleRequestsWithRedis;
use Tests\TestCase;

class LocationLocationEndpointTest extends TestCase
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
    public function it_will_return_a_list_of_locations_related_to_a_location_using_the_id_key(): void
    {
        $location = Location::factory()
            ->has(Location::factory()->count(10))
            ->create()
            ->toArray();

        $response = $this->get("/v0/locations/{$location['id']}/locations");

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
    public function it_will_return_a_list_of_locations_related_to_a_location_using_the_slug_key(): void
    {
        $location = Location::factory()
            ->has(Location::factory()->count(10))
            ->create()
            ->toArray();

        $response = $this->get("/v0/locations/{$location['slug']}/locations");

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
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found(): void
    {
        $response = $this->get('/v0/locations/invalid/locations');

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
        $region = Location::factory();
        $location = Location::factory()
            ->has($region, 'region')
            ->has(
                Location::factory()->count(10)->has($region, 'region'),
                'locations'
            )
            ->create()
            ->toArray();

        $response = $this->get("/v0/locations/{$location['id']}/locations?include=region");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status_code',
            'data' => [
                [
                    'region' => [
                        // An array of Region data on each record...
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
    public function it_can_load_the_parent_relation_on_a_list_of_locations(): void
    {
        $location = Location::factory()
            ->create()
            ->toArray();
        Location::factory()->count(10)->create(['parent_id' => $location['id']]);

        $response = $this->get("/v0/locations/{$location['id']}/locations?include=parent");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status_code',
            'data' => [
                [
                    'parent' => [
                        // An array of Parent data on each record...
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
    public function it_can_load_the_locations_relation_on_a_list_of_locations(): void
    {
        /**
         * Triple nested relationship.
         * Top level Location has 10 children.
         * Each of those first level children, also have 10 children.
         * The third level should be reflected within the results.
         */
        $location = Location::factory()
            ->has(
                Location::factory()->has(
                    Location::factory()->count(10),
                    'locations'
                )->count(10),
                'locations'
            )
            ->create()
            ->toArray();

        $response = $this->get("/v0/locations/{$location['id']}/locations?include=locations");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status_code',
            'data' => [
                [
                    'locations' => [
                        // An array of Location data on each record...
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
}
