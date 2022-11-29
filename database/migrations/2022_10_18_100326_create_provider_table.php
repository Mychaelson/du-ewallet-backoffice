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
        Schema::create('memberships.provider', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('slug');
            $table->string('logo');
            $table->unsignedInteger('category_id')->nullable()->default(NULL);
            $table->unsignedInteger('owner_user_id');
            $table->integer('conversion')->default(1);
            $table->unsignedInteger('owner_merchant_id')->unique()->nullable()->default(NULL);
            $table->text('description');
            $table->text('redemption_note')->nullable()->default(NULL);
            $table->smallInteger('private')->default(0);
            $table->smallInteger('member_on_reg')->default(0);
            $table->json('properties');
            $table->datetime('deleted_at')->nullable()->default(NULL);
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
        Schema::dropIfExists('memberships.provider');
    }
};
