<?php
class Socialplace_Form_ManageSearch extends Engine_Form
{
	public function init()
	{
		$this->clearDecorators()
		->addDecorators(array(
        'FormElements',
		array('HtmlTag', array('tag' => 'dl')),
        'Form',
		))
		->setMethod('get');

		$this->addElement('Text', 'keyword', array(
	      'label' => 'Search:',
	      'alt' => 'Search places',
	      'onchange' => '$(this).getParent("form").submit();',
		));
	}
}