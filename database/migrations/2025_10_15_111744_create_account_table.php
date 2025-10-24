<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('appid')->comment('ID');
            $table->string('secret')->comment('密钥');
            $table->string('passphrase')->comment('密码');
            $table->string('state')->default('end')->comment('是否执行程序');
            $table->string('trade')->default('end')->comment('是否开始交易');
            $table->string('trend')->default('up')->comment('趋势');
            $table->string('value')->comment('当前价差')->nullable();
            $table->integer('pid')->nullable()->comment('进程ID');
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
        Schema::dropIfExists('account');
    }
}
