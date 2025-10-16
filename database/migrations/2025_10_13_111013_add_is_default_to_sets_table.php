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
        Schema::table('sets', function (Blueprint $table) {
            // Add a boolean column named 'is_default'
            // Set its default value to 'false'
            // Place it after the 'office_code' column for organization
            $table->boolean('is_default')->default(false)->after('office_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sets', function (Blueprint $table) {
            // This will remove the column if the migration is rolled back
            $table->dropColumn('is_default');
        });
    }
};