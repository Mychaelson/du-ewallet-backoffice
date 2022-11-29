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
        Schema::create('log.kyc_access_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user');
            $table->string('page')->nullable();
            $table->string('ref')->nullable();
            $table->integer('target');
            $table->string('origin')->nullable();
            $table->string('content')->nullable();
            $table->string('type')->nullable();
            $table->datetime('time_start')->nullable();
            $table->datetime('time_end')->nullable();
            $table->datetime('created')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log.kyc_access_log');
    }
};
