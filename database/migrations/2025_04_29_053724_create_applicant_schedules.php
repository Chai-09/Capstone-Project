<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('applicant_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id'); // from accounts
            $table->string('applicant_name');
            $table->string('applicant_contact_number');
            $table->string('incoming_grade_level');
            $table->date('exam_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('applicant_schedules');
    }
};
