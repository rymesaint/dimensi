<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Genre extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('config_model');
		$this->load->model('genre_model');
		$this->load->model('anime_model');
		$this->load->model('counter_model');
	}

	public function viewGenre($permalink){
		$title = $this->config_model->select_by_function('SITE_TITLE')->row();

		$info['genre'] = $this->genre_model->select_by_permalink($permalink)->row();

		if(empty($info['genre'])):
			show_404();
		endif;

		$desc_genre = 'Lihat semua anime berdasarkan genre '.$info['genre']->namegenre;

		$data['website'] = $title->content;
		$data['title'] = $info['genre']->namegenre.' | '.$title->content;
		$data['description'] = substr($desc_genre, 0, 150);
		$data['keywords'] = null;

		$data['anime'] = $this->anime_model->select_by_genre($permalink)->result();

		$info['rating'] = $this->rating;

		$this->load->view('header', $data);
		$this->load->view('templates/single-genre', $info);
		$this->load->view('footer', $data);
	}
}