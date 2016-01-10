<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Az_plugin {

	private $tbl = 'anime';

	public function __construct()
    {
        $this->CI =& get_instance();
    }

    function createAZPagination(){
		$alfa = 'A';
		$data = null;
		$data .= '<ul class="nav-az">';
		$data .= '<li><a href="#0_9">0-9</a></li>';
		for ($i=1; $i <= 26 ; $i++) { 
			$data .= '<li><a href="#'.$alfa.'">'.$alfa.'</a></li>';
			$alfa++;
		}
		$data .= '</ul>';
		return $data;
	}

	public function createList(){
		$alfa 	= 'A';
		$data 	= null;
		do {
			$this->CI->db->select('*');
			$this->CI->db->from($this->tbl);
			$this->CI->db->like('title_anime', $alfa, 'after');

			$result = $this->CI->db->get()->result();

			$data .= '<div class="wrap-alfabet">';
			$data .= '<div class="title_alfabet" id="'.$alfa.'">'.$alfa.' <div class="backtotop scrollTop"><a title="Back to Top" href="#top"><i class="glyphicon glyphicon-arrow-up"></i></a></div></div>
		<div class="clearfix"></div>';
			$data .= '<ul class="alfa_list_anime">';

			foreach ($result as $obj):
				$data .= '<li><a href="'.base_url().'anime/'.$obj->permalink.'/" title="'.$obj->title_anime.'">'.$obj->title_anime.'</a></li>';
			endforeach;

			$data .= '</ul>';
			$data .= '<div class="clearfix"></div></div>';
			$alfa++;
		}
		while($alfa != "AA");
		return $data;
	}
}