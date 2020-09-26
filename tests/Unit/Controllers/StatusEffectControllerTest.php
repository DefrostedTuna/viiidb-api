<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\StatusEffectController;
use App\Models\StatusEffect;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Tests\TestCase;

class StatusEffectControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_status_effects()
    {
        $status_effects = StatusEffect::factory()->count(10)->create();

        $statusEffectController = new StatusEffectController(new StatusEffect());

        $response = $statusEffectController->index(new Request());

        // Controller should return a collection of StatusEffects.
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(10, $response);
    }

    /** @test */
    public function it_will_return_an_individual_status_effect()
    {
        $statusEffect = StatusEffect::factory()->create();

        $statusEffectController = new StatusEffectController(new StatusEffect());

        $response = $statusEffectController->show(new Request(), $statusEffect->name);

        // The controller should return the instance of an StatusEffect that was found via
        // route model binding. Since we are mocking this result by injecting the
        // StatusEffect into the method, we should get the same StatusEffect back.
        $this->assertInstanceOf(StatusEffect::class, $response);
        $this->assertEquals($statusEffect->toArray(), $response->toArray());
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found()
    {
        $this->expectException(ModelNotFoundException::class);

        $statusEffectController = new StatusEffectController(new StatusEffect());

        $statusEffectController->show(new Request(), 'not-found');
    }

    /** @test */
    public function it_can_filter_status_effects_by_the_name_column()
    {
        StatusEffect::factory()->create([ 'name' => 'Death', 'type' => 'harmful' ]);
        StatusEffect::factory()->create([ 'name' => 'Double', 'type' => 'beneficial' ]);
        StatusEffect::factory()->create([ 'name' => 'Triple', 'type' => 'beneficial' ]);

        // Equals
        $request = new Request([ 'name' => 'Triple' ]);
        $statusEffectController = new StatusEffectController(new StatusEffect());
        $response = $statusEffectController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('name', 'Triple'));

        // Like
        $request = new Request([ 'name' => 'like:le' ]);
        $statusEffectController = new StatusEffectController(new StatusEffect());
        $response = $statusEffectController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('name', 'Double'));
        $this->assertTrue($response->contains('name', 'Triple'));

        // Not
        $request = new Request([ 'name' => 'not:Triple' ]);
        $statusEffectController = new StatusEffectController(new StatusEffect());
        $response = $statusEffectController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('name', 'Death'));
        $this->assertTrue($response->contains('name', 'Double'));
    }

    /** @test */
    public function it_can_filter_status_effects_by_the_type_column()
    {
        $statusEffect = new StatusEffect();
        StatusEffect::factory()->create([ 'name' => 'Death', 'type' => 'harmful' ]);
        StatusEffect::factory()->create([ 'name' => 'Double', 'type' => 'beneficial' ]);
        StatusEffect::factory()->create([ 'name' => 'Triple', 'type' => 'beneficial' ]);

        // Equals
        $request = new Request([ 'type' => 'harmful' ]);
        $statusEffectController = new StatusEffectController(new StatusEffect());
        $response = $statusEffectController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('type', 'harmful'));
        $this->assertTrue($response->contains('name', 'Death'));

        // Like
        $request = new Request([ 'type' => 'like:cial' ]);
        $statusEffectController = new StatusEffectController(new StatusEffect());
        $response = $statusEffectController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('type', 'beneficial'));
        $this->assertTrue($response->contains('name', 'Double'));
        $this->assertTrue($response->contains('name', 'Triple'));

        // Not
        $request = new Request([ 'type' => 'not:beneficial' ]);
        $statusEffectController = new StatusEffectController(new StatusEffect());
        $response = $statusEffectController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('type', 'harmful'));
        $this->assertTrue($response->contains('name', 'Death'));
    }
}
