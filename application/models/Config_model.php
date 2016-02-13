<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Config_model extends CI_Model {
	
	private $table = 'config'; // Define variable for table

	public function __construct(){
		parent::__construct();
	}

	/**
	 * Function select_all()
	 *
	 * Show all data configuration
	 *
	 * return @get (Object)
	 */
	public function select_all(){
		$this->db->select('*');
		$this->db->from($this->table);

		return $this->db->get();
	}

	/**
	 * Function select_by_function($function)
	 *
	 * Fetch value from spesific function from database
	 *
	 * Parameters:
	 * @function (String) name_function on database
	 *
	 * return @get (Object)
	 */
	public function select_by_function($function){
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->where('function',$function);

		return $this->db->get();
	}
}