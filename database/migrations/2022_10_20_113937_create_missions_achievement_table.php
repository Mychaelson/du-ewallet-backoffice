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
        Schema::create('memberships.missions_achievement', function (Blueprint $table) {
            $table->id();
            $table->integer('catalogue_id');
            $table->integer('card_id');
            $table->integer('mission');
            $table->integer('completed_mission')->default(0);
            $table->integer('coupon_id')->nullable()->default(NULL);
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
        Schema::dropIfExists('memberships.missions_achievement');
    }
};
