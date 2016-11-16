<?php

class Socialplace_Model_Album extends Core_Model_Item_Collection
{
	protected $_parent_type = 'place';

	protected $_owner_type = 'place';

	protected $_children_types = array('socialplace_photo');

	protected $_collectible_type = 'socialplace_photo';

	public function getHref($params = array())
	{
		$params = array_merge(array(
		      'route' => 'socialplace_specific',
		      'reset' => true,
		      'id' => $this->getPlace()->getIdentity(),
		), $params);
		$route = $params['route'];
		$reset = $params['reset'];
		unset($params['route']);
		unset($params['reset']);
		return Zend_Controller_Front::getInstance()->getRouter()
		->assemble($params, $route, $reset);
	}

	public function getPlace()
	{
		return $this->getOwner();
	}

	public function getAuthorizationItem()
	{
		return $this->getParent('place');
	}

	protected function _delete()
	{
		// Delete all child posts
		$photoTable = Engine_Api::_()->getItemTable('socialplace_photo');
		$photoSelect = $photoTable->select()->where('album_id = ?', $this->getIdentity());
		foreach( $photoTable->fetchAll($photoSelect) as $placePhoto ) {
			$placePhoto->delete();
		}

		parent::_delete();
	}
}