<?php

namespace App\Http\Controllers\CMS;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use \App\Pages;

class CMS_PagesController extends CMS_Controller {

	var $plugin, $model, $message = '';
	var                  $error   = FALSE;


	/******************************************************************************************************************
	 * CMS_PagesController constructor.
	 *****************************************************************************************************************/
	public function __construct(){
		$this->model  = 'Pages';
		$this->plugin = DB::table('cms_plugins')->where('cms_model', $this->model)->first();

		if (empty($this->plugin)){
			return view('auth.interior.home');
		}
	}


	/******************************************************************************************************************
	 * This function determines the index of a CMS plugin.
	 * @return View
	 *****************************************************************************************************************/
	public function plugin_index(){
		$plugin = $this->plugin;
		$all_data = Pages::all();
		//$plugins = DB::table('cms_plugins')->orderBy('display')->get();

		return view('auth.interior.plugins.' . $plugin->cms_slug . '.index', [$plugin->cms_slug => $all_data/*, 'plugins' => $plugins*/]);
	}


	/******************************************************************************************************************
	 * This function returns the form view of a plugin.
	 * @param $item_id          integer associated
	 * @return View
	 *****************************************************************************************************************/
	public function plugin_modify($item_id = 0){
		$plugin = $this->plugin;
		$singular = $item_id != 0 ? Pages::where('id', $item_id)->first() : '';
		$plural = Pages::where(['parent_id' => 0, 'type' => 'master'])->get();

		return view('auth.interior.plugins.' . $plugin->cms_slug . '.form', ['item' => $singular, 'pages' => $plural]);
	}


	/******************************************************************************************************************
	 * This function handles the submission process for a plugin form.
	 * @param int $item_id
	 * @return \Illuminate\Support\Facades\View
	 * @internal param \Illuminate\Http\Request $request
	 *****************************************************************************************************************/
	public function plugin_submit($item_id = 0){
		$plugin = $this->plugin;
		$posted = $_POST;
		$status = "error";

		//BE form rules.
		$this->error[] = form_rule("empty", $posted['title'], "You must provided a title to save a page.");
		$this->error[] = form_rule("empty", $posted['permalink'], "You must provided a permalink to save a page.");
		$this->error[] = form_rule("empty", $posted['content'], "You must provided content to save a page.");

		//Process form rules
		if (!form_errors($this->error)){
			$existing_permalink = $item_id == 0 ? Pages::where('permalink', $posted['permalink'])->first() : '';
			if(!empty($existing_permalink)){
				$maxPageId = DB::table('plugin_pages')->max('id');
				$posted['permalink'] = $posted['permalink'] . ($maxPageId + 1);
			}

			//Find existing item
			$existing_item = Pages::find($item_id);
			//Did item exist, or do we need to build it?
			$item          = !empty($existing_item) ? $existing_item : new Pages;

			//Parent id does not exist when Orphan Page Type is checked.
			$posted['parent_id'] = isset($posted['parent_id']) ? $posted['parent_id']: 0;
			//Remove the $_POST fields we no longer need.
			array_forget($posted, array("_token", "image"));

			foreach ($posted as $k => $v){
				$item->$k = $v;
			}

			$item->save();
			$status          = "success";
			$this->message[] = "Item saved successfully.";
		} else {
			$this->message = form_errors($this->error, TRUE);
		}

		//Determine overall status to figure out our next route.
		if($status == "success"){
			$segments = build_segments();
			return redirect($segments[0].'/'.$segments[1])->with(['status'   => $status, 'messages' => $this->message]);
		}else{
			return view('auth.interior.plugins.' . $plugin->cms_slug . '.form', ['status'   => $status, 'messages' => $this->message]);
		}
	}


	/******************************************************************************************************************
	 * This function deletes a plugin item by its id.
	 * @param $item_id integer associated to an item.
	 * @return \Illuminate\Http\RedirectResponse
	 *****************************************************************************************************************/
	public function plugin_delete($item_id){
		Pages::destroy($item_id);
		$status          = "success";
		$this->message[] = "Item removed successfully.";
		$segments = build_segments();
		return redirect($segments[0].'/'.$segments[1])->with(['status'   => $status, 'messages' => $this->message]);
	}

}