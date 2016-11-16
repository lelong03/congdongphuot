<?php
class Socialplace_Widget_ProfileCoverController extends Engine_Content_Widget_Abstract 
{
     public function indexAction() 
     {
	     // Don't render this if not authorized
	    $viewer = Engine_Api::_()->user()->getViewer();
	    if( !Engine_Api::_()->core()->hasSubject() ) {
	      return $this->setNoRender();
	    }
	
	    // Get subject and check auth
	    $subject = Engine_Api::_()->core()->getSubject('place');
	    if( !$subject->authorization()->isAllowed($viewer, 'view') ) {
	      return $this->setNoRender();
	    }
	
	    // Get paginator
	    $album = $subject->getSingletonAlbum();
	    $this->view->paginator = $paginator = $album->getCollectiblesPaginator();
	    $this->view->canUpload = $canUpload = ($subject->user_id == $viewer->getIdentity());
	
	    // Set item count per page and current page number
	    $paginator->setItemCountPerPage($this->_getParam('itemCountPerPage', 8));
	    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
	    
	    // Do not render if nothing to show and cannot upload
	    if( $paginator->getTotalItemCount() <= 0 && !$canUpload ) {
	      return $this->setNoRender();
	    }
	
	    // Add count to title if configured
	    if( $this->_getParam('titleCount', false) && $paginator->getTotalItemCount() > 0 ) {
	      $this->_childCount = $paginator->getTotalItemCount();
	    }
     }

}