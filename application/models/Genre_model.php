<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Genre_model extends CI_Model {
	
	private $tbl = 'genres';

	public function __construct(){
		parent::__construct();
	}

	public function select_by_permalink($permalink, $start = 0, $limit = 6){
		$this->db->select('*');
		$this->db->from($this->tbl);
		$this->db->where('namegenre', $permalink);
		$this->db->limit($limit, $start);

		return $this->db->get();
	}

	public function select_like($genre, $start = 0, $limit = 6){
		$this->db->select('*');
		$this->db->from($this->tbl);
		$this->db->like('namegenre', $genre);
		$this->db->limit($limit, $start);

		return $this->db->get();
	}

	public function select_all(){
		$this->db->select('*');
		$this->db->from($this->tbl);

		return $this->db->get();
	}
}