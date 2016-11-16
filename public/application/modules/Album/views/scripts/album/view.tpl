<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Album
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: view.tpl 9987 2013-03-20 00:58:10Z john $
 * @author     Sami
 */
?>
<?php $albumDes = $this->string()->truncate($this->string()->stripTags($this->album->getDescription()), 300); ?>
<?php 
$http = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://' ;
$this->serverName = $http . $_SERVER['SERVER_NAME'];
?>
<?php
    $this->headMeta()->appendName('og:type', 'profile');
    $this->headMeta()->appendName('og:title', $this->album->getTitle());
    $this->headMeta()->appendName('og:description', $albumDes);
    $this->headMeta()->appendName('og:image', $this->serverName . $this->baseUrl() . $this->album->getPhotoUrl());
    $this->headMeta()->appendName('og:url', $this->serverName . $this->baseUrl() . $this->album->getHref());
    $this->headMeta()->appendName('og:site_name', $this->album->getTitle());
    $this->headMeta()->appendName('og:see_also', 'http://www.congdongphuot.com'); 
?>
<?php
    $this->headMeta()->appendName('name', $this->album->getTitle());
    $this->headMeta()->appendName('description', $albumDes);
    $this->headMeta()->appendName('image', $this->serverName . $this->baseUrl() . $this->album->getPhotoUrl());
?>
<?php
    $this->headMeta()->appendName('twitter:card', 'summary');
    $this->headMeta()->appendName('twitter:site', $this->serverName . $this->baseUrl() . $this->album->getHref());
    $this->headMeta()->appendName('twitter:title', $this->album->getTitle());
    $this->headMeta()->appendName('twitter:description', $albumDes);
    $this->headMeta()->appendName('twitter:image:src', $this->serverName . $this->baseUrl() . $this->album->getPhotoUrl());
    $this->headMeta()->appendName('twitter:domain', 'http://www.congdongphuot.com');
?>
<?php 
$this->headScript()->appendScript('var switchTo5x=true;');
$this->headScript()->appendFile('http://w.sharethis.com/button/buttons.js');
$this->headScript()->appendScript('stLight.options({publisher: "c611dbd7-4b3f-40ed-98fe-f80029b67e74", doNotHash: false, doNotCopy: false, hashAddressBar: false, closeDelay:0});');
?>


<h2>
  <?php echo $this->translate('%1$s\'s Album: %2$s',
    $this->album->getOwner()->__toString(),
    ( '' != trim($this->album->getTitle()) ? $this->album->getTitle() : '<em>' . $this->translate('Untitled') . '</em>')
  ); ?>
</h2>

<?php if( $this->mine || $this->canEdit ): ?>
  <script type="text/javascript">
    var SortablesInstance;

    en4.core.runonce.add(function() {
      $$('.thumbs_nocaptions > li').addClass('sortable');
      SortablesInstance = new Sortables($$('.thumbs_nocaptions'), {
        clone: true,
        constrain: true,
        //handle: 'span',
        onComplete: function(e) {
          var ids = [];
          $$('.thumbs_nocaptions > li').each(function(el) {
            ids.push(el.get('id').match(/\d+/)[0]);
          });
          //console.log(ids);

          // Send request
          var url = '<?php echo $this->url(array('action' => 'order')) ?>';
          var request = new Request.JSON({
            'url' : url,
            'data' : {
              format : 'json',
              order : ids
            }
          });
          request.send();
        }
      });
    });
  </script>
<?php endif ?>

<?php if( '' != trim($this->album->getDescription()) ): ?>
  <p>
    <?php echo $this->album->getDescription() ?>
  </p>
  <br />
<?php endif ?>

<?php if( $this->mine || $this->canEdit ): ?>
  <div class="album_options">
    <?php echo $this->htmlLink(array('route' => 'album_general', 'action' => 'upload', 'album_id' => $this->album->album_id), $this->translate('Add More Photos'), array(
      'class' => 'buttonlink icon_photos_new'
    )) ?>
    <?php echo $this->htmlLink(array('route' => 'album_specific', 'action' => 'editphotos', 'album_id' => $this->album->album_id), $this->translate('Manage Photos'), array(
      'class' => 'buttonlink icon_photos_manage'
    )) ?>
    <?php echo $this->htmlLink(array('route' => 'album_specific', 'action' => 'edit', 'album_id' => $this->album->album_id), $this->translate('Edit Settings'), array(
      'class' => 'buttonlink icon_photos_settings'
    )) ?>
    <?php echo $this->htmlLink(array('route' => 'album_specific', 'action' => 'delete', 'album_id' => $this->album->album_id, 'format' => 'smoothbox'), $this->translate('Delete Album'), array(
      'class' => 'buttonlink smoothbox icon_photos_delete'
    )) ?>
  </div>
<?php endif;?>

<div class="layout_middle">
  <ul class="thumbs thumbs_nocaptions">
    <?php foreach( $this->paginator as $photo ): ?>
      <li id="thumbs-photo-<?php echo $photo->photo_id ?>">
        <a class="thumbs_photo" href="<?php echo $photo->getHref(); ?>">
          <span style="background-image: url(<?php echo $photo->getPhotoUrl('thumb.normal'); ?>);"></span>
        </a>
      </li>
    <?php endforeach;?>
  </ul>
  <?php if( $this->paginator->count() > 0 ): ?>
    <br />
    <?php echo $this->paginationControl($this->paginator); ?>
  <?php endif; ?>

</div>

<div style="margin-top: 10px;">
<span class='st_facebook_large' displayText='Facebook'></span>
<span class='st_googleplus_large' displayText='Google +'></span>
<span class='st_twitter_large' displayText='Tweet'></span>
<span class='st_pinterest_large' displayText='Pinterest'></span>
<span class='st_email_large' displayText='Email'></span>
</div>

<script type="text/javascript">
  $$('.core_main_album').getParent().addClass('active');
</script>
