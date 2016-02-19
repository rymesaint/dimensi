<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Anime extends CI_Controller {

	/**
	 *
	 * Load related model to anime and load library :
	 * )Generate Genre 	: To regenerate the genre from database with linked link.
	 * )AZ Plugin 		: Create a pagination anime from alfabet filter.
	 * )Vote Episode 	: Create voting system for each episode.
	 *
	 */
	public function __construct(){
		parent::__construct();
		$this->load->model('anime_model');
		$this->load->model('episode_model');
		$this->load->model('counter_model');
		$this->load->model('hosting_model');

		$this->load->library('generate_genres');
		$this->load->library('az_plugin');
		$this->load->library('Vote_episode');
	}

	/**
	 * Function viewAnime($permalink)
	 *
	 * Show selected anime data with the same @permalink
	 *
	 * Parameters:
	 * @permalink (String)
	 *
	 * return html
	 *
	 */
	public function viewAnime($permalink){

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
		 * @rate (String) Filter by rating_kode anime such as : PG, PG-13,or R
		 *
		 */
		$info['anime'] = $this->anime_model->select_by_permalink($permalink, $rate = null)->row();
		
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
		$data['website'] = $title->content;
		$data['title'] = $info['anime']->title_anime.' | '.$title->content;
		$data['description'] = character_limiter(strip_tags($info['anime']->synopsis), 150, '...');
		$data['keywords'] = "download anime ".$info['anime']->title_anime.", streaming anime ".$info['anime']->title_anime;

		/**
		 * Define variable @info (array) that need to be used in content
		 * Configuring what you need to show the information of anime.
		 *
		 */

		/**
		 * Get rating data from idanime
		 *
		 * Parameters:
		 * @item_id (int)
		 *
		 */
		$info['rating'] = $this->rating->get($item_id = $info['anime']->idanime);

		/**
		 * Get Episode Anime from exists idanime return an object
		 * 
		 * Parameters:
		 * @idanime (int)
		 *
		 */ 
		$info['episodes'] = $this->episode_model->select_by_idanime($idanime = $info['anime']->idanime)->result();
		$info['vote_episode'] = $this->vote_episode;

		/**
		 * Count the genre @tags (String)
		 * return @genre_count (int)
		 */
		$genre_count = $this->generate_genres->countTags($tags = $info['anime']->genres);

		/**
		 * Recreate genre from database with linked link for each genre.
		 *
		 * Return @genre_link (Array)
		 *
		 */
		$info['genre_link'] = $this->generate_genres->get_tag_link($info['anime']->genres, $genre_count);

		$this->load->view('header', $data);
		$this->load->view('templates/single-anime', $info);
		$this->load->view('footer', $data);
	}

	/**
	 * Function browse()
	 *
	 * Create a page for easy browse anime title
	 *
	 */
	public function browse(){

		/**
		 * Get title website from database with the same parameter.
		 * 
		 * @title (Object)
		 *
		 */
		$title = $this->config_model->select_by_function('SITE_TITLE')->row();

		/**
		 * Fetch all data anime from database
		 *
		 * return @anime (Object)
		 */
		$info['anime'] = $this->anime_model->select_all()->result();

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
		$desc = 'Cari anime yang anda sukai dengan menjelajahi dimensi anime.';
		$data['website'] = $title->content;
		$data['title'] = 'Jelajahi Anime | '.$title->content;
		$data['description'] = character_limiter($desc, 150, '...');
		$data['keywords'] = null;

		/**
		 * Define variable @info (Object) that need to use within template.
		 *
		 */
		$info['az_plugin'] = $this->az_plugin;
		$info['rating'] = $this->rating;

		$this->load->view('header', $data);
		$this->load->view('templates/browse-anime', $info);
		$this->load->view('footer', $data);
	}

	/**
	 * Function decodeStream($hashcode)
	 *
	 * Decode base64 from @hashcode and return @newdata (String)
	 * To get url link download or streaming
	 *
	 * Parameters:
	 * @hashcode (String)
	 *
	 */
	private function decodeStream($hashcode){
			/**
			 * Decode @hashcode based base64
			 */
			$decodeCode = base64_decode($hashcode);

			/**
			 * Explode @decodeCode to split data domain with code embed.
			 */
			$url 	= explode('/',$decodeCode);

			/**
			 * Switch @url[2] (String) domain name
			 * str_replace() used to replace/combine the domain with embed code.
			 */
			switch($url[2]):
				case'www.mp4upload.com';
				case'mp4upload.com';
					$http 	= "mp4upload.com";
					$replace 	= str_replace($http."/", $http."/embed-", $decodeCode);
					$newdata 	= $replace.".html";
				break;
				case'upload4free.co';
					$http 	= "upload4free.co";
					$replace 	= str_replace($http."/", $http."/embed-", $decodeCode);
					$newdata 	= $replace."-648x460.html";
				break;
				default:
					$newdata = null;
				break;
			endswitch;
		return $newdata;
	}

	/**
	 * Function viewEpisode($permalink, $episode)
	 *
	 * Show episode anime to stream with selected @permalink and @episode from database
	 *
	 * Parameters:
	 * @permalink (String)
	 * @episode (int)
	 */
	public function viewEpisode($permalink, $episode){

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
		
		$info['hashcode'] 	= "0"; // Define variable @info[hashcode] and store default value with 0
		
		/**
		 * Condition when selected data anime not found
		 * Show Error Code 404
		 */
		if(empty($info['sAnime'])):
			show_404();
		endif;

		/**
		 * Loop data episode from @sAnime as @hosting
		 * return @info[eAnime] (Object)
		 */
		foreach($info['sAnime'] as $hosting):
			/**
			 * Condition to check domain is exists in database or not
			 * with status_streaming is equal 1
			 * If equal then store the data in @info[hashcode] (String)
			 */
			if($this->hosting_model->checkHosting($hosting->namahosting)->row()->status_streaming == 1):
				$info['eAnime'] 	= $hosting;
				$info['hashcode'] 	= Anime::decodeStream($hosting->hashcode);
				break;
			else:
				$info['eAnime'] 	= $hosting;
			endif;
		endforeach;
		
		/**
		 * Condition when @info[hashcode] is empty or not set
		 * redirected to new url download anime
		 */
		if(empty($info['hashcode'])):
			redirect('download/'.$info['anime']->permalink.'/'.$info['eAnime']->episode.'/');
		endif;

		/**
		 * Fetch another episode who have the same episode and idanime
		 */
		$info['mirror'] = $info['sAnime'] = $this->episode_model->select_by_episode($info['anime']->idanime, $episode, true)->result();

		/**
		 * Define variable @data (array) that need to be used in header
		 * Configuring meta tag header
		 *
		 */
		$desc = "Free streaming anime ".$info['anime']->title_anime.' episode '.$info['eAnime']->episode;
		$data['website'] 		= $title->content;
		$data['title'] 			= $info['anime']->title_anime.' Episode '.$info['eAnime']->episode.' | '.$title->content;
		$data['description'] 	= character_limiter($desc, 150, '...');
		$data['keywords'] 		= "streaming ".$info['anime']->title_anime.", download anime ".$info['anime']->title_anime;

		/**
		 * Define variable @info (Object) that need to use within template.
		 *
		 */
		$info['rating'] 	= $this->rating->get($info['anime']->idanime);
		$genre_count 		= $this->generate_genres->countTags($info['anime']->genres);
		$info['genre_link'] = $this->generate_genres->get_tag_link($info['anime']->genres, $genre_count);


		$this->load->view('header', $data);
		$this->load->view('templates/single-episode', $info);
		$this->load->view('footer', $data);
	}

	/**
	 * Function viewMirror($permalink, $episode, $mirrorid)
	 *
	 * Get episode anime with the same anime and episode
	 * 
	 * Parameters:
	 * @permalink (String)
	 * @episode (int)
	 * @mirrorid (int)
	 */
	public function viewMirror($permalink, $episode, $mirrorid){

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
		 * Define @mirror (Array)
		 * @mirror keys:
		 * get, and parentid
		 */
		$mirror = array(
			'get' => true,
			'parentid' => $mirrorid
			);

		/**
		 * Fetch another episode who have the same episode and idanime
		 *
		 * Parameters:
		 * @idanime (int)
		 * @episode (int)
		 * @mirror (int)
		 * return @info[sAnime] (Object)
		 */
		$info['sAnime'] = $this->episode_model->select_by_episode($info['anime']->idanime, $episode, $mirror)->row();
		
		$info['hashcode'] = "0"; // Define variable @info[hashcode] and store default value with 0

		/**
		 * Condition when the mirror link is found within database
		 */
		if(!empty($info['sAnime'])):
			/**
			 * Condition to check domain is exists in database or not
			 * with status_streaming is equal 1
			 * If equal then store the data in @info[hashcode] (String)
			 */
			if($this->hosting_model->checkHosting($info['sAnime']->namahosting)->row()->status_streaming == 1):
				$info['eAnime'] = $info['sAnime'];
				$info['hashcode'] = Anime::decodeStream($info['sAnime']->hashcode);
			else:
				show_404();
			endif;
		endif;

		/**
		 * Condition when @info[hashcode] is empty or not set
		 * redirected to new url download anime
		 */
		if(empty($info['hashcode'])):
			redirect('download/'.$info['anime']->permalink.'/'.$info['sAnime']->episode.'/');
		endif;

		/**
		 * Fetch another episode who have the same episode and idanime
		 */
		$info['mirror'] = $info['sAnime'] = $this->episode_model->select_by_episode($info['anime']->idanime, $episode, true)->result();

		/**
		 * Define variable @data (array) that need to be used in header
		 * Configuring meta tag header
		 *
		 */
		$data['website'] = $title->content;
		$data['title'] = $info['anime']->title_anime.' Episode '.$info['eAnime']->episode.' | '.$title->content;
		$data['description'] = character_limiter($info['anime']->synopsis, 150, '...');
		$data['keywords'] = null;

		/**
		 * Define variable @info (Object) that need to use within template.
		 *
		 */
		$info['rating'] = $this->rating->get($info['anime']->idanime);
		$genre_count = $this->generate_genres->countTags($info['anime']->genres);
		$info['genre_link'] = $this->generate_genres->get_tag_link($info['anime']->genres, $genre_count);

		$this->load->view('header', $data);
		$this->load->view('templates/single-episode', $info);
		$this->load->view('footer', $data);
	}
}