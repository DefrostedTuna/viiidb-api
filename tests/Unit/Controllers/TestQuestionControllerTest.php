<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\TestQuestionController;
use App\Models\SeedTest;
use App\Models\TestQuestion;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Tests\TestCase;

class TestQuestionControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_test_questions()
    {
        $test_questions = TestQuestion::factory()->count(10)->create();

        $testQuestionController = new TestQuestionController(new TestQuestion());

        $response = $testQuestionController->index(new Request());

        // Controller should return a collection of TestQuestions.
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(10, $response);
    }

    /** @test */
    public function it_will_return_an_individual_test_question()
    {
        $testQuestion = TestQuestion::factory()->create();

        $testQuestionController = new TestQuestionController(new TestQuestion());

        $response = $testQuestionController->show(new Request(), $testQuestion->id);

        // The controller should return the instance of an TestQuestion that was found via
        // route model binding. Since we are mocking this result by injecting the
        // TestQuestion into the method, we should get the same TestQuestion back.
        $this->assertInstanceOf(TestQuestion::class, $response);
        $this->assertEquals($testQuestion->toArray(), $response->toArray());
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found()
    {
        $this->expectException(ModelNotFoundException::class);

        $testQuestionController = new TestQuestionController(new TestQuestion());

        $testQuestionController->show(new Request(), 'not-found');
    }

    /** @test */
    public function it_can_filter_test_questions_by_the_question_number_column()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        // Equals
        $request = new Request([ 'question_number' => '1' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('question_number', 1));

        // Less Than
        $request = new Request([ 'question_number' => 'lt:2' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('question_number', 1));

        // Less Than or Equal To
        $request = new Request([ 'question_number' => 'lte:2' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('question_number', 1));
        $this->assertTrue($response->contains('question_number', 2));

        // Greater Than
        $request = new Request([ 'question_number' => 'gt:2' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('question_number', 3));

        // Greater Than or Equal To
        $request = new Request([ 'question_number' => 'gte:2' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('question_number', 2));
        $this->assertTrue($response->contains('question_number', 3));

        // Like
        $request = new Request([ 'question_number' => 'like:2' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('question_number', 2));

        // Not
        $request = new Request([ 'question_number' => 'not:2' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('question_number', 1));
        $this->assertTrue($response->contains('question_number', 3));
    }

    /** @test */
    public function it_can_filter_test_questions_by_the_question_column()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        // Equals
        $request = new Request([ 'question' => 'What is your favorite color?' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('question_number', 1));

        // Like
        $request = new Request([ 'question' => 'like:your' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('question_number', 1));
        $this->assertTrue($response->contains('question_number', 3));

        // Not
        $request = new Request([ 'question' => 'not:What is your quest?' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('question_number', 1));
        $this->assertTrue($response->contains('question_number', 2));
    }

    /** @test */
    public function it_can_filter_test_questions_by_the_answer_column()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        // Equals
        $request = new Request([ 'answer' => 'yes' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('question_number', 1));
        $this->assertTrue($response->contains('question_number', 3));

        // Like
        $request = new Request([ 'answer' => 'like:ye' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('question_number', 1));
        $this->assertTrue($response->contains('question_number', 3));

        // Not
        $request = new Request([ 'answer' => 'not:yes' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('question_number', 2));
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

        $request = new Request([
            'with' => 'test',
        ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);
        $this->assertCount(1, $response);

        // Test.
        $this->assertTrue(array_key_exists('test', $response->first()->toArray()));
        $this->assertEquals(
            $seedTest->toArray(),
            $response->first()->test->toArray()
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

        $request = new Request([
            'with' => 'test',
        ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->show($request, $testQuestion->id);

        // Test.
        $this->assertTrue(array_key_exists('test', $response->toArray()));
        $this->assertEquals(
            $seedTest->toArray(),
            $response->test->toArray()
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

        $request = new Request([
            'with' => 'test.level',
        ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);
        $this->assertCount(1, $response);

        // Test.
        $this->assertTrue(array_key_exists('test', $response->first()->toArray()));
        $this->assertEquals([
            'id' => $seedTest->id,
            'level' => $seedTest->level,
        ], $response->first()->test->toArray());
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

        $request = new Request([
            'with' => 'test.level',
        ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->show($request, $testQuestion->id);

        // Test.
        $this->assertTrue(array_key_exists('test', $response->toArray()));
        $this->assertEquals([
            'id' => $seedTest->id,
            'level' => $seedTest->level,
        ], $response->test->toArray());
    }
}
