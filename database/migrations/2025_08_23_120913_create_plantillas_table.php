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
        Schema::create('plantillas', function (Blueprint $table) {
            $table->id();
            $table->string('plantilla_item_number');
            $table->unsignedInteger('salary_grade'); // corresponds to Salary Grade in the table
            $table->unsignedTinyInteger('step'); // Step number (1-8)
            $table->string('eligibility_requirement');
            $table->string('educational_requirement');
            $table->unsignedBigInteger('department_id');
            $table->timestamps();

            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantillas');
    }
};
