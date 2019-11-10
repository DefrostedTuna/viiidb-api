<?php

namespace Tests\Unit\Controllers;


use App\Http\Controllers\StatusEffectController;
use App\Models\StatusEffect;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class StatusEffectControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_return_a_list_of_status_effects()
    {
        $statusEffects = factory(StatusEffect::class, 10)->create();

        $statusEffectController = new StatusEffectController(new StatusEffect());

        $response = $statusEffectController->index(new Request());

        // Controller should return a collection of StatusEffects.
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(10, $response);
    }

    /** @test */
    public function it_returns_an_individual_status_effect()
    {
        $statusEffect = factory(StatusEffect::class)->create();

        $statusEffectController = new StatusEffectController(new StatusEffect());

        $response = $statusEffectController->show(new Request(), $statusEffect->id);

        // The controller should return the instance of a StatusEffect that was found via 
        // route model binding. Since we are mocking this result by injecting the
        // StatusEffect into the method, we should get the same StatusEffect back.
        $this->assertInstanceOf(StatusEffect::class, $response);
        $this->assertEquals($statusEffect->toArray(), $response->toArray());
    }

    /** @test */
    public function it_throws_an_exception_when_an_individual_record_is_not_found()
    {
        $this->expectException(ModelNotFoundException::class);

        $statusEffect = factory(StatusEffect::class)->create();

        $statusEffectController = new StatusEffectController(new StatusEffect());

        $response = $statusEffectController->show(new Request(), 'invalid');
    }

    /** @test */
    public function multiple_colons_will_be_ignored_when_filtering_results()
    {
        // Set the filterable operators on the StatusEffect class.
        $statusEffect = new StatusEffect();
        $statusEffect->filterableOperators = [ 'like' => 'like' ];

        factory(StatusEffect::class)->create([ 'name' => 'Death', 'type' => 'harmful' ]);
        factory(StatusEffect::class)->create([ 'name' => 'Double', 'type' => 'beneficial' ]);
        factory(StatusEffect::class)->create([ 'name' => 'Triple', 'type' => 'beneficial' ]);

        $request = new Request([ 'name' => 'like:le:w' ]);
        $statusEffectController = new StatusEffectController($statusEffect);
        $response = $statusEffectController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('name', 'Double'));
        $this->assertTrue($response->contains('name', 'Triple'));
    }

    /** @test */
    public function the_filters_are_case_insensitive()
    {
        factory(StatusEffect::class)->create([ 'name' => 'Death', 'type' => 'harmful' ]);
        factory(StatusEffect::class)->create([ 'name' => 'Double', 'type' => 'beneficial' ]);
        factory(StatusEffect::class)->create([ 'name' => 'Triple', 'type' => 'beneficial' ]);

        $request = new Request([ 'name' => 'death' ]);
        $statusEffectController = new StatusEffectController(new StatusEffect());
        $response = $statusEffectController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('name', 'Death'));
    }

    /** @test */
    public function the_name_column_can_be_filtered_by_the_equals_operator()
    {
        factory(StatusEffect::class)->create([ 'name' => 'Death', 'type' => 'harmful' ]);
        factory(StatusEffect::class)->create([ 'name' => 'Double', 'type' => 'beneficial' ]);
        factory(StatusEffect::class)->create([ 'name' => 'Triple', 'type' => 'beneficial' ]);

        $request = new Request([ 'name' => 'Triple' ]);
        $statusEffectController = new StatusEffectController(new StatusEffect());
        $response = $statusEffectController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('name', 'Triple'));
    }

    /** @test */
    public function the_name_column_can_be_filtered_by_the_like_operator()
    {
        factory(StatusEffect::class)->create([ 'name' => 'Death', 'type' => 'harmful' ]);
        factory(StatusEffect::class)->create([ 'name' => 'Double', 'type' => 'beneficial' ]);
        factory(StatusEffect::class)->create([ 'name' => 'Triple', 'type' => 'beneficial' ]);

        $request = new Request([ 'name' => 'like:le' ]);
        $statusEffectController = new StatusEffectController(new StatusEffect());
        $response = $statusEffectController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('name', 'Double'));
        $this->assertTrue($response->contains('name', 'Triple'));
    }

    /** @test */
    public function the_name_column_can_be_filtered_by_the_not_operator()
    {
        factory(StatusEffect::class)->create([ 'name' => 'Death', 'type' => 'harmful' ]);
        factory(StatusEffect::class)->create([ 'name' => 'Double', 'type' => 'beneficial' ]);
        factory(StatusEffect::class)->create([ 'name' => 'Triple', 'type' => 'beneficial' ]);

        $request = new Request([ 'name' => 'not:Triple' ]);
        $statusEffectController = new StatusEffectController(new StatusEffect());
        $response = $statusEffectController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('name', 'Death'));
        $this->assertTrue($response->contains('name', 'Double'));
    }

    /** @test */
    public function the_type_column_can_be_filtered_by_the_equals_operator()
    {
        factory(StatusEffect::class)->create([ 'name' => 'Death', 'type' => 'harmful' ]);
        factory(StatusEffect::class)->create([ 'name' => 'Double', 'type' => 'beneficial' ]);
        factory(StatusEffect::class)->create([ 'name' => 'Triple', 'type' => 'beneficial' ]);

        $request = new Request([ 'type' => 'harmful' ]);
        $statusEffectController = new StatusEffectController(new StatusEffect());
        $response = $statusEffectController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('type', 'harmful'));
    }

    /** @test */
    public function the_type_column_can_be_filtered_by_the_like_operator()
    {
        factory(StatusEffect::class)->create([ 'name' => 'Death', 'type' => 'harmful' ]);
        factory(StatusEffect::class)->create([ 'name' => 'Double', 'type' => 'beneficial' ]);
        factory(StatusEffect::class)->create([ 'name' => 'Triple', 'type' => 'beneficial' ]);

        $request = new Request([ 'type' => 'like:cial' ]);
        $statusEffectController = new StatusEffectController(new StatusEffect());
        $response = $statusEffectController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('type', 'beneficial'));
        $this->assertTrue($response->contains('name', 'Double'));
        $this->assertTrue($response->contains('name', 'Triple'));
    }

    /** @test */
    public function the_type_column_can_be_filtered_by_the_not_operator()
    {
        factory(StatusEffect::class)->create([ 'name' => 'Death', 'type' => 'harmful' ]);
        factory(StatusEffect::class)->create([ 'name' => 'Double', 'type' => 'beneficial' ]);
        factory(StatusEffect::class)->create([ 'name' => 'Triple', 'type' => 'beneficial' ]);

        $request = new Request([ 'type' => 'not:beneficial' ]);
        $statusEffectController = new StatusEffectController(new StatusEffect());
        $response = $statusEffectController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('name', 'Death'));
        $this->assertTrue($response->contains('type', 'harmful'));
    }

    /** @test */
    public function the_name_and_type_columns_can_both_be_filtered_together()
    {
        factory(StatusEffect::class)->create([ 'name' => 'Death', 'type' => 'harmful' ]);
        factory(StatusEffect::class)->create([ 'name' => 'Double', 'type' => 'beneficial' ]);
        factory(StatusEffect::class)->create([ 'name' => 'Triple', 'type' => 'beneficial' ]);

        $request = new Request([
            'name' => 'like:Dou',
            'type' => 'like:ficial',
        ]);
        $statusEffectController = new StatusEffectController(new StatusEffect());
        $response = $statusEffectController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('name', 'Double'));
        $this->assertTrue($response->contains('type', 'beneficial'));
    }
}
