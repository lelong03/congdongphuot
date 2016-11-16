<?php
class Socialplace_Model_DbTable_Places extends Engine_Db_Table
{
	protected $_rowClass = "Socialplace_Model_Place";
	protected $_serializedColumns = array('phone');

	public function getPlacesSelect($params = array())
	{
		$placeTbl = Engine_Api::_()->getDbtable('places', 'socialplace');
		$placeTblName = $placeTbl->info('name');

		$tmTable = Engine_Api::_()->getDbtable('TagMaps', 'core');
		$tmName = $tmTable->info('name');

		$select = $placeTbl->select();
		//->order( !empty($params['orderby']) ? $params['orderby'].' DESC' : $placeTblName.'.creation_date DESC' );

		if( !empty($params['user_id']) && is_numeric($params['user_id']) )
		{
			$select->where($placeTblName.'.owner_id = ?', $params['user_id']);
		}

		//Get your location
		$target_distance = $base_lat = $base_lng = "";
		if(isset($params['lat']))
			$base_lat = $params['lat'];
		if(isset($params['long']))
			$base_lng = $params['long'];

		//Get target distance in miles
		if(isset($params['within']))
			$target_distance = $params['within'];

		$select -> setIntegrityCheck(false);
		if ($base_lat && $base_lng && $target_distance && is_numeric($target_distance))
		{
            $this->view->unit = $lengthUnit = Engine_Api::_()->getApi('settings', 'core')->getSetting('socialplace.lengthunit', 'mile');
            if ($lengthUnit == 'km')
            {
                $m = 1.60934;
            }
            else
            {
                $m = 1;
            }
			$select -> from("$placeTblName", array(
				"$placeTblName.*",
				"({$m} * 3959 * acos( cos( radians('$base_lat')) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('$base_lng') ) + sin( radians('$base_lat') ) * sin( radians( latitude ) ) ) ) AS distance"
			));
			$select -> where("latitude <> ''");
			$select -> where("longitude <> ''");
		}
		else
		{
			$select -> from("$placeTblName", array("$placeTblName.*"));
		}
		
		if( !empty($params['user']) && $params['user'] instanceof User_Model_User )
		{
			$select->where($placeTblName.'.owner_id = ?', $params['user_id']->getIdentity());
		}

		if( !empty($params['users']) )
		{
			$str = (string) ( is_array($params['users']) ? "'" . join("', '", $params['users']) . "'" : $params['users'] );
			$select->where($placeTblName.'.owner_id in (?)', new Zend_Db_Expr($str));
		}

		if( !empty($params['tag']) )
		{
			$select
			//->setIntegrityCheck(false)
			//->from($placeTblName)
			->joinLeft($tmName, "$tmName.resource_id = $placeTblName.blog_id")
			->where($tmName.'.resource_type = ?', 'blog')
			->where($tmName.'.tag_id = ?', $params['tag']);
		}

		if( !empty($params['category_id']) )
		{
			if (is_array($params['category_id']) && count($params['category_id'])>0)
			{
				$select->where($placeTblName.'.category_id IN (?)', $params['category_id']);
			}
		}

        if( !empty($params['region_id']) && $params['region_id'] != '')
        {
            $select->where($placeTblName.'.region_id = ?', $params['region_id']);
        }

		if( isset($params['draft']) )
		{
			$select->where($placeTblName.'.draft = ?', $params['draft']);
		}

		if( !empty($params['keyword']) )
		{
			//$select->where($placeTblName.".title LIKE ? OR ".$placeTblName.".body LIKE ?", '%'.$params['keyword'].'%');
			$select->where("{$placeTblName}.title_search LIKE ? ", '%'.$params['keyword'].'%');
		}

		if( !empty($params['visible']) )
		{
			$select->where($placeTblName.".search = ?", $params['visible']);
		}

        if (!empty($params['min_price']))
        {
            $select->where($placeTblName.".price >= ? ", $params['min_price']);
        }

        if (!empty($params['max_price']))
        {
            $select->where($placeTblName.".price <= ? ", $params['max_price']);
        }

		// Order
		if (!empty($params['order']))
		{
			switch ($params['order']) {
				case 'high_price':
					$select -> order("price DESC");
				break;
				case 'low_price':
					$select -> order("price ASC");
				break;
				case 'most_view':
					$select -> order("view_count DESC");
				break;
				case 'most_like':
					$select -> order("like_count DESC");
				break;
				case 'most_comment':
					$select -> order("comment_count DESC");
				break;
				case 'most_rating':
					$select -> order("rating DESC");
				break;
				default:
					$select -> order("place_id DESC");
				break;
			}
		}
		else 
		{
			$select -> order("place_id DESC");
		}
		if ($base_lat && $base_lng && $target_distance && is_numeric($target_distance))
		{
			$select -> having("distance <= $target_distance");
			$select -> order("distance ASC");
		}
		//echo $select; exit;
		return $select;
	}

