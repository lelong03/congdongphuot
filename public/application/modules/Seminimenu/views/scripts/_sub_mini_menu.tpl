<span onmouseover = "seMiniMenu.mouseoverMiniMenuPulldown(event, this, '4');" onmouseout = "seMiniMenu.mouseoutMiniMenuPulldown(event, this, '4');" style="display: inline-block;" class="updates_pulldown"> 			
	<div class="pulldown_contents_wrapper">
		<div class="pulldown_contents">
			<ul class="notifications_menu">
				<?php foreach($this->sub_menus as $item):?>
				<li>		
					<?php if($item->name != "core_mini_auth" || $this->return_url == ""):?>					
					<?php echo $this->htmlLink($item->getHref(), $this->translate($item->getLabel()), array_filter(array(
				        'class' => ( !empty($item->class) ? $item->class : null ),
				        'alt' => ( !empty($item->alt) ? $item->alt : null ),
				        'target' => ( !empty($item->target) ? $item->target : null ),
				      )));?>
				     <?php else:?>
				     	<?php echo $this->htmlLink($this->return_url, $this->translate($item->getLabel()), array_filter(array(
				        'class' => ( !empty($item->class) ? $item->class : null ),
				        'alt' => ( !empty($item->alt) ? $item->alt : null ),
				        'target' => ( !empty($item->target) ? $item->target : null ),
				      )));?>
				     <?php endif;?>
				</li>	
				<?php endforeach;?>				
			</ul>
		</div>
	</div>
	<?php if(!$this->parent_item && strpos($this->key, "core_mini_yntour") ):?>
		<a href="javascript:en4.yntour.startTour();" class="menu_core_mini core_mini_yntour new_updates"><?php echo $this->translate("Tour Guide");?></a>
	<?php elseif($this->parent_item->name == 'core_mini_profile'): ?>
		<?php
			$img = $this->itemPhoto($this->viewer(), 'thumb.icon');
			if($this->viewer()->getTitle() == 'admin')
			{
				echo "<a class = 'menu_core_mini core_mini_profile new_updates' href='" . $this->viewer()->getHref() . "'><div>" .$img. "</div>".$this->translate('Admin') . "</a>";
			}
			else
			{				
			  	echo $this->htmlLink($this->viewer()->getHref(), '<div>'.$img.'</div>'.strip_tags(substr($this->viewer()->getTitle(), 0, 20)),array('class'=> 'menu_core_mini core_mini_profile new_updates')); if (strlen($this->viewer()->getTitle()) > 19) echo $this->translate("...");				 
			}
			?> 
	<?php else:?>
		<?php if($this->parent_item->name != "core_mini_auth" || $this->return_url == ""):?>
			<a class=" <?php echo $this->parent_item->class?> new_updates" href="<?php echo $this->parent_item->getHref();?>"><?php echo $this->translate($this->parent_item->getLabel())?></a>
		<?php else:?>
			<a class=" <?php echo $this->parent_item->class?> new_updates" href="<?php echo $this->return_url;?>"><?php echo $this->translate($this->parent_item->getLabel())?></a>
		<?php endif;?>
	<?php endif;?>				
</span>