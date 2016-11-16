<?php
class Socialplace_Widget_BrowsePlaceController extends Engine_Content_Widget_Abstract 
{
	public function indexAction() 
    {
    	$params = $this -> _getAllParams();
 		$mode_list = $mode_map = 1;
		$mode_enabled = array();
		$view_mode = 'list';
		
		if(isset($params['mode_list']))
		{
			$mode_list = $params['mode_list'];
		}
		if($mode_list)
		{
			$mode_enabled[] = 'list';
		}
		
		if(isset($params['mode_map']))
		{
			$mode_map = $params['mode_map'];
		}
		if($mode_map)
		{
			$mode_enabled[] = 'map';
		}
		
		if(isset($params['view_mode']))
		{
			$view_mode = $params['view_mode'];
		}
		if($mode_enabled && !in_array($view_mode, $mode_enabled))
		{
			$view_mode = $mode_enabled[0];
		}
			
		$this -> view -> mode_enabled = $mode_enabled;
		$class_mode = "socialplace-browse-place-viewmode-list";
		switch ($view_mode) 
		{
			case 'map':
				$class_mode = "socialplace-browse-place-viewmode-maps";
				break;
			default:
				$class_mode = "socialplace-browse-place-viewmode-list";
				break;
		}
    	
		$searchParams = Zend_Controller_Front::getInstance()->getRequest()->getParams();
		$placeTbl = Engine_Api::_()->getItemTable('place');
    	if (!isset($searchParams['page']) || $searchParams['page'] == '0')
		{
			$page = 1;
		}
		else
		{
			$page = (int)$searchParams['page'];
		}
		$this->view->class_mode = $class_mode;
		if (!$searchParams['location'])
		{
			unset($searchParams['lat']);
			unset($searchParams['long']);
		}
		$this->view->paginator = $paginator = $placeTbl->getPlacesPaginator($searchParams);
		$limit = $this->_getParam('itemCountPerPage', 1);
		$paginator->setItemCountPerPage($limit);
		$paginator->setCurrentPageNumber($page );

   		$placeIds = array();
		foreach ($paginator as $place){
			$placeIds[] = $place -> getIdentity();
		}
		$this->view->placeIds = implode("_", $placeIds);
		unset($searchParams['controller']);
		unset($searchParams['action']);
		unset($searchParams['module']);
		unset($searchParams['rewrite']);
		$this->view->formValues = array_filter($searchParams);
        $currency = Engine_Api::_()->getApi('settings', 'core')->getSetting('socialplace.currency', 'USD');
        $this -> view -> c = ($currency == 'USD') ? '$' : 'đ';
    }
}