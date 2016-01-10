<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Counter_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function count_table($tblName){
		$this->db->from($tblName);
		return $this->db->count_all_results();
	}
}
