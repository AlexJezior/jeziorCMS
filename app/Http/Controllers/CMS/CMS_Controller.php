<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class CMS_Controller extends Controller {

	var $plugins = '';
	/*************************************************************************************************************
	 * Create a new controller instance.
	 ************************************************************************************************************/
	public function __construct(){
		$this->middleware('auth');
	}

	/*************************************************************************************************************
	 * Show the Jezior CMS dashboard.
	 * @return View
	 ************************************************************************************************************/
	public function index(){

		return view('auth.interior.home');
	}


	/**************************************************************************************************************
	 * Update the users menu display in the db. Called via ajax.
	 * @param $new_value int bool either 0 or 1. Expanding or collapsing the menu.
	 *************************************************************************************************************/
	public function update_menu($new_value){
		User::where('id', 1)->update(['display_menu' => $new_value]);
	}
}
