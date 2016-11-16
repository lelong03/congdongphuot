<?php
class Yhweather_AdminSettingsController extends Core_Controller_Action_Admin
{
	public function indexAction()
	{
		$this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
		->getNavigation('yhweather_admin_main', array(), 'yhweather_admin_main_settings');

		$this->view->form = $form = new Yhweather_Form_Admin_Global();
		$settings = Engine_Api::_()->getApi('settings', 'core');
		 
		if (!$this->getRequest()->isPost()) {
			return ;
		}
		 
		if (!$form->isValid($this->getRequest()->getPost())) {
			return ;
		}

		if (isset($product_result['result']) && !$product_result['result']) {
			$form->addError($product_result['message']);
			$this->view->headScript()->appendScript($product_result['script']);

			return;
		}

		$value = $form->getValue('default_location');
		$settings->setSetting('yhweather.default_location', $value);
		$form->default_location->setValue($value);

		$value = $form->getValue('unit_system');
		$settings->setSetting('yhweather.unit_system', $value);
		$form->unit_system->setValue($value);

	}
}