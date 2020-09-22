<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\SeedTestController;
use App\Models\SeedTest;
use App\Models\TestQuestion;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class SeedTestControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_return_a_list_of_seed_tests()
    {
        $seedTests = factory(SeedTest::class, 10)->create();

        $seedTestController = new SeedTestController(new SeedTest());

        $response = $seedTestController->index(new Request());

        // Controller should return a collection of SeedTests.
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(10, $response);
    }

    /** @test */
    public function it_returns_an_individual_seed_test()
    {
        $seedTest = factory(SeedTest::class)->create();

        $seedTestController = new SeedTestController(new SeedTest());

        $response = $seedTestController->show(new Request(), $seedTest->id);

        // The controller should return the instance of a SeedTest that was found via
        // route model binding. Since we are mocking this result by injecting the
        // SeedTest into the method, we should get the same SeedTest back.
        $this->assertInstanceOf(SeedTest::class, $response);
        $this->assertEquals($seedTest->toArray(), $response->toArray());
    }

    /** @test */
    public function it_can_load_relations_on_individual_records()
    {
        $seedTest = factory(SeedTest::class)->create([
            'level' => 1,
        ]);
        $testQuestion = factory(TestQuestion::class)->create([
            'seed_test_id' => $seedTest->id,
            'question_number' => 1,
            'question' => 'Will this work?',
            'answer' => 'yes',
        ]);

        $seedTestController = new SeedTestController(new SeedTest());

        $response = $seedTestController->show(new Request([
            'with' => 'questions',
        ]), $seedTest->id);

        $this->assertTrue(array_key_exists(
            'questions',
            $response->toArray()
        ));
        $this->assertInstanceOf(Collection::class, $response->questions);
        $this->assertEquals(
            $testQuestion->toArray(),
            $response->questions->first()->toArray()
        );
    }

    /** @test */
    public function it_can_load_relation_properties_on_individual_records()
    {
        $seedTest = factory(SeedTest::class)->create([
            'level' => 1,
        ]);
        $testQuestion = factory(TestQuestion::class)->create([
            'seed_test_id' => $seedTest->id,
            'question_number' => 1,
            'question' => 'Will this work?',
            'answer' => 'yes',
        ]);

        $seedTestController = new SeedTestController(new SeedTest());

        $response = $seedTestController->show(new Request([
            'with' => 'questions.question_number',
        ]), $seedTest->id);

        $this->assertTrue(array_key_exists(
            'questions',
            $response->toArray()
        ));
        $this->assertInstanceOf(Collection::class, $response->questions);
        $this->assertEquals(
            [
                'id' => $testQuestion->id,
                'seed_test_id' => $seedTest->id,
                'question_number' => $testQuestion->question_number,
            ],
            $response->questions->first()->toArray()
        );
    }

    /** @test */
    public function it_can_load_multiple_relation_properties_on_individual_records()
    {
        $seedTest = factory(SeedTest::class)->create([
            'level' => 1,
        ]);
        $testQuestion = factory(TestQuestion::class)->create([
            'seed_test_id' => $seedTest->id,
            'question_number' => 1,
            'question' => 'Will this work?',
            'answer' => 'yes',
        ]);

        $seedTestController = new SeedTestController(new SeedTest());

        $response = $seedTestController->show(new Request([
            'with' => 'questions.question_number,questions.question',
        ]), $seedTest->id);

        $this->assertTrue(array_key_exists(
            'questions',
            $response->toArray()
        ));
        $this->assertInstanceOf(Collection::class, $response->questions);
        $this->assertEquals(
            [
                'id' => $testQuestion->id,
                'seed_test_id' => $seedTest->id,
                'question_number' => $testQuestion->question_number,
                'question' => $testQuestion->question,
            ],
            $response->questions->first()->toArray()
        );
    }

    /** @test */
    public function it_throws_an_exception_when_an_individual_record_is_not_found()
    {
        $this->expectException(ModelNotFoundException::class);

        $seedTest = factory(SeedTest::class)->create();

        $seedTestController = new SeedTestController(new SeedTest());

        $response = $seedTestController->show(new Request(), 'invalid');
    }

    /** @test */
    public function the_level_column_can_be_filtered_by_the_equals_operator()
    {
        factory(SeedTest::class)->create([ 'level' => 1 ]);
        factory(SeedTest::class)->create([ 'level' => 3 ]);
        factory(SeedTest::class)->create([ 'level' => 10 ]);
        factory(SeedTest::class)->create([ 'level' => 12 ]);

        $request = new Request([ 'level' => 1 ]);
        $seedTestController = new SeedTestController(new SeedTest());
        $response = $seedTestController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('level', '1'));
    }

    /** @test */
    public function the_level_column_can_be_filtered_by_the_like_operator()
    {
        factory(SeedTest::class)->create([ 'level' => 1 ]);
        factory(SeedTest::class)->create([ 'level' => 3 ]);
        factory(SeedTest::class)->create([ 'level' => 10 ]);
        factory(SeedTest::class)->create([ 'level' => 12 ]);

        $request = new Request([ 'level' => 'like:1' ]);
        $seedTestController = new SeedTestController(new SeedTest());
        $response = $seedTestController->index($request);

        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('level', 1));
        $this->assertTrue($response->contains('level', 10));
        $this->assertTrue($response->contains('level', 12));
    }

    /** @test */
    public function the_level_column_can_be_filtered_by_the_not_operator()
    {
        factory(SeedTest::class)->create([ 'level' => 1 ]);
        factory(SeedTest::class)->create([ 'level' => 3 ]);
        factory(SeedTest::class)->create([ 'level' => 10 ]);
        factory(SeedTest::class)->create([ 'level' => 12 ]);

        $request = new Request([ 'level' => 'not:10' ]);
        $seedTestController = new SeedTestController(new SeedTest());
        $response = $seedTestController->index($request);

        $this->assertCount(3, $response);
        $this->assertTrue($response->contains('level', 1));
        $this->assertTrue($response->contains('level', 3));
        $this->assertTrue($response->contains('level', 12));
    }

    /** @test */
    public function it_can_load_the_questions_without_additional_filters()
    {
        $seedTest = factory(SeedTest::class)->create([
            'level' => 1,
        ]);
        $testQuestion = factory(TestQuestion::class)->create([
            'seed_test_id' => $seedTest->id,
            'question_number' => 1,
            'question' => 'Will this work?',
            'answer' => 'yes',
        ]);

        $request = new Request([ 'with' => 'questions' ]);
        $seedTestController = new SeedTestController(new SeedTest());
        $response = $seedTestController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue(array_key_exists(
            'questions',
            $response->first()->toArray()
        ));
        $this->assertEquals(
            $testQuestion->toArray(),
            $response->first()->questions->first()->toArray()
        );
    }

    /** @test */
    public function it_can_load_the_question_number_column_on_the_questions_relation()
    {
        $seedTest = factory(SeedTest::class)->create([
            'level' => 1,
        ]);
        $testQuestion = factory(TestQuestion::class)->create([
            'seed_test_id' => $seedTest->id,
            'question_number' => 1,
            'question' => 'Will this work?',
            'answer' => 'yes',
        ]);

        $request = new Request([ 'with' => 'questions.question_number' ]);
        $seedTestController = new SeedTestController(new SeedTest());
        $response = $seedTestController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue(array_key_exists(
            'questions',
            $response->first()->toArray()
        ));
        $this->assertEquals(
            [
                'id' => $testQuestion->id,
                'seed_test_id' => $seedTest->id,
                'question_number' => $testQuestion->question_number,
            ],
            $response->first()->questions->first()->toArray()
        );
    }

    /** @test */
    public function it_can_load_the_question_column_on_the_questions_relation()
    {
        $seedTest = factory(SeedTest::class)->create([
            'level' => 1,
        ]);
        $testQuestion = factory(TestQuestion::class)->create([
            'seed_test_id' => $seedTest->id,
            'question_number' => 1,
            'question' => 'Will this work?',
            'answer' => 'yes',
        ]);

        $request = new Request([ 'with' => 'questions.question' ]);
        $seedTestController = new SeedTestController(new SeedTest());
        $response = $seedTestController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue(array_key_exists(
            'questions',
            $response->first()->toArray()
        ));
        $this->assertEquals(
            [
                'id' => $testQuestion->id,
                'seed_test_id' => $seedTest->id,
                'question' => $testQuestion->question,
            ],
            $response->first()->questions->first()->toArray()
        );
    }

    /** @test */
    public function it_can_load_the_answer_column_on_the_questions_relation()
    {
        $seedTest = factory(SeedTest::class)->create([
            'level' => 1,
        ]);
        $testQuestion = factory(TestQuestion::class)->create([
            'seed_test_id' => $seedTest->id,
            'question_number' => 1,
            'question' => 'Will this work?',
            'answer' => 'yes',
        ]);

        $request = new Request([ 'with' => 'questions.answer' ]);
        $seedTestController = new SeedTestController(new SeedTest());
        $response = $seedTestController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue(array_key_exists(
            'questions',
            $response->first()->toArray()
        ));
        $this->assertEquals(
            [
                'id' => $testQuestion->id,
                'seed_test_id' => $seedTest->id,
                'answer' => $testQuestion->answer,
            ],
            $response->first()->questions->first()->toArray()
        );
    }

    /** @test */
    public function it_can_load_multiple_relation_columns_explicitly()
    {
        $seedTest = factory(SeedTest::class)->create([
            'level' => 1,
        ]);
        $testQuestion = factory(TestQuestion::class)->create([
            'seed_test_id' => $seedTest->id,
            'question_number' => 1,
            'question' => 'Will this work?',
            'answer' => 'yes',
        ]);

        $request = new Request([ 'with' => 'questions.question_number,questions.question' ]);
        $seedTestController = new SeedTestController(new SeedTest());
        $response = $seedTestController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue(array_key_exists(
            'questions',
            $response->first()->toArray()
        ));
        $this->assertEquals(
            [
                'id' => $testQuestion->id,
                'seed_test_id' => $seedTest->id,
                'question_number' => $testQuestion->question_number,
                'question' => $testQuestion->question,
            ],
            $response->first()->questions->first()->toArray()
        );
    }
}
