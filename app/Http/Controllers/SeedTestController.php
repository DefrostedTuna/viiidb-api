<?php

namespace App\Http\Controllers;

use App\Models\SeedTest;
use Illuminate\Database\Eloquent\Collection;
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
     * @param  \App\Models\SeedTest  $seedTest
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
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request): Collection
    {
        return $this->seedTestRepository->getFilteredRecords($request->input());
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string                    $seedTestLevel
     *
     * @return \App\Models\SeedTest
     */
    public function show(Request $request, string $seedTestLevel): SeedTest
    {
        return $this->seedTestRepository->getRecordWithRelations($seedTestLevel, $request->input(), 'level');
    }
}
