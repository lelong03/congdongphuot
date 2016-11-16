<?php
class Socialplace_Model_Category extends Core_Model_Item_Abstract
{
	protected $_searchTriggers = false;

	public function getTitle()
	{
		return $this->category_name;
	}

	public function getUsedCount()
	{
		$placeTable = Engine_Api::_()->getItemTable('place');
		return $placeTable->select()
		->from($placeTable, new Zend_Db_Expr('COUNT(place_id)'))
		->where('category_id = ?', $this->category_id)
		->query()
		->fetchColumn();
	}

	public function isOwner($owner)
	{
		return false;
	}

	public function getOwner()
	{
		return $this;
	}
}