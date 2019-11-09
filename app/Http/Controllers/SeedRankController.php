<?php

namespace App\Http\Controllers;

use App\Models\SeedRank;
use Illuminate\Http\Request;

class SeedRankController extends Controller
{
    /**
     * Instance of the SeedRank Model.
     *
     * @var \App\Models\SeedRank $seedRankRepository
     */
    protected $seedRankRepository;

    /**
     * Sets the SeedRankRepository instance to be used throughout the controller.
     *
     * @param \App\Models\SeedRank $seedRank
     * 
     * @return void
     */
    public function __construct(SeedRank $seedRank)
    {
        $this->seedRankRepository = $seedRank;
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
        return $this->seedRankRepository->getFilteredRecords($request->input());
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $seedRankId
     * 
     * @return \App\Models\SeedRank
     */
    public function show(Request $request, string $seedRankId): \App\Models\SeedRank
    {
        return $this->seedRankRepository->getRecordWithRelations($seedRankId, $request->input());
    }
}
