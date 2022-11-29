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
        Schema::create('memberships.missions', function (Blueprint $table) {
            $table->id();
            $table->integer('catalogue_id');
            $table->integer('mission_type');
            $table->string('description')->default('');
            $table->string('mission_target');
            $table->integer('mission_count_needed')->default(0);
            $table->dateTime('deleted_at')->nullable()->default(NULL);
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
        Schema::dropIfExists('memberships.missions');
    }
};
