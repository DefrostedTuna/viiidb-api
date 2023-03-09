<?php

namespace Tests\Unit\Models;

use App\Models\Stat;
use Tests\TestCase;

class StatTest extends TestCase
{
    /** @test */
    public function it_uses_the_proper_database_table(): void
    {
        $stat = new Stat();

        $this->assertEquals('stats', $stat->getTable());
    }

    /** @test */
    public function it_explicitly_defines_the_column_that_results_should_use_for_ordering(): void
    {
        $stat = new Stat();

        $this->assertEquals('sort_id', $stat->getOrderByField());
    }

    /** @test */
    public function it_explicitly_defines_the_visible_fields_for_api_consumption(): void
    {
        $stat = new Stat();

        $visibleFields = [
            'id',
            'sort_id',
            'name',
            'abbreviation',
        ];

        $this->assertEquals($visibleFields, $stat->getVisible());
    }

    /** @test */
    public function it_explicitly_defines_the_cast_type_for_each_field(): void
    {
        $stat = new Stat();

        $expected = [
            'id'           => 'string',
            'sort_id'      => 'integer',
            'name'         => 'string',
            'abbreviation' => 'string',
        ];

        $this->assertEquals($expected, $stat->getCasts());
    }
}
