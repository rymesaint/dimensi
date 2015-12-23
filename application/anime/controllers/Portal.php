<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portal extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('anime_model');
		$this->load->model('episode_model');
		$this->load->model('counter_model');
		$this->load->library('pagination');
	}

	public function index()
	{
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

		$menu = get_cookie('dimensi_cookie');

		switch ($menu) {
			default:
			case null:
				$this->load->view('portal', $data);
			break;
			case'anime_enter':
				// $config = array();
				// $config['base_url'] = base_url()."page/";
				// $config['total_rows'] = $this->episode_model->record_count();

				// $config["per_page"] = 4;
    //     		$config["uri_segment"] = 3;

    //     		$this->pagination->initialize($config);

    //     		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

    //     		$info["links"] = $this->pagination->create_links();
				$info['popular'] = $this->anime_model->popular_anime()->result();
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

	public function anime(){
		set_cookie('dimensi_cookie','anime_enter', time()+60*60*24*30);
		redirect();
	}

	public function hentai(){
		setcookie('dimensi_cookie','hentai_enter', time()+60*60*24*30);
		$url = prep_url(base_url('hentai.php'));
		redirect($url);
	}

	public function return_portal(){
		delete_cookie('dimensi_cookie');
		redirect();
	}
}
