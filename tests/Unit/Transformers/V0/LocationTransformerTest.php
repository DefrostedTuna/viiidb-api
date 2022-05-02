<?php

namespace Tests\Unit\Transformers\V0;

use App\Http\Transformers\V0\LocationTransformer;
use App\Models\Location;
use Tests\TestCase;

class LocationTransformerTest extends TestCase
{
    /** @test */
    public function it_will_transform_a_single_record(): void
    {
        $location = Location::factory()->make([
            'id' => 'some-random-uuid',
            'region_id' => 'some-random-region-uuid',
            'parent_id' => 'some-random-parent-uuid',
            'sort_id' => 1,
            'slug' => 'balamb-alcauld-plains',
            'name' => 'Balamb - Alcauld Plains',
            'notes' => null,
        ])->toArray();

        $transformer = new LocationTransformer();

        $transformedRecord = $transformer->transformRecord($location);

        $this->assertEquals([
            'id' => $location['id'],
            'region_id' => $location['region_id'],
            'parent_id' => $location['parent_id'],
            'sort_id' => $location['sort_id'],
            'slug' => $location['slug'],
            'name' => $location['name'],
            'notes' => $location['notes'],
        ], $transformedRecord);
    }

    /** @test */
    public function it_will_transform_a_collection_of_records(): void
    {
        $locations = Location::factory()->count(3)->sequence(
            ['id' => 'one'],
            ['id' => 'two'],
            ['id' => 'three']
        )->make()->toArray();

        $transformer = new LocationTransformer();

        $transformedRecords = $transformer->transformCollection($locations);

        $this->assertEquals([
            [
                'id' => $locations[0]['id'],
                'region_id' => $locations[0]['region_id'],
                'parent_id' => $locations[0]['parent_id'],
                'sort_id' => $locations[0]['sort_id'],
                'slug' => $locations[0]['slug'],
                'name' => $locations[0]['name'],
                'notes' => $locations[0]['notes'],
            ],
            [
                'id' => $locations[1]['id'],
                'region_id' => $locations[1]['region_id'],
                'parent_id' => $locations[1]['parent_id'],
                'sort_id' => $locations[1]['sort_id'],
                'slug' => $locations[1]['slug'],
                'name' => $locations[1]['name'],
                'notes' => $locations[1]['notes'],
            ],
            [
                'id' => $locations[2]['id'],
                'region_id' => $locations[2]['region_id'],
                'parent_id' => $locations[2]['parent_id'],
                'sort_id' => $locations[2]['sort_id'],
                'slug' => $locations[2]['slug'],
                'name' => $locations[2]['name'],
                'notes' => $locations[2]['notes'],
            ],
        ], $transformedRecords);
    }

    /** @test */
    public function it_will_transform_the_region_record_if_it_is_present(): void
    {
        $region = Location::factory()->make([
            'id' => 'some-random-region-uuid',
            'region_id' => null,
            'parent_id' => null,
            'sort_id' => 1,
            'slug' => 'balamb-region',
            'name' => 'Balamb (Region)',
            'notes' => null,
        ])->toArray();

        $location = Location::factory()->make([
            'id' => 'some-random-uuid',
            'region_id' => 'some-random-region-uuid',
            'parent_id' => 'some-random-region-uuid', // Region is also the parent here.
            'sort_id' => 1,
            'slug' => 'balamb-alcauld-plains',
            'name' => 'Balamb - Alcauld Plains',
            'notes' => null,
        ])->toArray();

        // Manually append the Region to the record since we're not using the database.
        $location['region'] = $region;

        $transformer = new LocationTransformer();

        $transformedRegion = $transformer->transformRecord($region);
        $transformedLocation = $transformer->transformRecord($location);

        $this->assertEquals($transformedRegion, $transformedLocation['region']);
    }

    /** @test */
    public function it_will_transform_the_parent_record_if_it_is_present(): void
    {
        $parent = Location::factory()->make([
            'id' => 'some-random-region-uuid',
            'region_id' => null,
            'parent_id' => null,
            'sort_id' => 1,
            'slug' => 'balamb-region',
            'name' => 'Balamb (Region)',
            'notes' => null,
        ])->toArray();

        $location = Location::factory()->make([
            'id' => 'some-random-uuid',
            'region_id' => 'some-random-region-uuid',
            'parent_id' => 'some-random-region-uuid', // Region is also the parent here.
            'sort_id' => 1,
            'slug' => 'balamb-alcauld-plains',
            'name' => 'Balamb - Alcauld Plains',
            'notes' => null,
        ])->toArray();

        // Manually append the Parent to the record since we're not using the database.
        $location['parent'] = $parent;

        $transformer = new LocationTransformer();

        $transformedParent = $transformer->transformRecord($parent);
        $transformedLocation = $transformer->transformRecord($location);

        $this->assertEquals($transformedParent, $transformedLocation['parent']);
    }

    /** @test */
    public function it_will_transform_the_child_records_if_they_are_present(): void
    {
        $region = Location::factory()->make([
            'id' => 'some-random-region-uuid',
            'region_id' => null,
            'parent_id' => null,
            'sort_id' => 1,
            'slug' => 'balamb-region',
            'name' => 'Balamb (Region)',
            'notes' => null,
        ])->toArray();

        $location = Location::factory()->make([
            'id' => 'some-random-uuid',
            'region_id' => 'some-random-region-uuid',
            'parent_id' => 'some-random-region-uuid', // Region is also the parent here.
            'sort_id' => 1,
            'slug' => 'balamb-alcauld-plains',
            'name' => 'Balamb - Alcauld Plains',
            'notes' => null,
        ])->toArray();

        // Manually append the child Location to the record since we're not using the database.
        $region['locations'] = [$location];

        $transformer = new LocationTransformer();

        $transformedRegion = $transformer->transformRecord($region);
        $transformedLocation = $transformer->transformRecord($location);

        $this->assertEquals([$transformedLocation], $transformedRegion['locations']);
    }
}
