<?php
class Widget_HomeblogController extends Engine_Content_Widget_Abstract
{
	public function indexAction()
 	{
        $limit = $this -> _getParam('itemCountPerPage', 6);
 		$blogTbl = Engine_Api::_()->getItemTable('blog');
 		$blogSelect = $blogTbl
 		    ->select()
 		    ->where("photo_id != ? ", '0')
 		    ->where("category_id IN (?)", array(5, 15, 16))
            ->where("featured = ?", '1')
 		    ->limit($limit);
 		$this->view->blogs = $blogs = $blogTbl->fetchAll($blogSelect);
        if (count($blogs) %2 != 0)
        {
            $limit = count($blogs) - 1;
        }
        $this -> view -> limit = $limit;
 	}
}
