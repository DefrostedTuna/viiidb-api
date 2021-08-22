<?php

namespace App\Contracts\Transformers;

interface RecordTransformer
{
    /**
     * Transforms an individual record to standardize the output.
     *
     * @param array $record The record to be transformed
     *
     * @return array
     */
    public function transformRecord(array $record): array;

    /**
     * Transforms a collection of records to standardize the output.
     *
     * @param array $collection The collection of records to be transformed
     *
     * @return array
     */
    public function transformCollection(array $collection): array;
}
