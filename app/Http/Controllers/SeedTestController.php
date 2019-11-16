<?php

namespace App\Http\Controllers;

use App\Models\SeedTest;
use Illuminate\Http\Request;

class SeedTestController extends Controller
{
    /**
     * Instance of the SeedTest Model.
     *
     * @var \App\Models\SeedTest $seedTestRepository
     */
    protected $seedTestRepository;

    /**
     * Sets the SeedTestRepository instance to be used throughout the controller.
     *
     * @param \App\Models\SeedTest $seedTest
     * 
     * @return void
     */
    public function __construct(SeedTest $seedTest)
    {
        $this->seedTestRepository = $seedTest;
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
        return $this->seedTestRepository->getFilteredRecords($request->input());
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $seedTestId
     * 
     * @return \App\Models\SeedTest
     */
    public function show(Request $request, string $seedTestId): \App\Models\SeedTest
    {
        // return $this->seedTestRepository->with('questions:id,question_number,seed_test_id')->where('id', '022e0295-fd03-454f-9a24-2e5b0708dcfe')->first();
        return $this->seedTestRepository->getRecordWithRelations($seedTestId, $request->input());
    }
}
