<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Animes extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('anime_model');
		$this->load->model('episode_model');
		$this->load->model('hosting_model');
		$this->load->model('season_model');
		$this->load->model('genre_model');
		$this->load->model('subtitle_model');
	}

	public function index(){
		$data['app_name'] = "Dimensi";
		$data['title'] = "Animes | ".$data['app_name'];

		if($this->session->login != 1 && $this->session->level != 8):
			redirect(site_url('dashboard'));
		endif;

		$data['user'] = $this->user_model->getUser($this->session->iduser)->row();
		$info['count_anime'] = $this->anime_model->count_anime()->num_rows();
		$info['count_episode'] = $this->episode_model->record_count();

		$info['animes'] = $this->anime_model->select_all($rate_filter = null)->result();
		$info['episodes'] = $this->episode_model->select_all(150, 0)->result();
		$info['hostings'] = $this->hosting_model->select_all()->result();

		$this->load->view('header', $data);
		$this->load->view('templates/animes', $info);
		$this->load->view('footer');
	}

	public function tambah_anime(){
		$data['app_name'] = "Dimensi";
		$data['title'] = "Tambah Anime | ".$data['app_name'];

		if($this->session->login != 1 && $this->session->level != 8):
			redirect(site_url('dashboard'));
		endif;

		$data['user'] = $this->user_model->getUser($this->session->iduser)->row();
		$data['genres'] = $this->genre_model->select_all()->result();
		$data['seasons'] = $this->season_model->select_all()->result();

		$this->load->view('header', $data);
		$this->load->view('templates/tambah-anime');
		$this->load->view('footer');
	}

	public function tambah_episode(){
		$data['app_name'] = "Dimensi";
		$data['title'] = "Tambah Episode Anime | ".$data['app_name'];

		if($this->session->login != 1 && $this->session->level != 8):
			redirect(site_url('dashboard'));
		endif;

		$data['user'] = $this->user_model->getUser($this->session->iduser)->row();

		$orderBy = array(
			'order' => 'title_anime',
			'type' => 'ASC'
			);

		$info['animes'] = $this->anime_model->select_all(0,null, $search = array('search_type' => null), $orderBy)->result();
		$info['subtitles'] = $this->subtitle_model->select_all()->result();
		$info['source_videos'] = $this->hosting_model->select_all()->result();

		$this->load->view('header', $data);
		$this->load->view('templates/tambah-episode', $info);
		$this->load->view('footer');
	}

	public function ubah_anime($permalink){
		$data['app_name'] = "Dimensi";
		$data['animes'] = $this->anime_model->select_by_id($permalink)->row();
		$data['title'] = $data['animes']->title_anime." | ".$data['app_name'];

		if($this->session->login != 1 && $this->session->level != 8):
			redirect(site_url('dashboard'));
		endif;

		$data['user'] = $this->user_model->getUser($this->session->iduser)->row();
		$data['genres'] = $this->genre_model->select_all()->result();
		$data['seasons'] = $this->season_model->select_all()->result();

		$this->load->view('header', $data);
		$this->load->view('templates/ubah-anime', $data);
		$this->load->view('footer');
	}

	public function proses($opsi, $permalink = null){
		switch($opsi):
		case'tambah';
			Animes::tambah();
		break;
		case'ubah';
			Animes::ubah();
		break;
		endswitch;
	}

	public function hapus($permalink){
		$this->anime_model->delete_anime($permalink);
		redirect('dashboard/animes/');
	}

	protected function tambah(){
		$series 	= $this->input->post("series");
		$judul 		= $this->input->post("judul-anime");
		$synopsis 	= $this->input->post("synopsis");
		$arr_genre 	= $this->input->post("genre");
		$genre 		= implode(',', $arr_genre);
		$rating		= $this->input->post("ratingkode");
		$studio 	= $this->input->post("studio");
		$rilis 		= $this->input->post("rilistahun");
		$episodes 	= $this->input->post("episodes");
		$season 	= $this->input->post("season");
		$status 	= $this->input->post("status");
		$photo 		= $_FILES['photo'];
		$permalink 	= url_title($judul, '-', true);

		if ( !$photo ):
            $filename = "no-image.jpg";
        else:
			$config['image_library'] = 'gd2';
	        $config['source_image'] = $photo['tmp_name'];
	        $config['new_image'] = 'uploads/'.$permalink.'.jpeg';
	        $config['maintain_ratio'] = TRUE;
	        $config['width']     = 150;
	        $config['height']   = 150;
	        $this->load->library('image_lib', $config);

	        $this->image_lib->resize();

	        $filename = $permalink.".jpeg";
		endif;

		$data['title_anime'] = $judul;
		$data['created_date'] = time();
		$data['image'] = $filename;
		$data['genres'] = $genre;
		$data['series'] = $series;
		$data['studios'] = $studio;
		$data['kode_rate'] = $rating;
		$data['date_published'] = $rilis;
		$data['season'] = $season;
		$data['synopsis'] = $synopsis;
		$data['max_episodes'] = $episodes;
		$data['permalink'] = $permalink;
		$data['status'] = $status;

		$this->anime_model->save_anime($data);
		redirect('dashboard/animes/');
	}

	public function ubah(){

		$idanime 	= $this->input->post("idanime");
		$series 	= $this->input->post("series");
		$judul 		= $this->input->post("judul-anime");
		$synopsis 	= $this->input->post("synopsis");
		$arr_genre 	= $this->input->post("genre");
		$genre 		= implode(',', $arr_genre);
		$rating		= $this->input->post("ratingkode");
		$studio 	= $this->input->post("studio");
		$rilis 		= $this->input->post("rilistahun");
		$episodes 	= $this->input->post("episodes");
		$season 	= $this->input->post("season");
		$status 	= $this->input->post("status");
		$photo 		= $_FILES['photo'];
		$permalink 	= url_title($judul, '-', true);

		if ( $photo ):
			$config['image_library'] = 'gd2';
	        $config['source_image'] = $photo['tmp_name'];
	        $config['new_image'] = 'uploads/'.$permalink.'.jpeg';
	        $config['maintain_ratio'] = TRUE;
	        $config['width']     = 150;
	        $config['height']   = 150;
	        $this->load->library('image_lib', $config);

	        $this->image_lib->resize();

	        $filename = $permalink.".jpeg";
		endif;

		$data['title_anime'] = $judul;
		$data['created_date'] = time();
		$data['image'] = $filename;
		$data['genres'] = $genre;
		$data['series'] = $series;
		$data['studios'] = $studio;
		$data['kode_rate'] = $rating;
		$data['date_published'] = $rilis;
		$data['season'] = $season;
		$data['synopsis'] = $synopsis;
		$data['max_episodes'] = $episodes;
		$data['permalink'] = $permalink;
		$data['status'] = $status;

		echo $data['permalink'];
		$this->anime_model->update_anime($data, $idanime);
		redirect('dashboard/animes/');
	}

	public function changehosting(){
		if($this->input->is_ajax_request() != true):
			die("Sorry, you're not using the right method.");
		endif;

		$idepisode = $this->input->post("idepisode");
		$namehosting = $this->input->post("hosting");

		$data['sourcevideo'] = $namehosting;
		$this->episode_model->updateEpisode($data, $idepisode);

		$hosting = $this->hosting_model->select_all("idhosting=".$namehosting)->row();

		echo $hosting->namahosting;
	}

	public function listanimes(){
		if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
			die("Sorry, you're not using the right method.");
		}

		$start = filter_var($this->input->post("start"), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		$end = filter_var($this->input->post("end"), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		$page = filter_var($this->input->post("page"), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

		//validate page number is really numaric
		if(!is_numeric($page) && !is_numeric($end) && !is_numeric($start)){
			die('Invalid page number!');
		}

		$end = $end - $start;
		$animes = $this->anime_model->select_all($start, $end)->result();
		$rating = $this->rating;
		$data = null;

		foreach ($animes as $anime):
			$data .= '<tr>
	                    <td>'.$anime->idanime.'</td>
	                    <td>'.$anime->title_anime.'</td>
	                    <td>'.$anime->date_published.'</td>
	                    <td>'.$anime->max_episodes.'</td>
	                    <td>'.date("M, d Y",$anime->created_date).'</td>
	                    <td>'.$anime->status.'</td>
	                    <td>
	                      <a class="btn green lighten-2" href="'.site_url('dashboard/animes/ubah_anime/'.$anime->idanime.'/').'">Edit</a>
	                      <a class="btn materialize-red lighten-2" href="'.site_url('dashboard/animes/hapus/'.$anime->idanime.'/').'">X</a>
	                    </td>
	                  </tr>';
		endforeach;

		echo $data;
	}

	public function episodesearch(){

		if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
			die("Sorry, you're not using the right method.");
		}

		$query = $this->input->get("keyword");

		$state = array(
			'column' => 'title_anime',
			'value' => $query
			);

		$animes = $this->episode_model->select_all(null, null, $state)->result();
		$hostings = $this->hosting_model->select_all()->result();
		$rating = $this->rating;
		$data = null;

		foreach ($animes as $episode):
			$data .= '<tr class="edit_tr" id="'.$episode->idepisode.'">
	                      <td>'.$episode->idepisode.'</td>
	                      <td>'.$episode->title_anime.'</td>
	                      <td>'. $episode->episode.'</td>
	                      <td>
	                        <span class="text" id="label_hosting_'.$episode->idepisode.'">'.$episode->namahosting.'</span>
	                        <select class="inputhosting" id="input_hosting_'.$episode->idepisode.'">';
	                          foreach ($hostings as $hosting):
	                            if($episode->namahosting == $hosting->namahosting):
	        $data .=                    '<option value="'.$hosting->idhosting.'" selected>'.$hosting->namahosting.'</option>';
	                            else:
	        $data .=                    '<option value="'.$hosting->idhosting.'">'.$hosting->namahosting.'</option>';  
	                          	endif;
	                          endforeach;
	        $data .=         '</select>
	                      </td>
	                      <td>'.date("M, d Y",$episode->date_added).'</td>
	                    </tr>';
		endforeach;

		echo $data;

		echo '<script type="text/javascript">
            $(document).ready(function()
            {

              var idepisode,
                  hosting,
                  dataS;
              $(".edit_tr").click(function(){
                idepisode = $(this).attr("id");

                $("#label_hosting_"+idepisode).hide();
                $("#input_hosting_"+idepisode).show();
              });

              $(".inputhosting").change(function(){
                hosting = $(this).val(),
                dataS = "idepisode="+idepisode+"&hosting="+hosting;
                $.ajax({
                  type: \'POST\',
                  url: \''.site_url('dashboard/animes/changehosting/').'\',
                  data: dataS,
                  cache: false,
                  success:function(data){
                    $("#label_hosting_"+idepisode).html(data);
                  }
                });
              });

              $(".inputhosting").mouseup(function(){
                return false
              });

              $(document).mouseup(function(){
                $(".inputhosting").hide();
                $(".text").show();
              });
            });
          </script>';
	}

	public function animesearch(){

		if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
			die("Sorry, you're not using the right method.");
		}

		$query = $this->input->get("keyword");

		$state = array(
			'search_type' => 'like',
			'column' => 'title_anime',
			'value' => $query
			);

		$animes = $this->anime_model->select_all(null, null, $state)->result();
		$hostings = $this->hosting_model->select_all()->result();
		$rating = $this->rating;
		$data = null;

		foreach ($animes as $anime):
			$data .= '<tr>
	                    <td>'.$anime->idanime.'</td>
	                    <td>'.$anime->title_anime.'</td>
	                    <td>'.$anime->date_published.'</td>
	                    <td>'.$anime->max_episodes.'</td>
	                    <td>'.date("M, d Y",$anime->created_date).'</td>
	                    <td>'.$anime->status.'</td>
	                    <td>
	                      <a class="btn btn-success" href="'.site_url('dashboard/animes/edit/'.$anime->idanime.'/').'"><i class="fa fa-edit"></i></a>
	                      <a class="btn btn-danger" href="'.site_url('dashboard/animes/delete/'.$anime->idanime.'/').'"><i class="fa fa-trash"></i></a>
	                    </td>
	                  </tr>';
		endforeach;

		echo $data;
	}		

	public function listepisode(){

		if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
			die("Sorry, you're not using the right method.");
		}

		$start = filter_var($this->input->post("start"), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		$end = filter_var($this->input->post("end"), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		$page = filter_var($this->input->post("page"), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

		//validate page number is really numaric
		if(!is_numeric($page) && !is_numeric($end) && !is_numeric($start)){
			die('Invalid page number!');
		}

		$end = $end - $start;
		$animes = $this->episode_model->select_all($end, $start)->result();
		$hostings = $this->hosting_model->select_all()->result();
		$rating = $this->rating;
		$data = null;

		foreach ($animes as $episode) {
			$result = $rating->get($episode->idanime);
			$data .= '<tr class="edit_tr" id="'.$episode->idepisode.'">
	                      <td>'.$episode->idepisode.'</td>
	                      <td>'.$episode->title_anime.'</td>
	                      <td>'. $episode->episode.'</td>
	                      <td>
	                        <span class="text" id="label_hosting_'.$episode->idepisode.'">'.$episode->namahosting.'</span>
	                        <select class="inputhosting" id="input_hosting_'.$episode->idepisode.'">';
	                          foreach ($hostings as $hosting):
	                            if($episode->namahosting == $hosting->namahosting):
	        $data .=                    '<option value="'.$hosting->idhosting.'" selected>'.$hosting->namahosting.'</option>';
	                            else:
	        $data .=                    '<option value="'.$hosting->idhosting.'">'.$hosting->namahosting.'</option>';  
	                          	endif;
	                          endforeach;
	        $data .=         '</select>
	                      </td>
	                      <td>'.date("M, d Y",$episode->date_added).'</td>
	                    </tr>';
		}
		echo $data;

		echo '<script type="text/javascript">
            $(document).ready(function()
            {

              var idepisode,
                  hosting,
                  dataS;
              $(".edit_tr").click(function(){
                idepisode = $(this).attr("id");

                $("#label_hosting_"+idepisode).hide();
                $("#input_hosting_"+idepisode).show();
              });

              $(".inputhosting").change(function(){
                hosting = $(this).val(),
                dataS = "idepisode="+idepisode+"&hosting="+hosting;
                $.ajax({
                  type: \'POST\',
                  url: \''.site_url('dashboard/animes/changehosting/').'\',
                  data: dataS,
                  cache: false,
                  success:function(data){
                    $("#label_hosting_"+idepisode).html(data);
                  }
                });
              });

              $(".inputhosting").mouseup(function(){
                return false
              });

              $(document).mouseup(function(){
                $(".inputhosting").hide();
                $(".text").show();
              });
            });
          </script>';
	}	
}