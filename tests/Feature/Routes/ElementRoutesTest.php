<?php

namespace Tests\Feature\Routes;

use App\Models\Element;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ElementRoutesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_elements()
    {
        Element::factory()->count(10)->create();

        $response = $this->get('/api/elements');

        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }

    /** @test */
    public function it_will_return_an_individual_element()
    {
        $element = Element::factory()->create();

        $response = $this->get("/api/elements/{$element->name}");

        $response->assertStatus(200);
        $response->assertJson($element->toArray());
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found()
    {
        $response = $this->get('/api/elements/invalid');

        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_filter_elements_by_the_name_column()
    {
        Element::factory()->create([ 'name' => 'fire' ]);
        Element::factory()->create([ 'name' => 'water' ]);
        Element::factory()->create([ 'name' => 'thunder' ]);

        // Equals
        $response = $this->get('/api/elements?name=thunder');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'name' =>  'thunder' ]);

        // Like
        $response = $this->get('/api/elements?name=like:er');
        
        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'name' =>  'water' ]);
        $response->assertJsonFragment([ 'name' =>  'thunder' ]);

        // Not
        $response = $this->get('/api/elements?name=not:water');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'name' => 'fire' ]);
        $response->assertJsonFragment([ 'name' => 'thunder' ]);
    }
}
