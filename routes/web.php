<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('index');
});

Auth::routes();

//CMS Routes
Route::group(['prefix' => 'jezior-cms', 'namespace' => 'CMS', 'middleware' => 'auth'],function(){
	//INDEX OF THE CMS
	Route::get('/', 'CMS_Controller@index');
	//ALTER LEFT ADMIN MENU DISPLAY. CALLED VIA AJAX IN 'cms.js'
	Route::post('/update-menu/{new_value}', 'CMS_Controller@update_menu');

	//CMS DYNAMIC PLUGINS / !!! THIS WILL CAUSE THE 'php artisan migrate' TO FAIL, COMMENT THIS OUT BEFORE DOING SO !!!
	$plugins = DB::table('cms_plugins')->get();
	foreach($plugins as $plugin){
		//DEFAULT PLUGIN ROUTES
		Route::get('/'.$plugin->cms_permalink, 'CMS_'.$plugin->cms_model.'Controller@plugin_index');
		Route::get('/'.$plugin->cms_permalink.'/modify/{id?}', 'CMS_'.$plugin->cms_model.'Controller@plugin_modify');
		Route::post('/'.$plugin->cms_permalink.'/modify/{id?}', 'CMS_'.$plugin->cms_model.'Controller@plugin_submit');
		Route::get('/'.$plugin->cms_permalink.'/delete/{id?}', 'CMS_'.$plugin->cms_model.'Controller@plugin_delete');
	}
});



//ROUTE ACCESSED BY GUESTS VISITING THE SITE.
Route::get('/{segment}', 'PagesController@fetch_page');


