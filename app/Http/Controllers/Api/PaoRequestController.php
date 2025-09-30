<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaoRequest;
use App\Http\Requests\UpdatePaoRequest;
use Illuminate\Support\Facades\DB;

class PaoRequestController extends Controller
{
    /** ---------------------------
     *  Helper: Load request details
     *  ---------------------------
     */
   private function loadRequestWithRelations($id)
    {
        $request = DB::table('pao_requests')->where('id', $id)->first();
        if (!$request) {
            return null;
        }

        // Get office code name
        $officeCode = DB::table('office_codes')->where('id', $request->office_code_id)->first();

        $groups = DB::table('pao_groups')
            ->where('request_id', $request->id)
            ->get()
            ->map(function ($group) {
                $group->group_object_expenditure = DB::table('group_object_expenditures')
                    ->find($group->group_id);
                return $group;
            });

        $objects = DB::table('pao_objects')
            ->where('request_id', $request->id)
            ->get()
            ->map(function ($object) {
                $object->object_expenditure = DB::table('object_expenditures')
                    ->find($object->object_expenditure_id);
                return $object;
            });

        return [
            'id'               => $request->id,
            'office_code_id'   => $request->office_code_id,
            'office_code_name' => $officeCode->office_code ?? null, // Use actual column
            'created_by'       => $request->created_by,
            'updated_by'       => $request->updated_by,
            'deleted_by'       => $request->deleted_by,
            'created_at'       => $request->created_at,
            'updated_at'       => $request->updated_at,
            'groups'           => $groups,
            'objects'          => $objects,
            'total_amount'     => $objects->sum('amount'),
        ];
    }

/** ---------------------------
 *  GET /api/pao-requests
 *  ---------------------------
 */
public function index()
{
    $requests = DB::table('pao_requests')
        ->join('office_codes', 'pao_requests.office_code_id', '=', 'office_codes.id')
        ->leftJoin('users', 'pao_requests.created_by', '=', 'users.id')
        ->select(
            'pao_requests.id as request_id',
            'pao_requests.created_by',
            'users.name as name',
            'pao_requests.created_at',
            'pao_requests.office_code_id',
            'office_codes.description as office_code_description'
        )
        ->orderBy('pao_requests.id', 'asc')
        ->get();

    $data = $requests->map(function ($request) {
        // Fetch groups for each request
        $groups = DB::table('pao_groups')
            ->join('group_object_expenditures', 'pao_groups.group_id', '=', 'group_object_expenditures.id')
            ->where('pao_groups.request_id', $request->request_id)
            ->select(
                'pao_groups.id as pao_group_id',
                'group_object_expenditures.id as group_id',
                'group_object_expenditures.group_name'
            )
            ->orderBy('group_object_expenditures.id', 'asc')
            ->get()
            ->map(function ($group) use ($request) {
                // Fetch objects for each group
                $objects = DB::table('pao_objects')
                    ->join('object_expenditures', 'pao_objects.object_expenditure_id', '=', 'object_expenditures.id')
                    ->where('pao_objects.request_id', $request->request_id)
                    ->where('pao_objects.group_id', $group->pao_group_id)
                    ->select(
                        'object_expenditures.id as object_expenditure_id',
                        'object_expenditures.object_expenditure as object_expenditure_name',
                        'object_expenditures.account_code',
                        'pao_objects.amount' // ✅ Added amount
                    )
                    ->orderBy('object_expenditures.id', 'asc')
                    ->get();

                return [
                    'group_id'   => $group->group_id,
                    'group_name' => $group->group_name,
                    'objects'    => $objects,
                ];
            });

        return [
            'request_id'       => $request->request_id,
            'created_by'       => $request->created_by,
            'name'             => $request->name,
            'created_at'       => $request->created_at,
            'office_code_id'   => $request->office_code_id,
            'office_code_description' => $request->office_code_description,
            'groups'           => $groups,
        ];
    });

    return response()->json($data);
}



    /** ---------------------------
     *  GET /api/pao-requests/{id}
     *  ---------------------------
     */
    public function show($id)
    {
        $data = $this->loadRequestWithRelations($id);
        return $data
            ? response()->json($data)
            : response()->json(['message' => 'Request not found'], 404);
    }

