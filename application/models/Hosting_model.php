<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Hosting_model extends CI_Model {

	private $tbl;

	public function __construct(){
		parent::__construct();
		$this->tbl = 'videohosting';
	}

	public function select_all($state = null){
		$this->db->select('*');
		$this->db->from($this->tbl);

		if($state != null):
			$this->db->where($state);
		endif;

		return $this->db->get();
	}

	public function checkHosting($hosting){
		$this->db->select('status_streaming');
		$this->db->from($this->tbl);
		$this->db->where('namahosting', $hosting);

		return $this->db->get();
	}
}