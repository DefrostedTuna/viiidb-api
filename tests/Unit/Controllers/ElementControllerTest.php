<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\ElementController;
use App\Models\Element;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ElementControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_elements()
    {
        $elements = Element::factory()->count(10)->create();

        $elementController = new ElementController(new Element());

        $response = $elementController->index(new Request());

        // Controller should return a collection of Elements.
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(10, $response);
    }

    /** @test */
    public function it_will_return_an_individual_element()
    {
        $element = Element::factory()->create();

        $elementController = new ElementController(new Element());

        $response = $elementController->show(new Request(), $element->name);

        // The controller should return the instance of an Element that was found via
        // route model binding. Since we are mocking this result by injecting the
        // Element into the method, we should get the same Element back.
        $this->assertInstanceOf(Element::class, $response);
        $this->assertEquals($element->toArray(), $response->toArray());
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found()
    {
        $this->expectException(ModelNotFoundException::class);

        $elementController = new ElementController(new Element());

        $elementController->show(new Request(), 'not-found');
    }

    /** @test */
    public function it_can_filter_elements_by_the_name_column()
    {
        $element = new Element();
        Element::factory()->create([ 'name' => 'fire' ]);
        Element::factory()->create([ 'name' => 'water' ]);
        Element::factory()->create([ 'name' => 'thunder' ]);

        // Equals
        $request = new Request([ 'name' => 'thunder' ]);
        $elementController = new ElementController(new Element());
        $response = $elementController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('name', 'thunder'));

        // Like
        $request = new Request([ 'name' => 'like:er' ]);
        $elementController = new ElementController(new Element());
        $response = $elementController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('name', 'water'));
        $this->assertTrue($response->contains('name', 'thunder'));

        // Not
        $request = new Request([ 'name' => 'not:water' ]);
        $elementController = new ElementController(new Element());
        $response = $elementController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('name', 'fire'));
        $this->assertTrue($response->contains('name', 'thunder'));
    }
}
