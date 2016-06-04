<?php
class Base_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		
		// load database
		$this->load->database();
	}
	
	/**
	 * Melakukan pencarian data 
	 * @param $criteria criteria dan speisifkasi pencarian, ada beberapa required criteria yaitu
	 * 
	 *  - table, mendifinisikan dari tabel mana data akan dicari
	 *  
	 * Sedangkan beberapa criteria lainnya yaitu
	 * 
	 *  - fields, kolom apa saja yang akan diambil
	 *  - where, kondisi dalam melakukan filter data dengan menggunakan operator EQUAL
	 *  - like, kondisi dalam melakukan filter data dengan menggunakan operator LIKE
	 *  - order, spesifikasi pengurutan data
	 *  - limit, jumlah data yang akan diambil
	 *  - offset, index baris pengambilan data akan dimulai
	 * 
	 */
	public function search($criteria = []){
		$fields = isset($criteria['fields']) ? $criteria['fields'] : '*';
		$table = $criteria['table'];
		$where = isset($criteria['where']) ? $criteria['where'] : [];
		
		$this->db->select($fields);
		
		if(isset($criteria['like'])){
			foreach($criteria['like'] as $k => $v){
				$this->db->like($k, $v);
			}
		}
		
		if(isset($criteria['order'])){
			foreach($criteria['order'] as $k => $v){
				$this->db->order_by($k, $v);
			}
		}
		
		if(isset($criteria['limit'])){
			$limit = $criteria['limit'];
			$offset = $criteria['offset'];
			
			$query = $this->db->get_where($table, $where, $offset, $limit);
		}
		else{
			$query = $this->db->get_where($table, $where);
		}
		
		return $query->result();
	}
	
	/**
	 * Mengambil data/object tertentu menggunakan id
	 */
	public function getOne($id, $table){
		$q = $this->db->get_where($table, ['id' => $id]);
		foreach($q->result() as $obj){
			return $obj;
		}
		
		return null;
	}
	
	public function insert($data = [], $table){
		if(!isset($data['created'])){
			$data['created'] = date('Y-m-d H:i:s');
		}
		$this->db->insert($table, $data);
		return $this->getOne($this->db->insert_id(), $table);
	}
	
	public function update($data = [], $table){
		if(!isset($data['modified'])){
			$data['modified'] = date('Y-m-d H:i:s');
		}
		$this->db->where('id', $data['id']);
		$this->db->update($table, $data);
		return $this->getOne($data['id'], $table);		
	}
	
	public function remove($where = [], $table) {
		foreach($where as $k => $v){
			$this->db->where($k, $v);
		}
		$this->db->delete($table);
	}
}