<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Blog
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Blog.php 10072 2013-07-24 22:38:42Z john $
 * @author     Jung
 */

/**
 * @category   Application_Extensions
 * @package    Blog
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Blog_Model_Blog extends Core_Model_Item_Abstract
{
  // Properties

  protected $_parent_type = 'user';

  //protected $_owner_type = 'user';
  
  protected $_searchTriggers = array('title', 'body', 'search');

  protected $_parent_is_owner = true;


  public function getSlug()
	{
		if( null === $str ) {
			$str = $this->getTitle();
		}
		$str = Engine_Api::_()->blog()->vnFilter($str);
		
		if( strlen($str) > 64 ) {
			$str = Engine_String::substr($str, 0, 64) . '...';
		}

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
      'route' => 'blog_entry_view',
      'reset' => true,
      'user_id' => $this->owner_id,
      'blog_id' => $this->blog_id,
      'slug' => $slug,
    ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()
      ->assemble($params, $route, $reset);
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

  public function setPhoto($photo)
  {
    if( $photo instanceof Zend_Form_Element_File ) {
      $file = $photo->getFileName();
    } else if( is_array($photo) && !empty($photo['tmp_name']) ) {
      $file = $photo['tmp_name'];
    } else if( is_string($photo) && file_exists($photo) ) {
      $file = $photo;
    } else {
      throw new Event_Model_Exception('invalid argument passed to setPhoto');
    }

    $name = basename($file);
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
     'parent_id' => $this->getIdentity(),
     'parent_type'=>'event'
    );
    
    // Save
    $storage = Engine_Api::_()->storage();
    
    // Resize image (main)
    $image = Engine_Image::factory();
    $image->open($file)
      ->resize(720, 720)
      ->write($path.'/m_'.$name)
      ->destroy();

    // Resize image (profile)
    $image = Engine_Image::factory();
    $image->open($file)
      ->resize(200, 400)
      ->write($path.'/p_'.$name)
      ->destroy();

    // Resize image (normal)
    $image = Engine_Image::factory();
    $image->open($file)
      ->resize(140, 160)
      ->write($path.'/in_'.$name)
      ->destroy();

    // Resize image (icon)
    $image = Engine_Image::factory();
    $image->open($file);

    $size = min($image->height, $image->width);
    $x = ($image->width - $size) / 2;
    $y = ($image->height - $size) / 2;

    $image->resample($x, $y, $size, $size, 48, 48)
      ->write($path.'/is_'.$name)
      ->destroy();

    // Store
    $iMain = $storage->create($path.'/m_'.$name, $params);
    $iProfile = $storage->create($path.'/p_'.$name, $params);
    $iIconNormal = $storage->create($path.'/in_'.$name, $params);
    $iSquare = $storage->create($path.'/is_'.$name, $params);

    $iMain->bridge($iProfile, 'thumb.profile');
    $iMain->bridge($iIconNormal, 'thumb.normal');
    $iMain->bridge($iSquare, 'thumb.icon');

    // Remove temp files
    @unlink($path.'/p_'.$name);
    @unlink($path.'/m_'.$name);
    @unlink($path.'/in_'.$name);
    @unlink($path.'/is_'.$name);

    // Update row
    $this->modified_date = date('Y-m-d H:i:s');
    $this->photo_id = $iMain->file_id;
    $this->save();

    return $this;
  }
}