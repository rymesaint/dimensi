<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Genre extends CI_Controller {

	/**
	 * Load related model
	 *
	 */
	public function __construct(){
		parent::__construct();
		$this->load->model('config_model');
		$this->load->model('genre_model');
		$this->load->model('anime_model');
		$this->load->model('counter_model');
	}

	/**
	 * Function viewGenre($permalink)
	 *
	 * Show anime based genre from selected @permalink
	 *
	 * Parameters:
	 * @permalink (String)
	 */

	public function viewGenre($permalink){

		/**
		 * Get title website from database with the same parameter.
		 * 
		 * @title (Object)
		 *
		 */
		$title = $this->config_model->select_by_function('SITE_TITLE')->row();

		/**
		 * Decode @permalink
		 */
		$permalink = urldecode($permalink);

		/**
		 * Fetch genre from selected @permalink
		 *
		 * return @info[genre] (Object)
		 */
		$info['genre'] = $this->genre_model->select_by_permalink($permalink)->row();

		/**
		 * Condition when selected data anime not found
		 * Show Error Code 404
		 */
		if(empty($info['genre'])):
			show_404();
		endif;
		
		/**
		 * Count total anime from selected @permalink
		 */
		$info['total_anime'] = $this->anime_model->record_count($permalink);

		/**
		 * Define variable @data (array) that need to be used in header
		 * Configuring meta tag header
		 *
		 */
		$desc_genre = 'Lihat semua anime berdasarkan genre '.$info['genre']->namegenre;
		$data['website'] = $title->content;
		$data['title'] = $info['genre']->namegenre.' | '.$title->content;
		$data['description'] = character_limiter($desc_genre, 150, '...');
		$data['keywords'] = "anime ".$info['genre']->namegenre.", streaming ".$info['genre']->namegenre;

		/**
		 * Fetch anime from selected genre @permalink
		 *
		 * return @data[anime] (Object)
		 */
		$data['anime'] = $this->anime_model->select_by_genre($permalink)->result();

		$info['rating'] = $this->rating; //Store rating plugin in the variable

		$this->load->view('header', $data);
		$this->load->view('templates/single-genre', $info);
		$this->load->view('footer', $data);
	}

	/**
	 * Function listGenre()
	 *
	 * Show all genre from database
	 *
	 */
	public function listGenre(){

		/**
		 * Get title website from database with the same parameter.
		 * 
		 * @title (Object)
		 *
		 */
		$title = $this->config_model->select_by_function('SITE_TITLE')->row();
		
		/**
		 * Define variable @data (array) that need to be used in header
		 * Configuring meta tag header
		 *
		 */
		$desc_genre = 'Jelajahi Genre Anime Terfavorit';

		$data['website'] = $title->content;
		$data['title'] = 'Jelajahi Genre | '.$title->content;
		$data['description'] = character_limiter($desc_genre, 150, '...');
		$data['keywords'] = null;

		/**
		 * Fetch all genre from database
		 * return @data[genre] (Object)
		 */
		$data['genres'] = $this->genre_model->select_all()->result();
		$data['count_genre'] = $this->anime_model;

		$this->load->view('header', $data);
		$this->load->view('templates/all-genre');
		$this->load->view('footer', $data);
	}
}