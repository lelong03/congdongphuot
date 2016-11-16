<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Classified
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: index.tpl 9747 2012-07-26 02:08:08Z john $
 * @author     John
 */
?>

<ul class="generic_list_widget">
  <?php foreach( $this->paginator as $item ): ?>
    <li>
      <div class="photo" style="float: left;">
        <?php //echo $this->htmlLink($item->getHref(), $this->itemPhoto($item, 'thumb.icon'), array('class' => 'thumb')) 
			echo $this->htmlLink($item->getHref(), $this->itemPhoto($item->getOwner(), 'thumb.icon'), array('class' => 'thumb')) 
		?>
      </div>
      <div class="info">
        <div class="title">
          <?php echo $this->htmlLink($item->getHref(), $item->getTitle()) ?>
        </div>
        <div>
			
			<span class="event_location">
				<?php echo $item->location; ?>
			</span>
			 - 
			<span class="event_destination">
				<?php echo $item->destination;?>
			</span>
		  
          
        </div>
        <div class="stats">
          <?php 
            $startDateObject = new Zend_Date(strtotime($item->starttime));
            $endDateObject = new Zend_Date(strtotime($item->endtime));
          ?>
          <?php echo $this->translate('%1$s',
            $this->locale()->toDate($startDateObject)
          ) ?>
          - 
          <?php echo $this->translate('%1$s',
            $this->locale()->toDate($endDateObject)
          ) ?>

          - <?php echo $this->translate('hosted by %1$s',
              $this->htmlLink($item->getOwner()->getHref(), $item->getOwner()->getTitle())) ?>
          <?php if( $this->popularType == 'view' ): ?>
            - <?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count)) ?>
          <?php else /*if( $this->popularType == 'member' )*/: ?>
            - <?php echo $this->translate(array('%s member', '%s members', $item->member_count), $this->locale()->toNumber($item->member_count)) ?>
          <?php endif; ?>
        </div>
      </div>
    </li>
  <?php endforeach; ?>
  <li>
    <div style="text-align: right; font-size: 11.8px;"><a href="<?php echo $this -> url(array(), 'event_general') ?>"><?php echo $this->translate("View more"); ?></a></div>
  </li>
</ul>
