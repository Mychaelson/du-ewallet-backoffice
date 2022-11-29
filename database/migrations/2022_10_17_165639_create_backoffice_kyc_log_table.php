<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backoffice.kyc_log', function (Blueprint $table) {
            $table->id();
            $table->integer('operator');
            $table->integer('user');
            $table->integer('type')->nullable()->default(0);
            $table->integer('rejection')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('backoffice.kyc_log');
    }
};
