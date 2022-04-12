<?php

namespace Tests\Unit\Middleware;

use App\Http\Middleware\SanitizesSearchInput;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tests\TestCase;

class SanitizesSearchInputTest extends TestCase
{
    /** @test */
    public function it_will_sanitize_search_input_and_convert_values_to_an_array(): void
    {
        $request = new Request([
            'q' => 'something',
            'only' => 'seedRanks,seed_tests,test-questions',
            'exclude' => 'statusEffects,elements,stats',
        ]);
        $middleware = new SanitizesSearchInput();

        $middleware->handle($request, function ($req) {
            $this->assertEquals([
                'seed_ranks',
                'seed_tests',
                'test_questions',
            ], $req->only);

            $this->assertEquals([
                'status_effects',
                'elements',
                'stats',
            ], $req->exclude);

            return new JsonResponse([], 200);
        });
    }
}
