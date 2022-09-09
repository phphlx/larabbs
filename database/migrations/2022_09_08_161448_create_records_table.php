<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
	public function up()
	{
		Schema::create('records', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('admin_id');
            $table->decimal('money');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('records');
	}
}
