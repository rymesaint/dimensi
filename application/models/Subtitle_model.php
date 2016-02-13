<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Subtitle_model extends CI_Model {

	private $tbl; // Define variable for table

	/**
	 * Store table name @tbl
	 */
	public function __construct(){
		parent::__construct();
		$this->tbl = 'subs';
	}

	/**
	 * Function select_all()
	 *
	 * Show all subtitle exists in database
	 *
	 * return @get (Object)
	 */
	public function select_all(){
		$this->db->select('*');
		$this->db->from($this->tbl);

		return $this->db->get();
	}
}