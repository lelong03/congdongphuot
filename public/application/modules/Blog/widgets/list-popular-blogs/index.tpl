<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Blog
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: index.tpl 9747 2012-07-26 02:08:08Z john $
 * @author     John
 */
?>
<style>
ul.generic_list_widget .photo {
  float: none;
  display: block;
}
ul.generic_list_widget li div.title a{
    white-space: normal;
    font-size: 11.5px;
}
</style>
<ul class="generic_list_widget">
  <?php foreach( $this->paginator as $item ): ?>
    <li>
      <div class="title" style="font-size: 12px;">
          <?php echo $this->htmlLink($item->getHref(), $item->getTitle()) ?>
      </div>
      <div class="photo">
        <?php //echo $this->htmlLink($item->getHref(), $this->itemPhoto($item->getOwner(), 'thumb.icon'), array('class' => 'thumb')) ?>
        <?php echo $this->htmlLink($item->getHref(), $this->itemPhoto($item, 'thumb.normal')) ?>
      </div>
      <div class="stats">
          <?php if( $this->popularType == 'view' ): ?>
            <?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count)) ?>
          <?php else /*if( $this->popularType == 'comment' )*/: ?>
            <?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count)) ?>
          <?php endif; ?>
      </div> 
      <div class="owner">
          <?php
            $owner = $item->getOwner();
            echo $this->translate('Posted by %1$s', $this->htmlLink($owner->getHref(), $owner->getTitle()));
          ?>
      </div>    
      <div class="info">
        
        
        
      </div>
    </li>
  <?php endforeach; ?>
  <li>
    <div style="text-align: right; font-size: 11.8px;"><a href="<?php echo $this -> url(array(), 'blog_general') ?>"><?php echo $this->translate("View more"); ?></a></div>
  </li>
</ul>