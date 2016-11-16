<?php

class Socialplace_Form_Edit extends Socialplace_Form_Create
{
	public function init()
	{
		parent::init();
		$this->setTitle('Edit Place');
		$this->submit->setLabel('Save Changes');
		$this->getElement('photo')->setRequired(false);
	}
}