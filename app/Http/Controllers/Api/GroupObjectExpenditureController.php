<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GroupObjectExpenditure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupObjectExpenditureController extends Controller
{
    public function index()
    {
        $groups = GroupObjectExpenditure::with(['objectExpenditures' => function ($query) {
            $query->orderBy('id', 'asc'); // sort objects by id asc
        }])
        ->orderBy('id', 'asc') // sort groups by id asc
        ->get();

        $data = $groups->map(function ($group) {
            return [
                "group_id" => $group->id,
                "group_name" => $group->group_name,
                "object_of_expenditures" => $group->objectExpenditures->map(function ($obj) {
                    return [
                        "object_id" => $obj->id,
                        "object_name" => $obj->object_expenditure,
                        "account_code" => $obj->account_code,
                    ];
                })->values(),
            ];
        });

        return response()->json($data);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'group_name' => 'required|string|max:255',
        ]);

        $existing = GroupObjectExpenditure::withTrashed()
            ->where('group_name', $validated['group_name'])
            ->first();

        if ($existing) {
            if ($existing->trashed()) {
                $existing->restore();
                $existing->update($validated);

                DB::table('audit_logs')->insert([
                    'auditable_id'   => $existing->id,
                    'auditable_type' => GroupObjectExpenditure::class,
                    'changes'        => json_encode(['from' => '[soft-deleted]', 'to' => $validated]),
                    'remarks'        => 'Restored soft-deleted group expenditure',
                    'updated_by'     => auth()->user()->employee_id ?? null,
                    'updated_at'     => now(),
                ]);

                return response()->json([
                    'message' => 'Group expenditure restored successfully.',
                    'data'    => $existing,
                ]);
            }

            return response()->json([
                'message' => 'Group expenditure already exists.',
                'data'    => $existing,
            ], 409);
        }

        $group = GroupObjectExpenditure::create($validated);

        // ✅ Audit log for creation
        DB::table('audit_logs')->insert([
            'auditable_id'   => $group->id,
            'auditable_type' => GroupObjectExpenditure::class,
            'changes'        => json_encode(['from' => null, 'to' => $validated]),
            'remarks'        => 'Created new group expenditure',
            'updated_by'     => auth()->user()->employee_id ?? null,
            'updated_at'     => now(),
        ]);

        return response()->json([
            'message' => 'Group expenditure created successfully.',
            'data'    => $group,
        ]);
    }

    public function update(Request $request, $id)
    {
        $group = GroupObjectExpenditure::withTrashed()->findOrFail($id);

        $validated = $request->validate([
            'group_name' => 'required|string|max:255|unique:group_object_expenditures,group_name,' . $group->id,
        ]);

        $original = $group->only(['group_name']);

        $group->update($validated);

        DB::table('audit_logs')->insert([
            'auditable_id'   => $group->id,
            'auditable_type' => GroupObjectExpenditure::class,
            'changes'        => json_encode(['from' => $original, 'to' => $validated]),
            'remarks'        => 'Updated group expenditure info',
            'updated_by'     => auth()->user()->employee_id ?? null,
            'updated_at'     => now(),
        ]);

        return response()->json([
            'message' => 'Group expenditure updated successfully.',
            'data'    => $group,
        ]);
    }

    public function destroy($id)
    {
        $group = GroupObjectExpenditure::withTrashed()->findOrFail($id);

        $original = $group->only(['group_name']);

        DB::table('audit_logs')->insert([
            'auditable_id'   => $group->id,
            'auditable_type' => GroupObjectExpenditure::class,
            'changes'        => json_encode([
                'from' => $original,
                'to'   => ['group_name' => '[deleted]'],
            ]),
            'remarks'        => 'Deleted group expenditure record (cascade delete handled by DB)',
            'updated_by'     => auth()->user()->employee_id ?? null,
            'updated_at'     => now(),
        ]);

        // ✅ No need to manually delete children, DB cascade handles it
        $group->delete();

        return response()->noContent();
    }

    public function show($id)
    {
        $group = GroupObjectExpenditure::withTrashed()->findOrFail($id);

        return response()->json([
            'message' => 'Group expenditure retrieved successfully.',
            'data'    => $group,
        ]);
    }
}
