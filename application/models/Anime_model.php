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
		if($limit != false):
			$this->db->limit($limit, $start);
		endif;
		$this->db->order_by("title_anime", "ASC");

		return $this->db->get();
	}

	public function record_count($genre, $rate = "PG-13") {
		$this->db->select('*');
		$this->db->from($this->tbl);
		$this->db->like('genres', $genre);
		if($rate != null):
			$this->db->where('kode_rate', $rate);
		endif;

        return $this->db->get()->num_rows();
    }

	public function select_by_title($title, $start = 0, $limit = 10, $rate = "PG-13"){
		$this->db->select('*');
		$this->db->from($this->tbl);
		$this->db->like('title_anime', $title);
		$this->db->or_like('genres', $title);
		$this->db->or_like('synopsis', $title);
		$this->db->where('kode_rate', $rate);
		$this->db->limit($limit, $start);

		return $this->db->get();
	}

	public function select_all($start = 0, $limit = null, $rate = "PG-13"){
		$this->db->select('*');
		$this->db->from($this->tbl);
		if($limit != null):
			$this->db->limit($limit, $start);
		endif;
		if($rate != null):
			$this->db->where('kode_rate', $rate);
		endif;
		$this->db->order_by('idanime', "DESC");

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

	public function count_anime(){
		$this->db->select('*');
		$this->db->from($this->tbl);

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
