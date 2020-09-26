<?php

namespace App\Http\Controllers;

use App\Models\Element;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ElementController extends Controller
{
    /**
     * Instance of the Element Model.
     *
     * @var \App\Models\Element $elementRepository
     */
    protected $elementRepository;

    /**
     * Sets the ElementRepository instance to be used throughout the controller.
     *
     * @param  \App\Models\Element  $element
     *
     * @return void
     */
    public function __construct(Element $element)
    {
        $this->elementRepository = $element;
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
        return $this->elementRepository->getFilteredRecords($request->input());
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string                    $elementName
     *
     * @return \App\Models\Element
     */
    public function show(Request $request, string $elementName): Element
    {
        return $this->elementRepository->getRecordWithRelations($elementName, $request->input(), 'name');
    }
}
