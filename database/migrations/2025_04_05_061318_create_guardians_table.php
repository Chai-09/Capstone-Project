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
    Schema::create('guardian', function (Blueprint $table) {
        $table->id();
        $table->string('guardian_fname');
        $table->string('guardian_mname')->nullable();
        $table->string('guardian_lname');
        $table->string('guardian_email')->unique();
        $table->string('password');
        //$table->timestamps();
    });
    
}


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('guardian');
    }
};
