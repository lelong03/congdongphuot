<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Event
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: manage.tpl 9989 2013-03-20 01:13:58Z john $
 * @author     Sami
 */
?>

<?php if( count($this->paginator) > 0 ): ?>

  <div class='layout_middle'>
    <ul class='events_browse'>
      <?php foreach( $this->paginator as $event ): ?>
        <li>
          <div class="events_photo">
            <?php echo $this->htmlLink($event->getHref(), $this->itemPhoto($event, 'thumb.normal')) ?>
          </div>
          <div class="events_options">
            <?php if( $this->viewer() && $event->isOwner($this->viewer()) ): ?>
              <?php echo $this->htmlLink(array('route' => 'event_specific', 'action' => 'edit', 'event_id' => $event->getIdentity()), $this->translate('Edit Event'), array(
                'class' => 'buttonlink icon_event_edit'
              )) ?>
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'event', 'controller' => 'event', 'action' => 'delete', 'event_id' => $event->getIdentity(), 'format' => 'smoothbox'), $this->translate('Delete Event'), array(
                'class' => 'buttonlink smoothbox icon_event_delete'
              )); ?>
            <?php endif; ?>
            <?php if( $this->viewer() && !$event->membership()->isMember($this->viewer(), null) ): ?>
              <?php echo $this->htmlLink(array('route' => 'event_extended', 'controller'=>'member', 'action' => 'join', 'event_id' => $event->getIdentity()), $this->translate('Join Event'), array(
                'class' => 'buttonlink smoothbox icon_event_join'
              )) ?>
            <?php elseif( $this->viewer() && $event->membership()->isMember($this->viewer()) && !$event->isOwner($this->viewer()) ): ?>
              <?php echo $this->htmlLink(array('route' => 'event_extended', 'controller'=>'member', 'action' => 'leave', 'event_id' => $event->getIdentity()), $this->translate('Leave Event'), array(
                'class' => 'buttonlink smoothbox icon_event_leave'
              )) ?>
            <?php endif; ?>
          </div>
          <div class="events_info">
            <div class="events_title">
              <h3><?php echo $this->htmlLink($event->getHref(), $event->getTitle()) ?></h3>
            </div>
			<div class="events_members_new">
				<span class="event_location">
					<?php echo $event->location; ?>
				</span>
				 - 
				<span class="event_destination">
					<?php echo $event->destination;?>
				</span>
		  </div>
	    <div class="events_members_new">
			<?php
			// Convert the dates for the viewer
			$startDateObject = new Zend_Date(strtotime($event->starttime));
			$endDateObject = new Zend_Date(strtotime($event->endtime));
			if( $this->viewer() && $this->viewer()->getIdentity() ) {
			  $tz = $this->viewer()->timezone;
			  $startDateObject->setTimezone($tz);
			  $endDateObject->setTimezone($tz);
			}
			?>
			<span class="event_startdate">
				<?php echo $this->translate('%1$s', $this->locale()->toDate($startDateObject)) ?>
			</span>
			 - 
			<span class="event_enddate">
				<?php echo $this->translate('%1$s', $this->locale()->toDate($endDateObject)) ?>
			</span>
		</div>
            <div class="events_members_new">
              <?php echo $this->translate(array('%s guest', '%s guests', $event->membership()->getMemberCount()),$this->locale()->toNumber($event->membership()->getMemberCount())) ?>
              <?php echo $this->translate('led by') ?>
              <?php echo $this->htmlLink($event->getOwner()->getHref(), $event->getOwner()->getTitle()) ?>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>

    <?php if( $this->paginator->count() > 1 ): ?>
      <?php echo $this->paginationControl($this->paginator, null, null, array(
        'query' => array('view'=>$this->view, 'text'=>$this->text)
      )); ?>
    <?php endif; ?>
    
  </div>
<?php else: ?>
  <div class="tip">
    <span>
        <?php echo $this->translate('You have not joined any events yet.') ?>
        <?php if( $this->canCreate): ?>
          <?php echo $this->translate('Why don\'t you %1$screate one%2$s?',
            '<a href="'.$this->url(array('action' => 'create'), 'event_general').'">', '</a>') ?>
        <?php endif; ?>
    </span>
  </div>
<?php endif; ?>


<script type="text/javascript">
  $$('.core_main_event').getParent().addClass('active');
</script>
