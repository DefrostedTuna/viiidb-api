<?php

namespace Tests\Unit\Traits;

use App\Models\SeedTest;
use Tests\TestCase;

class VerifiesIncludesTest extends TestCase
{
    /** @test */
    public function it_will_verify_an_array_of_includes(): void
    {
        $seedTest = new SeedTest();

        $includes = $seedTest->verifyIncludes(['test-questions']);

        $this->assertEquals(['testQuestions'], $includes);
    }

    /** @test */
    public function it_will_verify_an_array_of_nested_includes(): void
    {
        $seedTest = new SeedTest();

        $includes = $seedTest->verifyIncludes(['test-questions.seed-test']);

        $this->assertEquals(['testQuestions.seedTest'], $includes);
    }

    /** @test */
    public function it_will_not_verify_nested_includes_that_are_more_than_two_levels_deep(): void
    {
        $seedTest = new SeedTest();

        $includes = $seedTest->verifyIncludes(['test-questions.seed-test.test-questions.seed-test']);

        $this->assertEquals(['testQuestions.seedTest.testQuestions'], $includes);
    }

    /** @test */
    public function it_will_drop_the_include_if_any_part_of_it_is_invalid(): void
    {
        $seedTest = new SeedTest();

        $includes = $seedTest->verifyIncludes(['test-questions.not-valid.test-questions']);

        $this->assertEquals([], $includes);
    }
}
