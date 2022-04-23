<?php

namespace App\Services;

use App\Contracts\Services\ItemService as ItemServiceContract;
use App\Models\Item;

class ItemService extends ModelService implements ItemServiceContract
{
    /**
     * Create a new ItemService instance.
     *
     * @param Item $model The instance of the model to use for the service
     */
    public function __construct(Item $model)
    {
        $this->model = $model;
    }
}
