<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Anime_model extends CI_Model {

	private $tbl;

	public function __construct(){
		parent::__construct();
		$this->tbl = 'anime';
	}

	public function save_anime($data){
		$this->db->insert($this->tbl, $data);
	}

	public function update_anime($data, $id){
		$this->db->where('idanime', $id);
		$this->db->update($this->tbl, $data);
	}

	public function delete_anime($id){
		$this->db->where('idanime', $id);
		$this->db->delete($this->tbl);
	}

	public function select_by_genre($genre, $start = 0, $limit = 10, $rate = null){
		$this->db->select('*');
		$this->db->from($this->tbl);
		$this->db->like('genres', $genre);
		if($rate != null):
			$this->db->where('kode_rate', $rate);
		endif;
		if($limit != false):
			$this->db->limit($limit, $start);
		endif;
		$this->db->order_by("title_anime", "ASC");

		return $this->db->get();
	}

	public function record_count($genre) {
		$this->db->select('*');
		$this->db->from($this->tbl);
		$this->db->like('genres', $genre);

        return $this->db->get()->num_rows();
    }

	public function select_by_title($title, $start = 0, $limit = 10, $rate =null){
		$this->db->select('*');
		$this->db->from($this->tbl);
		$this->db->like('title_anime', $title);
		if($rate != null):
			$this->db->where('kode_rate', $rate);
		endif;
		$this->db->or_like('genres', $title);
		$this->db->or_like('synopsis', $title);
		$this->db->limit($limit, $start);

		return $this->db->get();
	}

	public function select_all($start = 0, $limit = null, $search = array("search_type" => "null"), $orderBy = array('order'=>'idanime', 'type'=>'DESC')){
		$this->db->select('*');
		$this->db->from($this->tbl);
		if($limit != null):
			$this->db->limit($limit, $start);
		endif;

		if($search['search_type'] != null):
			switch ($search['search_type']):
				case'normal':
				$this->db->where($search['cond_value']);
				break;
				case 'like':
				$this->db->like($search['column'], $search['value']);
				break;
				case 'combination';
				$this->db->where($search['condition_column'], $search['cond_value']);
				$this->db->or_like($search['column'], $search['value']);
				break;
			endswitch;
		endif;

		switch($orderBy['type']):
			case'DESC':
			$this->db->order_by($orderBy['order'], 'DESC');
			break;
			case'ASC':
			$this->db->order_by($orderBy['order'], 'ASC');
			break;
		endswitch;

		return $this->db->get();
	}

	public function popular_anime($rate = null){
		$this->db->select('*');
		$this->db->from($this->tbl);
		$this->db->where('views >=', 50);
		if($rate != null):
			$this->db->where('kode_rate', $rate);
		endif;
		$this->db->limit(3, 0);

		return $this->db->get();
	}

	public function count_anime(){
		$this->db->select('*');
		$this->db->from($this->tbl);

		return $this->db->get();
	}

	public function count_all(){
		return $this->db->count_all($this->tbl);
	}

	public function select_by_id($permalink){
		$this->db->select('*');
		$this->db->from($this->tbl);
		$this->db->where('idanime',$permalink);

		return $this->db->get();
	}

	public function select_by_permalink($permalink, $rate = null){
		$this->db->select('*');
		$this->db->from($this->tbl);
		if($rate != null):
			$this->db->where('kode_rate', $rate);
		endif;
		$this->db->where('permalink',$permalink);

		return $this->db->get();
	}
}
