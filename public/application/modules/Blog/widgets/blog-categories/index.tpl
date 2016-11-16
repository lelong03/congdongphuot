<ul class = "global_form_box"  style="margin-bottom: 15px;">
	<?php foreach( $this->categories as $category ): ?>
	<li class="blog_categories_blogs">
		<a class="buttonlink icon_blog_category" href="<?php echo $this->url(array(), 'blog_general' ) . "?category={$category->category_id}";?>">
			<?php echo $this->translate($category->category_name) ?> 
		</a>
	</li>
	<?php endforeach; ?>
</ul>
