<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
	<section class="content col-lg-8 col-md-8">
		<div class="wrapper-bullet-title">
			<i class="glyphicon glyphicon-star"></i>
			Cari Anime Berdasarkan Genre <?php echo $genre->namegenre ?>
		</div>
		<div class="wrapper-content-inside">
			<div class="loadEpisodes">
				<?php foreach ($anime as $episode): $result = $rating->get($episode->idanime); ?>
				<div class="wrapper-block-anime">
					<a href="<?php echo base_url().'anime/'.$episode->permalink.'/' ?>">
						<div class="block-anime-title">
						<?php echo $episode->title_anime ?></span>
						</div>
					</a>
					<div class="block-anime-img">
						<a href="<?php echo base_url().'anime/'.$episode->permalink.'/' ?>"><img src="<?php echo base_url().'uploads/'.$episode->image ?>" class="img img-responsive"></a>
					</div>
					<div class="block-anime-meta">
						<table class="table table-stripped">
							<tr>
								<td><?php echo $this->lang->line('release_date') ?></td>
								<td>: <?php echo date('F d Y H:i A', $episode->created_date); ?></td>
							</tr>
							<tr>
								<td>Rating</td>
								<td>: <?php echo $result->avg ?>/5 dari <?php echo $result->votes ?> pengguna.</td>
							</tr>
							<tr>
								<td>Lihat semua Episode</td>
								<td>: <a href="<?php echo base_url().'anime/'.$episode->permalink.'/' ?>"><?php echo $episode->title_anime ?></a></td>
							</tr>
						</table>
					</div>
					<div class="clearfix"></div>
				</div>
				<?php endforeach; ?>
			</div>
			<div class="wrapper-paging">
				<div class="pagination"></div>
			</div>
		</div>
	</section>
	<script>
			$(".pagination").paging(<?php echo $total_anime ?>, {
				format: '< nnncnnn >',
				perpage: 4,
				onSelect: function (page) {
					// add code which gets executed when user selects a page
					var dataS = "start="+ this.slice[0] + "&end="+ this.slice[1] + "&page=" + page +"&genre=<?php echo strtolower($genre->namegenre) ?>";
					$.ajax({
						url: "<?php echo base_url().'ajax/searchGenre/' ?>",
						data: dataS,
						type: 'POST',
						beforeSend:function(){
							$(".loadEpisodes").html('<center><i class="fa fa-spinner fa-spin fa-4x"></i></center');
						},
						success:function(data){
							$(".loadEpisodes").html(data);
						},
						error:function(data){
							$(".loadEpisodes").html("Try to load but return with error code : "+data.txtStatus);
						}
					})
				},
				onFormat: function (type) {
					switch (type) {
					case 'block': // n and c
						if(this.value != this.page)
							return '<li><a href="#'+ this.value +'" id="'+ this.value +'">' + this.value + '</a></li>';
						else
							return '<li class="active"><a href="#'+ this.value +'" id="'+ this.value +'">' + this.value + '</a></li>';
					case 'next': // >
						if(this.active)
							return '<li><a href="#'+ this.value +'" id="'+ this.value +'">Next</a></li>';
						else
							return '<li class="disabled"><a href="#'+ this.value +'" id="'+ this.value +'">Next</a></li>';
					case 'prev': // <
						if(this.active)
							return '<li><a href="#'+ this.value +'" id="'+ this.value +'">Previous</a></li>';
						else
							return '<li class="disabled"><a href="#'+ this.value +'" id="'+ this.value +'">Previous</a></li>';
					case 'first': // [
						if(this.active)
							return '<li><a href="#'+ this.value +'" id="'+ this.value +'">First</a></li>';
						else
							return '<li class="disabled"><a href="#'+ this.value +'" id="'+ this.value +'">First</a></li>';
					case 'last': // ]
						if(this.active)
							return '<li><a href="#'+ this.value+ '" id="'+ this.value +'">Last</a></li>';
						else
							return '<li class="disabled"><a href="#'+ this.value+ '" id="'+ this.value +'">Last</a></li>';
					}
				}
			});
			</script>
	<aside class="sidebar col-lg-4 col-md-4">
		<div class="wrapper_sidebar">
			<div class="sidebar_title">Lihat Genre Lainnya</div>
			<div class="sidebar_content">
				
			</div>
		</div>
	</aside>
</div>
