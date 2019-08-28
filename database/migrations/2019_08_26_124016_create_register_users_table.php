<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRegisterUsersTable extends Migration {

	public function up()
	{
		Schema::create('register_users', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 255);
			$table->string('surname', 255);
			$table->string('address', 255);
			$table->string('city', 255);
			$table->smallInteger('cp');
			$table->string('telephone', 20);
			$table->string('email', 255);
		});
	}

	public function down()
	{
		Schema::drop('register_users');
	}
}