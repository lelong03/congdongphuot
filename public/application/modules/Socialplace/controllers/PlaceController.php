<?php
class Socialplace_PlaceController extends Core_Controller_Action_Standard
{
	public function indexAction()
	{
		$this->view->someVar = 'someVal';
	}
	
	public function viewAction()
	{
		$subject = null;
		if( !Engine_Api::_()->core()->hasSubject() &&
		($id = $this->_getParam('place_id')) ) 
		{
			$subject = Engine_Api::_()->getItem('place', $id);
			if( $subject && $subject->getIdentity() ) {
				Engine_Api::_()->core()->setSubject($subject);
			}
		}
		$this->_helper->requireSubject();
		$subject = Engine_Api::_()->core()->getSubject();
		
		//add meta keyword for SEO
		/*
		$contents = explode(',', $subject->metadata);
		foreach($contents as $content)
		{
			$this->view->headMeta()->appendName('keyword', $content);
		}
		*/
		
		$viewer = Engine_Api::_()->user()->getViewer();
		if( !$this->_helper->requireAuth()->setAuthParams($subject, $viewer, 'view')->isValid())
		{
			return;
		}

		// Increment view count
		if( !$subject->getOwner()->isSelf($viewer) )
		{
			$subject->view_count++;
			$subject->save();
		}

		// Render
		$this->_helper->content
		//->setNoRender()
		->setEnabled()
		;
	}
	
	public function deleteAction()
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		$place = Engine_Api::_()->getItem('place', $this->getRequest()->getParam('place_id'));
		if( !$this->_helper->requireAuth()->setAuthParams($place, null, 'delete')->isValid()) return;

		// In smoothbox
		$this->_helper->layout->setLayout('default-simple');

		// Make form
		$this->view->form = $form = new Socialplace_Form_Delete();

		if( !$place )
		{
			$this->view->status = false;
			$this->view->error = Zend_Registry::get('Zend_Translate')->_("Place doesn't exists or not authorized to delete");
			return;
		}

		if( !$this->getRequest()->isPost() )
		{
			$this->view->status = false;
			$this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
			return;
		}

		$db = $place->getTable()->getAdapter();
		$db->beginTransaction();

		try
		{
			$place->delete();
			$db->commit();
		}
		catch( Exception $e )
		{
			$db->rollBack();
			throw $e;
		}

		$this->view->status = true;
		$this->view->message = Zend_Registry::get('Zend_Translate')->_('The selected place has been deleted.');
		return $this->_forward('success' ,'utility', 'core', array(
	      'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'socialplace_general', true),
	      'messages' => Array($this->view->message)
		));
	}
	
	public function editAction()
	{
		// Get navigation
		$this->view->navigation = Engine_Api::_()
		->getApi('menus', 'core')
		->getNavigation('socialplace_main', array());

		if( count($this->view->navigation) == 1 ) {
			$this->view->navigation = null;
		}
		
		if( !$this->_helper->requireAuth()->setAuthParams('place', null, 'create')->isValid()) return;
		$this -> view -> place = $place = Engine_Api::_()->getItem('place', $this->getRequest()->getParam('place_id'));
		$viewer = Engine_Api::_()->user()->getViewer();
		
		// Prepare form
		$this->view->form = $form = new Socialplace_Form_Edit(array(
			'location' => $place->location,
			'place' => $place,
		));
		$placeArray = $place -> toArray();
		$placeArray['location_address'] = $placeArray['address'];
        $placeArray['full_address'] = $placeArray['address'];
		if (is_array($placeArray['phone']))
			$placeArray['phone'] = $placeArray['phone'][0];
		$form -> populate($placeArray);
		
		$tagStr = '';
		foreach( $place->tags()->getTagMaps() as $tagMap ) 
		{
			$tag = $tagMap->getTag();
			if( !isset($tag->text) ) 
				continue;
			if( '' !== $tagStr ) 
				$tagStr .= ', ';
			$tagStr .= $tag->text;
		}
		$form->populate(array(
      		'tags' => $tagStr,
		));
    
		 $auth = Engine_Api::_()->authorization()->context;
		 $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
	
		 foreach( $roles as $role ) 
		 {
		 	if ($form->auth_view)
		 	{
		 		if( $auth->isAllowed($place, $role, 'view') ) 
		 		{
		 			$form->auth_view->setValue($role);
		 		}
		 	}
	
		 	if ($form->auth_comment)
		 	{
		 		if( $auth->isAllowed($place, $role, 'comment') ) 
		 		{
		 			$form->auth_comment->setValue($role);
		 		}
		 	}
		 }
		
		// If not post or form not valid, return
		if( !$this->getRequest()->isPost() ) 
		{
			return;
		}
		if( !$form->isValid($this->getRequest()->getPost()) ) 
		{
			return;
		}
		$values = $form->getValues();
		if ($values['location_address'] == '')
		{
			$form->addError("Please enter the location address");
			return;
		}
		
		// Process
		$table = Engine_Api::_()->getItemTable('place');
		$db = $table->getAdapter();
		$db->beginTransaction();

		try {
			// Edit place
			$viewer = Engine_Api::_()->user()->getViewer();
			$values = $form->getValues();
            if (isset($values['full_address']) && $values['full_address'] != '')
            {
                $values['address'] = $values['full_address'];
            }
            else
            {
                $values['address'] = $values['location_address'];
            }
			$values['location'] = (isset($_POST['location']) && $_POST['location'] ) 
				? $_POST['location']
				: $values['location_address'];
			
			// Check phones
            $sub_fone = $this -> _getParam('sub_phone', array());
            array_unshift($sub_fone, $values['phone']);
            $values['phone'] = $sub_fone;
			
			$place->setFromArray($values);
			$place->save();

			// Auth
			$auth = Engine_Api::_()->authorization()->context;
			$roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

			if( empty($values['auth_view']) ) {
				$values['auth_view'] = 'everyone';
			}

			if( empty($values['auth_comment']) ) {
				$values['auth_comment'] = 'everyone';
			}

			$viewMax = array_search($values['auth_view'], $roles);
			$commentMax = array_search($values['auth_comment'], $roles);

			foreach( $roles as $i => $role ) {
				$auth->setAllowed($place, $role, 'view', ($i <= $viewMax));
				$auth->setAllowed($place, $role, 'comment', ($i <= $commentMax));
			}

			// Add tags
			$tags = preg_split('/[,]+/', $values['tags']);
			$place->tags()->addTagMaps($viewer, $tags);

			// Add photo
			if (!empty($values['photo']))
			{
				$place -> setPhoto($form -> photo);
			}
			
			// Add activity only if place is published
			if( $values['draft'] == 0 ) {
				//$action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $place, 'place_new');

				// make sure action exists before attaching the place to the activity
				if( $action ) {
					//Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $place);
				}

			}

			// Commit
			$db->commit();
		}

		catch( Exception $e )
		{
			$db->rollBack();
			throw $e;
		}

		return $this->_helper->redirector->gotoRoute(array('action' => 'manage'));
	}
	
	public function directionAction()
	{
        // Render
        $this->_helper->content->setEnabled();
		$id = $this -> _getParam('place_id', 0);
		$this->view->place = $place = Engine_Api::_()->getItem('place', $id);
		if (empty($place)) {
			return $this->_helper->requireAuth()->forward();
		}
	}
	
}