<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rating {

	private $rating_table = 'rating';

	public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function get($item_id)
    {
	    $rating = new \stdClass();
  		$this->item_id = $item_id;
	    $rating->avg = $this->get_avg();
    	$rating->votes = $this->get_total_votes();
    	if(!$rating->avg)
    		$rating->avg = 0;
    	return $rating;
    }

    private function get_total_votes()
    {
    	$this->CI->db->where('id_anime', $this->item_id);
    	return $this->CI->db->count_all_results($this->rating_table);
    }

    private function get_avg()
    {
    	$this->CI->db->where('id_anime', $this->item_id);
    	$this->CI->db->select_avg('score');
    	$q = $this->CI->db->get($this->rating_table);
    	return round($q->row()->score, 2);
    }
}