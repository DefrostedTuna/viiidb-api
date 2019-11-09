<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Instance of the Location Model.
     *
     * @var \App\Models\Location $locationRepository
     */
    protected $locationRepository;

    /**
     * Sets the LocationRepository instance to be used throughout the controller.
     *
     * @param \App\Models\Location $location
     * 
     * @return void
     */
    public function __construct(Location $location)
    {
        $this->locationRepository = $location;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request): \Illuminate\Database\Eloquent\Collection
    {
        return $this->locationRepository->getFilteredRecords($request->input());
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $locationId
     * 
     * @return \App\Models\Location
     */
    public function show(Request $request, string $locationId): \App\Models\Location
    {
        return $this->locationRepository->getRecordWithRelations($locationId, $request->input());
    }
}
