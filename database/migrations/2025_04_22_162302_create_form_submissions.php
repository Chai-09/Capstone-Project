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
        Schema::create('form_submissions', function (Blueprint $table) {
            //applicant
            $table->id();
            $table->string('applicant_fname');
            $table->string('applicant_mname')->nullable();
            $table->string('applicant_lname');
            $table->string('applicant_contact_number');
            $table->string('applicant_email');
            $table->string('region');
            $table->string('province');
            $table->string('city');
            $table->string('barangay');
            $table->string('numstreet');
            $table->string('postal_code');
            $table->integer('age');
            $table->string('gender');
            $table->string('nationality');

            //guardian
            $table->string('guardian_fname');
            $table->string('guardian_mname')->nullable();
            $table->string('guardian_lname');
            $table->string('guardian_contact_number');
            $table->string('guardian_email');
            $table->string('relation');

            //schoolinfo
            $table->string('current_school');
            $table->string('current_school_city');
            $table->string('school_type');
            $table->string('educational_level');
            $table->string('incoming_grlvl');
            $table->string('applicant_bday')->nullable();
            $table->string('lrn_no')->nullable();
            $table->string('strand')->nullable();
            $table->string('source');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
