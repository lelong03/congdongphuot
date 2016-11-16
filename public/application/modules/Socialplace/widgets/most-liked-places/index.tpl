<div style="margin-top: 15px;"></div>
<ul class="generic_list_widget">
    <?php foreach ($this->paginator as $place): ?>
    <li>
        <div class="socialplace-place-item socialplace-clearfix">
            <div class="socialplace-most-item-image" style="background: url(<?php echo $place->getPhotoUrl('thumb.normal');?>);">
            </div>
            <div class="socialplace-most-item-content">
                <div class="socialplace-place-item-name">
                    <a href="<?php echo $place->getHref();?>">
                        <h4><?php echo $place->title;?></h4>
                    </a>
                </div>
                <div class="socialplace-place-item-likecount">
                    <?php echo $this->translate(array("%s like", "%s likes", (int)$place->like_count), (int)$place->like_count);?>
                </div>
            </div>
        </div>
    </li>
    <?php endforeach; ?>
</ul>