	public function getPlacesPaginator($params = array())
	{
		$paginator = Zend_Paginator::factory($this->getPlacesSelect($params));
		if( !empty($params['page']) )
		{
			$paginator->setCurrentPageNumber($params['page']);
		}
		if( !empty($params['limit']) )
		{
			$paginator->setItemCountPerPage($params['limit']);
		}

		if( empty($params['limit']) )
		{
			$page = (int) Engine_Api::_()->getApi('settings', 'core')->getSetting('blog.page', 10);
			$paginator->setItemCountPerPage($page);
		}

		return $paginator;
	}

	public function getArchiveList($spec)
	{
		if( !($spec instanceof User_Model_User) ) {
			return null;
		}

		$localeObject = Zend_Registry::get('Locale');
		if( !$localeObject ) {
			$localeObject = new Zend_Locale();
		}

		$dates = $this->select()
		->from($this, 'creation_date')
		->where('owner_type = ?', 'user')
		->where('owner_id = ?', $spec->getIdentity())
		->where('draft = ?', 0)
		->order('place_id DESC')
		->query()
		->fetchAll(Zend_Db::FETCH_COLUMN);

		$time = time();

		$archive_list = array();
		foreach( $dates as $date ) {

			$date = strtotime($date);
			$ltime = localtime($date, true);
			$ltime["tm_mon"] = $ltime["tm_mon"] + 1;
			$ltime["tm_year"] = $ltime["tm_year"] + 1900;

			// LESS THAN A YEAR AGO - MONTHS
			if( $date + 31536000 > $time ) {
				$date_start = mktime(0, 0, 0, $ltime["tm_mon"], 1, $ltime["tm_year"]);
				$date_end = mktime(0, 0, 0, $ltime["tm_mon"] + 1, 1, $ltime["tm_year"]);
				$type = 'month';

				$dateObject = new Zend_Date($date);
				$format = $localeObject->getTranslation('yMMMM', 'dateitem', $localeObject);
				$label = $dateObject->toString($format, $localeObject);
			}
			// MORE THAN A YEAR AGO - YEARS
			else {
				$date_start = mktime(0, 0, 0, 1, 1, $ltime["tm_year"]);
				$date_end = mktime(0, 0, 0, 1, 1, $ltime["tm_year"] + 1);
				$type = 'year';

				$dateObject = new Zend_Date($date);
				$format = $localeObject->getTranslation('yyyy', 'dateitem', $localeObject);
				if( !$format ) {
					$format = $localeObject->getTranslation('y', 'dateitem', $localeObject);
				}
				$label = $dateObject->toString($format, $localeObject);
			}

			if( !isset($archive_list[$date_start]) ) {
				$archive_list[$date_start] = array(
			          'type' => $type,
			          'label' => $label,
			          'date' => $date,
			          'date_start' => $date_start,
			          'date_end' => $date_end,
			          'count' => 1
				);
			} else {
				$archive_list[$date_start]['count']++;
			}
		}

		return $archive_list;
	}
}