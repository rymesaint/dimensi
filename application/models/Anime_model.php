<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Anime_model extends CI_Model {

	private $tbl; // Define variable for table

	/**
	 * Store table name @tbl
	 */
	public function __construct(){
		parent::__construct();
		$this->tbl = 'anime';
	}

	/**
	 * Function save_anime($data)
	 *
	 * Insert data anime into database
	 *
	 * Parameters:
	 * @data (Array)
	 */
	public function save_anime($data){
		$this->db->insert($this->tbl, $data);
	}

	/**
	 * Function update_anime($data, $id)
	 *
	 * Update data anime with selected @id to database
	 *
	 * Parameters:
	 * @data (Array)
	 * @id (int)
	 */
	public function update_anime($data, $id){
		$this->db->where('idanime', $id);
		$this->db->update($this->tbl, $data);
	}

	/**
	 * Function delete_anime($id)
	 *
	 * Delete anime from selected @id in database
	 *
	 * Parameters:
	 * @id (int)
	 */
	public function delete_anime($id){
		$this->db->where('idanime', $id);
		$this->db->delete($this->tbl);
	}

	/**
	 * Function select_by_genre($genre, $start, $limit, $rate)
	 *
	 * Show anime based on @genre from database
	 *
	 * Parameters:
	 * @genre (String)
	 * @start (int)
	 * @limit (int)
	 * @rate (String)
	 */
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

	/**
	 * Function record_count($genre)
	 *
	 * Count all anime based on @genre
	 *
	 * Parameters:
	 * @genre (String)
	 *
	 * return @num_rows (int)
	 */
	public function record_count($genre) {
		$this->db->select('*');
		$this->db->from($this->tbl);
		$this->db->like('genres', $genre);

        return $this->db->get()->num_rows();
    }

    /**
     * Function select_by_title($title, $start, $limit, $rate)
     *
     * Show anime information with matching title
     * Used to searching form
     *
     * Parameters:
     * @title (String)
     * @start (int)
     * @limit (int)
     * @rate (String)
     *
     * return @get (Object)
     */
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

	/**
	 * Function select_all($start, $limit, $search, $orderBy)
	 *
	 * Show all anime
	 *
	 * Parameters:
	 * @start (int)
	 * @limit (int) limit data
	 * @search (Array) When you have a condition to apply
	 * have 3 conditions :
	 *   .normal : When you have a normal condition
	 *   .like 	 : When you have a searching condition
	 *   .combination : When you have a normal condition but more like
	 * @orderBy (Array) Ordering option
	 * have 2 conditions:
	 *   .DESC : Descending data
	 *   .ASC : Ascending Data
	 *
	 * return @get (Object)
	 */
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

	/**
	 * Function popular_anime($rate)
	 *
	 * Show popular anime within more than 50 views
	 *
	 * Parameters:
	 * @rate (String)
	 *
	 * return @get (Object)
	 */
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

	/**
	 * Function count_anime()
	 *
	 * Count all data from table
	 *
	 * return @get (Object)
	 */
	public function count_anime(){
		$this->db->select('*');
		$this->db->from($this->tbl);

		return $this->db->get();
	}

	/**
	 * Function count_all()
	 *
	 * Count all data from table
	 *
	 * return @count_all (int)
	 */
	public function count_all(){
		return $this->db->count_all($this->tbl);
	}

	/**
	 * Function select_by_id($permalink)
	 * 
	 * Show anime by selected @permalink
	 *
	 * Parameters:
	 * @permalink (String)
	 *
	 * return @get (Object)
	 */
	public function select_by_id($permalink){
		$this->db->select('*');
		$this->db->from($this->tbl);
		$this->db->where('idanime',$permalink);

		return $this->db->get();
	}

	/**
	 * Function select_by_permalink($permalink, $rate)
	 *
	 * Show selected anime data with matching @permalink from database
	 *
	 * Parameters:
	 * @permalink (String)
	 * @rate (String)
	 *
	 * return @get (Object)
	 */
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
