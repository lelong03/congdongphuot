<?php if (count($this->messages)):?>
<script type="text/javascript">
function makeRead(actionid,href)
{
    window.location = href;
}
</script>
<?php endif;?>
<?php if (count($this->messages)): ?>
<div class="seminimenu_dropdownHaveContent">
	<ul class="seminimenu_Contentlist">
	<?php foreach ($this->messages as $item):
	        $message = $item->getInboxMessage($this->viewer());
	        $recipient = $item->getRecipientInfo($this->viewer());?>
		<?php $subject = Engine_Api::_()->user()->getUser($item->user_id)?>
		<li <?php if( !$recipient->inbox_read ): echo 'class = "seminimenu_Contentlist_unread"'; endif; ?>" onclick="makeRead(<?php echo $item->conversation_id;?>,'<?php echo $item->getHref();?>')" >
		<a onclick="makeRead(<?php echo $item->conversation_id;?>,'<?php echo  $item->getHref();?>')" class="fb_txt" href="javascript:;">
			<?php echo $this->itemPhoto($subject, 'thumb.icon');?> 
		</a>
		<div class="seminimenu_ContentlistInfo">
			<div class="seminimenu_NameUser">
				<a style="text-decoration: none" onclick="makeRead(<?php echo $item->conversation_id;?>,'<?php echo $item->getHref();?>')" href="javascript:;"><?php echo $subject->getTitle()?></a>
			</div>
			<div class="seminimenu_MessDescription">
				<?php  ( '' != ($title = trim($message->getTitle())) ||
	                  '' != ($title = trim($item->getTitle())));
	                $title = html_entity_decode(strip_tags($title));
	                echo strlen($title)>50?substr($title,0,50).'...':$title;
	                ?>
	         </div>
	         <div class="timestamp seminimenu_postIcon notification_type_message_new">
	         	<?php echo $this->timestamp($message->date)?>
	         </div>
	    </div> 
		</li>
	<?php endforeach;?>
	</ul>
</div>
<?php else:?>
<div class="seminimenu_dropdownNoContent">
	<?php echo $this->translate("You have no new messages.") ?>
</div>
<?php endif;?>
</ul>