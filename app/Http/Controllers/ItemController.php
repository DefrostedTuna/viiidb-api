<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Instance of the Item Model.
     *
     * @var \App\Models\Item $ItemRepository
     */
    protected $itemRepository;

    /**
     * Sets the ItemRepository instance to be used throughout the controller.
     *
     * @param  \App\Models\Item  $item
     *
     * @return void
     */
    public function __construct(Item $item)
    {
        $this->itemRepository = $item;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request): Collection
    {
        return $this->itemRepository->getFilteredRecords($request->input());
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string                    $itemName
     *
     * @return \App\Models\Item
     */
    public function show(Request $request, string $itemName): Item
    {
        return $this->itemRepository->getRecordWithRelations($itemName, $request->input(), 'name');
    }
}
