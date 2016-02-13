<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model {

	private $tbl; // Define variable for table

	/**
	 * Store table name @tbl
	 */
	public function __construct(){
		parent::__construct();
		$this->tbl = 'users';
	}

	/**
	 * Function countUsers()
	 *
	 * Count all users from database except for user who have groupid not same 5
	 *
	 * return @num_rows (int)
	 */
	public function countUsers(){
		$this->db->select('iduser');
		$this->db->from($this->tbl);
		$this->db->where('groupid != 5');

		return $this->db->get()->num_rows();
	}

	/**
	 * Function getID($user)
	 *
	 * Select a data with the same user id @user
	 * Used for selecting profile
	 *
	 * Parameters:
	 * @user (String)
	 *
	 * return @get (Object)
	 */
	public function getID($user){
		$this->db->select('*');
		$this->db->from($this->tbl);
		$this->db->where('username', $user);

		return $this->db->get();
	}

	/**
	 * Function getUser($user)
	 *
	 * Select a data with the same user id @user
	 * Used for login or forgotpassword or something like that.
	 *
	 * Parameters:
	 * @user (String)
	 *
	 * return @get (Object)
	 */
	public function getUser($user){
		$this->db->select('*');
		$this->db->from($this->tbl);
		$this->db->where('username', $user);
		$this->db->or_where('iduser', $user);

		return $this->db->get();
	}
}