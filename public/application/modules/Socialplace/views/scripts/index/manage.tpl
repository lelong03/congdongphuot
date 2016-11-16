<?php if( $this->paginator->getTotalItemCount() > 0 ): ?>
    <ul class="places_browse">
      <?php foreach( $this->paginator as $item ): ?>
        <li>
          <div class='places_browse_photo'>
            <?php echo $this->htmlLink($item->getHref(), $this->itemPhoto($item, 'thumb.normal')) ?>
          </div>
          <div class='places_browse_options'>
            <?php echo $this->htmlLink(array(
              'action' => 'edit',
              'place_id' => $item->getIdentity(),
              'route' => 'socialplace_specific',
              'reset' => true,
            ), $this->translate('Edit Place'), array(
              'class' => 'buttonlink icon_place_edit',
            )) ?>
            <?php
            echo $this->htmlLink(array('route' => 'socialplace_specific', 'action' => 'delete', 'place_id' => $item->getIdentity(), 'format' => 'smoothbox'), $this->translate('Delete Place'), array(
              'class' => 'buttonlink smoothbox icon_place_delete'
            ));
            ?>
          </div>
          <div class='places_browse_info'>
            <p class='places_browse_info_title'>
              <?php echo $this->htmlLink($item->getHref(), $item->getTitle()) ?>
            </p>
            <p class='places_browse_info_date'>
              <?php echo $this->translate('Posted by');?>
              <?php echo $this->htmlLink($item->getOwner()->getHref(), $item->getOwner()->getTitle()) ?>
              <?php echo $this->translate('about');?>
              <?php echo $this->timestamp(strtotime($item->creation_date)) ?>
            </p>
            <p class='places_browse_info_blurb'>
              <?php echo $this->string()->truncate($this->string()->stripTags($item->body), 150) ?>
            </p>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>

  <?php elseif($this->search): ?>
    <div class="tip">
      <span>
        <?php echo $this->translate('You do not have any place.');?>
      </span>
    </div>
  <?php else: ?>
    <div class="tip">
      <span>
        <?php echo $this->translate('You do not have any place.');?>
        <?php if( $this->canCreate ): ?>
          <?php echo $this->translate('Get started by %1$swriting%2$s a new entry.', '<a href="'.$this->url(array('action' => 'create'), 'socialplace_general').'">', '</a>'); ?>
        <?php endif; ?>
      </span>
    </div>
  <?php endif; ?>

  <?php echo $this->paginationControl($this->paginator, null, null, array(
    'pageAsQuery' => true,
    'query' => $this->formValues,
  )); ?>


<script type="text/javascript">
  $$('.core_main_socialplace').getParent().addClass('active');
</script>
