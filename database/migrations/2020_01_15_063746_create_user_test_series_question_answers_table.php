<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTestSeriesQuestionAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_test_series_question_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger("user_test_series_id");
            $table->bigInteger("question_id");
            $table->bigInteger("answer_id");
            $table->tinyInteger("is_correct");
            $table->tinyInteger("status")->default(0);
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
        Schema::dropIfExists('user_test_series_question_answers');
    }
}
