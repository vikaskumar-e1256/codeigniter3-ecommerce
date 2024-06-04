<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('isAdminLoggedIn')) {
	function isAdminLoggedIn()
	{
		$CI = &get_instance();
		$auth = $CI->session->userdata('auth');
		return isset($auth) && $auth['logged_in'] && $auth['is_admin'];
	}
}
