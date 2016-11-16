<?php

class Scrolltotop_Widget_ScrolltopController extends Engine_Content_Widget_Abstract
{
	public function indexAction()
	{
		$settingApi = Engine_Api::_() -> getApi('settings', 'core');
		$this -> view -> scroll_icon = $settingApi -> getSetting('scrolltotop.icon', 'arrow (1).png');
	}

}
