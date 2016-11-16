<?php

class Yhweather_Form_Admin_Global extends Engine_Form
{
  public function init()
  {
    $this
      ->setTitle('yhweather_Weather Global Settings')
      ->setDescription('YHWEATHER_FORM_ADMIN_GLOBAL_DESCRIPTION');

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->addElement('Text', 'default_location', array(
      'label' => 'yhweather_Default Location',
      'description' => 'YHWEATHER_DEFAULT_LOCATION_DESC',
      'value' => $settings->getSetting('yhweather.default_location', 'New-York')
    ));

    $this->addElement('Select', 'unit_system', array(
      'label' => 'yhweather_Default temperature units',
      'description' => 'YHWEATHER_DEFAULT_UNITS_DESC',
      'multiOptions' => array(
        'us' => 'yhweather_Fahrenheit',
        'si' => 'yhweather_Celsius',
      ),
      'value' => $settings->getSetting('yhweather.unit_system', 'us')
    ));

    $this->getElement('unit_system')->getDecorator('Description')->setOption('escape', false);

    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true
    ));
  }
}