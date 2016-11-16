<?php
class Socialplace_Widget_ManageSearchController extends Engine_Content_Widget_Abstract {
    public function indexAction() 
    {
    	$this -> view -> formFilter = $formFilter = new Socialplace_Form_ManageSearch();
    	$defaultValues = $formFilter -> getValues();
    	
    	// Populate form data
    	if ($formFilter -> isValid(Zend_Controller_Front::getInstance()->getRequest()->getParams()))
    	{
    		$this -> view -> formValues = $values = $formFilter -> getValues();
    	}
    	else
    	{
    		$formFilter -> populate($defaultValues);
    		$this -> view -> formValues = $values = array();
    	}
    }
}
