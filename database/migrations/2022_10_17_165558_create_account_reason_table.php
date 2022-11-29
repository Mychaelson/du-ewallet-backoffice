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
        Schema::create('accounts.reasons', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('by');
            $table->integer('type')->default(0);
            $table->text('content');
            $table->string('subject')->nullable();
            $table->string('field')->nullable();
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
        Schema::dropIfExists('accounts.reasons');
    }
};
