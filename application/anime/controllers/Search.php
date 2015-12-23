<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('anime_model');
	}

	public function getSearch($keyword){
		$title = $this->config_model->select_by_function('SITE_TITLE')->row();

		$info['anime'] = $this->anime_model->select_by_title($keyword)->result();

		if(empty($info['anime'])):
			show_404();
		endif;
		
		$data['txt_keyword'] = $keyword;
		$data['website'] = $title->content;
		$data['title'] = 'Pencarian Anime | '.$title->content;
		$data['description'] = substr('Mencari anime berdasarkan kata kunci '.$keyword, 0, 150);
		$data['keywords'] = null;

		$info['rating'] = $this->rating;

		$this->load->view('header', $data);
		$this->load->view('templates/search-anime', $info);
		$this->load->view('footer', $data);
	}

	public function setKeyword(){
		$query = $this->input->post('q');
		redirect('search/'.$query);
	}
}