<?php
class Socialplace_Widget_SearchFormController extends Engine_Content_Widget_Abstract
{
	public function indexAction()
	{
		$viewer = Engine_Api::_()->user()->getViewer();
        $searchParams = Zend_Controller_Front::getInstance()->getRequest()->getParams();
        $location = '';
        if (isset($searchParams['location'])){
            $location = $searchParams['location'];
        }

		if (trim($location) == '')
		{
			unset($searchParams['lat']);
			unset($searchParams['long']);
		}
		// Create search form.
		$this->view->form = $searchForm = new Socialplace_Form_Search(array('location' => $location));
		$searchForm->setAction($this->view->baseUrl() . "/places/listing");

		if( !$viewer || !$viewer->getIdentity() ) {
			$searchForm ->removeElement('view');
		}

		$request = Zend_Controller_Front::getInstance() -> getRequest();
		$params =  $searchParams;
		$searchForm->populate($params);
	}
}