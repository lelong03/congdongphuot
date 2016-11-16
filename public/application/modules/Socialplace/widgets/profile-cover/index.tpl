<?php
$this->headScript()
        ->appendFile($this->baseUrl() . '/application/modules/Socialplace/externals/scripts/jquery-1.7.1.min.js')
        ->appendFile($this->baseUrl() . '/application/modules/Socialplace/externals/scripts/jquery.flexslider.js');
	$this->headLink()
        ->appendStylesheet($this->baseUrl() . '/application/modules/Socialplace/externals/styles/flexslider.css'); 
?>

<script type="text/javascript">
	jQuery.noConflict();
	(function($){
		$(window).load(function() {
			  $('.flexslider').flexslider({
			    animation: "slide"
			    //controlNav: "thumbnails"
			  });
		});
	})(jQuery);
</script>

<div class="flexslider">
  <ul class="slides">
  	<?php foreach( $this->paginator as $photo ): ?>
		<li data-thumb="<?php echo $photo->getPhotoUrl('thumb.main'); ?>">
	      <span class="flexslider-image" style="background-image: url(<?php echo $photo->getPhotoUrl(null); ?>);"></span>
	    </li>
    <?php endforeach; ?>
  </ul>
</div>
<style type="text/css">
	.flexslider-image {
		width: 100%;
		height: 350px;
		background-repeat: no-repeat;
		/*background-size: cover;*/
		background-position: center;
		display: block;
	}
	.flexslider {
		background-color: black;
	}
</style>