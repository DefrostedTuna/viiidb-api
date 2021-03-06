<?php

namespace Tests\Unit\Models;

use App\Models\Stat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_the_proper_database_table()
    {
        $stat = new Stat();
    
        $this->assertEquals('stats', $stat->getTable());
    }
    
    /** @test */
    public function it_sets_the_primary_key_type_to_string()
    {
        $stat = new Stat();
    
        $this->assertEquals('string', $stat->getKeyType());
    }

    /** @test */
    public function it_explicitly_defines_the_route_key_name()
    {
        $stat = new Stat();

        $this->assertEquals('name', $stat->getRouteKeyName());
    }
    
    /** @test */
    public function it_does_not_allow_properties_to_be_assigned_in_mass()
    {
        $stat = new Stat();
    
        $this->assertEquals([], $stat->getFillable());
    }
    
    /** @test */
    public function it_explicitly_defines_the_visible_fields_for_api_consumption()
    {
        $stat = new Stat();
    
        $visibleFields = [
            'id',
            'name',
            'abbreviation',
        ];
    
        $this->assertEquals($visibleFields, $stat->getVisible());
    }
    
    /** @test */
    public function it_explicitly_defines_the_hidden_fields_for_api_consumption()
    {
        $stat = new Stat();
    
        $hiddenFields = [
            'created_at',
            'updated_at',
            'deleted_at',
        ];
    
        $this->assertEquals($hiddenFields, $stat->getHidden());
    }
    
    /** @test */
    public function it_explicitly_defines_the_cast_type_for_each_field()
    {
        $stat = new Stat();
        $fields = $stat->getCasts();

        $expected = [
            'id'            => 'string',
            'name'          => 'string',
            'abbreviation'  => 'string',
        ];
    
        $this->assertEquals($expected, $fields);
    }
}
