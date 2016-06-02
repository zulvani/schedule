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
}
?>