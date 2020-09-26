<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\SeedTestController;
use App\Models\SeedTest;
use App\Models\TestQuestion;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Tests\TestCase;

class SeedTestControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_seed_tests()
    {
        $seedTests = SeedTest::factory()->count(10)->create();

        $seedTestController = new SeedTestController(new SeedTest());

        $response = $seedTestController->index(new Request());

        // Controller should return a collection of SeedTests.
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(10, $response);
    }

    /** @test */
    public function it_will_return_an_individual_seed_test()
    {
        $seedTest = SeedTest::factory()->create();

        $seedTestController = new SeedTestController(new SeedTest());

        $response = $seedTestController->show(new Request(), $seedTest->level);

        // The controller should return the instance of an SeedTest that was found via
        // route model binding. Since we are mocking this result by injecting the
        // SeedTest into the method, we should get the same SeedTest back.
        $this->assertInstanceOf(SeedTest::class, $response);
        $this->assertEquals($seedTest->toArray(), $response->toArray());
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found()
    {
        $this->expectException(ModelNotFoundException::class);

        $seedTestController = new SeedTestController(new SeedTest());

        $seedTestController->show(new Request(), 'not-found');
    }

    /** @test */
    public function it_can_filter_seed_tests_by_the_level_column()
    {
        SeedTest::factory()->create([ 'level' => 1 ]);
        SeedTest::factory()->create([ 'level' => 3 ]);
        SeedTest::factory()->create([ 'level' => 10 ]);

        // Equals
        $request = new Request([ 'level' => 1 ]);
        $seedTestController = new SeedTestController(new SeedTest());
        $response = $seedTestController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('level', 1));

        // Less Than
        $request = new Request([ 'level' => 'lt:3' ]);
        $seedTestController = new SeedTestController(new SeedTest());
        $response = $seedTestController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('level', 1));

        // Less Than or Equal To
        $request = new Request([ 'level' => 'lte:3' ]);
        $seedTestController = new SeedTestController(new SeedTest());
        $response = $seedTestController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('level', 1));
        $this->assertTrue($response->contains('level', 3));

        // Greater Than
        $request = new Request([ 'level' => 'gt:3' ]);
        $seedTestController = new SeedTestController(new SeedTest());
        $response = $seedTestController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('level', 10));

        // Greater Than or Equal To
        $request = new Request([ 'level' => 'gte:3' ]);
        $seedTestController = new SeedTestController(new SeedTest());
        $response = $seedTestController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('level', 3));
        $this->assertTrue($response->contains('level', 10));

        // Like
        $request = new Request([ 'level' => 'like:1' ]);
        $seedTestController = new SeedTestController(new SeedTest());
        $response = $seedTestController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('level', 1));
        $this->assertTrue($response->contains('level', 10));

        // Not
        $request = new Request([ 'level' => 'not:3' ]);
        $seedTestController = new SeedTestController(new SeedTest());
        $response = $seedTestController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('level', 1));
        $this->assertTrue($response->contains('level', 10));
    }

    /** @test */
    public function it_can_load_relations_on_a_list_of_resources()
    {
        $seedTest = SeedTest::factory()->create([
            'level' => 1,
        ]);
        $testQuestion = TestQuestion::factory()->create([
            'seed_test_id' => $seedTest->id,
            'question_number' => 1,
            'question' => 'Will this work?',
            'answer' => 'yes',
        ]);

        $request = new Request([ 'with' => 'questions' ]);
        $seedTestController = new SeedTestController(new SeedTest());
        $response = $seedTestController->index($request);
        $this->assertCount(1, $response);

        // Questions.
        $this->assertTrue(array_key_exists('questions', $response->first()->toArray()));
        $this->assertEquals(
            $testQuestion->toArray(),
            $response->first()->questions->first()->toArray()
        );
    }

    /** @test */
    public function it_can_load_relations_on_an_individual_resource()
    {
        $seedTest = SeedTest::factory()->create([
            'level' => 1,
        ]);
        $testQuestion = TestQuestion::factory()->create([
            'seed_test_id' => $seedTest->id,
            'question_number' => 1,
            'question' => 'Will this work?',
            'answer' => 'yes',
        ]);

        $request = new Request([ 'with' => 'questions' ]);
        $seedTestController = new SeedTestController(new SeedTest());
        $response = $seedTestController->show($request, $seedTest->level);

        // Questions.
        $this->assertTrue(array_key_exists('questions', $response->toArray()));
        $this->assertEquals(
            $testQuestion->toArray(),
            $response->questions->first()->toArray()
        );
    }

    /** @test */
    public function it_can_load_relation_properties_on_a_list_of_resources()
    {
        $seedTest = SeedTest::factory()->create([
            'level' => 1,
        ]);
        $testQuestion = TestQuestion::factory()->create([
            'seed_test_id' => $seedTest->id,
            'question_number' => 1,
            'question' => 'Will this work?',
            'answer' => 'yes',
        ]);

        $request = new Request([ 'with' => 'questions.question_number,questions.question,questions.answer' ]);
        $seedTestController = new SeedTestController(new SeedTest());
        $response = $seedTestController->index($request);
        $this->assertCount(1, $response);

        // Questions.
        $this->assertTrue(array_key_exists('questions', $response->first()->toArray()));
        $this->assertEquals([
            'id' => $testQuestion->id,
            'seed_test_id' => $testQuestion->seed_test_id,
            'question_number' => $testQuestion->question_number,
            'question' => $testQuestion->question,
            'answer' => $testQuestion->answer,
        ], $response->first()->questions->first()->toArray());
    }

    /** @test */
    public function it_can_load_relation_properties_on_an_individual_resource()
    {
        $seedTest = SeedTest::factory()->create([
            'level' => 1,
        ]);
        $testQuestion = TestQuestion::factory()->create([
            'seed_test_id' => $seedTest->id,
            'question_number' => 1,
            'question' => 'Will this work?',
            'answer' => 'yes',
        ]);

        $request = new Request([ 'with' => 'questions.question_number,questions.question,questions.answer' ]);
        $seedTestController = new SeedTestController(new SeedTest());
        $response = $seedTestController->show($request, $seedTest->level);

        // Questions.
        $this->assertTrue(array_key_exists('questions', $response->toArray()));
        $this->assertEquals([
            'id' => $testQuestion->id,
            'seed_test_id' => $testQuestion->seed_test_id,
            'question_number' => $testQuestion->question_number,
            'question' => $testQuestion->question,
            'answer' => $testQuestion->answer,
        ], $response->questions->first()->toArray());
    }
}
