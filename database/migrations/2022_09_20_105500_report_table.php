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
        Schema::create('backoffice.report', function (Blueprint $table) {
            $table->id();
            $table->integer('user');
            $table->string('subject');
            $table->string('number');
            $table->text('contents');
            $table->string('attachements')->nullable();
            $table->string('signeds')->nullable();
            $table->integer('used_by')->nullable();
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
        Schema::drop('backoffice.report');
    }
};
