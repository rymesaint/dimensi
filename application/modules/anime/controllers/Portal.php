<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portal extends CI_Controller {

	/**
	 * Load related model
	 * Load library pagination to use ajax
	 */
	public function __construct(){
		parent::__construct();
		$this->load->model('anime_model');
		$this->load->model('episode_model');
		$this->load->model('counter_model');
		$this->load->model('slider_model');
		$this->load->library('pagination');
	}

	/**
	 * Function index()
	 *
	 * Main Page of the site
	 */
	public function index()
	{
		/**
		 * Get title, description, keywords website from database with the same parameter.
		 * 
		 * @title (Object)
		 *
		 */
		$title = $this->config_model->select_by_function('SITE_TITLE')->row();
		$description = $this->config_model->select_by_function('SITE_DESCRIPTION')->row();
		$keywords = $this->config_model->select_by_function('SITE_TAGS')->row();
		$slider = $this->config_model->select_by_function('SLIDER_ENABLE')->row();

		/**
		 * Define variable @data (array) that need to be used in header
		 * Configuring meta tag header
		 *
		 */
		$data['title'] = $title->content;
		$data['website'] = $data['title'];
		$data['description'] = $description->content;
		$data['keywords'] = $keywords->content;

		/**
		 * Count anime, episode, genre, user from selected table
		 */
		$data['count_anime'] = $this->counter_model->count_table('anime');
		$data['count_episode'] = $this->counter_model->count_table('episodes');
		$data['count_genre'] = $this->counter_model->count_table('genres');
		$data['count_user'] = $this->counter_model->count_table('users');

		/**
		 * Fetch cookie from browser
		 */
		$menu = get_cookie('dimensi_cookie');

		switch ($menu) {
			default:
			// case null:
			// 	$this->load->view('portal', $data);
			// break;
			case'anime_enter':
				/**
				 * Fetch data slider is enabled or not
				 */
				$info['slider'] = $slider->content;

				/**
				 * Check condition before fetching data slider
				 */
				if($slider->content == true):
					/**
					 * Fetch all data slider
					 */
					$info['slide_content'] = $this->slider_model->getSlide()->result();
				endif;

				/**
				 * Fetch total record anime
				 */
				$info['total_anime'] = $this->episode_model->record_count();
				
				/**
				 * Fetch total popular anime
				 */
				$info['popular'] = $this->anime_model->popular_anime()->result();

				/**
				 * Fetch all episode anime
				 */
        		$info['anime'] = $this->episode_model->select_all()->result();



				$info['rating'] = $this->rating;

				$this->load->view('header', $data);
				$this->load->view('templates/beranda', $info);
				$this->load->view('footer', $data);
			break;
			case'hentai_enter':
				$url = prep_url(base_url('hentai.php'));
				redirect($url);
			break;
		}
	}

	/**
	 * Function anime()
	 * 
	 * Set cookie named "dimensi_cookie" for entering anime site
	 * within 1 month expires
	 */
	public function anime(){
		set_cookie('dimensi_cookie','anime_enter', time()+60*60*24*30);
		redirect(base_url());
	}

	/**
	 * Function hentai()
	 * 
	 * Set cookie named "dimensi_cookie" for entering hentai anime site
	 * within 1 month expires
	 */
	public function hentai(){
		setcookie('dimensi_cookie','hentai_enter', time()+60*60*24*30);
		$url = prep_url(base_url('hentai.php'));
		redirect($url);
	}

	/**
	 * Function return_portal()
	 * 
	 * delete cookie named "dimensi_cookie" from browser
	 * then redirect to the base url
	 */
	public function return_portal(){
		delete_cookie('dimensi_cookie');
		redirect();
	}
}
