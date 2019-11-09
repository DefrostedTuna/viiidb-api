<?php

namespace Tests\Unit\Models;

use App\Models\Element;
use App\Traits\Filterable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ElementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_the_proper_database_table()
    {
        $element = new Element();

        $this->assertEquals('elements', $element->getTable());
    }

    /** @test */
    public function it_does_not_allow_properties_to_be_assigned_in_mass()
    {
        $element = new Element();

        $this->assertEquals([], $element->getFillable());
    }

    /** @test */
    public function it_hides_the_created_at_field_from_the_output()
    {
        $element = new Element();

        $this->assertContains('created_at', $element->getHidden());
    }

    /** @test */
    public function it_hides_the_updated_at_field_from_the_output()
    {
        $element = new Element();

        $this->assertContains('updated_at', $element->getHidden());
    }

    /** @test */
    public function it_hides_the_deleted_at_field_from_the_output()
    {
        $element = new Element();

        $this->assertContains('deleted_at', $element->getHidden());
    }

    /** @test */
    public function it_casts_the_name_column_to_a_string()
    {
        $element = new Element();
        $casts = $element->getCasts();

        $this->assertArrayHasKey('name', $casts);
        $this->assertEquals('string', $casts['name']);
    }

    /** @test */
    public function it_is_able_to_filter_records()
    {
        $this->assertTrue(in_array(
            Filterable::class, 
            class_uses(Element::class)
        ));
    }

    /** @test */
    public function it_allows_specific_fields_to_be_filtered()
    {
        $element = new Element();
        $shouldBeFilterable = [
            'name',
        ];

        $this->assertEquals($shouldBeFilterable, $element->getFilterableFields());
    }
}
