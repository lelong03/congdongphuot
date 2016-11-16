<?php
class Socialplace_Model_Place extends Core_Model_Item_Abstract
{
	// Properties
	protected $_parent_type = 'user';
	protected $_searchTriggers = array('title', 'body', 'search');
	//protected $_parent_is_owner = true;
	protected $_type = 'place';

	// General
	/**
	 * Gets an absolute URL to the page to view this item
	 *
	 * @return string
	 */
	public function getHref($params = array())
	{
		$slug = $this->getSlug();

		$params = array_merge(array(
		      'route' => 'socialplace_place_view',
		      'reset' => true,
		      'place_id' => $this->place_id,
		      'slug' => $slug,
		), $params);
		$route = $params['route'];
		$reset = $params['reset'];
		unset($params['route']);
		unset($params['reset']);
		return Zend_Controller_Front::getInstance()->getRouter()->assemble($params, $route, $reset);
	}

    public function getMediaType()
    {
        return Zend_Registry::get("Zend_Translate")->_("place");
    }

	protected function stripUnicode($str)
	{
		if(!$str)
		{
			return false;
		}
		$unicode = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
		);
		foreach($unicode as $nonUnicode => $uni)
		{
			$str = preg_replace("/($uni)/i", $nonUnicode, $str);
		}
		return $str;
	}

	public function getSlug($str = null, $maxstrlen = 64)
	{
		if( null === $str )
		{
			$str = $this->getTitle();
		}
		if( strlen($str) > $maxstrlen )
		{
			$str = Engine_String::substr($str, 0, $maxstrlen);
		}
		$str = $this->stripUnicode($str);
		$search  = array('Ã€','Ã�','Ã‚','Ãƒ','Ã„','Ã…','Ã†','Ã‡','Ãˆ','Ã‰','ÃŠ','Ã‹','ÃŒ','Ã�','ÃŽ','Ã�','Ã�','Ã‘','Ã’','Ã“','Ã”','Ã•','Ã–','Ã˜','Ã™','Ãš','Ã›','Ãœ','Ã�','ÃŸ','Ã ','Ã¡','Ã¢','Ã£','Ã¤','Ã¥','Ã¦','Ã§','Ã¨','Ã©','Ãª','Ã«','Ã¬','Ã­','Ã®','Ã¯','Ã±','Ã²','Ã³','Ã´','Ãµ','Ã¶','Ã¸','Ã¹','Ãº','Ã»','Ã¼','Ã½','Ã¿','Ä€','Ä�','Ä‚','Äƒ','Ä„','Ä…','Ä†','Ä‡','Äˆ','Ä‰','ÄŠ','Ä‹','ÄŒ','Ä�','ÄŽ','Ä�','Ä�','Ä‘','Ä’','Ä“','Ä”','Ä•','Ä–','Ä—','Ä˜','Ä™','Äš','Ä›','Äœ','Ä�','Äž','ÄŸ','Ä ','Ä¡','Ä¢','Ä£','Ä¤','Ä¥','Ä¦','Ä§','Ä¨','Ä©','Äª','Ä«','Ä¬','Ä­','Ä®','Ä¯','Ä°','Ä±','Ä²','Ä³','Ä´','Äµ','Ä¶','Ä·','Ä¹','Äº','Ä»','Ä¼','Ä½','Ä¾','Ä¿','Å€','Å�','Å‚','Åƒ','Å„','Å…','Å†','Å‡','Åˆ','Å‰','ÅŒ','Å�','ÅŽ','Å�','Å�','Å‘','Å’','Å“','Å”','Å•','Å–','Å—','Å˜','Å™','Åš','Å›','Åœ','Å�','Åž','ÅŸ','Å ','Å¡','Å¢','Å£','Å¤','Å¥','Å¦','Å§','Å¨','Å©','Åª','Å«','Å¬','Å­','Å®','Å¯','Å°','Å±','Å²','Å³','Å´','Åµ','Å¶','Å·','Å¸','Å¹','Åº','Å»','Å¼','Å½','Å¾','Å¿','Æ’','Æ ','Æ¡','Æ¯','Æ°','Ç�','ÇŽ','Ç�','Ç�','Ç‘','Ç’','Ç“','Ç”','Ç•','Ç–','Ç—','Ç˜','Ç™','Çš','Ç›','Çœ','Çº','Ç»','Ç¼','Ç½','Ç¾','Ç¿');
		$replace = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
		$str = str_replace($search, $replace, $str);

		$str = preg_replace('/([a-z])([A-Z])/', '$1 $2', $str);
		$str = strtolower($str);
		$str = preg_replace('/[^a-z0-9-]+/i', '-', $str);
		$str = preg_replace('/-+/', '-', $str);
		$str = trim($str, '-');
		if( !$str ) {
			$str = '-';
		}
		return $str;
	}


	public function getDescription()
	{
		// @todo decide how we want to handle multibyte string functions
		$tmpBody = strip_tags($this->body);
		return ( Engine_String::strlen($tmpBody) > 255 ? Engine_String::substr($tmpBody, 0, 255) . '...' : $tmpBody );
	}

	public function getKeywords($separator = ' ')
	{
		$keywords = array();
		foreach( $this->tags()->getTagMaps() as $tagmap ) {
			$tag = $tagmap->getTag();
			$keywords[] = $tag->getTitle();
		}
		if( null === $separator ) {
			return $keywords;
		}
		return join($separator, $keywords);
	}



	// Interfaces

	/**
	 * Gets a proxy object for the comment handler
	 *
	 * @return Engine_ProxyObject
	 **/
	public function comments()
	{
		return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('comments', 'core'));
	}


	/**
	 * Gets a proxy object for the like handler
	 *
	 * @return Engine_ProxyObject
	 **/
	public function likes()
	{
		return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('likes', 'core'));
	}

	/**
	 * Gets a proxy object for the tags handler
	 *
	 * @return Engine_ProxyObject
	 **/
	public function tags()
	{
		return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('tags', 'core'));
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
		/*
		if (function_exists('exif_read_data'))
		{
			$exif = exif_read_data($file);

			if (!empty($exif['Orientation']))
			{
				switch($exif['Orientation'])
				{
					case 8 :
						$angle = 90;
						break;
					case 3 :
						$angle = 180;
						break;
					case 6 :
						$angle = -90;
						break;
				}
			}
		}
		*/
		// Resize image (main)
		$image = Engine_Image::factory();
		$image -> open($file) ;
		if ($angle != 0)
			$image -> rotate($angle);
		$image -> resize(720, 720) -> write($path . '/m_' . $name) -> destroy();

		// Resize image (profile)
		$image = Engine_Image::factory();
		$image -> open($file);
		if ($angle != 0)
			$image -> rotate($angle);
		$image-> resize(200, 400) -> write($path . '/p_' . $name) -> destroy();

		// Resize image (feature)
		$image = Engine_Image::factory();
		@$image -> open($file) ;
		if ($angle != 0)
			$image -> rotate($angle);
		$image -> resize(242, 150) -> write($path . '/fe_' . $name) -> destroy();

		// Resize image (normal)
		$image = Engine_Image::factory();
		$image -> open($file);
		if ($angle != 0)
			$image -> rotate($angle);
		$image -> resize(140, 160) -> write($path . '/in_' . $name) -> destroy();

		// Resize image (icon)
		$image = Engine_Image::factory();
		$image -> open($file);

		$size = min($image -> height, $image -> width);
		$x = ($image -> width - $size) / 2;
		$y = ($image -> height - $size) / 2;
		if ($angle != 0)
			$image -> rotate($angle);
		$image -> resample($x, $y, $size, $size, 48, 48) -> write($path . '/is_' . $name) -> destroy();

		// Store
		$iMain = $storage -> create($path . '/m_' . $name, $params);
		$iProfile = $storage -> create($path . '/p_' . $name, $params);
		$iIconNormal = $storage -> create($path . '/in_' . $name, $params);
		$iFeature = $storage -> create($path . '/fe_' . $name, $params);
		$iSquare = $storage -> create($path . '/is_' . $name, $params);

		$iMain -> bridge($iProfile, 'thumb.profile');
		$iMain -> bridge($iIconNormal, 'thumb.normal');
		$iMain -> bridge($iFeature, 'thumb.feature');
		$iMain -> bridge($iSquare, 'thumb.icon');

		// Remove temp files
		@unlink($path . '/p_' . $name);
		@unlink($path . '/m_' . $name);
		@unlink($path . '/in_' . $name);
		@unlink($path . '/fe_' . $name);
		@unlink($path . '/is_' . $name);

		// Update row
		$this -> modified_date = date('Y-m-d H:i:s');
		$this -> photo_id = $iMain -> file_id;
		$this -> save();

		// Add to album
	    $viewer = Engine_Api::_()->user()->getViewer();
	    $photoTable = Engine_Api::_()->getItemTable('socialplace_photo');
	    $placeAlbum = $this->getSingletonAlbum();
	    $photoItem = $photoTable->createRow();
	    $photoItem->setFromArray(array(
	      'place_id' => $this->getIdentity(),
	      'album_id' => $placeAlbum->getIdentity(),
	      'user_id' => $viewer->getIdentity(),
	      'file_id' => $iMain->getIdentity(),
	      'collection_id' => $placeAlbum->getIdentity(),
	      'user_id' =>$viewer->getIdentity(),
	    ));
	    $photoItem->save();

		return $this;
	}

	public function getSingletonAlbum()
	{
		$table = Engine_Api::_()->getItemTable('socialplace_album');
		$select = $table->select()
		->where('place_id = ?', $this->getIdentity())
		->order('album_id ASC')
		->limit(1);

		$album = $table->fetchRow($select);

		if( null === $album )
		{
			$album = $table->createRow();
			$album->setFromArray(array(
        		'place_id' => $this->getIdentity()
			));
			$album->save();
		}

		return $album;
	}

    public function getPhotoUrl($type = null)
    {
        if ($this->photo_id)
        {
            return parent::getPhotoUrl($type);
        }
        else if ($this->photo_url)
        {
            return $this->photo_url;
        }
        else if ($this->thumb_image)
        {
            return $this->thumb_image;
        }
        else
        {
            return '';
        }
    }

    public function addPhoto($photoPath)
    {
        $viewer = Engine_Api::_()->user()->getViewer();
        $album = $this->getSingletonAlbum();
        $params = array(
            // We can set them now since only one album is allowed
            'collection_id' => $album->getIdentity(),
            'album_id' => $album->getIdentity(),
            'place_id' => $this->getIdentity(),
            'user_id' => $viewer->getIdentity(),
        );
        $photoTable = Engine_Api::_()->getItemTable('socialplace_photo');
        $photo = $photoTable->createRow();
        $photo->setFromArray($params);
        $photo->save();
        $photo->setPhoto($photoPath);
    }
}