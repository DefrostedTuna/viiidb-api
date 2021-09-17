<?php

namespace App\Contracts\Services;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

interface ModelService
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
     * @param string  $id      The ID of the requested resource
     * @param Request $request The HTTP request from the client
     *
     * @throws NotFoundHttpException
     *
     * @return array
     */
    public function findOrFail(string $id, Request $request): array;
}
