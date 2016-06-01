<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base.php';

class Welcome extends BaseController {

	public function index()
	{
		$this->render('home', []);
	}
}
