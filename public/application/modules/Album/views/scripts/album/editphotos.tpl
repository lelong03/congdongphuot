<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Album
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: editphotos.tpl 9747 2012-07-26 02:08:08Z john $
 * @author     Sami
 */
?>

<div class="headline">
  <h2>
    <?php echo $this->translate('Photo Albums');?>
  </h2>
  <div class="tabs">
    <?php
      // Render the menu
      echo $this->navigation()
        ->menu()
        ->setContainer($this->navigation)
        ->render();
    ?>
  </div>
</div>

<div class="layout_middle">
<h3>
  <?php echo $this->htmlLink($this->album->getHref(), $this->album->getTitle()) ?>
  (<?php echo $this->translate(array('%s photo', '%s photos', $this->album->count()),$this->locale()->toNumber($this->album->count())) ?>)
</h3>

<?php if( $this->paginator->count() > 0 ): ?>
  <br />
  <?php echo $this->paginationControl($this->paginator); ?>
  <br />
  <div class="tip">
    <span>
      <?php echo $this->translate("Lưu thay đổi trước khi chuyển trang!") ?>
    </span>
  </div>
<?php endif; ?>


<form action="<?php echo $this->escape($this->form->getAction()) ?>" method="<?php echo $this->escape($this->form->getMethod()) ?>">
  <?php echo $this->form->album_id; ?>
  <ul class='albums_editphotos'>
    <?php foreach( $this->paginator as $photo ): ?>
      <li>
        <div class="albums_editphotos_photo">
          <?php echo $this->htmlLink($photo->getHref(), $this->itemPhoto($photo, 'thumb.normal'))  ?>
        </div>
        <div class="albums_editphotos_info">
          <?php
            $key = $photo->getGuid();
            echo $this->form->getSubForm($key)->render($this);
          ?>
          <div class="albums_editphotos_cover">
            <input type="radio" name="cover" value="<?php echo $photo->getIdentity() ?>" <?php if( $this->album->photo_id == $photo->getIdentity() ): ?> checked="checked"<?php endif; ?> />
          </div>
          <div class="albums_editphotos_label">
            <label><?php echo $this->translate('Album Cover');?></label>
        </div>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
  
  <?php echo $this->form->submit->render(); ?>
</form>

<?php if( $this->paginator->count() > 0 ): ?>
  <br />
  <div class="tip">
    <span>
      <?php echo $this->translate("Lưu thay đổi trước khi chuyển trang!") ?>
    </span>
  </div>
  <br />
  <?php echo $this->paginationControl($this->paginator); ?>
<?php endif; ?>
</div>