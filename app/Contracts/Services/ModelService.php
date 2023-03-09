<?php

namespace App\Contracts\Services;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

interface ModelService
{
    /**
     * Retrieve all of the records in the database.
     *
     * @param array<int, string> $includes The relations to include on the resource
     *
     * @return array<int, array<string, mixed>>
     */
    public function all(array $includes = []): array;

    /**
     * Retrieve a specific record from the database, or fail if a record was not found.
     *
     * @param string             $id       The ID of the requested resource
     * @param array<int, string> $includes The relations to include on the resource
     *
     * @throws NotFoundHttpException
     *
     * @return array<string, mixed>
     */
    public function findOrFail(string $id, array $includes = []): array;

    /**
     * Retrieve the specified relation through the parent record, or fail if the parent record was not found.
     *
     * @param string             $id       The ID of the requested resource
     * @param string             $relation The relation to load on the resource
     * @param array<int, string> $includes The relations to include on the resource
     *
     * @return array<int, array<string, mixed>>
     */
    public function findRelationOrFail(string $id, string $relation, array $includes = []): array;
}