    /** ---------------------------
     *  POST /api/pao-requests
     *  ---------------------------
     */
    public function store(StorePaoRequest $request)
    {
        $validated = $request->validated();
        \Log::info('PAO Request store payload:', $validated);

        DB::beginTransaction();

        try {
            // Insert PAO request
            $requestId = DB::table('pao_requests')->insertGetId([
                'office_code_id' => $validated['office_code_id'],
                'created_by'     => $validated['created_by'],
                'updated_by'     => $validated['created_by'],
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            // Insert groups and objects
            foreach ($validated['groups'] as $group) {
                if (!DB::table('group_object_expenditures')->where('id', $group['group_id'])->exists()) {
                    DB::rollBack();
                    return response()->json(['error' => "Group ID {$group['group_id']} does not exist"], 422);
                }

                $groupId = DB::table('pao_groups')->insertGetId([
                    'request_id' => $requestId,
                    'group_id'   => $group['group_id'],
                    'created_by' => $validated['created_by'],
                    'updated_by' => $validated['created_by'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                foreach ($group['objects'] as $object) {
                    if (!DB::table('object_expenditures')->where('id', $object['object_expenditure_id'])->exists()) {
                        DB::rollBack();
                        return response()->json(['error' => "Object Expenditure ID {$object['object_expenditure_id']} does not exist"], 422);
                    }

                    DB::table('pao_objects')->insert([
                        'request_id'            => $requestId,
                        'group_id'              => $groupId,
                        'object_expenditure_id' => $object['object_expenditure_id'],
                        'amount'                => $object['amount'],
                        'created_by'            => $validated['created_by'],
                        'updated_by'            => $validated['created_by'],
                        'created_at'            => now(),
                        'updated_at'            => now(),
                    ]);
                }
            }

            // Fetch office code name for response
            $officeCode = DB::table('office_codes')->where('id', $validated['office_code_id'])->first();

            // Save to audit_logs
            DB::table('audit_logs')->insert([
                'auditable_id'   => $requestId,
                'auditable_type' => 'App\Models\PaoRequest',
                'changes'        => json_encode(['to' => $validated]),
                'remarks'        => 'Created new PAO request',
                'updated_by'     => $validated['created_by'],
                'updated_at'     => now(),
            ]);

            DB::commit();

            return response()->json([
                'message'           => 'Request saved successfully',
                'request_id'        => $requestId,
                'office_code_name'  => $officeCode->office_code ?? null, // include office code name
            ], 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('PAO Request store failed', ['message' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /** ---------------------------
     *  PUT/PATCH /api/pao-requests/{id}
     *  ---------------------------
     */
   public function update(UpdatePaoRequest $request, $id)
    {
    $validated = $request->validated();
    $userId = $validated['updated_by'] ?? auth()->id();

    DB::beginTransaction();

    try {
        $paoRequest = DB::table('pao_requests')->where('id', $id)->first();
        if (!$paoRequest) {
            return response()->json(['error' => "PAO Request {$id} not found"], 404);
        }

        // Update main request
        DB::table('pao_requests')->where('id', $id)->update([
            'office_code_id' => $validated['office_code_id'] ?? $paoRequest->office_code_id,
            'updated_by'     => $userId,
            'updated_at'     => now(),
        ]);

        // Handle groups and objects
        if (!empty($validated['groups'])) {
            foreach ($validated['groups'] as $group) {
                $paoGroup = DB::table('pao_groups')
                    ->where('request_id', $id)
                    ->where('group_id', $group['group_id'])
                    ->first();

                $paoGroupId = $paoGroup
                    ? tap($paoGroup->id, fn() => DB::table('pao_groups')->where('id', $paoGroup->id)->update(['updated_by' => $userId, 'updated_at' => now()]))
                    : DB::table('pao_groups')->insertGetId([
                        'request_id' => $id,
                        'group_id'   => $group['group_id'],
                        'created_by' => $userId,
                        'updated_by' => $userId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                foreach ($group['objects'] as $object) {
                    $paoObject = DB::table('pao_objects')
                        ->where('request_id', $id)
                        ->where('group_id', $paoGroupId)
                        ->where('object_expenditure_id', $object['object_expenditure_id'])
                        ->first();

                    if ($paoObject) {
                        DB::table('pao_objects')->where('id', $paoObject->id)->update([
                            'amount'     => $object['amount'],
                            'updated_by' => $userId,
                            'updated_at' => now(),
                        ]);
                    } else {
                        DB::table('pao_objects')->insert([
                            'request_id'            => $id,
                            'group_id'              => $paoGroupId,
                            'object_expenditure_id' => $object['object_expenditure_id'],
                            'amount'                => $object['amount'],
                            'created_by'            => $userId,
                            'updated_by'            => $userId,
                            'created_at'            => now(),
                            'updated_at'            => now(),
                        ]);
                    }
                }
            }
        }

        // Fetch office code name for response
        $officeCode = DB::table('office_codes')->where('id', $validated['office_code_id'] ?? $paoRequest->office_code_id)->first();

        // Save to audit_logs
        DB::table('audit_logs')->insert([
            'auditable_id'   => $id,
            'auditable_type' => 'App\Models\PaoRequest',
            'changes'        => json_encode(['to' => $validated]),
            'remarks'        => 'Updated PAO request',
            'updated_by'     => $userId,
            'updated_at'     => now(),
        ]);

        DB::commit();

        return response()->json([
            'message'           => 'Request updated successfully',
            'request_id'        => $id,
            'office_code_name'  => $officeCode->office_code ?? null,
        ], 200);

    } catch (\Throwable $e) {
        DB::rollBack();
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


    /** ---------------------------
     *  DELETE /api/pao-requests/{id}
     *  ---------------------------
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            if (!DB::table('pao_requests')->where('id', $id)->exists()) {
                return response()->json(['error' => "PAO request ID {$id} not found"], 404);
            }

            DB::table('pao_requests')->where('id', $id)->delete();

            // ✅ Audit log
            DB::table('audit_logs')->insert([
                'auditable_id'   => $id,
                'auditable_type' => 'App\Models\PaoRequest',
                'changes'        => json_encode(['deleted' => true]),
                'remarks'        => 'Deleted PAO request',
                'updated_by'     => auth()->id(),
                'updated_at'     => now(),
            ]);

            DB::commit();
            return response()->json(['message' => "PAO request {$id} deleted successfully"]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /** ---------------------------
     *  DELETE /api/pao-requests/{requestId}/objects/{objectId}
     *  ---------------------------
     */
    public function destroyObject($requestId, $objectExpenditureId)
    {
        DB::beginTransaction();

        try {
            $paoObject = DB::table('pao_objects')
                ->where('request_id', $requestId)
                ->where('object_expenditure_id', $objectExpenditureId)
                ->first();

            if (!$paoObject) {
                return response()->json([
                    'error' => "Object Expenditure ID {$objectExpenditureId} not found in Request ID {$requestId}"
                ], 404);
            }

            DB::table('pao_objects')->where('id', $paoObject->id)->delete();

            // ✅ Audit log
            DB::table('audit_logs')->insert([
                'auditable_id'   => $paoObject->id,
                'auditable_type' => 'App\Models\PaoRequest',
                'changes'        => json_encode(['deleted' => true]),
                'remarks'        => "Deleted object expenditure {$objectExpenditureId} from request {$requestId}",
                'updated_by'     => auth()->id(),
                'updated_at'     => now(),
            ]);

            DB::commit();
            return response()->json([
                'message' => "Object Expenditure ID {$objectExpenditureId} deleted from Request ID {$requestId}"
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /** ---------------------------
     *  DELETE /api/pao-requests/{requestId}/groups/{groupId}
     *  ---------------------------
     */
    public function destroyGroup($requestId, $groupId)
    {
        DB::beginTransaction();

        try {
            $paoGroupIds = DB::table('pao_groups')
                ->where('request_id', $requestId)
                ->where('group_id', $groupId)
                ->pluck('id');

            if ($paoGroupIds->isEmpty()) {
                return response()->json([
                    'error' => "No group with group_id {$groupId} found for request {$requestId}"
                ], 404);
            }

            $objectsDeleted = DB::table('pao_objects')
                ->where('request_id', $requestId)
                ->whereIn('group_id', $paoGroupIds)
                ->delete();

            $groupsDeleted = DB::table('pao_groups')
                ->whereIn('id', $paoGroupIds)
                ->delete();

            // ✅ Audit log
            DB::table('audit_logs')->insert([
                'auditable_id'   => $requestId,
                'auditable_type' => 'App\Models\PaoRequest',
                'changes'        => json_encode(['groups_deleted' => $groupsDeleted, 'objects_deleted' => $objectsDeleted]),
                'remarks'        => "Deleted group {$groupId} from request {$requestId}",
                'updated_by'     => auth()->id(),
                'updated_at'     => now(),
            ]);

            DB::commit();
            return response()->json([
                'message'         => "Deleted group_id {$groupId} for request {$requestId}",
                'groups_deleted'  => $groupsDeleted,
                'objects_deleted' => $objectsDeleted,
            ], 200);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
