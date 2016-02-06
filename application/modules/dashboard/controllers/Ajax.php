<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("anime_model");
	}

	public function getEpisode(){
		if (!$this->input->is_ajax_request()){
			die("Sorry, you're not using the right method.");
		}

		$idanime = filter_var($this->input->post("idanime"), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		if(!is_numeric($idanime)){die('Invalid Anime ID!');}

		$episodes = $this->anime_model->select_by_id($idanime)->row();

		$data = "";
		$data .= '<select id="selectEpisode" name="episode" required>
          <option value="" disabled selected>Pilih Episode</option>';
		for ($i=1; $i <= $episodes->max_episodes; $i++):
			$data .= '<option value="'.$i.'">'.$i.'</option>';
		endfor;
		$data .= '</select>';

		echo $data;
	}
}