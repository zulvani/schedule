<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base.php';

class Welcome extends BaseController {

	public function index()
	{
		// periksa, apakah operator sebelumnya sudah login dan session nya masih aktif atau tidak
		// jika masih aktif akan langsung direct ke halaman home
		if($this->isSignedIn()){
			$this->render('home');
		}
		else{
			// load helper form
			$this->load->helper('form');
			$data = [];
			
			// mengambil data dari input HTML form dengan method POST
			$username = $this->input->post('username');
			$password = $this->input->post('password');
	
			// jika username dan password tidak kosong, maka user
			// melakukan click tombol Submit dari halaman sign in
			if($username != '' && $password != ''){
				
				// load operator model
				$this->load->model('operator_model');
				
				// pemeriksaan username dan password ke database
				$op = $this->operator_model->signin($username, $password);
				
				// jika username dan password valid
				if($op != null){
					
					// load session
					// kita akan menggunakan session untuk menyimpan data operator yang 
					// berhasil sign in
					$this->load->library('session');
					
					// mempersiapkan data operator yang akan disimpan ke session
					$validUser = [
							'email' => $op->email,
							'nick' => $op->nick,
							'signinTime' => date('Y-m-d H:i:s')
					];
					
					// simpan data operator ke session
					foreach($validUser as $k => $v){
						$this->session->set_tempdata($k, $v, 1800);
					}
					
					// direct ke halaman home
					$this->render('home');
					return;
				}
				else{
					$data['message'] = 'Invalid username and/or password!';
				}
			}
			
			$this->load->view('signin', $data);
		}
	}
	
	public function logout() {
		$this->load->library('session');
		$this->load->helper('form');
		
		// hapus session operator
		unset($_SESSION['email']);
		unset($_SESSION['nick']);
		unset($_SESSION['signinTime']);
		
		// direct ke halaman sign in
		$this->load->view('signin', ['logout' => true]);
	}
	
	public function signedin() {
		$this->load->library('session');
			
		$validUser = [
				'email'=> $_GET['email'],
				'nick' => $_GET['name'],
				'signinTime' => date('Y-m-d H:i:s')
		];
			
		foreach($validUser as $k => $v){
			$this->session->set_tempdata($k, $v, 1800);
		}
			
		$this->render('home');
	}
}