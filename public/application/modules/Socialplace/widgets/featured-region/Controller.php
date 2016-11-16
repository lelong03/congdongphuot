<?php
class Socialplace_Widget_FeaturedRegionController extends Engine_Content_Widget_Abstract 
{
	public function indexAction() 
    {
    	$regionTable = Engine_Api::_()->getItemTable('socialplace_region');
    	$select = $regionTable -> select() -> where("featured = 1");
    	$this -> view -> regions = $regions = $regionTable -> fetchAll($select); 
    	if (count($regions) == 0)
    	{
    		return $this -> setNoRender();
    	}
    }
}