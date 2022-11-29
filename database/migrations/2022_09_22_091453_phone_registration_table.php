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
        Schema::create('backoffice.phone_registration', function (Blueprint $table) {
            $table->id();
            $table->integer('phone_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_user')->nullable();
            $table->integer('process')->nullable();
            $table->string('ip')->nullable();
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
        Schema::drop('backoffice.phone_registration');
    }
};
