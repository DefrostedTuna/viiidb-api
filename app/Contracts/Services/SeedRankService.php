<?php

namespace App\Contracts\Services;

use Illuminate\Http\Request;

interface SeedRankService
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
     * @param string  $seedRankId The ID of the requested SeedRank
     * @param Request $request    The HTTP request from the client
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
     *
     * @return array
     */
    public function findOrFail(string $seedRankId, Request $request): array;
}
