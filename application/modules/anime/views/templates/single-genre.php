<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row">
	<section class="content col-lg-8 col-md-8">
		<div class="wrapper-bullet-title">
			<i class="glyphicon glyphicon-star"></i>
			Cari Anime Berdasarkan Genre <?php echo $genre->namegenre ?>
		</div>
		<div class="wrapper-content-inside">
			<div class="loadEpisodes">
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
							$(".loadEpisodes").html('<div class="loader-wrap"><img src="<?php echo base_url() ?>assets/images/waiting.gif"></div>');
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
