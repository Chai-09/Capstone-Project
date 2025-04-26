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
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('applicant_id');
            $table->string('applicant_fname');
            $table->string('applicant_mname')->nullable();
            $table->string('applicant_lname');
            $table->string('applicant_email');
            $table->string('applicant_contact_number');
            $table->string('incoming_grlvl');
            $table->string('payment_method');
            $table->string('proof_of_payment');
            $table->date('payment_date');
            $table->time('payment_time');
            $table->timestamps();

            // Foreign key linking applicant_id to applicants table
            $table->foreign('applicant_id')->references('id')->on('applicants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
