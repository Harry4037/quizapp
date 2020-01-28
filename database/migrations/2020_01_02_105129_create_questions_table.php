<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->bigInteger('exam_id');
            $table->bigInteger('subject_id');
            $table->longText('description');
            $table->string('ques_image')->nullable();
            $table->integer("ques_time");
            $table->bigInteger("test_series_id")->default(0);
            $table->bigInteger("quiz_id")->default(0);
            $table->bigInteger("lang")->default(0);
            $table->bigInteger("is_approve")->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('questions');
    }

}
