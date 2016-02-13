<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Hosting_model extends CI_Model {

	private $tbl; // Define variable for table

	/**
	 * Store table name @tbl
	 */
	public function __construct(){
		parent::__construct();
		$this->tbl = 'videohosting';
	}

	/**
	 * Function select_all($state)
	 *
	 * Show all video hosting source
	 *
	 * Parameters:
	 * @state (String) Optional for condition
	 *
	 * return @get (Object)
	 */
	public function select_all($state = null){
		$this->db->select('*');
		$this->db->from($this->tbl);

		if($state != null):
			$this->db->where($state);
		endif;

		return $this->db->get();
	}

	/**
	 * Function checkHosting($hosting)
	 *
	 * Check video hosting with the same parameter @hosting
	 *
	 * Parameters:
	 * @hosting (String)
	 *
	 * return @get (Object)
	 */
	public function checkHosting($hosting){
		$this->db->select('status_streaming');
		$this->db->from($this->tbl);
		$this->db->where('namahosting', $hosting);

		return $this->db->get();
	}
}