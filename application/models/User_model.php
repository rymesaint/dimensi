<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model {

	private $tbl;

	public function __construct(){
		parent::__construct();
		$this->tbl = 'users';
	}

	public function countUsers(){
		$this->db->select('iduser');
		$this->db->from($this->tbl);
		$this->db->where('groupid != 5');

		return $this->db->get()->num_rows();
	}

	public function getUser($user){
		$this->db->select('*');
		$this->db->from($this->tbl);
		$this->db->where('username', $user);
		$this->db->or_where('iduser', $user);

		return $this->db->get();
	}
}