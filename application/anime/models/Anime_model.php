<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Anime_model extends CI_Model {

	private $tbl;

	public function __construct(){
		parent::__construct();
		$this->tbl = 'anime';
	}

	public function select_by_genre($genre, $start = 0, $limit = 10, $rate = "PG-13"){
		$this->db->select('*');
		$this->db->from($this->tbl);
		$this->db->like('genres', $genre);
		$this->db->where('kode_rate', $rate);
		$this->db->limit($limit, $start);

		return $this->db->get();
	}

	public function select_by_title($title, $start = 0, $limit = 10, $rate = "PG-13"){
		$this->db->select('*');
		$this->db->from($this->tbl);
		$this->db->like('title_anime', $title);
		$this->db->where('kode_rate', $rate);
		$this->db->limit($limit, $start);

		return $this->db->get();
	}

	public function select_all($rate = "PG-13"){
		$this->db->select('*');
		$this->db->from($this->tbl);
		$this->db->where('kode_rate', $rate);

		return $this->db->get();
	}

	public function popular_anime($rate = "PG-13"){
		$this->db->select('*');
		$this->db->from($this->tbl);
		$this->db->where('views >=', 50);
		$this->db->where('kode_rate', $rate);
		$this->db->limit(3, 0);

		return $this->db->get();
	}

	public function select_by_permalink($permalink, $rate = "PG-13"){
		$this->db->select('*');
		$this->db->from($this->tbl);
		$this->db->where('kode_rate', $rate);
		$this->db->where('permalink',$permalink);

		return $this->db->get();
	}
}