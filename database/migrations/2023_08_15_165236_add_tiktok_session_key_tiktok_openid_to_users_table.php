<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTiktokSessionKeyTiktokOpenidToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('tiktok_openid')->nullable()->unique()->after('weixin_unionid');
            $table->string('tiktok_unionid')->nullable()->unique()->after('tiktok_openid');
            $table->string('tiktok_session_key')->nullable()->unique()->after('tiktok_unionid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('tiktok_openid');
            $table->dropColumn('tiktok_unionid');
            $table->dropColumn('tiktok_session_key');
        });
    }
}
