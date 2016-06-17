<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
require_once 'Base.php';
class RestEmployee extends BaseController {
	
	private function invoke($Url, $data = [], $method = 'GET') {
		// apakah cURL sudah diinstall?
		if (! function_exists ( 'curl_init' )) {
			die ( 'Sorry cURL is not installed!' );
		}
		
		$ch = curl_init();
		
		// Set URL
		curl_setopt ( $ch, CURLOPT_URL, $Url );
		
		// Include header in result? (0 = yes, 1 = no)
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		
		// binding parameters
		$params = '';
		foreach($data as $k => $v) {
			$params .= $k . '=' . $v;
			$params .= '&';
		}
		$params = substr($params, 0, strlen($params) - 1);
		
		// set method
		if($method == 'POST') {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		}
		else if($method == 'GET'){
			$Url .= '?' . $params;
		}
		
		// Should cURL return or print out the data? (true = return, false = print)
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		
		// Timeout
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 10 );
		
		$output = curl_exec ( $ch );
		curl_close ( $ch );
		
		return $output;
	}
	
	public function index() {
		$employees = $this->invoke('http://kis.local/schedule/index.php/api/v1/employee');
		$employees = json_decode($employees);
		
		foreach($employees as $e){
			echo $e->full_name . '<br/>';
		}
	}
	
	public function create() {
		$data = ['nik' => '6304991', 'email' => 'japri@gmail.com', 'full_name'=> 'Jalur Pribadi', 'occupation'=>'Staff'];
		$res = $this->invoke('http://kis.local/schedule/index.php/api/v1/employee/create', $data, 'POST');
		$res = json_decode($res);
		if($res->status == 'success'){
			print_r($res->data);
		}
		else{
			echo $res->message;
		}
	}
}