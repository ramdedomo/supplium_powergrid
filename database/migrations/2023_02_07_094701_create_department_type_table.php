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
        Schema::create('department_type', function (Blueprint $table) {
            $table->comment('');
            $table->integer('department', true);
            $table->text('department_description')->nullable();
            $table->text('department_short')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->integer('nonteaching')->nullable();
            $table->dateTime('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('department_type');
    }
};
