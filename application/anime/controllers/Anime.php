<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Anime extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('anime_model');
		$this->load->model('episode_model');
		$this->load->model('counter_model');

		$this->load->library('generate_genres');
		$this->load->library('az_plugin');
		$this->load->library('pagination');
	}

	public function viewAnime($permalink){
		$title = $this->config_model->select_by_function('SITE_TITLE')->row();

		$info['anime'] = $this->anime_model->select_by_permalink($permalink)->row();

		if(empty($info['anime'])):
			show_404();
		endif;
		
		$data['website'] = $title->content;
		$data['title'] = $info['anime']->title_anime.' | '.$title->content;
		$data['description'] = substr($info['anime']->synopsis, 0, 150);
		$data['keywords'] = null;

		$info['rating'] = $this->rating->get($info['anime']->idanime);

		$info['episodes'] = $this->episode_model->select_by_idanime($info['anime']->idanime)->result();

		$genre_count = $this->generate_genres->countTags($info['anime']->genres);
		$info['genre_link'] = $this->generate_genres->get_tag_link($info['anime']->genres, $genre_count);

		$this->load->view('header', $data);
		$this->load->view('templates/single-anime', $info);
		$this->load->view('footer', $data);
	}

	public function browse(){
		$title = $this->config_model->select_by_function('SITE_TITLE')->row();

		$info['anime'] = $this->anime_model->select_all()->result();

		if(empty($info['anime'])):
			show_404();
		endif;
		
		$desc = 'Cari anime yang anda sukai dengan menjelajahi dimensi anime.';

		$data['website'] = $title->content;
		$data['title'] = 'Jelajahi Anime | '.$title->content;
		$data['description'] = substr($desc, 0, 150);
		$data['keywords'] = null;


		$info['az_plugin'] = $this->az_plugin;
		$info['rating'] = $this->rating;

		$this->load->view('header', $data);
		$this->load->view('templates/browse-anime', $info);
		$this->load->view('footer', $data);
	}

	private function decodeStream($hashcode){
			$decodeCode = base64_decode($hashcode);
			$url 	= explode('/',$decodeCode);
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

	private function createNavMirror($permalink, $episode, $num, $selected = 1){
		$nav = null;
		$nav 	.= '<div class="mirror">';
		for($i = 1; $i <= $num;$i++):
			if($selected == $i):
				$nav 	.= '<div class="mirror-title"><a class="active" href="'.base_url().'anime/'.$permalink.'/'.$episode.'/'.$i.'/">Mirror '.$i.'</a></div>';
			else:
				$nav 	.= '<div class="mirror-title"><a href="'.base_url().'anime/'.$permalink.'/'.$episode.'/'.$i.'/">Mirror '.$i.'</a></div>';
			endif;
		endfor;
		$nav 	.= '</div>';
		return $nav;
	}

	public function viewEpisode($permalink, $episode){
		$title = $this->config_model->select_by_function('SITE_TITLE')->row();

		$info['anime'] = $this->anime_model->select_by_permalink($permalink)->row();
		$info['sAnime'] = $this->episode_model->select_by_episode($info['anime']->idanime, $episode)->row();
		
		if(!empty($info['sAnime'])):
			$info['hashcode'] = Anime::decodeStream($info['sAnime']->hashcode);
		else:
			show_404();
		endif;

		$countMirror = $this->episode_model->countMirror($info['anime']->idanime, $info['sAnime']->episode);

		$info['createNavMirror'] = Anime::createNavMirror($info['anime']->permalink, $info['sAnime']->episode, $countMirror);

		if(empty($info['hashcode'])):
			redirect('download/'.$info['anime']->permalink.'/'.$info['sAnime']->episode.'/');
		endif;

		$data['website'] = $title->content;
		$data['title'] = $info['anime']->title_anime.' Episode '.$info['sAnime']->episode.' | '.$title->content;
		$data['description'] = substr($info['anime']->synopsis, 0, 150);
		$data['keywords'] = null;

		$info['rating'] = $this->rating->get($info['anime']->idanime);
		$genre_count = $this->generate_genres->countTags($info['anime']->genres);
		$info['genre_link'] = $this->generate_genres->get_tag_link($info['anime']->genres, $genre_count);


		$this->load->view('header', $data);
		$this->load->view('templates/single-episode', $info);
		$this->load->view('footer', $data);
	}

	public function page(){
		$title = $this->config_model->select_by_function('SITE_TITLE')->row();
		$description = $this->config_model->select_by_function('SITE_DESCRIPTION')->row();
		$keywords = $this->config_model->select_by_function('SITE_TAGS')->row();

		$data['title'] = $title->content;
		$data['website'] = $data['title'];
		$data['description'] = $description->content;
		$data['keywords'] = $keywords->content;

		$data['count_anime'] = $this->counter_model->count_table('anime');
		$data['count_episode'] = $this->counter_model->count_table('episodes');
		$data['count_genre'] = $this->counter_model->count_table('genres');
		$data['count_user'] = $this->counter_model->count_table('users');
		
		$config = array(
					'base_url' => base_url()."page/",
					'total_rows' => $this->episode_model->record_count(),
					'per_page' => 4,
					'num_links' => 5,
					'first_link' => "Awal",
					'last_link' => "Akhir"
				);
		$per_page = 4;

  		$this->pagination->initialize($config);

   		$page = number_format($this->uri->segment(3));
   		
   		$info['links'] = $this->pagination->create_links();

		$info['popular'] = $this->anime_model->popular_anime()->result();
    	$info['anime'] = $this->episode_model->select_all($per_page, $page)->result();

		$info['rating'] = $this->rating;

		$this->load->view('header', $data);
		$this->load->view('templates/beranda', $info);
		$this->load->view('footer', $data);
	}
}