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
        Schema::create('backoffice.one_time_passwords', function (Blueprint $table) {
            $table->id();
            $table->integer('modulable_id')->nullable();
            $table->string('modulable_type')->nullable();
            $table->integer('token')->nullable();
            $table->integer('request_count')->nullable();
            $table->integer('try_input')->nullable();
            $table->date('expires_on')->nullable();
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
        Schema::drop('backoffice.one_time_passwords');
    }
};
