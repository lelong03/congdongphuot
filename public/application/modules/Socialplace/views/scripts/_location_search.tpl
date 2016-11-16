<div id="location-wrapper" class="form-wrapper">
	<div id="location-label" class="form-label">
        <label for="location" class="optional"><?php echo $this->translate("Place Location");?>
            <a href="javascript:void()" onclick="return getCurrentLocation(this);" title="<?php echo $this->translate("Click here to get current position!");?>">
                <?php echo $this->translate("Get current position"); ?>
            </a>
        </label>

	</div>
	<div id="location-element" class="form-element">
		<input type="text" name="location" id="location" value="<?php if($this->location) echo $this->location;?>" title="<?php if($this->location) echo $this->location;?>" />
	</div>
</div>

