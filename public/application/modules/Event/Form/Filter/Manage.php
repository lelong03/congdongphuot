<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Event
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Manage.php 9989 2013-03-20 01:13:58Z john $
 * @author     John
 */

/**
 * @category   Application_Extensions
 * @package    Event
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Event_Form_Filter_Manage extends Engine_Form
{
  public function init()
  {
    $this->clearDecorators()
      ->addDecorators(array(
        'FormElements',
        array('HtmlTag', array('tag' => 'dl')),
        'Form',
      ))
      ->setMethod('get')
      ->setAttrib('class', 'filters')
      ;

    $this->addElement('Text', 'search_text', array(
      'label' => 'Search:',
      'style' => 'width: 165px;',
      'decorators' => array(
        'ViewHelper',
        array('HtmlTag', array('tag' => 'dd')),
        array('Label', array('tag' => 'dt', 'placement' => 'PREPEND'))
      ),
      //'onchange' => '$(this).getParent("form").submit();',
    ));

    $networks = array('0' => '');
    $networkTbl = Engine_Api::_()->getItemTable('network');
    foreach ($networkTbl->fetchAll($networkTbl->select()) as $network) {
      $networks[$network->title] = $network->title;
    }
    $this->addElement('Select', 'location', array(
            'label' => 'Location',
            'style' => 'width: 165px;',
            'multiOptions' => $networks,
            'value' => 'TP Hồ Chí Minh',
            //'onchange' => '$(this).getParent("form").submit();',
    ));

     // Destination
    $this -> addElement('Text', 'destination', array(
      'label' => 'Destination',
      'required' => false,
      'style' => 'width: 165px;',
      'description' => '',
      'filters' => array(new Engine_Filter_Censor())
    ));

    $this->addElement('Select', 'view', array(
      'label' => 'View:',
      'style' => 'width: 165px;',
      'multiOptions' => array(
        '' => 'All My Events',
        '2' => 'Only Events I Lead',
      ),
      'decorators' => array(
        'ViewHelper',
        array('HtmlTag', array('tag' => 'dd')),
        array('Label', array('tag' => 'dt', 'placement' => 'PREPEND'))
      ),
      //'onchange' => '$(this).getParent("form").submit();',
    ));
	
	$this->addElement('Button', 'submit', array(
		'label' => 'Search',
		'type' => 'submit'
    ));
  }
}