<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
require_once 'Base.php';
class Schedule extends BaseController {
	
	public function index() {
		$this->load->helper('form');
		$this->load->model('schedule_model');
		
		// siapkan criteria pencarian data schedule
		// di order berdasarkan schedule terbaru (id desc)
		$criteria = [
				'table' => 'schedule',
				'order' => ['id' => 'desc']
		];
		
		$schedules = $this->schedule_model->search($criteria);
		
		// mengambil data visiting type untuk ditampilkan di drowpdown
		$types = [];
		foreach($this->getVisitingTypes() as $obj){
			$types[$obj->title] = $obj->title;
		}
		
		// mengambil data realization untuk ditampilkan di dropdown
		// jika default = 1 maka realization tersebut akan terpilih
		$realizations = [];
		$selectedRealization = '';
		foreach($this->getVisitingRealizations() as $obj){
			$realizations[$obj->title] = $obj->title;
			if($obj->default == 1){
				$selectedRealization = $obj->title;
			}
		}
		
		$data = [ 
				'schedules' => $schedules,
				'types' => $types,
				'realizations' => $realizations,
				'selectedRealization' => $selectedRealization
		];
		
		$this->render('schedule/index', $data);
	}
	
	public function save() {
		// siapkan response yang akan ditampilkan
		// asumsikan saat ini response gagal
		$res = ['status' => 'failed', 'message' => 'Something went wrong'];
		
		// ambil inputan dari form
		$data = [
			'visiting_type' => $this->input->post('visiting_type'),
			'visiting_realization' => $this->input->post('visiting_realization'),
			'venue' => $this->input->post('venue'),
			'start' => $this->input->post('start'),
			'end' => $this->input->post('end'),
			'target' => $this->input->post('target'),
			'result' => $this->input->post('result')
		];
		
		// simpan schedule ke database
		$this->load->model('schedule_model');
		$savedSchedule = $this->schedule_model->insert($data, 'schedule');

		// jika proses penyimpanan berhasil
		if($savedSchedule != null){
			$this->load->model('scheduleemployee_model');
			$this->load->model('scheduleclient_model');
			
			// ambil inputan untuk employees dari form
			$employees = $this->input->post('employees');
			
			// split employee ID berdasarkan comma separator
			$employees = ($employees != '') ? explode(',', $employees) : [];
			
			// simpan ke tabel schedule_employee
			foreach($employees as $k => $v) {
				$de = ['schedule_id' => $savedSchedule->id, 'employee_id' => $v];
				$this->scheduleemployee_model->insert($de, 'schedule_employee');
			}
			
			// ambil inputan untuk client dari form
			$clients = $this->input->post('client');
			
			// splint client ID berdasarkan comma separator
			$clients = ($clients != '') ? explode(',', $clients) : [];
			
			// simpan ke table schedule_client
			foreach($clients as $k => $v) {
				$de = ['schedule_id' => $savedSchedule->id, 'client_id' => $v];
				$this->scheduleemployee_model->insert($de, 'schedule_client');
			}
			
			// set response success
			$res['message'] = 'Save schedule success!';
			$res['status'] = 'success';
			
			// kirim email ke employees dan clients
			$this->sendEmailNotification($savedSchedule, $employees, $clients);
		}
		else{
			$res['message'] = 'Save schedule failed!';
		}
		
		// set header response content type menjadi application/json bukan text/html
		header('Content-type: application/json');
		
		// mengubah array menjadi JSON
		echo json_encode($res);
	}
	
	private function getVisitingTypes(){
		$this->load->model('visitingtype_model');
		
		$criteria = [
				'table' => 'visiting_type',
				'order' => ['id' => 'asc']
		];
		
		return $this->visitingtype_model->search($criteria);
	}
	
	private function getVisitingRealizations(){
		$this->load->model('visitingrealization_model');
		
		$criteria = [
				'table' => 'visiting_realization',
				'order' => ['id' => 'asc']
		];
		
		return $this->visitingtype_model->search($criteria);
	}
	
	private function sendEmailNotification($schedule, $employeIds = [], $clientIds = []){
		$this->load->model('employee_model');
		$whereIn = ['id' => $employeIds];
		$emCriteria = [
				'table' => 'employee',
				'in' => $whereIn
		];
		$employees = $this->employee_model->search($emCriteria);
		
		$this->load->model('client_model');
		$whereIn = ['id' => $clientIds];
		$emCriteria = [
				'table' => 'client',
				'in' => $whereIn
		];
		$clients = $this->employee_model->search($emCriteria);
		
		$c = '';
		foreach($clients as $em){
			$message = 'Dear '.$em->name.', akan ada Kunjungan ' . $schedule->visiting_type . ' dari 
					PT. MUTU AGUNG LESTARI pada ' . $schedule->start . ' s/d ' . $schedule->end . ' di tempat: ' . 
					$schedule->venue;
			$subject = 'Invitation';
			$this->sendEmail($em->email, $message, $subject);
			$c .= $em->name . ', ';
		}		
		
		foreach($employees as $em){
			$message = 'Dear '.$em->full_name.'<br/> Anda di Invite untuk mengikuti Kunjungan ' . 
				$schedule->visiting_type . '<br/> untuk client ' . $c . ' dengan Target' . $schedule->target . 
				' di tempat ' . $schedule->venue;
			
			$subject = 'Invitation';
			$this->sendEmail($em->email, $message, $subject);
		}
	}
	
	public function remove($id) {
		$this->load->model('schedule_model');
		$this->schedule_model->remove(['id' => $id], 'schedule');
		$res = ['status' => 'success', 'message' => 'Schedule has been deleted'];
	
		header('Content-type: application/json');
		echo json_encode($res);
	}
}
