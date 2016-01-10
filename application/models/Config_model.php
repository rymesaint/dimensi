<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Config_model extends CI_Model {
	
	private $table = 'config';

	public function __construct(){
		parent::__construct();
	}

	public function select_all(){
		$this->db->select('*');
		$this->db->from($this->table);

		return $this->db->get();
	}

	public function select_by_function($function){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('function',$function);

		return $this->db->get();
	}

	public function select_all_paging($limit=array()){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->order_by('idconfig','desc');
			if($limit != NULL)
				$this->db->limit($limit['perpage'], $limit['offset']);
		return $this->db->get();
	}
}