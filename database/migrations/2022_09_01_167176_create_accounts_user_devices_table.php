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
        Schema::create('accounts.user_devices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('device_name')->nullable();
            $table->string('imei')->nullable();
            $table->string('device_token')->nullable();
            $table->string('session_id')->nullable();
            $table->integer('login_count');
            $table->string('location')->nullable();
            $table->timestamps();
            

            $table->index('user_id');	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts.user_devices');
    }
};
