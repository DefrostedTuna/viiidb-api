<?php

namespace Tests\Unit\Traits;

use App\Models\SeedTest;
use Tests\TestCase;

class LoadsRelationsThroughServicesTest extends TestCase
{
    /** @test */
    public function it_will_recursively_look_through_child_relations_to_validate_includes(): void
    {
        $seedTest = new SeedTest();

        $includes = $seedTest->parseIncludes('test-questions.seed-test.not-expected');

        // Since the include is not valid, it will drop the include entirely.
        $this->assertEquals([], $includes);
    }

    /** @test */
    public function it_will_validate_that_the_relation_exists_before_trying_to_retrieve_the_relation(): void
    {
        $seedTest = new SeedTest();

        $includes = $seedTest->parseIncludes('test-questions.not-expected.test-questions');

        // Since the include is not valid, it will drop the include entirely.
        $this->assertEquals([], $includes);
    }

    /** @test */
    public function it_will_only_load_two_levels_of_relations(): void
    {
        $seedTest = new SeedTest();

        $expected = [
            'testQuestions.seedTest.testQuestions',
        ];

        // Nesting three levels deep here.
        $includes = $seedTest->parseIncludes('test-questions.seed-test.test-questions.seed-test');

        // Will only return two levels deep.
        $this->assertEquals($expected, $includes);
    }
}
