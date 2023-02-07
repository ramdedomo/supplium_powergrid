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
        Schema::create('supply', function (Blueprint $table) {
            $table->comment('');
            $table->integer('id', true);
            $table->integer('supply_type')->nullable();
            $table->text('supply_name')->nullable();
            $table->integer('supply_stocks')->nullable();
            $table->binary('supply_img')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->text('supply_desc')->nullable();
            $table->text('supply_color')->nullable();
            $table->binary('supply_photo')->nullable();
            $table->float('supply_price', 10, 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supply');
    }
};
