<?php

namespace App\Http\Controllers;

use App\Models\TestQuestion;
use Illuminate\Http\Request;

class TestQuestionController extends Controller
{
    /**
     * Instance of the TestQuestion Model.
     *
     * @var \App\Models\TestQuestion $testQuestionRepository
     */
    protected $testQuestionRepository;

    /**
     * Sets the TestQuestionRepository instance to be used throughout the controller.
     *
     * @param \App\Models\TestQuestion $testQuestion
     * 
     * @return void
     */
    public function __construct(TestQuestion $testQuestion)
    {
        $this->testQuestionRepository = $testQuestion;
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
        return $this->testQuestionRepository->getFilteredRecords($request->input());
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $testQuestionId
     * 
     * @return \App\Models\TestQuestion
     */
    public function show(Request $request, string $testQuestionId): \App\Models\TestQuestion
    {
        return $this->testQuestionRepository->getRecordWithRelations($testQuestionId, $request->input());
    }
}
