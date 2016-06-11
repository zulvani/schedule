<?php
require_once 'Base_model.php';

class Schedule_model extends Base_model {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function advanceSearch($criteria) {
		$query = 'select * from schedule';
		
		$where = '';
		if(isset($criteria['period'])){
			$where .= 'start >= "' . $criteria['period']['start'] .'" and end <= "' . $criteria['period']['end'] .'"';
		}
		
		if($where != ''){
			$query .= ' where ' . $where;
		}
		
		$query = $this->db->query($query);
		return $query->result();
	}
}