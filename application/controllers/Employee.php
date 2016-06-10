<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base.php';

class Employee extends BaseController {

	public function index()
	{
		$this->load->helper('form');
		$this->load->model('employee_model');
		
		$criteria = [
				'table' => 'employee',
				'order' => ['id' => 'desc']
		];
		$employess = $this->employee_model->search($criteria);
		
		$data = ['employees' => $employess];
		$this->render('employee/index', $data);
	}
	
	/**
	 * Menyimpan data employee, jika data sudah ada, 
	 * maka akan diupdate, jika tidak, akan di insert
	 */
	public function save(){
		$this->load->model('employee_model');

		$id = $this->input->post('id');
		
		// load library form_validation Codeigniter
		$this->load->library('form_validation');

		// jika create employee
		if($id == ''){
			// Set rules untuk validation, dimana
			// NIK harus diisi (required), min dan max karakter harus 7 (min_length, max_length)
			// NIK harus bersifat unique (is_unique) terhadap table employee kolom nik 
			$this->form_validation->set_rules('nik', 'NIK', 'required|min_length[7]|max_length[7]|is_unique[employee.nik]', [
					'required' => 'NIK tidak boleh dikosongkan!',
					'is_unique' => 'NIK sudah terdaftar!',
					'min_length' => 'Panjang Karakter NIK harus 7!',
					'max_length' => 'Panjang Karakter NIK harus 7!'
			]);
			
			// Set rules untuk validation email harus diisi (required),
			// email harus unique (is_unique) terhadap tabel employee kolom email
			// email harus menggunakan format email yang valid (valid_email)
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[employee.email]', [
					'required' => 'Email harus diisi!',
					'is_unique' => 'Email sudah digunakan!',
					'valid_email' => 'Format email salah!'
			]);
		}
		
		// jika update employee
		else{
			// Set rules untuk validation, dimana
			// NIK harus diisi (required), min dan max karakter harus 7 (min_length, max_length)
			$this->form_validation->set_rules('nik', 'NIK', 'required|min_length[7]|max_length[7]', [
					'required' => 'NIK tidak boleh dikosongkan!',
					'min_length' => 'Panjang Karakter NIK harus 7!',
					'max_length' => 'Panjang Karakter NIK harus 7!'
			]);
			
			// Set rules untuk validation email harus diisi (required),
			// email harus menggunakan format email yang valid (valid_email)
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email', [
					'required' => 'Email harus diisi!',
					'valid_email' => 'Format email salah!'
			]);
		}
		
		// Set rules untuk validation full name harus diisi (required)
		$this->form_validation->set_rules('full-name', 'Full Name', 'required', [
				'required' => 'Nama Lengkap harus diisi'
		]);
		
		$data = [
				'nik' => $this->input->post('nik'),
				'full_name' =>$this->input->post('full-name'),
				'email' => $this->input->post('email'),
				'occupation' => $this->input->post('occupation')
		];
		
		// lakukan validasi berdasarkan rules yang telah 
		// didefinisikan diatas, jika TRUE maka akan melakukan penyimpanan employee
		if($this->form_validation->run() != FALSE) {
			$employee = null;
			
			// id empty, menandakan ini adalah data employee baru
			if($id == ''){
				$employee = $this->employee_model->insert($data, 'employee');
			}
			
			// id sudah terisi, menandakan ini adalah data existing employee
			else{
				$data['id'] = $id;
				$employee = $this->employee_model->update($data, 'employee');
			}
	
			$res = [
					'status' => 'success',
					'message' => 'Employee has been saved!',
					'employee' => $employee
			];
		}
		else{
			$err = str_replace('<p>', '', validation_errors());
			$err = str_replace('</p>', '', $err);
			$res = [
					'status' => 'failed',
					'message' => $err,
			];
		}
		
		header('Content-type: application/json');
		echo json_encode($res);
	}
	
	public function modify($id) {
		$this->load->helper('form');
		$this->load->model('employee_model');
		$employee = $this->employee_model->getOne($id, 'employee');
		header('Content-type: application/json');
		echo json_encode($employee);
	}
	
	public function remove($id) {
		$this->load->model('employee_model');
		$this->employee_model->remove(['id' => $id], 'employee');
		$res = ['status' => 'success', 'message' => 'Employee has been removed!'];
		
		header('Content-type: application/json');
		echo json_encode($res);
	}
}