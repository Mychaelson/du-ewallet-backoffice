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
        Schema::create('wallet.wallet_setting', function (Blueprint $table) {
            $table->id();
            $table->integer('wallet_id');
            $table->string('fiture');
            $table->string('status');
            $table->text('changes');
            $table->string('requested_by');
            $table->string('approved_by')->nullable();
            $table->string('document')->nullable();
            $table->text('reason')->nullable();
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
        Schema::dropIfExists('wallet.wallet_setting');
    }
};
