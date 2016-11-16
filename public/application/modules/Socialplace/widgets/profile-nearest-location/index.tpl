<div style="margin-top: 15px;"></div>
<ul class="generic_list_widget">
     <?php foreach ($this->places as $place): ?>
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
                      <div class="socialplace-place-item-distance">
                          <?php echo round($place->distance, 2) . " " . $this->unit . "s";?>
                      </div>
                  </div>
              </div>
          </li>
     <?php endforeach; ?>
</ul>
