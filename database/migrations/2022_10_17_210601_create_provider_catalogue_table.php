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
        Schema::create('memberships.provider_catalogue', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('category')->default(1);
            $table->integer('status');
            $table->integer('type');
            $table->string('slug');
            $table->string('description');
            $table->text('terms')->nullable()->default(NULL);
            $table->string('background')->default('#614385');
            $table->text('redemption_note')->nullable()->default(NULL);
            $table->json('images')->nullable()->default(NULL);
            $table->integer('point')->nullable()->default(NULL);
            $table->tinyInteger('coupon_as_payment')->default(0);
            $table->unsignedInteger('provider_id');
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('exchanged')->nullable()->default(NULL);
            $table->integer('product')->nullable()->default(NULL);
            $table->integer('product_category')->nullable()->default(NULL);
            $table->integer('product_flag')->nullable()->default(NULL);
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('partner_id')->nullable()->default(NULL);
            $table->integer('item_value')->nullable()->default(NULL);
            $table->integer('extra_pay')->nullable()->default(NULL);
            $table->datetime('start_at');
            $table->datetime('end_at');
            $table->datetime('exchange_date_limit');
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
        Schema::dropIfExists('memberships.provider_catalogue');
    }
};
