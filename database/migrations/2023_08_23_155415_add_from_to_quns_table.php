<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFromToQunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quns', function (Blueprint $table) {
            $table->string('from')->default(0); // 2 是抖音小程序, 0 是微信小程序
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quns', function (Blueprint $table) {
            $table->dropColumn('from');
        });
    }
}
