<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('time');
            $table->integer('data_1');
            $table->integer('data_2');
            $table->integer('data_3');
            $table->integer('data_4');
            $table->integer('data_5');
            $table->integer('data_6');
            $table->integer('data_7');
            $table->integer('data_8');
            $table->integer('data_9');
            $table->integer('data_10');
            $table->integer('data_11');
            $table->integer('data_12');
            $table->integer('data_13');
            $table->integer('data_14');
            $table->integer('data_15');
            $table->integer('data_16');
            $table->integer('data_17');
            $table->integer('data_18');
            $table->integer('data_19');
            $table->integer('data_20');
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
        Schema::dropIfExists('reports');
    }
}
