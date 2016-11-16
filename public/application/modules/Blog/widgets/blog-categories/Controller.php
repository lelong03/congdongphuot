<?php
class Blog_Widget_BlogCategoriesController extends Engine_Content_Widget_Abstract
{
	public function indexAction()
	{
		$this -> view -> categories = $categories = Engine_Api::_()->getDbtable('categories', 'blog')->fetchAll();
	}
}
