<div id="seminimenu_MessagesUpdates" class="seminimenu_mini_wrapper">
	<a href="javascript:void(0);" class="seminimenu_NotifiIcon" id="seminimenu_messages" >
		<span id="seminimenu_MessageIconCount" class="seminimenu_NotifiIconWrapper" style="display:none"><span id="seminimenu_MessageCount"></span></span>
	</a>
	<div class="seminimenuMini_dropdownbox" id="seminimenu_messageUpdates" style="display: none;">
		<div class="seminimenu_dropdownHeader">
			<div class="seminimenu_dropdownArrow"></div>				  
		</div>
		<div class="seminimenu_dropdownTitle">
			<h3><?php echo $this->translate("Messages") ?> </h3>				
			<a href="<?php echo $this->url(array('action'=>'compose'),'messages_general', true)?>"><?php echo $this->translate("Send a New Message") ?></a>
		</div>
		<div class="seminimenu_dropdownContent" id="seminimenu_messages_content">
			<!-- Ajax get and out contetn to here -->
		</div>				
		<div class="seminimenu_dropdownFooter">
			<a class="seminimenu_seeMore" href="<?php echo $this->url(array('action'=>'inbox'),'messages_general', true) ?>">
				<span><?php echo $this->translate("See All Messages") ?> </span>
			</a>				
		</div>				
	</div>
</div>

<div id="seminimenu_FriendsRequestUpdates" class="seminimenu_mini_wrapper">
	<a href="javascript:void(0);" class="seminimenu_NotifiIcon" id = "seminimenu_friends">
		<span id="seminimenu_FriendIconCount" class="seminimenu_NotifiIconWrapper" style="display:none"><span id="seminimenu_FriendCount"></span></span>
	</a>
	<div class="seminimenuMini_dropdownbox" id="seminimenu_friendUpdates" style="display: none;">
		<div class="seminimenu_dropdownHeader">
			<div class="seminimenu_dropdownArrow"></div>				  
		</div>
		<div class="seminimenu_dropdownTitle">
			<h3><?php echo $this->translate("Friend Requests") ?> </h3>				
			<a href="<?php echo $this->url(array(),'user_general', true)?>"><?php echo $this->translate("Find Friends") ?></a>
		</div>
		<div class="seminimenu_dropdownContent" id="seminimenu_friends_content">
			<!-- Ajax get and out contetn to here -->
		</div>				
		<div class="seminimenu_dropdownFooter">
			<a class="seminimenu_seeMore" href="<?php echo $this->url(array(),'seminimenu_friend_requests')?>">
				<span><?php echo $this->translate("See All Friend Requests") ?> </span>
			</a>				
		</div>				
	</div>
</div>

<div id="seminimenu_NotificationsUpdates" class="seminimenu_mini_wrapper">
	<a href="javascript:void(0);" class="seminimenu_NotifiIcon" id = "seminimenu_updates">
		<span id="seminimenu_NotifyIconCount" class="seminimenu_NotifiIconWrapper"><span id="seminimenu_NotifyCount"></span></span>
	</a>
	<div class="seminimenuMini_dropdownbox" id="seminimenu_notificationUpdates" style="display: none;">
		<div class="seminimenu_dropdownHeader">
			<div class="seminimenu_dropdownArrow"></div>				  
		</div>
		<div class="seminimenu_dropdownTitle">
			<h3><?php echo $this->translate("Notifications") ?> </h3>									
		</div>
		<div class="seminimenu_dropdownContent" id="seminimenu_updates_content">
			<!-- Ajax get and out contetn to here -->
		</div>				
		<div class="seminimenu_dropdownFooter">
			<a class="seminimenu_seeMore" href="<?php echo $this->url(array(),'seminimenu_notifications', true)?>">
				<span><?php echo $this->translate("See All Notifications") ?> </span>
			</a>				
		</div>				
	</div>
</div>			