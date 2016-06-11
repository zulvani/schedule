<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseController extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	protected function isSignedIn(){
		$this->load->library('session');
		$signedInEmail = $this->session->tempdata('email');
	
		return $signedInEmail != '';
	}
	
	public function render($view, $data = [], $layout = 'default') {
		$this->load->helper('form');
		$this->load->library('session');
		$nick = $this->session->tempdata('nick');
		$dataHeader = [
				'b' => $this->config->base_url(),
				'nick' => $nick,
		];
		$dataFooter = [
				'b' => $this->config->base_url(),
		];
		$this->load->view('layout/default_header', $dataHeader);
		$this->load->view($view, $data);
		$this->load->view('layout/default_footer', $dataFooter);
	}
	
	function sendEmail($to, $message, $subject, 
			$sender_email = 'no-reply@gmail.com', $sender_name = 'PT. MAL', $debug_mode = false){
		$sent = false;
		
		# load email library
		$this->load->library("email");
	
		$this->email->from($sender_email, $sender_name);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		$sent = $this->email->send();
			
		if($debug_mode){
			echo $this->email->print_debugger();
		}
	
		return $sent;
	}
}
?>