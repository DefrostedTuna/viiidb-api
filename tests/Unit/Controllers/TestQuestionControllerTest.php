<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\TestQuestionController;
use App\Models\SeedTest;
use App\Models\TestQuestion;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class TestQuestionControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_return_a_list_of_test_questions()
    {
        $testQuestions = TestQuestion::factory()->count(10)->create();

        $testQuestionController = new TestQuestionController(new TestQuestion());

        $response = $testQuestionController->index(new Request());

        // Controller should return a collection of TestQuestions.
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(10, $response);
    }

    /** @test */
    public function it_returns_an_individual_test_question()
    {
        $testQuestion = TestQuestion::factory()->create();

        $testQuestionController = new TestQuestionController(new TestQuestion());

        $response = $testQuestionController->show(new Request(), $testQuestion->id);

        // The controller should return the instance of a TestQuestion that was found via
        // route model binding. Since we are mocking this result by injecting the
        // TestQuestion into the method, we should get the same TestQuestion back.
        $this->assertInstanceOf(TestQuestion::class, $response);
        $this->assertEquals($testQuestion->toArray(), $response->toArray());
    }

    /** @test */
    public function it_can_load_relations_on_individual_records()
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

        $testQuestionController = new TestQuestionController(new TestQuestion());

        $response = $testQuestionController->show(new Request([
            'with' => 'test',
        ]), $testQuestion->id);

        $this->assertTrue(array_key_exists(
            'test',
            $response->toArray()
        ));
        $this->assertEquals(
            $seedTest->toArray(),
            $response->test->toArray()
        );
    }

    /** @test */
    public function it_can_load_relation_properties_on_individual_records()
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

        $testQuestionController = new TestQuestionController(new TestQuestion());

        $response = $testQuestionController->show(new Request([
            'with' => 'test.level',
        ]), $testQuestion->id);

        $this->assertTrue(array_key_exists(
            'test',
            $response->toArray()
        ));
        // Because there is only one parameter here, it will be the same as the array.
        $this->assertEquals(
            $seedTest->toArray(),
            $response->test->toArray()
        );
    }

    /** @test */
    public function it_throws_an_exception_when_an_individual_record_is_not_found()
    {
        $this->expectException(ModelNotFoundException::class);

        $testQuestion = TestQuestion::factory()->create();

        $testQuestionController = new TestQuestionController(new TestQuestion());

        $response = $testQuestionController->show(new Request(), 'invalid');
    }

    /** @test */
    public function the_filters_are_case_insensitive()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What is the airspeed velocity of an Unladen Swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $request = new Request([ 'question' => 'like:YoUr' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('question_number', 1));
        $this->assertTrue($response->contains('question_number', 3));
    }

    /** @test */
    public function the_question_number_column_can_be_filtered_by_the_equals_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $request = new Request([ 'question_number' => '1' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('question_number', 1));
    }

    /** @test */
    public function the_question_number_column_can_be_filtered_by_the_lt_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $request = new Request([ 'question_number' => 'lt:2' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('question_number', 1));
    }

    /** @test */
    public function the_question_number_column_can_be_filtered_by_the_lte_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $request = new Request([ 'question_number' => 'lte:2' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('question_number', 1));
        $this->assertTrue($response->contains('question_number', 2));
    }

    /** @test */
    public function the_question_number_column_can_be_filtered_by_the_gt_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $request = new Request([ 'question_number' => 'gt:2' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('question_number', 3));
    }

    /** @test */
    public function the_question_number_column_can_be_filtered_by_the_gte_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $request = new Request([ 'question_number' => 'gte:2' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('question_number', 2));
        $this->assertTrue($response->contains('question_number', 3));
    }

    /** @test */
    public function the_question_number_column_can_be_filtered_by_the_like_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $request = new Request([ 'question_number' => 'like:2' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('question_number', 2));
    }

    /** @test */
    public function the_question_number_column_can_be_filtered_by_the_not_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $request = new Request([ 'question_number' => 'not:2' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('question_number', 1));
        $this->assertTrue($response->contains('question_number', 3));
    }

    /** @test */
    public function the_question_column_can_be_filtered_by_the_equals_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $request = new Request([ 'question' => 'What is your favorite color?' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('question_number', 1));
    }

    /** @test */
    public function the_question_column_can_be_filtered_by_the_like_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $request = new Request([ 'question' => 'like:your' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('question_number', 1));
        $this->assertTrue($response->contains('question_number', 3));
    }

    /** @test */
    public function the_question_column_can_be_filtered_by_the_not_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $request = new Request([ 'question' => 'not:What is your quest?' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('question_number', 1));
        $this->assertTrue($response->contains('question_number', 2));
    }

    /** @test */
    public function the_answer_column_can_be_filtered_by_the_equals_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $request = new Request([ 'answer' => 'yes' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('question_number', 1));
        $this->assertTrue($response->contains('question_number', 3));
    }

    /** @test */
    public function the_answer_column_can_be_filtered_by_the_like_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $request = new Request([ 'answer' => 'like:ye' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('question_number', 1));
        $this->assertTrue($response->contains('question_number', 3));
    }

    /** @test */
    public function the_answer_column_can_be_filtered_by_the_not_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $request = new Request([ 'answer' => 'not:yes' ]);
        $testQuestionController = new TestQuestionController(new TestQuestion());
        $response = $testQuestionController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('question_number', 2));
    }

    /** @test */
    public function it_can_load_the_test_without_additional_filters()
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

        $testQuestionController = new TestQuestionController(new TestQuestion());

        $response = $testQuestionController->index(new Request([
            'with' => 'test',
        ]), $testQuestion->id);

        $this->assertTrue(array_key_exists(
            'test',
            $response->first()->toArray()
        ));
        $this->assertEquals(
            $seedTest->toArray(),
            $response->first()->test->toArray()
        );
    }

    /** @test */
    public function it_can_load_the_level_column_on_the_test_relation()
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

        $testQuestionController = new TestQuestionController(new TestQuestion());

        $response = $testQuestionController->index(new Request([
            'with' => 'test',
        ]), $testQuestion->id);

        $this->assertTrue(array_key_exists(
            'test',
            $response->first()->toArray()
        ));
        // Because there is only one parameter here, it will be the same as the array.
        $this->assertEquals(
            $seedTest->toArray(),
            $response->first()->test->toArray()
        );
    }
}
