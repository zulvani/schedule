<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseController extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function render($view, $data = [], $layout = 'default') {
		$dataHeader = [
				'b' => $this->config->base_url(),
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