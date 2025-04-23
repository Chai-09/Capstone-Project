<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('form_submissions', function (Blueprint $table) {
            // Match the INT UNSIGNED from applicants.id
            $table->unsignedInteger('applicant_id')->nullable()->after('id');

            $table->foreign('applicant_id')
                  ->references('id')
                  ->on('applicants')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('form_submissions', function (Blueprint $table) {
            $table->dropForeign(['applicant_id']);
            $table->dropColumn('applicant_id');
        });
    }
};
