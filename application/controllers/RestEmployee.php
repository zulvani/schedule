<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
require_once 'Base.php';

class RestEmployee extends BaseController {
	
	public function index($id = '') {
		$this->load->model('employee_model');
		$res = [];
		
		if($id != ''){
			$res = $this->employee_model->getOne($id, 'employee');
		}
		else{
			$criteria = ['table' => 'employee'];
			
			if(isset($_GET['nik'])){
				$criteria['where'] = ['nik' => $_GET['nik']];
			}
			
			if(isset($_GET['full_name'])){
				$criteria['like'] = ['full_name' => $_GET['full_name']];
			}
			
			$res = $this->employee_model->search($criteria);
		}
		
		header('Content-type: application/json');
		echo json_encode($res);
	}
	
	public function create() {
		$this->load->model('employee_model');
		$res = ['status' => 'failed', 'message' => '', 'data' => []];
		
		if(isset($_POST['nik']) && isset($_POST['full_name']) && isset($_POST['email'])){
			$data = [
					'nik' => $_POST['nik'],
					'full_name' => $_POST['full_name'],
					'email' => $_POST['email'],
			];
			
			$data['occupation'] = (isset($_POST['occupation'])) ? $_POST['occupation'] : '';
			$employee = $this->employee_model->insert($data, 'employee');
			
			if($employee != null){
				$res['status'] = 'success';
				$res['message'] = 'Employee has been saved successfully!';
				$res['data'] = $employee;
			}
			else{
				$res['message'] = 'Something went wrong!';
			}
		}
		else{
			$res['message'] = 'Please define NIK, Full Name and Email';
		}
		
		header('Content-type: application/json');
		echo json_encode($res);
	}
	
	public function modify() {
		$this->load->model('employee_model');
		$res = ['status' => 'failed', 'message' => '', 'data' => []];
		
		if(isset($_POST['id'])){
			$data = ['id' => $_POST['id']];
			
			$data['email'] = (isset($_POST['email'])) ? $_POST['email'] : '';
			$data['full_name'] = (isset($_POST['full_name'])) ? $_POST['full_name'] : '';
			$data['occupation'] = (isset($_POST['occupation'])) ? $_POST['occupation'] : '';
			$employee = $this->employee_model->update($data, 'employee');
			
			if($employee != null){
				$res['status'] = 'success';
				$res['message'] = 'Employee has been saved successfully!';
				$res['data'] = $employee;
			}
			else{
				$res['message'] = 'Something went wrong!';
			}
		}
		else{
			$res['message'] = 'Please define Employee ID';
		}
		
		header('Content-type: application/json');
		echo json_encode($res);
	}
	
	public function delete() {
		$this->load->model('employee_model');
		$res = ['status' => 'failed', 'message' => ''];
		
		if(isset($_POST['id'])){
			$data = ['id' => $_POST['id']];
			$employee = $this->employee_model->remove($data, 'employee');
					
			$res['status'] = 'success';
			$res['message'] = 'Employee has been deleted successfully!';
		}
		else{
			$res['message'] = 'Please define Employee ID';
		}
		header('Content-type: application/json');
		echo json_encode($res);
	}
}
