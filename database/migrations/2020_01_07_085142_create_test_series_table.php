<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_series', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("user_id");
            $table->bigInteger('exam_id');
            $table->bigInteger('subject_id');
            $table->string('name');
            $table->integer('total_question');
            $table->tinyInteger('lang');
            $table->bigInteger("is_approve")->nullable()->comment("Null=>idle, 0=>publish, 2=>approve, 3=>reject");;
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_series');
    }
}
