<script type="text/javascript">
en4.core.runonce.add(function()
{
    var anchor = $('socialplace_profile_photos').getParent();
    $('socialplace_profile_photos_previous').style.display = '<?php echo ( $this->paginator->getCurrentPageNumber() == 1 ? 'none' : '' ) ?>';
    $('socialplace_profile_photos_next').style.display = '<?php echo ( $this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' ) ?>';

    $('socialplace_profile_photos_previous').removeEvents('click').addEvent('click', function(){
      en4.core.request.send(new Request.HTML({
        url : en4.core.baseUrl + 'widget/index/content_id/' + <?php echo sprintf('%d', $this->identity) ?>,
        data : {
          format : 'html',
          subject : en4.core.subject.guid,
          page : <?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() - 1) ?>
        }
      }), {
        'element' : anchor
      })
    });

    $('socialplace_profile_photos_next').removeEvents('click').addEvent('click', function(){
      en4.core.request.send(new Request.HTML({
        url : en4.core.baseUrl + 'widget/index/content_id/' + <?php echo sprintf('%d', $this->identity) ?>,
        data : {
          format : 'html',
          subject : en4.core.subject.guid,
          page : <?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>
        }
      }), {
        'element' : anchor
      })
    });
  });
</script>

<?php if( $this->canUpload ): ?>
<div class="socialplace_album_options">
    <?php if( $this->canUpload ): ?>
    <?php echo $this->htmlLink(array(
    'route' => 'socialplace_extended',
    'controller' => 'photo',
    'action' => 'upload',
    'subject' => $this->subject()->getGuid(),
    ), $this->translate('Upload Photos'), array(
    'class' => 'buttonlink icon_socialplace_photo_new'
    )) ?>
    <?php endif; ?>
</div>
<br />
<?php endif; ?>

<?php if( $this->paginator->getTotalItemCount() > 0 ): ?>

<ul class="thumbs" id="socialplace_profile_photos">
    <?php 
    $thumb_photo = 'thumb.normal';
		if(defined('YNRESPONSIVE'))
		{
			$thumb_photo = 'thumb.profile';
		}
    foreach( $this->paginator as $photo ): ?>
      <li>
        <a class="thumbs_photo" href="<?php echo $photo->getHref(); ?>">
          <span style="background-image: url(<?php echo $photo->getPhotoUrl($thumb_photo); ?>);"></span>
        </a>
        <p class="thumbs_info">
          <?php echo $this->translate('By');?>
          <?php echo $this->htmlLink($photo->getOwner()->getHref(), $photo->getOwner()->getTitle(), array('class' => 'thumbs_author')) ?>
          <br />
          <?php echo $this->timestamp($photo->creation_date) ?>
        </p>
      </li>
    <?php endforeach;?>
  </ul>
<div>
  <div id="socialplace_profile_photos_previous" class="paginator_previous">
    <?php echo $this->htmlLink('javascript:void(0);', $this->translate('Previous'), array(
      'onclick' => '',
      'class' => 'buttonlink icon_previous'
    )); ?>
  </div>
  <div id="socialplace_profile_photos_next" class="paginator_next">
    <?php echo $this->htmlLink('javascript:void(0);', $this->translate('Next'), array(
      'onclick' => '',
      'class' => 'buttonlink_right icon_next'
    )); ?>
  </div>
</div>
<?php else: ?>

<div class="tip">
    <span>
      <?php echo $this->translate('No photos have been uploaded to this place yet.');?>
    </span>
</div>

<?php endif; ?>

