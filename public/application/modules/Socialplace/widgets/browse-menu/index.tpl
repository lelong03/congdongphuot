<div class="headline">
	<h2 style="width: 92px;">
		<?php echo $this->translate('Social Places') ?>
	</h2>
	<div class="tabs">
	<?php
		// Render the menu
		echo $this->navigation()
		->menu()
		->setContainer($this->navigation)
		->render();
		?>
	</div>
</div>
