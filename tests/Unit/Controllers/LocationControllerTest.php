<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\LocationController;
use App\Models\Location;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class LocationControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_return_a_list_of_locations()
    {
        $locations = factory(Location::class, 10)->create();

        $locationController = new LocationController(new Location());

        $response = $locationController->index(new Request());

        // Controller should return a collection of Locations.
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(10, $response);
    }

    /** @test */
    public function it_returns_an_individual_location()
    {
        $location = factory(Location::class)->create();

        $locationController = new LocationController(new Location());

        $response = $locationController->show(new Request(), $location);

        // The controller should return the instance of a Location that was found via 
        // route model binding. Since we are mocking this result by injecting the
        // Location into the method, we should get the same Location back.
        $this->assertInstanceOf(Location::class, $response);
        $this->assertEquals($location, $response);
    }

    /** @test */
    public function multiple_colons_will_be_ignored_when_filtering_results()
    {
        // Set the filterable operators on the Location class.
        $location = new Location();
        $location->filterableOperators = [ 'like' => 'like' ];

        factory(Location::class)->create([ 'name' => 'Balamb Region' ]);
        factory(Location::class)->create([ 'name' => 'Galbadia Region' ]);
        factory(Location::class)->create([ 'name' => 'Esthar Region' ]);

        $request = new Request(['name' => 'like:al:w']);
        $locationController = new LocationController($location);
        $response = $locationController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('name', 'Balamb Region'));
        $this->assertTrue($response->contains('name', 'Galbadia Region'));
    }

    /** @test */
    public function the_filters_are_case_insensitive()
    {
        factory(Location::class)->create([ 'name' => 'Balamb Region' ]);
        factory(Location::class)->create([ 'name' => 'Galbadia Region' ]);
        factory(Location::class)->create([ 'name' => 'Esthar Region' ]);

        $request = new Request(['name' => 'galbadia region']);
        $locationController = new LocationController(new Location());
        $response = $locationController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('name', 'Galbadia Region'));
    }

    /** @test */
    public function the_name_column_can_be_filtered_by_the_equals_operator()
    {
        factory(Location::class)->create([ 'name' => 'Balamb Region' ]);
        factory(Location::class)->create([ 'name' => 'Galbadia Region' ]);
        factory(Location::class)->create([ 'name' => 'Esthar Region' ]);

        $request = new Request(['name' => 'Galbadia Region']);
        $locationController = new LocationController(new Location());
        $response = $locationController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('name', 'Galbadia Region'));
    }

    /** @test */
    public function the_name_column_can_be_filtered_by_the_like_operator()
    {
        factory(Location::class)->create([ 'name' => 'Balamb Region' ]);
        factory(Location::class)->create([ 'name' => 'Galbadia Region' ]);
        factory(Location::class)->create([ 'name' => 'Esthar' ]);

        $request = new Request(['name' => 'like:Region']);
        $locationController = new LocationController(new Location());
        $response = $locationController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('name', 'Balamb Region'));
        $this->assertTrue($response->contains('name', 'Galbadia Region'));
    }

    /** @test */
    public function the_name_column_can_be_filtered_by_the_not_operator()
    {
        factory(Location::class)->create([ 'name' => 'Balamb Region' ]);
        factory(Location::class)->create([ 'name' => 'Galbadia Region' ]);
        factory(Location::class)->create([ 'name' => 'Esthar' ]);

        $request = new Request(['name' => 'not:Galbadia Region']);
        $locationController = new LocationController(new Location());
        $response = $locationController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('name', 'Balamb Region'));
        $this->assertTrue($response->contains('name', 'Esthar'));
    }

    /** @test */
    public function the_area_column_can_be_filtered_by_the_equals_operator()
    {
        factory(Location::class)->create([ 'name' => 'Balamb', 'area' => 'Alcauld Plains' ]);
        factory(Location::class)->create([ 'name' => 'Timber', 'area' => 'Lanker Plains' ]);
        factory(Location::class)->create([ 'name' => 'Winhill', 'area' => 'Winhill Bluffs' ]);

        $request = new Request([ 'area' => 'Alcauld Plains' ]);
        $locationController = new LocationController(new Location());
        $response = $locationController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('area', 'Alcauld Plains'));
    }

    /** @test */
    public function the_area_column_can_be_filtered_by_the_like_operator()
    {
        factory(Location::class)->create([ 'name' => 'Balamb', 'area' => 'Alcauld Plains' ]);
        factory(Location::class)->create([ 'name' => 'Timber', 'area' => 'Lanker Plains' ]);
        factory(Location::class)->create([ 'name' => 'Winhill', 'area' => 'Winhill Bluffs' ]);

        $request = new Request(['area' => 'like:Plains']);
        $locationController = new LocationController(new Location());
        $response = $locationController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('area', 'Alcauld Plains'));
        $this->assertTrue($response->contains('area', 'Lanker Plains'));
    }

    /** @test */
    public function the_area_column_can_be_filtered_by_the_not_operator()
    {
        factory(Location::class)->create([ 'name' => 'Balamb', 'area' => 'Alcauld Plains' ]);
        factory(Location::class)->create([ 'name' => 'Timber', 'area' => 'Lanker Plains' ]);
        factory(Location::class)->create([ 'name' => 'Winhill', 'area' => 'Winhill Bluffs' ]);

        $request = new Request(['area' => 'not:Alcauld Plains']);
        $locationController = new LocationController(new Location());
        $response = $locationController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('area', 'Lanker Plains'));
        $this->assertTrue($response->contains('area', 'Winhill Bluffs'));
    }

    /** @test */
    public function the_name_and_area_columns_can_both_be_filtered_together()
    {
        factory(Location::class)->create([ 'name' => 'Balamb Garden', 'area' => 'Alcauld Plains' ]);
        factory(Location::class)->create([ 'name' => 'Galbadia Garden', 'area' => 'Monterosa Plateau' ]);
        factory(Location::class)->create([ 'name' => 'Winhill', 'area' => 'Winhill Bluffs' ]);

        $request = new Request([
            'name' => 'like:Garden',
            'area' => 'like:Plateau',
        ]);
        $locationController = new LocationController(new Location());
        $response = $locationController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('name', 'Galbadia Garden'));
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

        $request = new Request([ 'with' => 'region' ]);
        $locationController = new LocationController(new Location());
        $response = $locationController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue(array_key_exists(
            'region', 
            $response->firstWhere('id', $balambGarden->id)->toArray()
        ));
        $this->assertEquals(
            $balambRegion->toArray(), 
            $response->firstWhere('id', $balambGarden->id)->region->toArray()
        );
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

        $request = new Request([ 'with' => 'region', 'name' => 'like:garden' ]);
        $locationController = new LocationController(new Location());
        $response = $locationController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue(array_key_exists('region', $response->first()->toArray()));
        $this->assertEquals($balambRegion->toArray(), $response->first()->region->toArray());
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

        $request = new Request([ 'with' => 'region.name', 'name' => 'like:garden' ]);
        $locationController = new LocationController(new Location());
        $response = $locationController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue(array_key_exists('region', $response->first()->toArray()));
        $this->assertEquals([
                'id' => $balambRegion->id,
                'name' => $balambRegion->name,
            ], 
            $response->first()->region->toArray()
        );
    }

    /** @test */
    public function it_can_load_multiple_columns_explicitly()
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

        $request = new Request([ 'with' => 'region.name,region.area', 'name' => 'like:garden' ]);
        $locationController = new LocationController(new Location());
        $response = $locationController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue(array_key_exists('region', $response->first()->toArray()));
        $this->assertEquals([
                'id' => $balambRegion->id,
                'name' => $balambRegion->name,
                'area' => $balambRegion->area,
            ], 
            $response->first()->region->toArray()
        );
    }
}
