<?php
class Operator_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		
		// load database
		$this->load->database();
	}
	
	public function signIn($username, $password) {
		
		// membedakan apakah username adalah nick atau email
		$w = (filter_var($username, FILTER_VALIDATE_EMAIL) !== false) ? 'email="'.$username.'"' : 'nick="'.$username.'"';
		
		// query ke database
		$q = $this->db->query('select id, email, nick, password from operator where ' . $w);
		
		// pemeriksaan kebenaran password
		$operator = null;
		foreach($q->result() as $op){
			if($op->password === MD5($password)){
				$operator = $op;
			}
		}
		
		return $operator; 
	}
}