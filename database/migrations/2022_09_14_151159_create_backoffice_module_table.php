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
        Schema::create('backoffice.module', function (Blueprint $table) {
            $table->id('modid');
            $table->integer('parent_id')->nullable();
            $table->string('mod_name')->nullable();
            $table->string('mod_alias')->nullable();
            $table->string('permalink')->nullable();
            $table->integer('mod_order')->nullable();
            $table->string('published')->nullable();
            $table->integer('created')->nullable();
            $table->string('icon')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('backoffice.module');
    }
};
