<?php
class Socialplace_Form_Admin_Global extends Engine_Form
{
	public function init()
	{
		$this
		->setTitle('Global Settings')
		->setDescription('These settings affect all members in your community.');
		
		 $this->addElement('Select', 'socialplace_lengthunit', array(
			 'label' => 'Unit Of Length',
			 'multiOptions' => array(
				 'mile' => 'Mile',
				 'km' => 'Kilometre'
			 ),
			 'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('socialplace.lengthunit', 'mile'),
		 ));

        $this->addElement('Select', 'socialplace_currency', array(
            'label' => 'Currency',
            'multiOptions' => array(
                'USD' => 'US Dollard',
                'VND' => 'Vietnam Dong'
            ),
            'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('socialplace.currency', 'USD'),
        ));

		// Add submit button
		$this->addElement('Button', 'submit', array(
		      'label' => 'Save Changes',
		      'type' => 'submit',
		      'ignore' => true
		));
	}
}