<style>
table.admin_table tbody tr td.region_level2
{
    padding-left: 35px;
}
</style>

<h2>
    <?php echo $this->translate('Places Plugin') ?>
</h2>

<?php if( count($this->navigation) ): ?>
<div class='tabs'>
    <?php
    // Render the menu
    //->setUlClass()
    echo $this->navigation()->menu()->setContainer($this->navigation)->render()
    ?>
</div>
<?php endif; ?>

<div class='clear'>
    <div class='settings'>
        <form class="global_form" method="POST">
            <div>
                <h3><?php echo $this->translate("Places Regions") ?></h3>

                <p class="description">
                    <?php echo $this->translate("SOCIALPLACE_VIEW_SCRIPTS_ADMINSETTINGS_REGION_DESCRIPTION") ?>
                </p>
                
                <div style="margin-bottom: 10px;">
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'socialplace', 'controller' =>
                'settings', 'action' => 'add-region'), $this->translate('Add New Region'), array(
                	'class' => 'smoothbox buttonlink',
                	'style' => 'background-image: url(' . $this->layout()->staticBaseUrl . 'application/modules/Socialplace/externals/images/new_region.png);'
                )); ?>
                </div>
                
                <?php if(count($this->regions)>0):?>

                <table class='admin_table'>
                    <thead>

                    <tr>
                    	<th></th>
                        <th><?php echo $this->translate("Region Name") ?></th>
                        <th><?php echo $this->translate("Featured") ?></th>
                        <th><?php echo $this->translate("Hotel Count") ?></th>
                        <th><?php echo $this->translate("Options") ?></th>
                    </tr>

                    </thead>
                    <tbody>
                    <?php foreach ($this->regions as $region): ?>
                        <?php if ($region->parent_id == '0') :?>
                            <!-- LEVEL 1-->
                            <tr>
                            	<td>
                                	<input type="checkbox" name="region_ids[]" value="<?php echo $region->region_id;?>" />
                                </td>
                                <td><?php echo $region->region_name?></td>
                                <td style="text-align: center;">
                                	<input type="checkbox" value="1" disabled="true" <?php echo ($region->featured == '1') ? 'checked="checked"' : ''; ?> />
                                </td>
                                <td style="text-align: center;">
                                	<?php echo $region->getUsedCount();?>
                                </td>
                                <td>
                                    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'socialplace',
                                    'controller' => 'settings', 'action' => 'edit-region', 'id' =>$region->region_id),
                                    $this->translate('edit'), array(
                                    'class' => 'smoothbox',
                                    )) ?>
                                    |
                                    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'socialplace',
                                    'controller' => 'settings', 'action' => 'delete-region', 'id' =>$region->region_id),
                                    $this->translate('delete'), array(
                                    'class' => 'smoothbox',
                                    )) ?>
                                    |
                                    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'socialplace',
                                    'controller' => 'settings', 'action' => 'add-region', 'id' => $region->region_id),
                                    $this->translate('add sub region'), array(
                                    'class' => 'smoothbox',
                                    )) ?>
                                </td>
                            </tr>

                            <!-- LEVEL 2-->
                            <?php $parent = $region->region_id;?>
                            <?php foreach ($this->regions2 as $region2): ?>
                                <?php if ($region2->parent_id == $parent) :?>
                                    <tr>
                                    	<td>
		                                	<input type="checkbox" name="region_ids[]" value="<?php echo $region2->region_id;?>" />
		                                </td>
                                        <td class="region_level2"><?php echo $region2->region_name?></td>
                                        <td style="text-align: center;">
		                                	<input type="checkbox" disabled="true" value="1" <?php echo ($region2->featured == '1') ? 'checked="checked"' : ''; ?> />
		                                </td>
		                                <td style="text-align: center;">
		                                	<?php echo $region2->getUsedCount();?>
		                                </td>
                                        <td>
                                            <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'socialplace',
                                            'controller' => 'settings', 'action' => 'edit-region', 'id' =>$region2->region_id),
                                            $this->translate('edit'), array(
                                            'class' => 'smoothbox',
                                            )) ?>
                                            |
                                            <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'socialplace',
                                            'controller' => 'settings', 'action' => 'delete-region', 'id' =>$region2->region_id),
                                            $this->translate('delete'), array(
                                            'class' => 'smoothbox',
                                            )) ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>

                        <?php endif; ?>
                    <?php endforeach; ?>

                    </tbody>
                </table>

                <?php else:?>
                <br/>

                <div class="tip">
                    <span><?php echo $this->translate("There are currently no regions.") ?></span>
                </div>
                <?php endif;?>
                <br/>
				<button type="submit" name="feature" value="1"><?php echo $this -> translate("Set Featured");?></button>
				<button type="submit" name="unfeature" value="1"><?php echo $this -> translate("Unset Featured");?></button>
            </div>
        </form>
    </div>
</div>
