<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\LocationController;
use App\Models\Location;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Tests\TestCase;

class LocationControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_locations()
    {
        $locations = Location::factory()->count(10)->create();

        $locationController = new LocationController(new Location());

        $response = $locationController->index(new Request());

        // Controller should return a collection of Locations.
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(10, $response);
    }

    /** @test */
    public function it_will_return_an_individual_location()
    {
        $location = Location::factory()->create();

        $locationController = new LocationController(new Location());

        $response = $locationController->show(new Request(), $location->name);

        // The controller should return the instance of an Location that was found via
        // route model binding. Since we are mocking this result by injecting the
        // Location into the method, we should get the same Location back.
        $this->assertInstanceOf(Location::class, $response);
        $this->assertEquals($location->toArray(), $response->toArray());
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found()
    {
        $this->expectException(ModelNotFoundException::class);

        $locationController = new LocationController(new Location());

        $locationController->show(new Request(), 'not-found');
    }

    /** @test */
    public function it_can_filter_locations_by_the_name_column()
    {
        Location::factory()->create([ 'name' => 'Balamb Region' ]);
        Location::factory()->create([ 'name' => 'Galbadia Region' ]);
        Location::factory()->create([ 'name' => 'Esthar' ]);

        // Equals
        $request = new Request([ 'name' => 'Galbadia Region' ]);
        $locationController = new LocationController(new Location());
        $response = $locationController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('name', 'Galbadia Region'));

        // Like
        $request = new Request([ 'name' => 'like:Region' ]);
        $locationController = new LocationController(new Location());
        $response = $locationController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('name', 'Balamb Region'));
        $this->assertTrue($response->contains('name', 'Galbadia Region'));

        // Not
        $request = new Request([ 'name' => 'not:Galbadia Region' ]);
        $locationController = new LocationController(new Location());
        $response = $locationController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('name', 'Balamb Region'));
        $this->assertTrue($response->contains('name', 'Esthar'));
    }

    /** @test */
    public function it_can_filter_locations_by_the_area_column()
    {
        $location = new Location();
        Location::factory()->create([ 'name' => 'Balamb', 'area' => 'Alcauld Plains' ]);
        Location::factory()->create([ 'name' => 'Timber', 'area' => 'Lanker Plains' ]);
        Location::factory()->create([ 'name' => 'Winhill', 'area' => 'Winhill Bluffs' ]);

        // Equals
        $request = new Request([ 'area' => 'Alcauld Plains' ]);
        $locationController = new LocationController(new Location());
        $response = $locationController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('area', 'Alcauld Plains'));

        // Like
        $request = new Request([ 'area' => 'like:Plains' ]);
        $locationController = new LocationController(new Location());
        $response = $locationController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('area', 'Alcauld Plains'));
        $this->assertTrue($response->contains('area', 'Lanker Plains'));

        // Not
        $request = new Request([ 'area' => 'not:Alcauld Plains' ]);
        $locationController = new LocationController(new Location());
        $response = $locationController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('area', 'Lanker Plains'));
        $this->assertTrue($response->contains('area', 'Winhill Bluffs'));
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
        $request = new Request([
            'with' => 'region',
            'name' => 'Balamb Garden',
        ]);
        $locationController = new LocationController(new Location());
        $response = $locationController->index($request);
        $this->assertCount(1, $response);

        // Region.
        $this->assertTrue(array_key_exists('region', $response->first()->toArray()));
        $this->assertEquals(
            $balambRegion->toArray(),
            $response->first()->region->toArray()
        );
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

        $request = new Request([
            'with' => 'region' ,
        ]);
        $locationController = new LocationController(new Location());
        $response = $locationController->show($request, $balambGarden->name);

        // Region.
        $this->assertTrue(array_key_exists('region', $response->toArray()));
        $this->assertEquals(
            $balambRegion->toArray(),
            $response->region->toArray()
        );
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
        $request = new Request([
            'with' => 'region.name,region.description,region.area',
            'name' => 'Balamb Garden',
        ]);
        $locationController = new LocationController(new Location());
        $response = $locationController->index($request);
        $this->assertCount(1, $response);

        // Region.
        $this->assertTrue(array_key_exists('region', $response->first()->toArray()));
        $this->assertEquals([
            'id' => $balambRegion->id,
            'region_id' => null,
            'name' => $balambRegion->name,
            'description' => $balambRegion->description,
            'area' => $balambRegion->area,
        ], $response->first()->region->toArray());
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

        $request = new Request([ 'with' => 'region.name,region.description,region.area' ]);
        $locationController = new LocationController(new Location());
        $response = $locationController->show($request, $balambGarden->name);

        // Region.
        $this->assertTrue(array_key_exists('region', $response->toArray()));
        $this->assertEquals([
            'id' => $balambRegion->id,
            'region_id' => null,
            'name' => $balambRegion->name,
            'description' => $balambRegion->description,
            'area' => $balambRegion->area,
        ], $response->region->toArray());
    }
}
