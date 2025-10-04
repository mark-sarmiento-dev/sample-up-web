<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OfficeCode;
use App\Models\OfficeCodeBudget;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class OfficeCodeBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     * Can be filtered by annual_budget_id.
     */
    public function index(Request $request)
    {
        $query = OfficeCodeBudget::with('officeCode');

        if ($request->has('annual_budget_id')) {
            $query->where('annual_budget_id', $request->annual_budget_id);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * ✅ ADDED: Get all budgets for a specific Office Code.
     *
     * @param int $officeCodeId The ID of the office code.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByOfficeCode($officeCodeId)
    {
        // First, check if the provided office code even exists.
        if (!OfficeCode::where('id', $officeCodeId)->exists()) {
            return response()->json(['message' => 'Office Code not found.'], Response::HTTP_NOT_FOUND);
        }

        // Fetch all budget entries for the given office_code_id
        $officeBudgets = OfficeCodeBudget::with('annualBudget')
            ->where('office_code_id', $officeCodeId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($officeBudgets);
    }

    /**
     * Store a newly created resource in storage.
     * If a record for the office code and annual budget exists and is soft-deleted, it will be restored.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'office_code_id' => 'required|exists:office_codes,id',
            'annual_budget_id' => 'required|exists:annual_budgets,id',
            'budget' => 'required|numeric|min:0',
        ]);

        // Check for an existing record, including soft-deleted ones
        $officeBudget = OfficeCodeBudget::withTrashed()
            ->where('office_code_id', $validated['office_code_id'])
            ->where('annual_budget_id', $validated['annual_budget_id'])
            ->first();

        if ($officeBudget) {
            if ($officeBudget->trashed()) {
                // If it exists but was deleted, restore and update it
                $officeBudget->restore();
                $officeBudget->update(['budget' => $validated['budget']]);

                return response()->json($officeBudget->load('officeCode'), Response::HTTP_OK);
            } else {
                // If it exists and is active, return a validation error
                return response()->json([
                    'message' => 'This office code has already been assigned a budget for this year.',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        // If it doesn't exist at all, create it
        $newOfficeBudget = OfficeCodeBudget::create($validated);

        return response()->json($newOfficeBudget->load('officeCode'), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(OfficeCodeBudget $officeCodeBudget)
    {
        return $officeCodeBudget->load('officeCode', 'annualBudget');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OfficeCodeBudget $officeCodeBudget)
    {
        $validated = $request->validate([
            'budget' => 'required|numeric|min:0',
            // You can add validation for other fields if they are updatable
        ]);

        $officeCodeBudget->update($validated);

        return response()->json($officeCodeBudget->load('officeCode'));
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(OfficeCodeBudget $officeCodeBudget)
    {
        $officeCodeBudget->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
