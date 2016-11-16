<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Video
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: index.tpl 9747 2012-07-26 02:08:08Z john $
 * @author     John
 */
?>

<ul class="generic_list_widget generic_list_widget_large_photo">
  <?php foreach( $this->paginator as $item ): ?>
    <li>
      <div class="photo">
        <?php echo $this->htmlLink($item->getHref(), $this->itemPhoto($item, 'thumb.normal'), array('class' => 'thumb')) ?>
      </div>
      <div class="info">
        <div class="title">
          <?php echo $this->htmlLink($item->getHref(), $this->string()->truncate($item->getTitle(), 13)) ?>
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
            $parent = $item->getParent();
            echo $this->translate('Posted by %1$s in the album %2$s',
                $this->htmlLink($owner->getHref(), $owner->getTitle()),
                $this->htmlLink($parent->getHref(), $parent->getTitle()));
          ?>
        </div>
      </div>
    </li>
  <?php endforeach; ?>
  <li>
    <div style="text-align: right; font-size: 11.8px;"><a href="<?php echo $this -> url(array(), 'album_general') ?>"><?php echo $this->translate("View more"); ?></a></div>
    </li>
</ul>