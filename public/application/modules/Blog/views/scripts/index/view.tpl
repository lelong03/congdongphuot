<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Blog
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @author     Jung
 */
?>
<?php $blogDes = $this->string()->truncate($this->string()->stripTags($this->blog->body), 300) ?>
<?php
    $this->headMeta()->appendName('og:type', 'profile');
    $this->headMeta()->appendName('og:title', $this->blog->getTitle());
    $this->headMeta()->appendName('og:description', $blogDes);
    $this->headMeta()->appendName('og:image', $this->serverName . $this->baseUrl() . $this->blog->getPhotoUrl());
    $this->headMeta()->appendName('og:url', $this->serverName . $this->baseUrl() . $this->blog->getHref());
    $this->headMeta()->appendName('og:site_name', $this->blog->getTitle());
    $this->headMeta()->appendName('og:see_also', 'http://www.congdongphuot.com'); 
?>
<?php
    $this->headMeta()->appendName('name', $this->blog->getTitle());
    $this->headMeta()->appendName('description', $blogDes);
    $this->headMeta()->appendName('image', $this->serverName . $this->baseUrl() . $this->blog->getPhotoUrl());
?>
<?php
    $this->headMeta()->appendName('twitter:card', 'summary');
    $this->headMeta()->appendName('twitter:site', $this->serverName . $this->baseUrl() . $this->blog->getHref());
    $this->headMeta()->appendName('twitter:title', $this->blog->getTitle());
    $this->headMeta()->appendName('twitter:description', $blogDes);
    $this->headMeta()->appendName('twitter:image:src', $this->serverName . $this->baseUrl() . $this->blog->getPhotoUrl());
    $this->headMeta()->appendName('twitter:domain', 'http://www.congdongphuot.com');
?>
<?php 
$this->headScript()->appendScript('var switchTo5x=true;');
$this->headScript()->appendFile('http://w.sharethis.com/button/buttons.js');
$this->headScript()->appendScript('stLight.options({publisher: "c611dbd7-4b3f-40ed-98fe-f80029b67e74", doNotHash: false, doNotCopy: false, hashAddressBar: false, closeDelay:0});');
?>
<h2>
  <?php echo $this->blog->getTitle() ?>
</h2>

<div>
<span class='st_facebook_large' displayText='Facebook'></span>
<span class='st_googleplus_large' displayText='Google +'></span>
<span class='st_twitter_large' displayText='Tweet'></span>
<span class='st_pinterest_large' displayText='Pinterest'></span>
<span class='st_email_large' displayText='Email'></span>
</div>
<ul class='blogs_entrylist'>
  <li>
    <div class="blog_entrylist_entry_date">
      <?php echo $this->translate('Posted by');?> <?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle()) ?>
      <?php echo $this->timestamp($this->blog->creation_date) ?>
      <?php if( $this->category ): ?>
        -
        <?php echo $this->translate('Filed in') ?>
        <a href='javascript:void(0);' onclick='javascript:categoryAction(<?php echo $this->category->category_id?>);'><?php echo $this->translate($this->category->category_name) ?></a>
      <?php endif; ?>
      <?php if (count($this->blogTags )):?>
        -
        <?php foreach ($this->blogTags as $tag): ?>
          <a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'>#<?php echo $tag->getTag()->text?></a>&nbsp;
        <?php endforeach; ?>
      <?php endif; ?>
      -
      <?php echo $this->translate(array('%s view', '%s views', $this->blog->view_count), $this->locale()->toNumber($this->blog->view_count)) ?>
    </div>
    <div class="blog_entrylist_entry_body rich_content_body">
      <?php echo $this->blog->body ?>
    </div>
  </li>
</ul>
<div>
<span class='st_facebook_large' displayText='Facebook'></span>
<span class='st_googleplus_large' displayText='Google +'></span>
<span class='st_twitter_large' displayText='Tweet'></span>
<span class='st_pinterest_large' displayText='Pinterest'></span>
<span class='st_email_large' displayText='Email'></span>
</div>

<script type="text/javascript">
  $$('.core_main_blog').getParent().addClass('active');
</script>
