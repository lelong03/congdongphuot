<script type="text/javascript">
function makeRead(actionid)
{
      en4.core.request.send(new Request.JSON({
        url : en4.core.baseUrl + 'seminimenu/index/markread',
        data : {
          format     : 'json',
          'actionid' :  actionid
        },
        'onComplete' : function(response)
        {
              var content = $('content_'+actionid).innerHTML;
              var arrHref = content.split("href");
              if(arrHref[2])
              {
                var strlink = arrHref[2];
                var arrstr = strlink.split('"');
                window.location = arrstr[1];
              }
              else if(arrHref[1])
              {
                  strlink = arrHref[1];
                  arrstr = strlink.split('"');
                  window.location = arrstr[1]; 
              }    
        }
      })); 
}
</script>	
<?php if (count($this->updates)): ?>
<div class="seminimenu_dropdownHaveContent">
	<ul class="seminimenu_Contentlist">
	<?php foreach ($this->updates as $item):
		try {?>
		<?php $subject = $item->getSubject()?>
		<li <?php if( !$item->read ): ?> class = "seminimenu_Contentlist_unread" <?php endif; ?> onclick="makeRead(<?php echo $item->getIdentity();?>)" value="<?php echo $item->getIdentity();?>" >
			<a><?php echo $this->itemPhoto($subject, 'thumb.icon');?></a>   
			<div class="seminimenu_ContentlistInfo">
				<div class="seminimenu_NameUser" id="content_<?php echo $item->getIdentity();?>" onclick="makeRead(<?php echo $item->getIdentity();?>)">
					<?php echo $item->getContent();?>
				</div>
				<div class="seminimenu_postIcon activity_icon_status notification_type_<?php echo $item->type ?>"> 
					<span class="timestamp"> <?php echo $this->timestamp($item->date)?> </span> 
				</div>
			</div>
		</li>
		 <?php
          } catch( Exception $e ) {
            continue;
          }?>
	<?php endforeach;?>
	</ul>
</div>
<?php else:?>
<div class="seminimenu_dropdownNoContent">
	<?php echo $this->translate("You have no new updates.") ?>
</div>
<?php endif;?>