<?php

abstract class PHPIO_Log {
	var $save_dir = '';
	var $logs = array();
	var $start = true;

	function append($value) {
		if ($this->start) {
			$this->logs[] = $value;
		}
	}

	function count() {
		return count($this->logs);
	}

	function stop() {
		if ( function_exists('fastcgi_finish_request') ) {
			fastcgi_finish_request();
		}

		restore_exception_handler();
		restore_error_handler();

		ini_set("aop.enable","0");

		$last_error = error_get_last();
		if ( is_array($last_error) ) {
			call_user_func_array(array(PHPIO::$hooks['Error'], '_error_handler'), $last_error);
		}
	
		$this->start = false;
	}

	function getURI($info) {
		return isset($info['DOCUMENT_URI']) ? $info['DOCUMENT_URI'] : $info['SCRIPT_NAME'];
	}

	function save() {}
	function getProfiles() {}
	function getProfile($profile_id) {}
	function getSource($file) {}
	function getFlow($root_profile_id){}
	function getCurlHeader($curl_id){}

}