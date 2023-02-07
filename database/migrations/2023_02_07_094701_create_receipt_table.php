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
        Schema::create('receipt', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->integer('supply_status')->nullable();
            $table->integer('user_id')->nullable();
            $table->dateTime('accepted_at')->nullable();
            $table->dateTime('chair_at')->nullable();
            $table->dateTime('dean_at')->nullable();
            $table->dateTime('supply_at')->nullable();
            $table->dateTime('done_at')->nullable();
            $table->dateTime('ced_at')->nullable();
            $table->dateTime('canceled_at')->nullable();
            $table->integer('is_supply')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipt');
    }
};
