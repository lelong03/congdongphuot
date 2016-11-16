<?php

class ChristmasSnow_Widget_SnowStormController extends Engine_Content_Widget_Abstract
{
	public function indexAction()
	{
		$settingApi = Engine_Api::_() -> getApi('settings', 'core');

		$snowOptions = array();
		$snowOptions['color'] = '#' .$settingApi -> getSetting('christmassnow.color', '#FFFFFF');
		$snowOptions['speed'] = $settingApi -> getSetting('christmassnow.speed', 100);
		$snowOptions['tree'] = $settingApi -> getSetting('christmassnow.speed');
		$snowOptions['song'] = $settingApi -> getSetting('christmassnow.song');
		$snowOptions['play'] = $settingApi -> getSetting('christmassnow.play',false);
		$snowOptions['char'] = $settingApi -> getSetting('christmassnow.char');
		$snowOptions['flakesMaxActive'] = '96';
		$snowOptions['useTwinkleEffect'] = true;
		$snowOptions['followMouse'] = true;
		$snowOptions['useTwinkleEffect'] = true;
		$snowOptions['usePositionFixed'] = false;
		$snowOptions['flakeBottom'] = null;
		$snowOptions['flakesMax'] = 128;
		$snowOptions['vMaxX'] = 8;
		$snowOptions['vMaxY'] = 5;
		
		$this -> view -> snowOptions = $snowOptions;

	}

}
