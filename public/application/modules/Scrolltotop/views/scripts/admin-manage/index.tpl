<style>
.list_scroll_icons > li
{
	width: 118px;
	display: inline-block;
	margin-bottom: 36px;
	border: 1px solid #CCC;
	height: 100px;
	padding-top: 15px;
}
.list_scroll_icons > li:hover
{
	background-color: #CDF7CB;
	border: solid 1px #148610;
}
.list_scroll_icons > li.active
{
	background-color: #94CBF6;
	border: solid 1px #094573;
}
.list_scroll_icons > li > div
{
	text-align : center;
}
.list_scroll_icons .icon_image
{
	height: 69px;
}
</style>

<div class='clear'>
	<div class="settings">
		<form class="global_form" method="post">
			<div>
			  <h3><?php echo $this->translate("Scroll To Top Setting"); ?></h3>
			  <p class="form-description"><?php echo $this->translate("Please choose the icon for Scroll To Top button."); ?></p>
			  <ul class="list_scroll_icons">
			  	<?php for ($i=1; $i<=74; $i++):?>
			  		<li onclick="activeIcon(this);" <?php echo ($this->scroll_icon == "arrow ({$i}).png") ? 'class="active"' : '';?>>
			  			<div class="icon_image">
			  				<img src="<?php echo $this->baseUrl();?>/application/modules/Scrolltotop/externals/images/scroll_top_buttons/arrow<?php echo $i;?>.png" />
			  			</div>
			  			<div>
			  				<input type="radio" name="icon" value="arrow<?php echo $i;?>.png"  <?php echo ($this->scroll_icon == "arrow{$i}.png") ? 'checked="true"' : '';?>/>
			  			</div>
			  		</li>
			  	<?php endfor;?>
			  </ul>
			  <div id="submit-element" class="form-element">
					<button name="submit" id="submit" type="submit"><?php echo $this->translate("Save Setting"); ?></button>
			  </div>
			</div>
			
		</form>
	</div>
</div>

<script type="text/javascript">
function activeIcon(elm)
{
	$$(".list_scroll_icons > li").each(function(current_elm){
		current_elm.removeClass("active");
		current_elm.getElement("input").set("checked", false);
		
	});
	elm.addClass("active");
	elm.getElement("input").set("checked", true);
}
</script>

