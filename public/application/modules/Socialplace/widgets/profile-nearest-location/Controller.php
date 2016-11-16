<?php

class Socialplace_Widget_ProfileNearestLocationController extends Engine_Content_Widget_Abstract
{
    public function indexAction()
    {
    	// Don't render this if not authorized
		$viewer = Engine_Api::_()->user()->getViewer();
		if (!Engine_Api::_()->core()->hasSubject()) {
			return $this->setNoRender();
		}
		// Get subject and check auth
		$subject = Engine_Api::_()->core()->getSubject('place');
		if (!$subject->authorization()->isAllowed($viewer, 'view')) {
			return $this->setNoRender();
		}
		
		// Prepare data
		$this->view->place = $place = $subject;
        $base_lat = $place->latitude;
        $base_lng = $place->longitude;
        $limit = $this->_getParam('max',5);
        $target_distance = $this->_getParam('radius', 500);
        
    	if (!$base_lat || !$base_lng) {
			return $this->setNoRender();
		} 
		$placeTbl = Engine_Api::_()->getDbtable('places', 'socialplace');
		$placeTblName = $placeTbl->info('name');
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
			$select = $placeTbl->select();
			$select -> from("$placeTblName", array(
				"$placeTblName.*",
				"({$m} * 3959 * acos( cos( radians('$base_lat')) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('$base_lng') ) + sin( radians('$base_lat') ) * sin( radians( latitude ) ) ) ) AS distance"
			));
			$select 
			-> where("latitude <> ''")
			-> where("longitude <> ''")
			-> where("place_id <> ?", $place->getIdentity())
			-> having("distance <= $target_distance")
			-> order("distance ASC")
			-> limit($limit);
			
			$this->view->places = $places = $placeTbl -> fetchAll($select);
			if (!count($places))
			{
				return $this->setNoRender();
			}
		}
		//echo $select; exit;
    }
}   