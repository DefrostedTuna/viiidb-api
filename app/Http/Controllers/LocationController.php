<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Database\Eloquent\Collection;
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
     * @param  \App\Models\Location  $location
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
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request): Collection
    {
        return $this->locationRepository->getFilteredRecords($request->input());
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string                    $locationName
     *
     * @return \App\Models\Location
     */
    public function show(Request $request, string $locationName): Location
    {
        return $this->locationRepository->getRecordWithRelations($locationName, $request->input(), 'name');
    }
}
