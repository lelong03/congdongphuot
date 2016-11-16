<?php
class Socialplace_Form_Admin_Region extends Engine_Form
{
	protected $_field;

	public function init()
	{
		$this
		->setMethod('post')
		->setAttrib('class', 'global_form_box')
		;

		$label = new Zend_Form_Element_Text('label');
		$label
			->setLabel('Region Name')
			->addValidator('NotEmpty')
			->setRequired(true)
			->setAttrib('class', 'text');

		$id = new Zend_Form_Element_Hidden('id');
		$this->addElements(array(
			$label,
			$id
		));

        $regionTbl = Engine_Api::_()->getItemTable('socialplace_region');
        $options = $regionTbl -> getParentRegionsAssoc();
        $this->addElement('select', 'parent_id', array(
            'label' => 'Parent Region',
            'multiOptions' => $options,
        ));

        // Photo
	    $this->addElement('File', 'photo', array(
	      'label' => 'Photo'
	    ));
	    $this->photo->addValidator('Extension', false, 'jpg,png,gif,jpeg');
        
		// Buttons
		$this->addElement('Button', 'submit', array(
		      'label' => 'Add Region',
		      'type' => 'submit',
		      'ignore' => true,
		      'decorators' => array('ViewHelper')
		));

		$this->addElement('Cancel', 'cancel', array(
		      'label' => 'cancel',
		      'link' => true,
		      'prependText' => ' or ',
		      'href' => '',
		      'onClick'=> 'javascript:parent.Smoothbox.close();',
		      'decorators' => array(
					'ViewHelper'
		       )
	    ));
        $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
        $button_group = $this->getDisplayGroup('buttons');
	}

	public function setField($region)
	{
		$this->_field = $region;
		$this->label->setValue($region->region_name);
		$this->id->setValue($region->region_id);
        $this->parent_id->setValue($region->parent_id);
		$this->submit->setLabel('Edit Region');

		// @todo add the rest of the parameters
	}
}