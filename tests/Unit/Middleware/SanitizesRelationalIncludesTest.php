<?php

namespace Tests\Unit\Middleware;

use App\Http\Middleware\SanitizesRelationalIncludes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tests\TestCase;

class SanitizesRelationalIncludesTest extends TestCase
{
    /** @test */
    public function it_will_sanitize_relational_includes_and_convert_values_to_an_array(): void
    {
        $request = new Request([
            'include' => 'test-questions,seedTest.test_questions',
        ]);
        $middleware = new SanitizesRelationalIncludes();

        $middleware->handle($request, function ($req) {
            $this->assertEquals([
                'testQuestions',
                'seedTest.testQuestions',
            ], $req->include);

            return new JsonResponse([], 200);
        });
    }
}
