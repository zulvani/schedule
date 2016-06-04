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
		
		$data = [
				'nik' => $this->input->post('nik'),
				'full_name' =>$this->input->post('full-name'),
				'email' => $this->input->post('email'),
				'occupation' => $this->input->post('occupation')
		];
		
		$id = $this->input->post('id');
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