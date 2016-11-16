<style>
#home_events_listing{
	text-align: center;
	background-color: #F8F5EF;
}

#home_events_listing .home_event_item{
	position: relative;
	height: 350px;
	width: 240px;
	display: inline-block;
	margin-left: 35px;
	margin-right: 35px;
	margin-bottom: 30px;
}
#home_events_listing .home_event_item div.event_photo{
	width: 230px;
	height: 230px;
	-webkit-border-radius: 115px;
	-moz-border-radius: 115px;
	border-radius: 115px;
	background-position: center !important;
	background-size: cover !important;
	border: 5px solid white;
}

#home_events_listing .home_event_item div.event_info {
	width: 100%;
	height: 180px;
	background: white;
	position: absolute;
	top: 196px;
	text-align: center;
}

#home_events_listing .home_event_item div.event_info strong{
	font: 24px raleway,sans-serif;
	color: #726277;
}

#home_events_listing .home_event_item div.event_info .events_title{
	border-bottom: 1px dashed #555;
	text-align: center;
}

#home_events_listing .home_event_item div.event_info .events_members_new{
	margin-bottom: 7px;
	border-bottom: 1px dashed #555;
	padding-bottom: 7px;
	padding-left: 15px;
	padding-right: 15px;
}

#home_events_listing .home_event_item .event_location,
#home_events_listing .home_event_item .event_destination{
	clear: both;
	overflow: hidden;
	white-space: nowrap;
	text-overflow: ellipsis;
}
</style>
<?php if (count($this->events)) :?>
	<ul id="home_events_listing">
		<?php foreach ($this->events as $event) : ?>
			<?php 
			$eventPhoto = $event->getPhotoUrl();
			if (!$eventPhoto)
			{
	$eventPhoto = $this->baseUrl() . "/application/modules/Event/externals/images/nophoto_event_thumb_profile.png";
			}			
			?>
			<li class="home_event_item">
				<div class="event_photo" style="background: url(<?php echo $eventPhoto ?>)"></div>
				<div class="event_info">


					
				        <div class="events_title">
				            <h3 title="<?php echo $event->getTitle();?>">
				            	<?php echo $this->htmlLink($event->getHref(), $this->string()->truncate($event->getTitle(), 35)) ?>
				            </h3>
				        </div>
			  		    <div class="events_members_new">
			      			<div class="event_location">
			      				<?php echo $event->location; ?>
			      			</div>
			    			<div class="event_destination">
			    				<?php echo $event->destination;?>
			    			</div>
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
							<div class="event_startdate">
								<?php echo $this->translate('%1$s', $this->locale()->toDate($startDateObject)) ?>
							</div>
							<div class="event_enddate">
								<?php echo $this->translate('%1$s', $this->locale()->toDate($endDateObject)) ?>
							</div>
						</div>
			        	<div class="events_members_new">
				            <?php echo $this->translate('led by') . " "; ?>
				            <?php echo $this->htmlLink($event->getOwner()->getHref(), $event->getOwner()->getTitle()) ?>
			        	</div>
			        


				</div>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>