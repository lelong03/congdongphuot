<?php
class Socialplace_Widget_ProfileTagsController extends Engine_Content_Widget_Abstract
{
	public function indexAction()
  	{
	    $tagTbl = Engine_Api::_()->getDbtable('tags', 'core');
	    $tagMapTbl = Engine_Api::_()->getDbtable('tagMaps', 'core');
	    $placeTbl = Engine_Api::_()->getItemTable('place');
	    
	    $tName = $tagTbl->info('name');
	    $tmName = $tagMapTbl->info('name');
	    $pName = $placeTbl->info('name');

	    $filter_select = $tagMapTbl->select()->distinct()->from($tmName,array("$pName.repeat_group", "$tmName.tag_id", "$tmName.resource_type", "$tmName.resource_id"))
    	                     ->setIntegrityCheck(false)
    	                     ->joinLeft($pName,"$pName.place_id = $tmName.resource_id",'')
    	                     ->where("$pName.search = ?", "1");
	    
		
	    $select = $tagTbl->select()->from($tName,array("$tName.*","Count($tName.tag_id) as count"));
	    $select->joinLeft($filter_select, "t.tag_id = $tName.tag_id",'');
	    $select  ->order("$tName.text");
	    $select  ->group("$tName.text");
	    $select  ->where("t.resource_type = ?","place");
	    
	    if(Engine_Api::_()->core()->hasSubject('user')){
	      $user = Engine_Api::_()->core()->getSubject('user');
	      $select -> where("t.tagger_id = ?", $user->getIdentity());
	    }
	    else if( Engine_Api::_()->core()->hasSubject('place') ) {
	      $place = Engine_Api::_()->core()->getSubject('place');
	      $select -> where("t.resource_id = ?", $place->getIdentity());
	    }

	    $result = $tagTbl->fetchAll($select);
	    if (count($result) == 0) {
	    	return $this->setNoRender();
	    }
	    $this->view->tags = $result;
	    
	    $filter_select = $tagMapTbl->select()->distinct()->from($tmName,array("$pName.repeat_group", "$tmName.tag_id", "$tmName.resource_type"))
		    ->setIntegrityCheck(false)
		    ->joinLeft($pName,"$pName.place_id = $tmName.resource_id",'')
		    ->where("$pName.search = ?", "1");
	    
	    $countSelect = $tagTbl->select()->from($tName,array("$tName.tag_id","Count($tName.tag_id) as count"));
	    $countSelect  -> joinLeft($filter_select, "t.tag_id = $tName.tag_id",'');
	    $countSelect  ->order("$tName.text");
	    $countSelect  ->group("$tName.text");
	    $countSelect  ->where("t.resource_type = ?","place");

	    $tagCounter = array();
	    foreach ($tagTbl->fetchAll($countSelect) as $tag)
	    {
	    	$tagCounter[$tag->tag_id] = $tag->count;
	    }
	    $this->view->tagCounter = $tagCounter;
	}
}