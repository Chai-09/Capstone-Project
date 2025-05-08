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
        Schema::create('applicant_schedules', function (Blueprint $table) {
            $table->id();

            // Foreign key to applicants table
            $table->unsignedInteger('applicant_id');
            $table->foreign('applicant_id')->references('id')->on('applicants')->onDelete('cascade');

            $table->string('applicant_name');
            $table->string('applicant_contact_number');
            $table->string('incoming_grade_level');
            $table->date('exam_date');
            $table->time('start_time');
            $table->time('end_time');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_schedules');
    }
};
