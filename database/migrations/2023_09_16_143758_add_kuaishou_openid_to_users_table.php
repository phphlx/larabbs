<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKuaishouOpenidToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('kuaishou_openid')->nullable()->unique()->after('tiktok_session_key');
            $table->string('kuaishou_session_key')->nullable()->unique()->after('kuaishou_openid');
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
            $table->dropColumn('kuaishou_openid');
            $table->dropColumn('kuaishou_session_key');
        });
    }
}
