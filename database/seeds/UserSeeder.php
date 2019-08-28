<?php

use Illuminate\Database\Seeder;

// Hace uso del modelo de User.
use App\User;

class UserSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		User::create(
			[
                                'name'=>'test',
				'email'=>'test@test.es',
				'password'=> Hash::make('12345678')	
			]);

	}
}