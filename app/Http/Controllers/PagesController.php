<?php

namespace App\Http\Controllers;

use App\Pages;

class PagesController extends Controller
{

	public function fetch_page($segment){
		$page = Pages::where('permalink',$segment)->first();

		if(!empty($page)){
			return view('interior', ['page' => $page]);
		}else{
			return view('index');
		}
	}

}
