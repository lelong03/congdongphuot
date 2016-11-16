<div class="social-place-featured-region">
<?php foreach ($this -> regions as $region):?>
	<div class="wrapper">
		<div>
			<?php $regionLink = $this->url(array('action' => 'listing', 'region_id' => $region->region_id), 'socialplace_general');?>
			<a href="<?php echo $regionLink;?>" class="photo" style="background-image: url(<?php echo $region -> getPhotoUrl();?>);"></a>
			<div>
				<span class="region-title"><a href="<?php echo $regionLink;?>"><?php echo $region->region_name;?></a></span>
				
				<?php $usedCount = $region->getUsedCount();?>
				<span class="region-hotel-count"><?php echo $usedCount;?> <i class="fa fa-building"></i></span>
			</div>
		</div>
		
		
	</div>
<?php endforeach;?>
</div>
<div style="clear: both;"></div>