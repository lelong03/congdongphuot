<?php
class Blog_Widget_FeaturedBlogsController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    // Should we consider views or comments popular?
    $popularType = $this->_getParam('popularType', 'view');
    if( !in_array($popularType, array('comment', 'view')) ) {
      $popularType = 'view';
    }
    $this->view->popularType = $popularType;
    $this->view->popularCol = $popularCol = $popularType . '_count';

    // Get paginator
    $table = Engine_Api::_()->getItemTable('blog');
    $select = $table->select()
      ->where('search = ?', 1)
      ->where('draft = ?', 0)
      ->where('featured = ?', 1)
      ->order($popularCol . ' DESC');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);

    // Set item count per page and current page number
    $paginator->setItemCountPerPage($this->_getParam('itemCountPerPage', 5));
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));

    // Hide if nothing to show
    if( $paginator->getTotalItemCount() <= 0 ) {
      return $this->setNoRender();
    }
  }
}