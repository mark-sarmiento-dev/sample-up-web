<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaperTrailSetRequest;
use App\Models\Set;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PaperTrailSetController extends Controller
{
    public function index(): JsonResponse
    {
        $sets = Set::with('steps.internalSteps')->latest()->paginate(10);
        return response()->json($sets);
    }

    public function store(StorePaperTrailSetRequest $request): JsonResponse
    {
        $validated = $request->validated();
        
        $set = DB::transaction(function () use ($validated) {
            // Find the highest existing set number.
            $latestSetNo = Set::max('set_no');
            
            // Calculate the next number. If no sets exist, start at 1.
            $nextSetNo = ($latestSetNo ?? 0) + 1;

            $set = Set::create([
                'set_no' => $nextSetNo, // Use the server-generated number
                'office_code' => $validated['office_code'],
                // 'created_by' => auth()->id(), // Uncomment if you have auth
            ]);

            foreach ($validated['steps'] as $stepIndex => $stepData) {
                $step = $set->steps()->create([
                    'office_code_step_owner' => $stepData['office_code_step_owner'],
                    'step_no' => $stepIndex + 1,
                    // 'created_by' => auth()->id(), // Uncomment if you have auth
                ]);

                foreach ($stepData['internal_steps'] as $internalStepData) {
                    $step->internalSteps()->create([
                        'approval_title' => $internalStepData['approval_title'],
                        // 'created_by' => auth()->id(), // Uncomment if you have auth
                    ]);
                }
            }
            return $set;
        });

        return response()->json($set->load('steps.internalSteps'), 201);
    }

    public function show(Set $paperTrailSet): JsonResponse
    {
        return response()->json($paperTrailSet->load('steps.internalSteps'));
    }

    public function update(StorePaperTrailSetRequest $request, Set $paperTrailSet): JsonResponse
    {
        $validated = $request->validated();

        $updatedSet = DB::transaction(function () use ($validated, $paperTrailSet) {
            $paperTrailSet->update([
                'set_no' => $validated['set_no'],
                'office_code' => $validated['office_code'],
                // 'updated_by' => auth()->id(), // Uncomment if you have auth
            ]);

            $paperTrailSet->steps()->delete();

            foreach ($validated['steps'] as $stepIndex => $stepData) {
                $step = $paperTrailSet->steps()->create([
                    'office_code_step_owner' => $stepData['office_code_step_owner'],
                    'step_no' => $stepIndex + 1,
                    // 'created_by' => auth()->id(), // Uncomment if you have auth
                ]);

                foreach ($stepData['internal_steps'] as $internalStepData) {
                    $step->internalSteps()->create([
                        'approval_title' => $internalStepData['approval_title'],
                        // 'created_by' => auth()->id(), // Uncomment if you have auth
                    ]);
                }
            }

            return $paperTrailSet;
        });

        return response()->json($updatedSet->load('steps.internalSteps'));
    }

    public function destroy(Set $paperTrailSet): JsonResponse
    {
        $paperTrailSet->delete();
        return response()->json(null, 204);
    }
}