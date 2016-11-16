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
			    animation: "slide",
			    controlNav: false, 
			    slideshow: true,
			    slideshowSpeed: 4000
			  });
		});
	})(jQuery);
</script>

<style>
div.featured-blogs-list .photo
{
	height: 300px;
	background-repeat: no-repeat;
	background-size: cover !important;
}
div.featured-blogs-list .title
{
	font-size: 13.5px;
	font-weight: bold;
}
div.featured-blogs-list ul li > div
{
	margin-bottom: 8px;
}
div.featured-blogs-list .title,
div.featured-blogs-list .description,
div.featured-blogs-list .stats
{
	padding-left: 10px;
	padding-right: 10px;
}
</style>


<div class="flexslider featured-blogs-list">
  <ul class="slides">
  	<?php foreach( $this->paginator as $item ): ?>
		<li>
	      <div class="photo" style="background: url(<?php echo $item->getPhotoUrl();?>);"></div>
	      <div class="title"><?php echo $this->htmlLink($item->getHref(), $item->getTitle()) ?></div>
	      <div class="description"><?php echo $this->string()->truncate($this->string()->stripTags($item->body), 300) ?></div>
	      <div class="stats">
	      		<?php
		            $owner = $item->getOwner();
		            echo $this->translate('Posted by %1$s', $this->htmlLink($owner->getHref(), $owner->getTitle()));
	          	?>
	            - 
		          <?php if( $this->popularType == 'view' ): ?>
		            <?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count)) ?>
		          <?php else: ?>
		            <?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count)) ?>
		          <?php endif; ?>
	      </div>
	    </li>
    <?php endforeach; ?>
  </ul>
</div>