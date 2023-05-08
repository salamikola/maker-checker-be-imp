<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMakerCheckersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maker_checkers', function (Blueprint $table) {
            $table->id();
            $table->morphs('checkable');
            $table->json('request_data')->nullable();
            $table->enum('request_type',['create-user','update-user','delete-user']);
            $table->enum('status',['pending','accepted','rejected'])->index();
            $table->bigInteger('maker_id')->unsigned();
            $table->bigInteger('checker_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('maker_id')->references('id')->on('admins');
            $table->foreign('checker_id')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maker_checkers');
    }
}
