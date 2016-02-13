<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Episode_model extends CI_Model {

	private $tbl; // Define variable for table

	/**
	 * Store table name @tbl
	 */
	public function __construct(){
		parent::__construct();
		$this->tbl = 'episodes';
	}

	/**
	 * Function set_episode($data)
	 *
	 * Insert data episode anime into database
	 *
	 * Parameters:
	 * @data (Array)
	 */
	public function set_episode($data){
		$this->db->insert($this->tbl, $data);
	}

	/**
	 * Function select_all($limit, $start, $state)
	 *
	 * Show all episode anime
	 *
	 * Parameters:
	 * @start (int)
	 * @limit (int) limit data
	 * @state (String) Making condition
	 *
	 * return @get (Object)
	 */
	public function select_all($limit = 4, $start = 0, $state = false){
		$this->db->select('idepisode, namahosting, anime.idanime,title_anime,views,username,subname,permalink,image,synopsis,episode,date_added,filesize,hashcode,parentid,sourcevideo');
		$this->db->from($this->tbl);

		$this->db->join('anime', 'anime.idanime=episodes.idanime', 'inner');
		$this->db->join('users', 'users.iduser=episodes.iduser', 'inner');
		$this->db->join('subs', 'subs.idsub=episodes.idsub','inner');
		$this->db->join('videohosting', 'videohosting.idhosting=episodes.sourcevideo', 'inner');
		if($limit != null || $start != null):
			$this->db->limit($limit, $start);
		endif;

		if($state != false):
			$this->db->like($state['column'], $state['value']);
		endif;

		$this->db->order_by('date_added', 'desc');

		return $this->db->get();
	}

	public function checkEpisode($episode, $idanime){
		$this->db->select('episode');
		$this->db->from($this->tbl);
		$this->db->where('episode', $episode);
		$this->db->where('idanime', $idanime);

		$count = $this->db->get()->num_rows();

		if($count <= 0):
			return 0;
		else:
			$result = $this->db->get()->row();
			return $result->episode;
		endif;
	}

	public function updateEpisode($data, $idepisode){
		$this->db->where('idepisode', $idepisode);
		$this->db->update($this->tbl, $data);
	}

	public function select_by_idanime($idanime){
		$this->db->select('idepisode,episode,klik,judul_episode');
		$this->db->from($this->tbl);
		$this->db->where('idanime', $idanime);
		$this->db->where('parentid', 0);
		$this->db->order_by('episode', 'desc');

		return $this->db->get();
	}

	public function record_count() {
        return $this->db->count_all($this->tbl);
    }

	public function select_by_episode($idanime, $episode, $streaming = false, $mirrorid = array()){
		$this->db->select('*');
		$this->db->from($this->tbl);
		$this->db->join('users', 'users.iduser=episodes.iduser', 'left');
		$this->db->join('subs', 'subs.idsub=episodes.idsub','left');
		$this->db->join('videohosting', 'videohosting.idhosting=episodes.sourcevideo');
		$this->db->where('episodes.idanime', $idanime);
		$this->db->where('episodes.episode',$episode);
		if(!empty($mirrorid) && $mirrorid['get'] == true):
			$this->db->where('parentid', $mirrorid['parentid']);
		endif;
		if($streaming == true):
			$this->db->where('status_streaming', 1);
		endif;

		return $this->db->get();
	}

	public function countMirror($idanime, $episode){
		$this->db->select('*');
		$this->db->from($this->tbl);
		$this->db->where('idanime', $idanime);
		$this->db->where('episode', $episode);

		return $this->db->get()->num_rows();

	}

	public function selectStream($idanime, $episode){
		$this->db->select('hashcode,date_added');
		$this->db->from($this->tbl);
		$this->db->where('idanime', $idanime);
		$this->db->where('episode', $episode);

		return $this->db->get();
	}

	public function fetch_page_episode($limit, $start) {
		$this->db->join('anime', 'anime.idanime=episodes.idanime', 'inner');
		$this->db->join('users', 'users.iduser=episodes.iduser', 'inner');
		$this->db->join('subs', 'subs.idsub=episodes.idsub','inner');
        $this->db->limit($limit, $start);
        $this->db->order_by('date_added', 'desc');

        $query = $this->db->get($this->tbl);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
}