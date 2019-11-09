<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\ElementController;
use App\Models\Element;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class ElementControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_return_a_list_of_elements()
    {
        $elements = factory(Element::class, 10)->create();

        $elementController = new ElementController(new Element());

        $response = $elementController->index(new Request());

        // Controller should return a collection of Elements.
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(10, $response);
    }

    /** @test */
    public function it_returns_an_individual_element()
    {
        $element = factory(Element::class)->create();

        $elementController = new ElementController(new Element());

        $response = $elementController->show(new Request(), $element);

        // The controller should return the instance of a Element that was found via 
        // route model binding. Since we are mocking this result by injecting the
        // Element into the method, we should get the same Element back.
        $this->assertInstanceOf(Element::class, $response);
        $this->assertEquals($element, $response);
    }

    /** @test */
    public function multiple_colons_will_be_ignored_when_filtering_results()
    {
        // Set the filterable operators on the Element class.
        $element = new Element();
        $element->filterableOperators = [ 'like' => 'like' ];

        factory(Element::class)->create([ 'name' => 'fire' ]);
        factory(Element::class)->create([ 'name' => 'water' ]);
        factory(Element::class)->create([ 'name' => 'thunder' ]);

        $request = new Request([ 'name' => 'like:er:w' ]);
        $elementController = new ElementController($element);
        $response = $elementController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('name', 'water'));
        $this->assertTrue($response->contains('name', 'thunder'));
    }

    /** @test */
    public function the_filters_are_case_insensitive()
    {
        factory(Element::class)->create([ 'name' => 'fire' ]);
        factory(Element::class)->create([ 'name' => 'water' ]);
        factory(Element::class)->create([ 'name' => 'thunder' ]);

        $request = new Request([ 'name' => 'FiRe' ]);
        $elementController = new ElementController(new Element());
        $response = $elementController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('name', 'fire'));
    }

    /** @test */
    public function the_name_column_can_be_filtered_by_the_equals_operator()
    {
        factory(Element::class)->create([ 'name' => 'fire' ]);
        factory(Element::class)->create([ 'name' => 'water' ]);
        factory(Element::class)->create([ 'name' => 'thunder' ]);

        $request = new Request([ 'name' => 'thunder' ]);
        $elementController = new ElementController(new Element());
        $response = $elementController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('name', 'thunder'));
    }

    /** @test */
    public function the_name_column_can_be_filtered_by_the_like_operator()
    {
        factory(Element::class)->create([ 'name' => 'fire' ]);
        factory(Element::class)->create([ 'name' => 'water' ]);
        factory(Element::class)->create([ 'name' => 'thunder' ]);

        $request = new Request([ 'name' => 'like:er' ]);
        $elementController = new ElementController(new Element());
        $response = $elementController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('name', 'water'));
        $this->assertTrue($response->contains('name', 'thunder'));
    }

    /** @test */
    public function the_name_column_can_be_filtered_by_the_not_operator()
    {
        factory(Element::class)->create([ 'name' => 'fire' ]);
        factory(Element::class)->create([ 'name' => 'water' ]);
        factory(Element::class)->create([ 'name' => 'thunder' ]);

        $request = new Request([ 'name' => 'not:water' ]);
        $elementController = new ElementController(new Element());
        $response = $elementController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('name', 'fire'));
        $this->assertTrue($response->contains('name', 'thunder'));
    }
}
