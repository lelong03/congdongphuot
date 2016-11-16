<?php
class Scrolltotop_AdminManageController extends Core_Controller_Action_Admin
{
	public function indexAction()
	{
		$settingApi = Engine_Api::_() -> getApi('settings', 'core');
		$this -> view -> scroll_icon = $settingApi -> getSetting('scrolltotop.icon', 'arrow0.png');
		if ($this -> getRequest() -> isPost())
		{
			$settingApi -> setSetting('scrolltotop.icon', $_POST['icon']);
			return $this->_helper->redirector->gotoRoute(array('controller'=>'manage', 'module'=>'scrolltotop'), 'admin_default', true);
		}
	}
}
