<?php

namespace Tests\Feature\Routes;

use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
    public function multiple_colons_will_be_ignored_when_filtering_results()
    {
        factory(Location::class)->create([ 'name' => 'Balamb Region' ]);
        factory(Location::class)->create([ 'name' => 'Galbadia Region' ]);
        factory(Location::class)->create([ 'name' => 'Esthar Region' ]);

        $response = $this->get("/api/locations?name=like:al:0");

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'name' => 'Balamb Region' ]);
        $response->assertJsonFragment([ 'name' => 'Galbadia Region' ]);
    }

    /** @test */
    public function the_name_column_can_be_filtered_by_the_equals_operator()
    {
        factory(Location::class)->create([ 'name' => 'Balamb Region' ]);
        factory(Location::class)->create([ 'name' => 'Galbadia Region' ]);
        factory(Location::class)->create([ 'name' => 'Esthar Region' ]);

        $response = $this->get("/api/locations?name=Balamb Region");

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

        $response = $this->get("/api/locations?name=like:al");

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

        $response = $this->get("/api/locations?name=not:Balamb Region");

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

        $response = $this->get("/api/locations?area=Alcauld Plains");

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

        $response = $this->get("/api/locations?area=like:Plains");

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

        $response = $this->get("/api/locations?area=not:Alcauld Plains");

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

        $response = $this->get("/api/locations?name=like:Garden&area=not:Alcauld Plains");

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([
            'name' => 'Galbadia Garden',
            'area' => 'Monterosa Plateau',
        ]);
    }
}
