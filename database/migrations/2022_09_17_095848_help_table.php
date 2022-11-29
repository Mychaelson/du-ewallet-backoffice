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
        Schema::create('backoffice.help', function (Blueprint $table) {
            $table->id();
            $table->integer('user');
            $table->integer('category');
            $table->string('locale');
            $table->string('group');
            $table->string('title');
            $table->string('keywords')->nullable();
            $table->text('content')->nullable();
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
        Schema::drop('backoffice.help');
    }
};
