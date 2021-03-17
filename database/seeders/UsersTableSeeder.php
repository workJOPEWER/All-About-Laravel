<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$data = [
			[
				'name' => 'Автор не известен',
				'email' => 'author_unknown@g-g',
				'password' => Hash::make( Str::random( 16 ) ),
			],
			[
				'name' => 'Автор',
				'email' => 'author1@g-g',
				'password' => Hash::make( 123456 ),
			],
		];

		DB::table( 'users' )->insert( $data );
	}
}
