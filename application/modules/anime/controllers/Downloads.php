<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Downloads extends CI_Controller {

	/**
	 * Load model when class is being accessed.
	 *
	 */
	public function __construct(){
		parent::__construct();
		$this->load->model('anime_model');
		$this->load->model('episode_model');

		$this->load->library('generate_genres');
		$this->load->library('Vote_episode');
	}

	public function getEpisode($permalink, $episode){
		/**
		 * Get title website from database with the same parameter.
		 * 
		 * @title (Object)
		 *
		 */
		$title = $this->config_model->select_by_function('SITE_TITLE')->row();

		/**
		 * Get data anime from selected @permalink
		 *
		 * Paremeters:
		 * @permalink (String)
		 *
		 * return @anime (Object)
		 */
		$info['anime'] = $this->anime_model->select_by_permalink($permalink)->row();

		/**
		 * Get data episode from @idanime
		 *
		 * Paremeters:
		 * @idanime (int)
		 * @episode (int)
		 *
		 * return @sAnime (Object)
		 */
		$info['sAnime'] 	= $this->episode_model->select_by_episode($info['anime']->idanime, $episode)->result();
		
		/**
		 * Condition when selected data anime not found
		 * Show Error Code 404
		 */
		if(empty($info['sAnime'])):
			show_404();
		endif;

		/**
		 * Define variable @data (array) that need to be used in header
		 * Configuring meta tag header
		 *
		 */
		$desc = "Download ".$info['anime']->title_anime." episode ".$episode." from ".$title->content;
		$data['website'] = $title->content;
		$data['title'] = 'Download '.$info['anime']->title_anime.' Episode '.$episode.' | '.$title->content;
		$data['description'] = character_limiter($desc, 150, '...');
		$data['keywords'] = "download anime ".$info['anime']->title_anime.", streaming anime ".$info['anime']->title_anime;

		/**
		 * Define variable @info (Object) that need to use within template.
		 *
		 */
		$info['rating'] 	= $this->rating->get($info['anime']->idanime);
		$genre_count 		= $this->generate_genres->countTags($info['anime']->genres);
		$info['genre_link'] = $this->generate_genres->get_tag_link($info['anime']->genres, $genre_count);


		$this->load->view('header', $data);
		$this->load->view('templates/downloads', $info);
		$this->load->view('footer', $data);
	}

	public function getLink($hashcode){
		$url = urldecode($hashcode);
		$url = base64_decode($url);
		redirect($url, 'location', 301);
	}
}