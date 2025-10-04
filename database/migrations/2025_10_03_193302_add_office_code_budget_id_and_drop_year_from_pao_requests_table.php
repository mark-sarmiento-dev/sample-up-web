<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Add the new foreign key column
        Schema::table('pao_requests', function (Blueprint $table) {
            $table->foreignId('office_code_budget_id')->nullable()->after('office_code_id')->constrained('office_code_budgets')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
 
        // Step 2: Drop the foreign key and column that were added
        Schema::table('pao_requests', function (Blueprint $table) {
            $table->dropForeign(['office_code_budget_id']);
            $table->dropColumn('office_code_budget_id');
        });
    }
};

