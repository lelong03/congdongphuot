<?php

class ChristmasSnow_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
	public function __construct($application)
	{
		parent::__construct($application);
		$application -> getApplication() -> getAutoloader() -> register('ChristmasSnow', $this -> getModulePath());
	}
	
	public function getModuleName()
	{
		return 'christmas-snow';
	}
	
}