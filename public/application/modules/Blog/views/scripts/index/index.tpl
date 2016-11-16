<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Blog
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: index.tpl 9747 2012-07-26 02:08:08Z john $
 * @author     Jung
 */
?>
<style>
.blog_item .left_column img
{
  width: 200px;
  height: 127px;
}
.blog_item .left_column
{
  float: left; 
  margin-right: 12px;
}
</style>

<?php if( $this->paginator->getTotalItemCount() > 0 ): ?>
  <ul class="blogs_browse">
    <?php foreach( $this->paginator as $item ): ?>
      <li class="blog_item">
        <div class="left_column">
          <?php echo $this->itemPhoto($item, 'thumb.profile', array('class' => 'main_photo'))?>
        </div>
        <div>
          <div class='blogs_browse_info'>
            <span class='blogs_browse_info_title'>
              <h3><?php echo $this->htmlLink($item->getHref(), $item->getTitle()) ?></h3>
            </span>
            <p class='blogs_browse_info_blurb cdp_blog_item_description'>
              <?php echo $this->string()->truncate($this->string()->stripTags($item->body), 250) ?>
            </p>
            <div>
                <div class='blogs_browse_photo cdp_blog_item_owner_photo'>
                <?php echo $this->htmlLink($item->getOwner()->getHref(), $this->itemPhoto($item->getOwner(), 'thumb.icon')) ?>
                </div>
                <div>
                  <div class='blogs_browse_info_date'>
                    <?php echo $this->translate('Posted');?>
                    <?php echo $this->timestamp(strtotime($item->creation_date)) ?>
                  </div>
                  <div class='blogs_browse_info_date'>
                    <?php echo $this->translate('By');?>
                    <?php echo $this->htmlLink($item->getOwner()->getHref(), $item->getOwner()->getTitle()) ?>
                  </div>
                  <div class='blogs_browse_info_date'>
                    <?php echo $this->translate(array('%s view', '%s views', $item->view_count), $item->view_count);?> - 
                    <?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $item->comment_count);?>
                  </div>
                </div>
            </div>
            
          </div>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>

<?php elseif( $this->category || $this->show == 2 || $this->search ): ?>
  <div class="tip">
    <span>
      <?php echo $this->translate('Nobody has written a blog entry with that criteria.');?>
      <?php if (TRUE): // @todo check if user is allowed to create a poll ?>
        <?php echo $this->translate('Be the first to %1$swrite%2$s one!', '<a href="'.$this->url(array('action' => 'create'), 'blog_general').'">', '</a>'); ?>
      <?php endif; ?>
    </span>
  </div>

<?php else:?>
  <div class="tip">
    <span>
      <?php echo $this->translate('Nobody has written a blog entry yet.'); ?>
      <?php if( $this->canCreate ): ?>
        <?php echo $this->translate('Be the first to %1$swrite%2$s one!', '<a href="'.$this->url(array('action' => 'create'), 'blog_general').'">', '</a>'); ?>
      <?php endif; ?>
    </span>
  </div>
<?php endif; ?>


<?php echo $this->paginationControl($this->paginator, null, null, array(
  'pageAsQuery' => true,
  'query' => $this->formValues,
  //'params' => $this->formValues,
)); ?>
