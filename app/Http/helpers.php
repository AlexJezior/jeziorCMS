<?php

/*************************************************************************************************************
 * This function builds URL segments provided by the browser.
 * @return array of segments.
 ************************************************************************************************************/
function build_segments(){
	$url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI']: '';
	$url = explode("/",$url);

	foreach($url as $k => $v){
		if(empty($v)){
			unset($url[$k]);
		}
	}

	return array_values($url);
}

/***********************************************************************************************************************
 * Toggles the value that should be in the form field. Parameters are l2r importance.
 * @param $post_value string value of the $_post input
 * @param $item_value string value of the $item
 * @param $default_value string default value
 * @param $return bool return as return, or echo.
 * @return string value that wins the form input!
 **********************************************************************************************************************/
function toggle_value($post_value, $item_value, $default_value = '', $return = true){

	if(!empty($post_value)){
		$answer = $post_value;
	}elseif(!empty($item_value)){
		$answer = $item_value;
	}else{
		$answer = $default_value;
	}

	if($return){
		return $answer;
	}else{
		echo($answer);
	}
}


/***********************************************************************************************************************
 * Toggles the selected state of an HTML element. Parameters are l2r importance.
 * @param $post_value string value of the $_post input
 * @param $item_value string value of the $item
 * @param $value string current input value from where this function is being called.
 * @param $defaulted bool determining if the place in code being called from is the default value if both $post_value
 * and $item_value are empty.
 * @param $verbiage string wording we want to use for selected state.
 * @return string value that wins the form input!
 **********************************************************************************************************************/
function toggle_selected($post_value, $item_value, $value = '', $defaulted = false, $verbiage = "selected"){
	$return = '';

	if(!empty($post_value) && $post_value == $value){
		$return = $verbiage;
	}elseif(!empty($item_value) && $item_value == $value){
		$return = $verbiage;
	}elseif(empty($post_value) && empty($item_value) && $defaulted){
		$return = $verbiage;
	}

	return $return;
}

/***********************************************************************************************************************
 * This function returns an error if a particular form field matches the $validator stipulation.
 *
 * @param $validator string determining how we intend to validate this field.
 * @param $field string fields value we are checking against.
 * @param $message string we will display upon error.
 *
 * @return string|array
 **********************************************************************************************************************/
function form_rule($validator, $field, $message){

	if($validator == "empty"){
		if(empty($field)){
			$return = array('error' => true,'message' => $message);
			return $return;
		}
	}

	return '';
}

/***********************************************************************************************************************
 * This function can checks for errors, or spit out the errors, upon request.
 *
 * @param $rules array of all the potential errors.
 * @param bool $output for whether we're requesting the bool status of potential errors, or string message of errors.
 *
 * @return bool|string
 **********************************************************************************************************************/
function form_errors($rules, $output = false){
	$has_error = false;
	$messages = '';

	foreach($rules as $rule){
		if(isset($rule['error'])){
			$has_error = true;
			$messages[] = $rule['message'];
		}
	}

	if(!$output){
		return $has_error;
	}else{
		return $messages;
	}

}
