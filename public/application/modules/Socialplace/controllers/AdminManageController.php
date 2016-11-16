<?php

class Socialplace_AdminManageController extends Core_Controller_Action_Admin
{
	public function indexAction()
	{
		$this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
		->getNavigation('socialplace_admin_main', array(), 'socialplace_admin_main_manage');

		if ($this->getRequest()->isPost())
		{
			$values = $this->getRequest()->getPost();
			foreach ($values as $key=>$value) {
				if ($key == 'delete_' . $value)
				{
					$place = Engine_Api::_()->getItem('place', $value);
					$place->delete();
				}
			}
			return $this->_helper->redirector->gotoRoute(array('module'=>'socialplace', 'controller'=>'manage'), 'admin_default', true);
		}

		$page = $this->_getParam('page',1);
		$this->view->paginator = Engine_Api::_()->getItemTable('place')->getPlacesPaginator(array());
		$this->view->paginator->setItemCountPerPage(25);
		$this->view->paginator->setCurrentPageNumber($page);
	}

	public function deleteAction()
	{
		// In smoothbox
		$this->_helper->layout->setLayout('admin-simple');
		$id = $this->_getParam('id');
		$this->view->place_id=$id;
		// Check post
		if( $this->getRequest()->isPost())
		{
			$db = Engine_Db_Table::getDefaultAdapter();
			$db->beginTransaction();

			try
			{
				$place = Engine_Api::_()->getItem('place', $id);
				$place->delete();
				$db->commit();
			}

			catch( Exception $e )
			{
				$db->rollBack();
				throw $e;
			}

			$this->_forward('success', 'utility', 'core', array(
		          'smoothboxClose' => 10,
		          'parentRefresh'=> 10,
		          'messages' => array('')
			));
		}
		// Output
		$this->renderScript('admin-manage/delete.tpl');
	}
}