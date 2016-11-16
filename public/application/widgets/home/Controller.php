<?php
class Widget_HomeController extends Engine_Content_Widget_Abstract
{
    /**
     *
     */
    public function indexAction()
 	{
 		$this->view->formSignup = $formSignup = new User_Form_Signup_Account();
        $formSignup->removeElement('name');
        foreach ($formSignup->getElements() as $element)
        {
            $name = $element->getName();
            $formSignup -> getElement($name)->tabindex = $formSignup -> getElement($name)->tabindex + 4;
        }
 		$this->view->formLogin = new User_Form_Login();
 	}
}
