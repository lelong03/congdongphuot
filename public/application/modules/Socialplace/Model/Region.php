<?php
class Socialplace_Model_Region extends Core_Model_Item_Abstract
{
	protected $_searchTriggers = false;

	public function getTitle()
	{
		return $this->region_name;
	}

	public function getUsedCount()
	{
		$placeTable = Engine_Api::_()->getItemTable('place');
		return $placeTable->select()
		->from($placeTable, new Zend_Db_Expr('COUNT(place_id)'))
		->where('region_id = ?', $this->region_id)
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
	
	public function setPhoto($photo, $userId = null)
	{
		if ($photo instanceof Zend_Form_Element_File)
		{
			$file = $photo -> getFileName();
		}
		else
		if (is_array($photo) && !empty($photo['tmp_name']))
		{
			$file = $photo['tmp_name'];
		}
		else
		if (is_string($photo) && file_exists($photo))
		{
			$file = $photo;
		}
		else
		{
			throw new Exception('invalid argument passed to setPhoto');
		}

		$name = basename($file);
		$path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
		$params = array(
			'parent_id' => $this -> getIdentity(),
			'parent_type' => 'place'
		);
		if (!is_null($userId))
		{
			$params['user_id'] = $userId;
		}
		
		// Save
		$storage = Engine_Api::_() -> storage();
		$angle = 0;
		
		// Resize image (main)
		$image = Engine_Image::factory();
		$image -> open($file) ;
		if ($angle != 0)
			$image -> rotate($angle);
		$image -> resize(242, 150) -> write($path . '/m_' . $name) -> destroy();

		// Store
		$iMain = $storage -> create($path . '/m_' . $name, $params);

		// Remove temp files
		@unlink($path . '/m_' . $name);

		// Update row
		$this -> photo_id = $iMain -> file_id;
		$this -> save();
		return $this;
	}
}