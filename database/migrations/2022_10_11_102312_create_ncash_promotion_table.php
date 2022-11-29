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
        Schema::create('promotions.ncash_promotion', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('merchant')->nullable()->default(NULL);
            $table->unsignedInteger('product')->nullable()->default(NULL);
            $table->unsignedInteger('created_by');
            $table->string('name');
            $table->string('slug')->nullable()->default(NULL);
            $table->integer('to_spread')->default(0);
            $table->integer('spread_count')->default(0);
            $table->double('budget',13,2)->nullable()->default(NULL);
            $table->double('budget_used',13,2)->nullable()->default(0);
            $table->integer('claim_p_day')->nullable()->default(NULL);
            $table->integer('claim_p_day_user')->nullable()->default(NULL);
            $table->tinyInteger('max_claim_p_month_user')->default(0);
            $table->string('code')->nullable()->default(NULL);
            $table->integer('percentage')->default(0);
            $table->tinyInteger('promo_fund_percentage')->default(0);
            $table->tinyInteger('merch_fund_percentage')->default(0);
            $table->double('max_amount')->default(0);
            $table->tinyInteger('direct_fund')->default(0);
            $table->double('max_amount_claim_user', 9,2)->default(0);
            $table->date('start_date')->nullable()->default(NULL);
            $table->date('end_date')->nullable()->default(NULL);
            $table->time('can_claim_start')->default('00:00:01');
            $table->time('can_claim_end')->default('23:59:59');
            $table->text('terms')->default('<p></p>');
            $table->text('meta')->nullable()->default(NULL);
            $table->date('terminated_end_date')->nullable()->default(NULL);
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('promotions.ncash_promotion');
    }
};
