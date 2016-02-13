<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Season_model extends CI_Model {

	private $tbl; // Define variable for table

	/**
	 * Store table name @tbl
	 */
	public function __construct(){
		parent::__construct();
		$this->tbl = 'seasons';
	}

	/**
	 * Function select_all()
	 *
	 * Show all seasons from database
	 *
	 * return @get (Object)
	 */
	public function select_all(){
		$this->db->select('*');
		$this->db->from($this->tbl);

		return $this->db->get();
	}
}