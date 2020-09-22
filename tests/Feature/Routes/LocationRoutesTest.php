<?php

namespace Tests\Feature\Routes;

use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocationRoutesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_a_list_of_locations()
    {
        $locations = factory(Location::class, 10)->create();

        $response = $this->get('/api/locations');

        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }

    /** @test */
    public function it_returns_an_individual_location()
    {
        $location = factory(Location::class)->create();

        $response = $this->get("/api/locations/{$location->id}");

        $response->assertStatus(200);
        $response->assertJson($location->toArray());
    }

    /** @test */
    public function it_can_load_relations_on_individual_records()
    {
        $balambRegion = factory(Location::class)->create([
            'name' => 'Balamb Region',
            'description' => 'This is technically the parent',
            'area' => 'Alcauld Plains',
        ]);
        $balambGarden = factory(Location::class)->create([
            'name' => 'Balamb Garden',
            'region_id' => $balambRegion->id,
            'description' => 'This is technically the child',
            'area' => 'Alcauld Plains',
        ]);

        $response = $this->get("/api/locations/{$balambGarden->id}?with=region");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'region' => $balambRegion->toArray()
        ]);
    }

    /** @test */
    public function it_can_load_relation_properties_on_individual_records()
    {
        $balambRegion = factory(Location::class)->create([
            'name' => 'Balamb Region',
            'description' => 'This is technically the parent',
            'area' => 'Alcauld Plains',
        ]);
        $balambGarden = factory(Location::class)->create([
            'name' => 'Balamb Garden',
            'region_id' => $balambRegion->id,
            'description' => 'This is technically the child',
            'area' => 'Alcauld Plains',
        ]);

        $response = $this->get("/api/locations/{$balambGarden->id}?with=region.name");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'region' => [
                'id' => $balambRegion->id,
                'name' => $balambRegion->name,
                'region_id' => $balambRegion->region_id,
            ],
        ]);
    }

    /** @test */
    public function it_can_load_multiple_relation_properties_on_individual_records()
    {
        $balambRegion = factory(Location::class)->create([
            'name' => 'Balamb Region',
            'description' => 'This is technically the parent',
            'area' => 'Alcauld Plains',
        ]);
        $balambGarden = factory(Location::class)->create([
            'name' => 'Balamb Garden',
            'region_id' => $balambRegion->id,
            'description' => 'This is technically the child',
            'area' => 'Alcauld Plains',
        ]);

        $response = $this->get("/api/locations/{$balambGarden->id}?with=region.name,region.area");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'region' => [
                'id' => $balambRegion->id,
                'name' => $balambRegion->name,
                'area' => $balambRegion->area,
                'region_id' => $balambRegion->region_id,
            ],
        ]);
    }

    /** @test */
    public function it_throws_an_exception_when_an_individual_record_is_not_found()
    {
        $response = $this->get('/api/locations/invalid');

        $response->assertStatus(404);
    }

    /** @test */
    public function the_name_column_can_be_filtered_by_the_equals_operator()
    {
        factory(Location::class)->create([ 'name' => 'Balamb Region' ]);
        factory(Location::class)->create([ 'name' => 'Galbadia Region' ]);
        factory(Location::class)->create([ 'name' => 'Esthar Region' ]);

        $response = $this->get('/api/locations?name=Balamb Region');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'name' => 'Balamb Region' ]);
    }

    /** @test */
    public function the_name_column_can_be_filtered_by_the_like_operator()
    {
        factory(Location::class)->create([ 'name' => 'Balamb Region' ]);
        factory(Location::class)->create([ 'name' => 'Galbadia Region' ]);
        factory(Location::class)->create([ 'name' => 'Esthar Region' ]);

        $response = $this->get('/api/locations?name=like:al');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'name' => 'Balamb Region' ]);
        $response->assertJsonFragment([ 'name' => 'Galbadia Region' ]);
    }

    /** @test */
    public function the_name_column_can_be_filtered_by_the_not_operator()
    {
        factory(Location::class)->create([ 'name' => 'Balamb Region' ]);
        factory(Location::class)->create([ 'name' => 'Galbadia Region' ]);
        factory(Location::class)->create([ 'name' => 'Esthar Region' ]);

        $response = $this->get('/api/locations?name=not:Balamb Region');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'name' => 'Galbadia Region' ]);
        $response->assertJsonFragment([ 'name' => 'Esthar Region' ]);
    }

    /** @test */
    public function the_area_column_can_be_filtered_by_the_equals_operator()
    {
        factory(Location::class)->create([ 'name' => 'Balamb', 'area' => 'Alcauld Plains' ]);
        factory(Location::class)->create([ 'name' => 'Timber', 'area' => 'Lanker Plains' ]);
        factory(Location::class)->create([ 'name' => 'Winhill', 'area' => 'Winhill Bluffs' ]);

        $response = $this->get('/api/locations?area=Alcauld Plains');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'area' => 'Alcauld Plains' ]);
    }

    /** @test */
    public function the_area_column_can_be_filtered_by_the_like_operator()
    {
        factory(Location::class)->create([ 'name' => 'Balamb', 'area' => 'Alcauld Plains' ]);
        factory(Location::class)->create([ 'name' => 'Timber', 'area' => 'Lanker Plains' ]);
        factory(Location::class)->create([ 'name' => 'Winhill', 'area' => 'Winhill Bluffs' ]);

        $response = $this->get('/api/locations?area=like:Plains');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'area' => 'Alcauld Plains' ]);
        $response->assertJsonFragment([ 'area' => 'Lanker Plains' ]);
    }

    /** @test */
    public function the_area_column_can_be_filtered_by_the_not_operator()
    {
        factory(Location::class)->create([ 'name' => 'Balamb', 'area' => 'Alcauld Plains' ]);
        factory(Location::class)->create([ 'name' => 'Timber', 'area' => 'Lanker Plains' ]);
        factory(Location::class)->create([ 'name' => 'Winhill', 'area' => 'Winhill Bluffs' ]);

        $response = $this->get('/api/locations?area=not:Alcauld Plains');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'area' => 'Lanker Plains' ]);
        $response->assertJsonFragment([ 'area' => 'Winhill Bluffs' ]);
    }

    /** @test */
    public function the_name_and_area_columns_can_both_be_filtered_together()
    {
        factory(Location::class)->create([ 'name' => 'Balamb Garden', 'area' => 'Alcauld Plains' ]);
        factory(Location::class)->create([ 'name' => 'Galbadia Garden', 'area' => 'Monterosa Plateau' ]);
        factory(Location::class)->create([ 'name' => 'Winhill', 'area' => 'Winhill Bluffs' ]);

        $response = $this->get('/api/locations?name=like:Garden&area=not:Alcauld Plains');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([
            'name' => 'Galbadia Garden',
            'area' => 'Monterosa Plateau',
        ]);
    }

    /** @test */
    public function it_can_load_the_region_without_additional_filters()
    {
        $balambRegion = factory(Location::class)->create([
            'name' => 'Balamb Region',
            'description' => 'This is technically the parent',
            'area' => 'Alcauld Plains',
        ]);
        $balambGarden = factory(Location::class)->create([
            'name' => 'Balamb Garden',
            'region_id' => $balambRegion->id,
            'description' => 'This is technically the child',
            'area' => 'Alcauld Plains',
        ]);

        $response = $this->get('/api/locations?with=region');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([
            'region' => $balambRegion->toArray(),
        ]);
    }

    /** @test */
    public function it_can_load_the_entire_region_relation()
    {
        $balambRegion = factory(Location::class)->create([
            'name' => 'Balamb Region',
            'description' => 'This is technically the parent',
            'area' => 'Alcauld Plains',
        ]);
        $balambGarden = factory(Location::class)->create([
            'name' => 'Balamb Garden',
            'region_id' => $balambRegion->id,
            'description' => 'This is technically the child',
            'area' => 'Alcauld Plains',
        ]);

        $response = $this->get('/api/locations?with=region&name=like:Garden');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([
            'region' => $balambRegion->toArray(),
        ]);
    }

    /** @test */
    public function it_can_load_the_name_column_on_the_region_relation()
    {
        $balambRegion = factory(Location::class)->create([
            'name' => 'Balamb Region',
            'description' => 'This is technically the parent',
            'area' => 'Alcauld Plains',
        ]);
        $balambGarden = factory(Location::class)->create([
            'name' => 'Balamb Garden',
            'region_id' => $balambRegion->id,
            'description' => 'This is technically the child',
            'area' => 'Alcauld Plains',
        ]);

        $response = $this->get('/api/locations?with=region.name&name=like:garden');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([
            'region' => [
                'id' => $balambRegion->id,
                'name' => $balambRegion->name,
                'region_id' => $balambRegion->region_id
            ],
        ]);
    }

    /** @test */
    public function it_can_load_multiple_relation_columns_explicitly()
    {
        $balambRegion = factory(Location::class)->create([
            'name' => 'Balamb Region',
            'description' => 'This is technically the parent',
            'area' => 'Alcauld Plains',
        ]);
        $balambGarden = factory(Location::class)->create([
            'name' => 'Balamb Garden',
            'region_id' => $balambRegion->id,
            'description' => 'This is technically the child',
            'area' => 'Alcauld Plains',
        ]);

        $response = $this->get('/api/locations?with=region.name,region.area&name=like:garden');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([
            'region' => [
                'id' => $balambRegion->id,
                'name' => $balambRegion->name,
                'area' => $balambGarden->area,
                'region_id' => $balambRegion->region_id,
            ],
        ]);
    }
}
