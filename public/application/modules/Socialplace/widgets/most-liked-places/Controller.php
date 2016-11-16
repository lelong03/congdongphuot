<?php
class Socialplace_Widget_MostLikedPlacesController extends Engine_Content_Widget_Abstract
{
    public function indexAction()
    {

        $placeTbl = Engine_Api::_()->getItemTable('place');
        $this->view->paginator = $paginator = $placeTbl->getPlacesPaginator(array('order' => 'most_like'));
        $limit = $this->_getParam('itemCountPerPage', 8);
        $paginator->setItemCountPerPage($limit);
        $paginator->setCurrentPageNumber(1);

        // Hide if nothing to show
        if (!$paginator->getTotalItemCount()) {
            return $this->setNoRender();
        }
    }
}
