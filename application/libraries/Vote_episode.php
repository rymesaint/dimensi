<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Vote_episode {

	private $tbl;

	public function __construct()
    {
        $this->CI =& get_instance();
        $this->tbl  = "vote_episodes";
    }

    public function countVote($idepisode){
		$this->CI->db->select('idepisode');
		$this->CI->db->from($this->tbl);
		$this->CI->db->where('idepisode', $idepisode);
		return $this->CI->db->get()->num_rows();
	}
}
