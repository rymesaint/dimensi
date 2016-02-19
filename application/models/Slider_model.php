<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Slider_model extends CI_Model {

	private $tbl; // Define variable for table

	/**
	 * Store table name @tbl
	 */
	public function __construct(){
		parent::__construct();
		$this->tbl = 'slider';
	}

	public function getSlide(){
		$this->db->select('*');
		$this->db->from($this->tbl);
		
		return $this->db->get();
	}
}