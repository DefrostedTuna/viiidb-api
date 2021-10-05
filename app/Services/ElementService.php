<?php

namespace App\Services;

use App\Contracts\Services\ElementService as ElementServiceContract;
use App\Models\Element;

class ElementService extends ModelService implements ElementServiceContract
{
    /**
     * Create a new ElementService instance.
     *
     * @param Element $model The instance of the model to use for the service
     */
    public function __construct(Element $model)
    {
        $this->model = $model;
    }
}
