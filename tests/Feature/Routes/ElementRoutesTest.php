<?php

namespace Tests\Feature\Routes;

use App\Models\Element;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ElementRoutesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_a_list_of_elements()
    {
        $elements = factory(Element::class, 10)->create();

        $response = $this->get('/api/elements');

        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }

    /** @test */
    public function it_returns_an_individual_element()
    {
        $element = factory(Element::class)->create();

        $response = $this->get("/api/elements/{$element->id}");

        $response->assertStatus(200);
        $response->assertJson($element->toArray());
    }

    /** @test */
    public function multiple_colons_will_be_ignored_when_filtering_results()
    {
        factory(Element::class)->create([ 'name' => 'fire' ]);
        factory(Element::class)->create([ 'name' => 'water' ]);
        factory(Element::class)->create([ 'name' => 'thunder' ]);

        $response = $this->get('/api/elements?name=like:er:w');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'name' => 'water' ]);
        $response->assertJsonFragment([ 'name' => 'thunder' ]);
    }

    /** @test */
    public function the_name_column_can_be_filtered_by_the_equals_operator()
    {
        factory(Element::class)->create([ 'name' => 'fire' ]);
        factory(Element::class)->create([ 'name' => 'water' ]);
        factory(Element::class)->create([ 'name' => 'thunder' ]);

        $response = $this->get('/api/elements?name=thunder');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'name' => 'thunder' ]);
    }

    /** @test */
    public function the_name_column_can_be_filtered_by_the_like_operator()
    {
        factory(Element::class)->create([ 'name' => 'fire' ]);
        factory(Element::class)->create([ 'name' => 'water' ]);
        factory(Element::class)->create([ 'name' => 'thunder' ]);

        $response = $this->get('/api/elements?name=like:er');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'name' => 'water' ]);
        $response->assertJsonFragment([ 'name' => 'thunder' ]);
    }

    /** @test */
    public function the_name_column_can_be_filtered_by_the_not_operator()
    {
        factory(Element::class)->create([ 'name' => 'fire' ]);
        factory(Element::class)->create([ 'name' => 'water' ]);
        factory(Element::class)->create([ 'name' => 'thunder' ]);

        $response = $this->get('/api/elements?name=not:water');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'name' => 'fire' ]);
        $response->assertJsonFragment([ 'name' => 'thunder' ]);
    }
}
