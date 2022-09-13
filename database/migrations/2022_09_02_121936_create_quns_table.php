<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQunsTable extends Migration
{
    public function up()
    {
        Schema::create('quns', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('intro');
            $table->tinyInteger('type');
            $table->string('avatar');
            $table->string('qrcode');
            $table->unsignedInteger('num');
            $table->string('share_title');
            $table->string('share_img');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('quns');
    }
}
