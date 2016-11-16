<?php
class Socialplace_Model_DbTable_Categories extends Engine_Db_Table
{
	protected $_rowClass = 'Socialplace_Model_Category';

	public function getCategoriesAssoc()
	{
		$stmt = $this->select()
		->from($this, array('category_id', 'category_name'))
		->order('category_id ASC')
		->query();

		$data = array();
		foreach( $stmt->fetchAll() as $category ) {
			$data[$category['category_id']] = $category['category_name'];
		}
		return $data;
	}

	public function getUserCategoriesAssoc($user)
	{
		if( $user instanceof User_Model_User ) 
		{
			$user = $user->getIdentity();
		} 
		else if( !is_numeric($user) ) 
		{
			return array();
		}

		$stmt = $this->getAdapter()
		->select()
		->from('engine4_socialplace_categories', array('category_id', 'category_name'))
		->joinLeft('engine4_socialplace_places', "engine4_socialplace_places.category_id = engine4_socialplace_categories.category_id")
		->group("engine4_socialplace_categories.category_id")
		->where('engine4_socialplace_places.owner_id = ?', $user)
		->where('engine4_socialplace_places.draft = ?', "0")
		->order('category_name ASC')
		->query();

		$data = array();
		foreach( $stmt->fetchAll() as $category ) {
			$data[$category['category_id']] = $category['category_name'];
		}

		return $data;
	}
	
	// NO NEED TO CODE THIS FUNCTION
	public function getCategory($id)
	{
		return Engine_Api::_()->getItem('socialplace_category', $id);
	}
}
