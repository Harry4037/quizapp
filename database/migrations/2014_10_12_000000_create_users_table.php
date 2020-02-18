<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile_number')->nullable();
            $table->date("dob")->nullable();
            $table->string("designation")->nullable();;
            $table->string("qualification")->nullable();;
            $table->text("into_line")->nullable();;
            $table->text("about")->nullable();;
            $table->tinyInteger("lang")->default(0);
            $table->text("experience")->nullable();
            $table->string('password')->nullable();
            $table->bigInteger('user_type_id')->default(0);
            $table->string('otp')->nullable();
            $table->string('profile_pic')->nullable();
            $table->string('device_token')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('is_approve')->default(0)->comment("0=>idle, 2=>approve, 3=>reject");
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->string('created_by')->default(0);
            $table->string('updated_by')->default(0);
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
        Schema::dropIfExists('users');
    }

}
