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
        return $this->seedRankRepository->all();
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SeedRank $seedRank
     * 
     * @return \App\Models\SeedRank $seedRank
     */
    public function show(Request $request, SeedRank $seedRank): \App\Models\SeedRank
    {
        return $seedRank;
    }
}
