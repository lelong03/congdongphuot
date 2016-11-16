<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Music
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Create.php 9747 2012-07-26 02:08:08Z john $
 * @author     Steve
 */

class ChristmasSnow_Form_Setting extends Engine_Form
{
	public function init()
	{
		// Init form
		$view = Zend_Registry::get('Zend_View');
	    $view->headScript()->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/ChristmasSnow/externals/scripts/jscolor.js');
		$this -> setTitle('Snow Storm Effect Setting') -> setDescription('Setting affected to all page that contain snow effect.') -> setAttrib('enctype', 'multipart/form-data') -> setAction(Zend_Controller_Front::getInstance() -> getRouter() -> assemble(array()));
		
		$this->addElement('Text', 'color', array(
						'label' => 'Color',
						'class' => 'color',
						'allowEmpty' => false,
						'value' => $color->hex_value,
				));
		/*
		$this -> addElement('Text', 'color', array(
			'label' => 'Color',
			'description' => 'Accept 6 Character include 0-9,A-Z. visit: http://www.w3schools.com/html/html_colornames.asp'
		));*/
		$this -> addElement('Select', 'speed', array(
			'label' => 'Speed',
			'multiOptions' => array(
				'22' => 'Fast',
				'33' => 'Medium',
				'44' => 'Slow'
			)
		));
		$this -> addElement('Select', 'char', array(
			'multiOptions' => array(
				'&#8226;' => 'bullet',
				'&#9679;' => 'big bullet',
				'&diams;' => 'diamond',
				'&hearts;' => 'heart',
				'&sung;' => 'music note',
				'&starf;' => 'star',
				'&sext;' => 'snow',
				'∗' => 'lowast',
				'◊' => 'lozenge',
			),
			'value' => '&#8226;',
			'label' => 'Snow Symbol'
		));
		// Init submit
		$this -> addElement('Button', 'submit', array(
			'label' => 'Save Setting',
			'type' => 'submit',
		));
	}
}
