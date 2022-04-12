<?php

namespace Tests\Feature\Endpoints\V0;

use App\Models\Element;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ElementEndpointTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_elements(): void
    {
        Element::factory()->count(8)->create();

        $response = $this->get('/v0/elements');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status_code',
            'data',
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
        ]);
        $response->assertJsonCount(8, 'data');
    }

    /** @test */
    public function it_will_return_an_individual_element_using_the_id_key(): void
    {
        $element = Element::factory()->create()->toArray();

        $response = $this->get("/v0/elements/{$element['id']}");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $element['id'],
                'sort_id' => $element['sort_id'],
                'name' => $element['name'],
            ],
        ]);
    }

    /** @test */
    public function it_will_return_an_individual_element_using_the_name_key(): void
    {
        $element = Element::factory()->create()->toArray();

        $response = $this->get("/v0/elements/{$element['name']}");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $element['id'],
                'sort_id' => $element['sort_id'],
                'name' => $element['name'],
            ],
        ]);
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found(): void
    {
        $response = $this->get('/v0/elements/invalid');

        $response->assertStatus(404);
        $response->assertExactJson([
            'success' => false,
            'message' => 'The requested record could not be found.',
            'status_code' => 404,
            'errors' => [
                'message' => 'The requested record could not be found.',
            ],
        ]);
    }
}
