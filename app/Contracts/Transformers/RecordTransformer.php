<?php

namespace App\Contracts\Transformers;

interface RecordTransformer
{
    /**
     * Transforms an individual record to standardize the output.
     *
     * @param array<string, mixed> $record The record to be transformed
     *
     * @return array<string, mixed>
     */
    public function transformRecord(array $record): array;

    /**
     * Transforms a collection of records to standardize the output.
     *
     * @param array<int, array<string, mixed>> $collection The collection of records to be transformed
     *
     * @return array<int, array<string, mixed>>
     */
    public function transformCollection(array $collection): array;
}
