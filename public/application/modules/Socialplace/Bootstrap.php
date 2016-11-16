<?php

class Socialplace_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
	/*** init CSS */
	public function _initCss()
	{
		$view = Zend_Registry::get('Zend_View');

		// add font Awesome 4.1.0
		$url = $view->baseUrl(). '/application/modules/Socialplace/externals/styles/font-awesome.css';
		$view->headLink()->appendStylesheet($url);
	}
}