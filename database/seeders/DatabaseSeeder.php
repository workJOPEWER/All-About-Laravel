<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call( UsersTableSeeder::class );
		$this->call( BlogCategoriesTablesSeeder::class );
		BlogPost::factory()->count(100)->create();
	}
}
