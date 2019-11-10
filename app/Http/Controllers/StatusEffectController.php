<?php

namespace App\Http\Controllers;

use App\Models\StatusEffect;
use Illuminate\Http\Request;

class StatusEffectController extends Controller
{
    /**
     * Instance of the StatusEffect Model.
     *
     * @var \App\Models\StatusEffect $statusEffectRepository
     */
    protected $statusEffectRepository;

    /**
     * Sets the StatusEffectRepository instance to be used throughout the controller.
     *
     * @param \App\Models\StatusEffect $statusEffect
     * 
     * @return void
     */
    public function __construct(StatusEffect $statusEffect)
    {
        $this->statusEffectRepository = $statusEffect;
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
        return $this->statusEffectRepository->getFilteredRecords($request->input());
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $statusEffectId
     * 
     * @return \App\Models\StatusEffect
     */
    public function show(Request $request, string $statusEffectId): \App\Models\StatusEffect
    {
        return $this->statusEffectRepository->getRecordWithRelations($statusEffectId, $request->input());
    }
}
