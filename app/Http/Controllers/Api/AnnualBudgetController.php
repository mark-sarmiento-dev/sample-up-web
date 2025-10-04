<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AnnualBudget;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnnualBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AnnualBudget::orderBy('year', 'desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     * If a record for the year exists and is soft-deleted, it will be restored.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|digits:4',
            'annual_budget' => 'required|numeric|min:0',
        ]);

        // Find a budget for the given year, including any soft-deleted ones.
        $budget = AnnualBudget::withTrashed()->where('year', $validated['year'])->first();

        if ($budget) {
            // If a budget was found...
            if ($budget->trashed()) {
                // ...and it was soft-deleted, restore it and update the amount.
                $budget->restore();
                $budget->update(['annual_budget' => $validated['annual_budget']]);
                
                return response()->json($budget, Response::HTTP_OK);
            } else {
                // ...and it's active, then it's a duplicate entry.
                return response()->json([
                    'message' => 'The year has already been taken.',
                    'errors'  => ['year' => ['The year has already been taken.']],
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        // If no budget was found for that year, create a new one.
        $newBudget = AnnualBudget::create($validated);

        return response()->json($newBudget, Response::HTTP_CREATED);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(AnnualBudget $annualBudget)
    {
        return $annualBudget;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AnnualBudget $annualBudget)
    {
        $validated = $request->validate([
            'year' => 'required|integer|digits:4|unique:annual_budgets,year,' . $annualBudget->id,
            'annual_budget' => 'required|numeric|min:0',
        ]);

        $annualBudget->update($validated);

        return response()->json($annualBudget);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnnualBudget $annualBudget)
    {
        $annualBudget->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
