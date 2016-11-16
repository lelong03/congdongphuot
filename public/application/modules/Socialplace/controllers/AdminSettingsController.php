<?php

class Socialplace_AdminSettingsController extends Core_Controller_Action_Admin
{
    public function indexAction()
    {
        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('socialplace_admin_main', array(), 'socialplace_admin_main_settings');

        $this->view->form = $form = new Socialplace_Form_Admin_Global();

        if ($this->getRequest()->isPost() && $form->isValid($this->getAllParams())) {
            $values = $form->getValues();

            foreach ($values as $key => $value) {
                Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
            }
            $form->addNotice(Zend_Registry::get('Zend_Translate')->_('Your changes have been saved.'));
        }
    }

    public function categoriesAction()
    {
        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('socialplace_admin_main', array(), 'socialplace_admin_main_categories');

        //$this->view->categories = Engine_Api::_()->getItemTable('socialplace_category')->getCategories();
        $this->view->categories = Engine_Api::_()->getDbTable('categories', 'socialplace')->fetchAll();
    }


    public function addCategoryAction()
    {
        // In smoothbox
        $this->_helper->layout->setLayout('admin-simple');

        // Generate and assign form
        $form = $this->view->form = new Socialplace_Form_Admin_Category();
        $form->setAction($this->getFrontController()->getRouter()->assemble(array()));
        // Check post
        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
            // we will add the category
            $values = $form->getValues();

            $db = Engine_Db_Table::getDefaultAdapter();
            $db->beginTransaction();

            try {
                // add category to the database
                // Transaction
                $table = Engine_Api::_()->getItemTable('socialplace_category');

                // insert the place into the database
                $row = $table->createRow();
                $row->user_id = 1;
                $row->category_name = $values["label"];
                $row->save();

                // change the category of all the places using that category

                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                throw $e;
            }

            $this->_forward('success', 'utility', 'core', array(
                'smoothboxClose' => 10,
                'parentRefresh' => 10,
                'messages' => array(Zend_Registry::get('Zend_Translate')->_('The category was added successfully.'))
            ));
        }

