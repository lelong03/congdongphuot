<script type="text/javascript">
var check_return_url = false;
var seMiniMenu = {	
	updateAllElement: function()
	{
		if($$('.core_mini_messages')[0] !== null && $$('.core_mini_messages')[0] !== undefined)
		{
			var message_element = $$('.core_mini_messages')[0].parentNode;
			message_element.style.display = 'none';
		}
		if(document.getElementById('core_menu_mini_menu_update') !== null && document.getElementById('core_menu_mini_menu_update') !== undefined)
		{
			var update_element = document.getElementById('core_menu_mini_menu_update');
			update_element.style.display = 'none';
			
			var li_notification_icons = document.createElement("li");
    		li_notification_icons.className = 'seminimenu_notification';
    		li_notification_icons.innerHTML = '<img src="./application/modules/Seminimenu/externals/images/loading.gif"/>';
    		update_element.parentNode.insertBefore(li_notification_icons, update_element.nextSibling);
			
    		li_notification_icons.innerHTML = <?php echo $this->html_json_notification;?>;
    		seMiniMenu.addNotificationScript();
		}
		var flag = 0;
		if($$('.core_mini_profile')[0] !== null && $$('.core_mini_profile')[0] !== undefined)
		{
			flag = 1;
			var profile_element = $$('.core_mini_profile')[0];
			var parent_element = profile_element.parentNode;
    		parent_element.className = 'seminimenu_MyProfile';
    		parent_element.innerHTML = <?php echo $this->html_json_profile;?>;
    		seMiniMenu.doAddSubMenu();
		}
		if(flag == 0)
		{
			seMiniMenu.doAddSubMenu();
		}
	},
	disableAllSubMenu: function()
	{
		// disable all sub mini menu
		<?php foreach($this->arr_sub_mini as $value):?>
		    seMiniMenu.doDisableMenu('<?php echo $value;?>');
		<?php endforeach;?>
	},
	doDisableMenu: function(name)
	{
		var sub_menu_item = $$('.'+ name)[0];
		if(sub_menu_item !== null && sub_menu_item !== undefined)
		{
			sub_menu_item.parentNode.style.display = 'none';
		}
	},
	doAddSubMenu: function()
	{
		// Add sub menu for mini menu
		<?php foreach($this->arr_objectParent as $key => $html_json):?>
			seMiniMenu.doAddEachSubMiniMenu('<?php echo $key?>',<?php echo $html_json;?>);
		<?php endforeach;?>
	},
	doAddEachSubMainMenu: function(key, html)
	{
		var parent_menu_item = $$('.'+ key)[0];
		if(parent_menu_item !== null && parent_menu_item !== undefined)
		{
			var parent_item = parent_menu_item.parentNode;
			parent_item.className += ' seminimenu_downservicesMain';
			parent_item.innerHTML = html;
		}
	},
	doAddEachSubMiniMenu: function(key, html)
	{
		var parent_menu_item = $$('.'+ key)[0];
		if(parent_menu_item !== null && parent_menu_item !== undefined)
		{
			var parent_item = parent_menu_item.parentNode;
			parent_item.className += ' seminimenu_downservices';
			parent_item.innerHTML = html;
		}
	},
	actionSeMiniMenu: function()
	{
		seMiniMenu.disableAllSubMenu();
		seMiniMenu.updateAllElement();
	},
	mouseoverMiniMenuPulldown: function(event, element, user_id) 
	{
	    element.className= 'updates_pulldown_active';
  	},
  	mouseoutMiniMenuPulldown: function(event, element, user_id) 
	{
		element.className='updates_pulldown';
	},
	addNotificationScript: function()
		{
			if (typeof jQuery != 'undefined') { 
		     jQuery.noConflict();
		  }
		  var notificationUpdater;
		  var hide_all_drop_box = function(except)
		  {
		      //hide all sub-minimenu
		      $$('.updates_pulldown_active').set('class','updates_pulldown');
		      // reset inbox
		      if (except != 1) {
		          $('seminimenu_messages').removeClass('notifyactive');
		          $('seminimenu_messageUpdates').hide();
		          inbox_status = false;
		          inbox_count_down = 1;
		      }
		      if (except != 2) {
		          // reset friend
		          $('seminimenu_friends').removeClass('notifyactive');
		          $('seminimenu_friendUpdates').hide();
		          friend_status = false;
		          friend_count_down = 1;
		      }
		      if (except != 3) {
		            // reset notification
		          $('seminimenu_updates').removeClass('notifyactive');
		          $('seminimenu_notificationUpdates').hide();
		          notification_status = false;
		          notification_count_down = 1;
		      }
		  }
		 //refresh box
		  var refreshBox = function(box) {
		      var img_loading = '<?php echo $this->baseUrl(); ?>/application/modules/Seminimenu/externals/images/loading.gif';
		      if (box == 1) {
		          // refresh message box
		          inbox_count_down = 1;
		          $('seminimenu_messages_content').innerHTML = '<center><img src="'+ img_loading +'" border="0" /></center>';
		          inbox();
		      } else if (box == 2) {
		          // refresh friend box
		          friend_count_down = 1;
		          $('seminimenu_friends_content').innerHTML = '<center><img src="'+ img_loading +'" border="0" /></center>';
		          freq();
		      } else if (box == 3) {
		          // refresh notification box
		          notification_count_down = 1;
		          $('seminimenu_updates_content').innerHTML = '<center><img src="'+ img_loading +'" border="0" /></center>';
		          notification();
		      }
		  }
		var isLoaded = [0, 0, 0]; // friend request, message, notifcation
		var timerNotificationID = 0;
		//time to check for notification updates (in seconds)
		var updateTimes = <?php echo Engine_Api::_()->getApi('settings','core')->getSetting('core.general.notificationupdate',30000) ?>; 
		var getNotificationsTotal = function()
		{
		    var notif = new Request.JSON({
		           url    :    '<?php echo $this->layout()->staticBaseUrl?>' + 'application/lite.php?module=seminimenu&name=total&viewer_id=' + <?php echo $this->viewer->getIdentity() ?>,
		           onSuccess : function(data) {
		                if(data != null)
		                {
		                       if (data.notification > 0) {
		                            var notification_count = $('seminimenu_NotifyCount');
		                            notification_count.set('text', data.notification);
		                            notification_count.getParent().setStyle('display', 'block');
		                            $('seminimenu_NotificationsUpdates').className += " seminimenu_hasNotify";
		                            isLoaded[2] = 0;
		                       }
		                       else
		                       {
		                          var notification_count = $('seminimenu_NotifyCount');
		                          notification_count.getParent().setStyle('display', 'none'); 
		                          $('seminimenu_NotificationsUpdates').className = "seminimenu_mini_wrapper"; 
		                       }
		                       if (data.freq > 0) {
		                            var friend_req_count = $('seminimenu_FriendCount');
		                            friend_req_count.set('text', data.freq);
		                            friend_req_count.getParent().setStyle('display', 'block');
		                            $('seminimenu_FriendsRequestUpdates').className += " seminimenu_hasNotify";
		                            isLoaded[0] = 0;
		                       }
		                       else
		                       {
		                           var friend_req_count = $('seminimenu_FriendCount');
		                           friend_req_count.getParent().setStyle('display', 'none');
		                           $('seminimenu_FriendsRequestUpdates').className = "seminimenu_mini_wrapper"; 
		                       }
		                       if (data.msg > 0) {
		                            var msg_count = $('seminimenu_MessageCount');
		                            msg_count.set('text', data.msg);
		                            msg_count.getParent().setStyle('display', 'block');
		                            $('seminimenu_MessagesUpdates').className += " seminimenu_hasNotify";
		                            isLoaded[1] = 0;
		                       }
		                       else
		                       {
		                            var msg_count = $('seminimenu_MessageCount');
		                             msg_count.getParent().setStyle('display', 'none');
		                             $('seminimenu_MessagesUpdates').className = "seminimenu_mini_wrapper";
		                       }
		                }              
		           }
		    }).get();
		    <?php if($this->viewer()->getIdentity() > 0): ?>
		    if(updateTimes > 10000){
		        timerNotificationID = setTimeout(getNotificationsTotal, updateTimes);
		    }
		    <?php endif; ?>
		}
		
		// DOM READY
		window.addEvent('domready', function(){
		    // Load notification, friend request, message in total
		    en4.core.runonce.add(getNotificationsTotal);
		});
		var inbox = function() {
		       new Request.HTML({
		           'url'    :    en4.core.baseUrl + 'seminimenu/index/message',
		           'data' : {
		                'format' : 'html',
		                'page' : 1
		            },
		            'onComplete' : function(responseTree, responseElements, responseHTML, responseJavaScript) {
		                        if(responseHTML)
		                        {
		                              $('seminimenu_messages_content').innerHTML = responseHTML;
		                              $('seminimenu_MessageCount').getParent().setStyle('display', 'none'); 
		                              $('seminimenu_MessagesUpdates').removeClass('seminimenu_hasNotify'); 
		                              $('seminimenu_messages_content').getChildren('ul').getChildren('li').each(function(el){
		                                  el.addEvent('click', function(){inbox_count_down = 1;});
		                              });
		                        }
		            }
		       }).send();
		   }
		   //inbox();
		
		   var freq = function() {
		       new Request.HTML({
		           'url'    :    en4.core.baseUrl + 'seminimenu/index/friend',
		           'data' : {
		                'format' : 'html',
		                'page' : 1
		            },
		            'onComplete' : function(responseTree, responseElements, responseHTML, responseJavaScript) {
		                if(responseHTML)
		                { 
		                    $('seminimenu_friends_content').innerHTML = responseHTML;
		                    $('seminimenu_FriendCount').getParent().setStyle('display', 'none');
		                    $('seminimenu_FriendsRequestUpdates').removeClass('seminimenu_hasNotify');
		                    $('seminimenu_friends_content').getChildren('ul').getChildren('li').each(function(el){
		                           el.addEvent('click', function(){friend_count_down = 1;});
		                    });
		                }
		            }
		       }).send();
		   }
		   //freq();
		
		   var notification = function() {
		       new Request.HTML({
		           'url'    :    en4.core.baseUrl + 'seminimenu/index/notification',
		           'data' : {
		                'format' : 'html',
		                'page' : 1
		            },
		            'onComplete' : function(responseTree, responseElements, responseHTML, responseJavaScript) {
		                if(responseHTML)
		                { 
		                    $('seminimenu_updates_content').innerHTML = responseHTML;    
		                    $('seminimenu_NotifyCount').getParent().setStyle('display', 'none');  
		                    $('seminimenu_NotificationsUpdates').removeClass('seminimenu_hasNotify');      
		                    $('seminimenu_updates_content').getChildren('ul').getChildren('li').each(function(el){
		                       el.addEvent('click', function(){notification_count_down = 1;});
		                    });
		                }
		            }
		       }).send();
		   }
		   //notification();
		  // Show Inbox Message
		  var inbox_count_down = 1;
		  var inbox_status = false; // false -> not shown, true -> shown
		  $('seminimenu_messages').addEvent('click', function() 
		  {
		      hide_all_drop_box(1);
		      if (inbox_status) inbox_count_down = 1; 
		      if (!inbox_status) {
		          // show
		          $(this).addClass('notifyactive');
		          $('seminimenu_messageUpdates').setStyle('display', 'block');
		      } else {
		          // hide
		          $(this).removeClass('notifyactive');
		          $('seminimenu_messageUpdates').setStyle('display', 'none');
		      }
		      inbox_status = inbox_status ? false : true;
		      if (isLoaded[1] == 0) 
		      {
		          refreshBox(1);
		          isLoaded[1] = 1;
		      }
		  });
		  // Friend box
		  var friend_count_down = 1;
		  var friend_status = false;
		  $('seminimenu_friends').addEvent('click', function(){
		      hide_all_drop_box(2);
		      if (friend_status) friend_count_down = 1;
		      if (!friend_status) {
		          $(this).addClass('notifyactive');
		          $('seminimenu_friendUpdates').setStyle('display', 'block');
		      } else {
		          $(this).removeClass('notifyactive');
		          $('seminimenu_friendUpdates').setStyle('display', 'none');
		      }
		      friend_status = friend_status ? false : true; 
		
		      // Set all message as read
		      if (isLoaded[0] == 0) {
		          refreshBox(2);
		          isLoaded[0] = 1;   // get again is check isloaded = 0      
		      }
		  });
		  //Notification box
		  var notification_count_down = 1;
		  var notification_status = false;
		  $('seminimenu_updates').addEvent('click', function(){
		      hide_all_drop_box(3);
		      if (notification_status) notification_count_down = 1;
		      if (!notification_status) {
		          // active
		          $(this).addClass('notifyactive');
		          $('seminimenu_notificationUpdates').setStyle('display', 'block');
		      } else {
		          $(this).removeClass('notifyactive');
		          $('seminimenu_notificationUpdates').setStyle('display', 'none');
		      }
		      notification_status = notification_status ? false : true;
		
		      if (isLoaded[2] == 0) {
		          refreshBox(3);
		          isLoaded[2] = 1;
		      }
		  });
		  do_confrim_friend = false;
		  $(document).addEvent('click', function() {
		        if (inbox_status && inbox_count_down <= 0) {
		            $('seminimenu_messages').removeClass('notifyactive');
		            $('seminimenu_messageUpdates').setStyle('display', 'none');
		                inbox_status = false;            
		                inbox_count_down = 1;
		        } else if (inbox_status) {
		            inbox_count_down = (inbox_count_down <= 0) ? 0 : --inbox_count_down;
		        }         
		        
		        if (friend_status && friend_count_down <= 0) {
		            if (do_confrim_friend) {do_confrim_friend = false; return false;}
		            $('seminimenu_friends').removeClass('notifyactive');
		            $('seminimenu_friendUpdates').setStyle('display', 'none');
		            friend_status = false;            
		            friend_count_down = 1;
		        } else if (friend_status) {
		            friend_count_down = (friend_count_down <= 0) ? 0 : --friend_count_down;
		        } 
		        if (notification_status && notification_count_down <= 0) {
		            $('seminimenu_updates').removeClass('notifyactive');
		            $('seminimenu_notificationUpdates').setStyle('display', 'none');
		            notification_status = false;            
		            notification_count_down = 1;
		        } else if (notification_status) {
		            notification_count_down = (notification_count_down <= 0) ? 0 : --notification_count_down;
		        }
		   });
		var firefox = false;
		if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)){ //test for Firefox/x.x or Firefox x.x (ignoring remaining digits);
		 var ffversion=new Number(RegExp.$1) // capture x.x portion and store as a number
		 if (ffversion>=1)
		 {
		     firefox = true;
		 } 
		}
		
		var isMouseLeaveOrEnter = function(e, handler)
		{    
		    if (e.type != 'mouseout' && e.type != 'mouseover') return false;
		    var reltg = e.relatedTarget ? e.relatedTarget :
		    e.type == 'mouseout' ? e.toElement : e.fromElement;
		    while (reltg && reltg != handler) reltg = reltg.parentNode;
		    return (reltg != handler);
		}
		}
}
document.onload = seMiniMenu.actionSeMiniMenu(); 
</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5062bc0a35087991" async="async"></script>
