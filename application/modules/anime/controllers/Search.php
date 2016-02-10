<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

	/**
	 * Load related model that need to use via ajax
	 * 
	 */
	public function __construct(){
		parent::__construct();
		$this->load->model('anime_model');
	}

	/**
	 * Function getSearch($keyword)
	 *
	 * Fetch anime from searching matching the title anime @keyword
	 *
	 * Parameters:
	 * @keyword (String)
	 */
	public function getSearch($keyword){

		/**
		 * Get title website from database with the same parameter.
		 * 
		 * @title (Object)
		 *
		 */
		$title = $this->config_model->select_by_function('SITE_TITLE')->row();

		/**
		 * Fetch anime from database with @keyword
		 *
		 * Parameters:
		 * @keyword (String)
		 *
		 * return @info[anime] (Object)
		 */
		$info['anime'] = $this->anime_model->select_by_title($keyword)->result();

		/**
		 * Condition when selected data anime not found
		 * Show Error Code 404
		 */
		if(empty($info['anime'])):
			show_404();
		endif;
		
		/**
		 * Define variable @data (array) that need to be used in header
		 * Configuring meta tag header
		 *
		 */
		$data['txt_keyword'] = $keyword;
		$data['website'] = $title->content;
		$data['title'] = 'Pencarian Anime | '.$title->content;
		$data['description'] = character_limiter('Mencari anime berdasarkan kata kunci '.$keyword, 150, '...');
		$data['keywords'] = null;

		$info['rating'] = $this->rating;

		$this->load->view('header', $data);
		$this->load->view('templates/search-anime', $info);
		$this->load->view('footer', $data);
	}

	/**
	 * Fetch input from post
	 * 
	 * redirected to search template.
	 */
	public function setKeyword(){
		$query = $this->input->post('q');
		redirect('search/'.$query);
	}
}