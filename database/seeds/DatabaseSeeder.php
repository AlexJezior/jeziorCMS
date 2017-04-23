<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('cms_users')->insert([
		    'name' => 'Alexander Jezior',
		    'email' => 'Alex.Jezior@gmail.com',
		    'password' => '$2y$10$N5VJUFJ3lsTm2bZiSsL9UuQLrqaP2XQlXW7SWgR2w5AYkohIvUrkG',
	         'ip_address' => ''
	    ]);

	    DB::table('cms_plugins')->insert([
		    'title' => 'Pages',
		    'icon' => 'file',
		    'cms_slug' => 'pages',
		    'cms_model' => 'Pages',
		    'cms_permalink' => 'pages',
		    'display' => 1
	    ]);
    }
}
