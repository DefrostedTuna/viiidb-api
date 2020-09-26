<?php

namespace Tests\Feature\Routes;

use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocationRoutesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_locations()
    {
        Location::factory()->count(10)->create();

        $response = $this->get('/api/locations');

        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }

    /** @test */
    public function it_will_return_an_individual_location()
    {
        $location = Location::factory()->create();

        $response = $this->get("/api/locations/{$location->name}");

        $response->assertStatus(200);
        $response->assertJson($location->toArray());
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found()
    {
        $response = $this->get('/api/locations/invalid');

        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_filter_locations_by_the_name_column()
    {
        Location::factory()->create([ 'name' => 'Balamb Region' ]);
        Location::factory()->create([ 'name' => 'Galbadia Region' ]);
        Location::factory()->create([ 'name' => 'Esthar Region' ]);

        // Equals
        $response = $this->get('/api/locations?name=Balamb Region');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'name' => 'Balamb Region' ]);

        // Like
        $response = $this->get('/api/locations?name=like:al');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'name' => 'Balamb Region' ]);
        $response->assertJsonFragment([ 'name' => 'Galbadia Region' ]);

        // Not
        $response = $this->get('/api/locations?name=not:Balamb Region');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'name' => 'Galbadia Region' ]);
        $response->assertJsonFragment([ 'name' => 'Esthar Region' ]);
    }

    /** @test */
    public function it_can_filter_locations_by_the_area_column()
    {
        Location::factory()->create([ 'name' => 'Balamb', 'area' => 'Alcauld Plains' ]);
        Location::factory()->create([ 'name' => 'Timber', 'area' => 'Lanker Plains' ]);
        Location::factory()->create([ 'name' => 'Winhill', 'area' => 'Winhill Bluffs' ]);

        // Equals
        $response = $this->get('/api/locations?area=Alcauld Plains');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'area' => 'Alcauld Plains' ]);

        // Like
        $response = $this->get('/api/locations?area=like:Plains');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'area' => 'Alcauld Plains' ]);
        $response->assertJsonFragment([ 'area' => 'Lanker Plains' ]);

        // Not
        $response = $this->get('/api/locations?area=not:Alcauld Plains');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'area' => 'Lanker Plains' ]);
        $response->assertJsonFragment([ 'area' => 'Winhill Bluffs' ]);
    }

    /** @test */
    public function it_can_load_relations_on_a_list_of_resources()
    {
        $balambRegion = Location::factory()->create([
            'name' => 'Balamb Region',
            'description' => 'This is technically the parent',
            'area' => null,
        ]);
        $balambGarden = Location::factory()->create([
            'name' => 'Balamb Garden',
            'region_id' => $balambRegion->id,
            'description' => 'This is technically the child',
            'area' => 'Alcauld Plains',
        ]);

        // We need to narrow this down to only one record since the relation is of the same type.
        $response = $this->get('/api/locations?with=region&name=Balamb Garden');
        $response->assertStatus(200);
        $response->assertJsonCount(1);

        // Region.
        $response->assertJsonFragment([
            'region' => $balambRegion->toArray(),
        ]);
    }

    /** @test */
    public function it_can_load_relations_on_an_individual_resource()
    {
        $balambRegion = Location::factory()->create([
            'name' => 'Balamb Region',
            'description' => 'This is technically the parent',
            'area' => null,
        ]);
        $balambGarden = Location::factory()->create([
            'name' => 'Balamb Garden',
            'region_id' => $balambRegion->id,
            'description' => 'This is technically the child',
            'area' => 'Alcauld Plains',
        ]);

        $response = $this->get('/api/locations/Balamb Garden?with=region');
        $response->assertStatus(200);

        // Region.
        $response->assertJsonFragment([
            'region' => $balambRegion->toArray(),
        ]);
    }

    /** @test */
    public function it_can_load_relation_properties_on_a_list_of_resources()
    {
        $balambRegion = Location::factory()->create([
            'name' => 'Balamb Region',
            'description' => 'This is technically the parent',
            'area' => null,
        ]);
        $balambGarden = Location::factory()->create([
            'name' => 'Balamb Garden',
            'region_id' => $balambRegion->id,
            'description' => 'This is technically the child',
            'area' => 'Alcauld Plains',
        ]);

        // We need to narrow this down to only one record since the relation is of the same type.
        $response = $this->get('/api/locations?with=region.name,region.description,region.area&name=Balamb Garden');
        $response->assertStatus(200);
        $response->assertJsonCount(1);

        // Region.
        $response->assertJsonFragment([
            'region' => [
                'id' => $balambRegion->id,
                'region_id' => null,
                'name' => $balambRegion->name,
                'description' => $balambRegion->description,
                'area' => $balambRegion->area,
            ],
        ]);
    }

    /** @test */
    public function it_can_load_relation_properties_on_an_individual_resource()
    {
        $balambRegion = Location::factory()->create([
            'name' => 'Balamb Region',
            'description' => 'This is technically the parent',
            'area' => null,
        ]);
        $balambGarden = Location::factory()->create([
            'name' => 'Balamb Garden',
            'region_id' => $balambRegion->id,
            'description' => 'This is technically the child',
            'area' => 'Alcauld Plains',
        ]);

        // We need to narrow this down to only one record since the relation is of the same type.
        $response = $this->get('/api/locations/Balamb Garden?with=region.name,region.description,region.area');
        $response->assertStatus(200);

        // Region.
        $response->assertJsonFragment([
            'region' => [
                'id' => $balambRegion->id,
                'region_id' => null,
                'name' => $balambRegion->name,
                'description' => $balambRegion->description,
                'area' => $balambRegion->area,
            ],
        ]);
    }
}
