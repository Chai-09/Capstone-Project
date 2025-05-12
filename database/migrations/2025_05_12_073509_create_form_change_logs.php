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
        Schema::create('form_change_logs', function (Blueprint $table) {
            $table->id();
            $table->string('changed_by');
            $table->timestamp('created_at')->nullable();
            $table->string('field_name');
            $table->unsignedBigInteger('form_submission_id'); // renamed
            $table->string('new_value')->nullable();
            $table->string('old_value')->nullable();
            $table->timestamp('updated_at')->nullable();
    
            
            $table->foreign('form_submission_id')->references('id')->on('form_submissions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_change_logs');
    }
};
