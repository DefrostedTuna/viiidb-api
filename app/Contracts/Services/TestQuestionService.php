<?php

namespace App\Contracts\Services;

use Illuminate\Http\Request;

interface TestQuestionService
{
    /**
     * Retrieve all of the records in the database.
     *
     * @param Request $request The HTTP request from the client
     *
     * @return array
     */
    public function all(Request $request): array;

    /**
     * Retrieve a specific record from the database, or fail if a record was not found.
     *
     * @param string  $testQuestionId The ID of the requested TestQuestion
     * @param Request $request        The HTTP request from the client
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
     *
     * @return array
     */
    public function findOrFail(string $testQuestionId, Request $request): array;
}