        // Output
        $this->renderScript('admin-settings/form.tpl');
    }

    public function deleteCategoryAction()
    {
        // In smoothbox
        $this->_helper->layout->setLayout('admin-simple');
        $id = $this->_getParam('id');
        $this->view->place_id = $id;
        // Check post
        if ($this->getRequest()->isPost()) {
            $db = Engine_Db_Table::getDefaultAdapter();
            $db->beginTransaction();

            try {
                // go through logs and see which place used this $id and set it to ZERO
                $placeTable = Engine_Api::_()->getItemtable('place');
                $select = $placeTable->select()->where('category_id = ?', $id);
                $places = $placeTable->fetchAll($select);

                // create permissions
                foreach ($places as $place) {
                    //this is not working
                    $place->category_id = 0;
                    $place->save();
                }
                $row = Engine_Api::_()->getItem('socialplace_category', $id);
                // delete the place into the database
                $row->delete();

                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                throw $e;
            }
            $this->_forward('success', 'utility', 'core', array(
                'smoothboxClose' => 10,
                'parentRefresh' => 10,
                'messages' => array(Zend_Registry::get('Zend_Translate')->_('The category was deleted successfully.'))
            ));
        }

        // Output
        $this->renderScript('admin-settings/delete.tpl');
    }

    public function editCategoryAction()
    {
        // In smoothbox
        $this->_helper->layout->setLayout('admin-simple');
        $form = $this->view->form = new Socialplace_Form_Admin_Category();
        $form->setAction($this->getFrontController()->getRouter()->assemble(array()));

        // Check post
        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
            // Ok, we're good to add field
            $values = $form->getValues();

            $db = Engine_Db_Table::getDefaultAdapter();
            $db->beginTransaction();

            try {
                // edit category in the database
                // Transaction
				$row = Engine_Api::_()->getItem('socialplace_category', $values["id"]);
                $row->category_name = $values["label"];
                $row->save();
                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                throw $e;
            }
            $this->_forward('success', 'utility', 'core', array(
                'smoothboxClose' => 10,
                'parentRefresh' => 10,
                'messages' => array(Zend_Registry::get('Zend_Translate')->_('The category was modified successfully.'))
            ));
        }

        // Must have an id
        if (!($id = $this->_getParam('id'))) {
            die(Zend_Registry::get('Zend_Translate')->_('No identifier specified'));
        }

        // Generate and assign form
        $category = Engine_Api::_()->getItem('socialplace_category', $id);
        $form->setField($category);

        // Output
        $this->renderScript('admin-settings/form.tpl');

    }

    public function regionsAction()
    {
        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('socialplace_admin_main', array(), 'socialplace_admin_main_regions');

        $this->view->regions = Engine_Api::_()->getDbTable('regions', 'socialplace')->fetchAll();
        $this->view->regions2 = Engine_Api::_()->getDbTable('regions', 'socialplace')->fetchAll();
        
        if (!$this -> getRequest()-> isPost())
        {
        	return; 
        }
        $values = $this -> getRequest() -> getPost();
        $ids = @$values['region_ids'];
        if (isset($values['feature']) && $values['feature'] == '1')
        {
	        if (count($ids))
	        {
	        	foreach ($ids as $id)
	        	{
		        	$region = Engine_Api::_()->getItem('socialplace_region', $id);
		        	if (!is_null($region))
		        	{
		        		$region -> featured = 1; 
		        		$region -> save();
		        	}
	        	}
	        }
        }
        elseif (isset($values['unfeature']) && $values['unfeature'] == '1')
        {
	        if (count($ids))
	        {
	        	foreach ($ids as $id)
	        	{
		        	$region = Engine_Api::_()->getItem('socialplace_region', $id);
		        	if (!is_null($region))
		        	{
		        		$region -> featured = 0; 
		        		$region -> save();
		        	}
	        	}
	        }
        }
        
        return $this->_helper->redirector->gotoRoute(array('action' => 'regions'));
    }

    public function addRegionAction()
    {
        // In smoothbox
        $this->_helper->layout->setLayout('admin-simple');

        // Generate and assign form
        $form = $this->view->form = new Socialplace_Form_Admin_Region();
        $form->setAction($this->getFrontController()->getRouter()->assemble(array()));
        $parentId = $this->getParam('id', 0);
        if ($parentId)
        {
            $form->parent_id->setValue($parentId);
        }
        // Check post
        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
            // we will add the region
            $values = $form->getValues();

            $db = Engine_Db_Table::getDefaultAdapter();
            $db->beginTransaction();

            try {
                // add region to the database
                // Transaction
                $table = Engine_Api::_()->getItemTable('socialplace_region');

                // insert the place into the database
                $row = $table->createRow();
                $row->region_name = $values["label"];
                $row->parent_id = $values["parent_id"];
                $row->save();

                // Add photo
				if( !empty($values['photo']) ) 
				{
			        $row->setPhoto($form->photo);
				}  
                
                // change the region of all the places using that region
                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                throw $e;
            }

            $this->_forward('success', 'utility', 'core', array(
                'smoothboxClose' => 10,
                'parentRefresh' => 10,
                'messages' => array(Zend_Registry::get('Zend_Translate')->_('The region was added successfully.'))
            ));
        }

        // Output
        $this->renderScript('admin-settings/form.tpl');
    }

    public function deleteRegionAction()
    {
        // In smoothbox
        $this->_helper->layout->setLayout('admin-simple');
        $id = $this->_getParam('id');
        $this->view->place_id = $id;
        // Check post
        if ($this->getRequest()->isPost()) {
            $db = Engine_Db_Table::getDefaultAdapter();
            $db->beginTransaction();

            try {
                // go through logs and see which place used this $id and set it to ZERO
                $placeTable = Engine_Api::_()->getItemtable('place');
                $select = $placeTable->select()->where('region_id = ?', $id);
                $places = $placeTable->fetchAll($select);

                // create permissions
                foreach ($places as $place) {
                    //this is not working
                    $place->region_id = 0;
                    $place->save();
                }
                $row = Engine_Api::_()->getItem('socialplace_region', $id);
                // delete the place into the database
                $row->delete();

                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                throw $e;
            }
            $this->_forward('success', 'utility', 'core', array(
                'smoothboxClose' => 10,
                'parentRefresh' => 10,
                'messages' => array(Zend_Registry::get('Zend_Translate')->_('The region was deleted successfully.'))
            ));
        }
    }

    public function editRegionAction()
    {
        // In smoothbox
        $this->_helper->layout->setLayout('admin-simple');
        $form = $this->view->form = new Socialplace_Form_Admin_Region();
        $form->setAction($this->getFrontController()->getRouter()->assemble(array()));

        // Check post
        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
            // Ok, we're good to add field
            $values = $form->getValues();

            $db = Engine_Db_Table::getDefaultAdapter();
            $db->beginTransaction();

            try 
            {
                // edit region in the database
                // Transaction
                $row = Engine_Api::_()->getItem('socialplace_region', $values["id"]);
                $row->region_name = $values["label"];
                $row->save();
                
                // Add photo
				if( !empty($values['photo']) ) 
				{
			        $row->setPhoto($form->photo);
				} 
                
                $db->commit();
            } 
            catch (Exception $e) 
            {
                $db->rollBack();
                throw $e;
            }
            $this->_forward('success', 'utility', 'core', array(
                'smoothboxClose' => 10,
                'parentRefresh' => 10,
                'messages' => array(Zend_Registry::get('Zend_Translate')->_('The region was modified successfully.'))
            ));
        }

        // Must have an id
        if (!($id = $this->_getParam('id'))) {
            die(Zend_Registry::get('Zend_Translate')->_('No identifier specified'));
        }

        // Generate and assign form
        $region = Engine_Api::_()->getItem('socialplace_region', $id);
        $form->setField($region);
    }
}