<?php
class Socialplace_Plugin_Menus
{
	public function canCreatePlaces()
	{
		// Must be logged in
		$viewer = Engine_Api::_()->user()->getViewer();
		if( !$viewer || !$viewer->getIdentity() ) {
			return false;
		}

		// Must be able to create blogs
		/*
		if( !Engine_Api::_()->authorization()->isAllowed('blog', $viewer, 'create') ) {
			return false;
		}
		*/
		return true;
	}

	public function canViewPlaces()
	{
		/*
		$viewer = Engine_Api::_()->user()->getViewer();

		// Must be able to view blogs
		
		if( !Engine_Api::_()->authorization()->isAllowed('blog', $viewer, 'view') ) {
			return false;
		}
		*/
		return true;
	}

	public function onMenuInitialize_SocialplaceProfileDelete()
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		$subject = Engine_Api::_()->core()->getSubject();
		if( $subject->getType() !== 'place' ) {
			throw new Exception('This place does not exist.');
		} else if( !$subject->authorization()->isAllowed($viewer, 'delete') ) {
			return false;
		}

		return array(
	      'label' => 'Delete Place',
	      'icon' => 'application/modules/Socialplace/externals/images/delete.png',
	      'class' => 'smoothbox',
	      'route' => 'socialplace_specific',
	      'params' => array(
		        'action' => 'delete',
		        'place_id' => $subject->getIdentity(),
			),
		);
	}

	public function onMenuInitialize_SocialplaceProfileEdit()
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		$subject = Engine_Api::_()->core()->getSubject();
		if( $subject->getType() !== 'place' )
		{
			throw new Exception('Whoops, not a place!');
		}

		if( !$viewer->getIdentity() || !$subject->authorization()->isAllowed($viewer, 'edit') )
		{
			return false;
		}

		if( !$subject->authorization()->isAllowed($viewer, 'edit') )
		{
			return false;
		}

		return array(
	      'label' => 'Edit Place Details',
	      'icon' => 'application/modules/Socialplace/externals/images/edit.png',
	      'route' => 'socialplace_specific',
	      'params' => array(
		        'action' => 'edit',
		        'place_id' => $subject->getIdentity(),
	        )
        );
	}

	public function onMenuInitialize_SocialplaceProfileReport()
	{
		return false;
	}

	public function onMenuInitialize_SocialplaceProfileShare()
	{
		$viewer = Engine_Api::_()->user()->getViewer();
		$subject = Engine_Api::_()->core()->getSubject();
		if( $subject->getType() !== 'place' )
		{
			throw new Exception('This place does not exist.');
		}

		if( !$viewer->getIdentity() )
		{
			return false;
		}

		return array(
	      'label' => 'Share This Place',
	      'icon' => 'application/modules/Socialplace/externals/images/share.png',
	      'class' => 'smoothbox',
	      'route' => 'default',
	      'params' => array(
		        'module' => 'activity',
		        'controller' => 'index',
		        'action' => 'share',
		        'type' => $subject->getType(),
		        'id' => $subject->getIdentity(),
		        'format' => 'smoothbox',
			),
		);
	}
}