<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreObrRequest;
use App\Http\Requests\UpdateObrRequest;
use App\Models\ObrRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ObrRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $obrRequests = ObrRequest::with([
            'obrObjects',
            'paoRequest.officeCode',
            // ✅ FIXED: Eager load the full relationship path to get the year
            'paoRequest.officeCodeBudget.annualBudget'
        ])
        ->latest()
        ->paginate(15);

        // ✅ ADDED: Manually append the year to the top level of each OBR for easy frontend access
        $obrRequests->getCollection()->transform(function ($obr) {
            // Check if the nested relationships exist before accessing the year
            if ($obr->paoRequest && $obr->paoRequest->officeCodeBudget && $obr->paoRequest->officeCodeBudget->annualBudget) {
                $obr->year = $obr->paoRequest->officeCodeBudget->annualBudget->year;
            } else {
                $obr->year = null; // Or some default/error value
            }
            return $obr;
        });

        return response()->json($obrRequests);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreObrRequest $request): JsonResponse
    {
        $validated = $request->validated();
        
        try {
            DB::beginTransaction();

            $obrRequest = ObrRequest::create([
                'request_id' => $validated['request_id'],
                'obr_no' => $validated['obr_no'],
                'office_address' => $validated['office_address'],
            ]);

            // Using createMany for a slightly cleaner approach
            if (!empty($validated['obr_objects'])) {
                $obrRequest->obrObjects()->createMany($validated['obr_objects']);
            }
            
            DB::commit();
            
            return response()->json($obrRequest->load('obrObjects'), 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to create OBR.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ObrRequest $obrRequest): JsonResponse
    {
        return response()->json($obrRequest->load('obrObjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateObrRequest $request, ObrRequest $obrRequest): JsonResponse
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            // ✅ FIXED: Update logic now handles both the main record and its children

            // 1. Update the main OBR Request record
            $obrRequest->update([
                'request_id' => $validated['request_id'],
                'obr_no' => $validated['obr_no'],
                'office_address' => $validated['office_address'],
            ]);

            // 2. Synchronize the OBR Objects (Delete existing and recreate from request)
            $obrRequest->obrObjects()->delete(); // Delete all old objects

            if (!empty($validated['obr_objects'])) {
                $obrRequest->obrObjects()->createMany($validated['obr_objects']); // Create new ones
            }

            DB::commit();

            return response()->json($obrRequest->load('obrObjects'));

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to update OBR.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ObrRequest $obrRequest): JsonResponse
    {
        // Note: Ensure your database migration for 'obr_objects' has
        // ->onDelete('cascade') for the foreign key to auto-delete children.
        // If not, you should delete them manually here before deleting the parent.
        // e.g., $obrRequest->obrObjects()->delete();
        
        $obrRequest->delete();

        return response()->json(null, 204); // 204 No Content
    }
}