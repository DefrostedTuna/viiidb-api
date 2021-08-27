<?php

namespace App\Contracts\Services;

use Illuminate\Http\Request;

interface SeedTestService
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
     * @param string  $seedTestId The ID of the requested SeedTest
     * @param Request $request    The HTTP request from the client
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
     *
     * @return array
     */
    public function findOrFail(string $seedTestId, Request $request): array;
}
