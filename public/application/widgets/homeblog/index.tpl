<style type="text/css">
.home_blog_main_categories{
    width: 70%;
    margin-top: 20px;
    height: 102px;
    text-align: center;
    margin-left: auto;
    margin-right: auto;
}

.home_blog_main_categories img{
	margin-top: 0px; margin-left: 0px; width: 25%; height: 25%;

}
.cat_item {
	float: left;
	/*display: inline-block;*/
	width: 33.3%;
	text-align: center;
}	
.home_blog_listing
{
    width: 72%;
    margin-top: 37px;
    margin-left: auto;
    margin-right: auto;
}
.home_blog_listing .blog_item_odd
{
	float: left;
	margin-bottom: 35px;
	width: 49%
}
.home_blog_listing .blog_item_even
{
	float: right;
	margin-bottom: 35px;
	width: 49%
}
.home_blog_listing .photo img {
	width: 100%;
}
.home_blog_listing .photo{
	background-size: cover !important;
	background-position: center !important;
	height: 187px;
}
.home_blog_listing .info {
	margin-top: 15px;
}
.home_blog_listing .info .title{
	text-transform: uppercase;
	font-weight: bold;
	margin-bottom: 5px;
	border-bottom: 1px dashed;
}
.home_blog_listing .category_photo {
	float: left;
	margin-right: 15px;
	border-right: #555 dashed 1px;
	padding-right: 15px;
	margin-left: -1px;
}

</style>

<div class="home_blog_main_categories">
	<div class="cat_item">
		<a href="http://congdongphuot.com/blogs?category=16">
			<img skinpart="image" class="cat_icon" src="<?php echo $this->baseUrl();?>/application/themes/grid-green/images/congdongphuot/food.png" />
			<h3>Ăn & Uống</h3>
		</a>
	</div>
	<div class="cat_item">
		<a href="http://congdongphuot.com/blogs?category=5">
			<img skinpart="image" class="cat_icon" alt="" src="<?php echo $this->baseUrl();?>/application/themes/grid-green/images/congdongphuot/experiences.png" />
			<h3>Kinh Nghiệm</h3>
		</a>
	</div>
	<div class="cat_item">
		<a href="http://congdongphuot.com/places">
			<img skinpart="image" class="cat_icon" alt="" src="<?php echo $this->baseUrl();?>/application/themes/grid-green/images/congdongphuot/hotels.png" />
			<h3>Khách sạn</h3>
		</a>
	</div>
</div>
 
<div class="home_blog_listing">
	<?php $i = 1;?>
	<?php foreach ($this->blogs as $blog) :?>
		<div class="<?php echo ($i % 2) ? 'blog_item_odd' : 'blog_item_even'?>">
			<div class="photo" style="background: url(<?php echo $blog->getPhotoUrl();?>)">
	        	
	      	</div>
	      	<div class="info"> 
	      		<div class="category_photo">
	      			<img src="<?php echo $this->baseUrl() . "/application/modules/Blog/externals/images/cat_" . $blog->category_id . ".png"; ?>" />
	      		</div>
	      		<div>
	      			<div class="title">
	      				<?php echo $this->htmlLink($blog->getHref(), $blog->getTitle(), array()) ?>
					</div>
					<hr>
					<div class="description">
						<?php echo $blog->getDescription();?>
					</div>
	      		</div>
	      		
	      	</div>
		</div>
	<?php if ($i % 2 == 0) :?>
		<div style="clear:both;"></div>
	<?php endif; ?>
    <?php if ($i == $this -> limit){break;}?>
	<?php $i++;?>
	<?php endforeach; ?>
</div>