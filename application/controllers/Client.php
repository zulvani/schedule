<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base.php';

class Client extends BaseController {

	public function index()
	{
		$this->load->helper('form');
		$this->load->model('client_model');
		
		$criteria = [
				'table' => 'client',
				'order' => ['id' => 'desc']
		];
		$employess = $this->client_model->search($criteria);
		
		$data = ['clients' => $employess];
		$this->render('client/index', $data);
	}
	
	/**
	 * Menyimpan data employee, jika data sudah ada, 
	 * maka akan diupdate, jika tidak, akan di insert
	 */
	public function save(){
		$this->load->model('client_model');
		
		$data = [
				'name' =>$this->input->post('name'),
				'email' => $this->input->post('email'),
				'address' => $this->input->post('address')
		];
		
		$id = $this->input->post('id');
		$client = null;
		
		// id empty, menandakan ini adalah data employee baru
		if($id == ''){
			$client = $this->client_model->insert($data, 'client');
		}
		
		// id sudah terisi, menandakan ini adalah data existing employee
		else{
			$data['id'] = $id;
			$employee = $this->client_model->update($data, 'client');
		}

		$res = [
				'status' => 'success',
				'message' => 'Client has been saved!',
				'employee' => $client
		];
		
		header('Content-type: application/json');
		echo json_encode($res);
	}
	
	public function modify($id) {
		$this->load->helper('form');
		$this->load->model('client_model');
		$client = $this->client_model->getOne($id, 'client');
		header('Content-type: application/json');
		echo json_encode($client);
	}
	
	public function remove($id) {
		$this->load->model('client_model');
		$this->client_model->remove(['id' => $id], 'client');
		$res = ['status' => 'success', 'message' => 'Client has been removed!'];
		
		header('Content-type: application/json');
		echo json_encode($res);
	}
}