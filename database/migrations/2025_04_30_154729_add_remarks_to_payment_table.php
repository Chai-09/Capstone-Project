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
        Schema::table('payment', function (Blueprint $table) {
            $table->text('remarks')->nullable()->after('payment_status');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('payment', function (Blueprint $table) {
            $table->dropColumn('remarks');
        });
    }

};
