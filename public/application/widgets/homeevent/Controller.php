<?php
class Widget_HomeeventController extends Engine_Content_Widget_Abstract
{
	public function indexAction()
 	{
 		$eventTbl = Engine_Api::_()->getItemTable('event');
 		$eventSelect = $eventTbl
 		->select()
        ->where("featured = ?", '1')
        ->order("event_id DESC")
 		->limit(3);
 		$this->view->events = $eventTbl->fetchAll($eventSelect);
 	}
}
