<?php

class Seminimenu_Widget_MinimenuController extends Engine_Content_Widget_Abstract
{
	public function indexAction()
	{
		$this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

		/**
		 * Notification mini menu
		 */
		$html_notifications = "";
		if($viewer->getIdentity())
		{
			$html_notifications = $this->view->partial(Seminimenu_Api_Core::partialViewFullPath('_notification_icons.tpl'), array('viewer'=>$viewer));
		}
		$this->view->html_json_notification = json_encode($html_notifications);

		/**
		 * Profile mini menu
		 */
		$html_profile = "";
		if($viewer->getIdentity())
		{
			$html_profile = $this->view->partial(Seminimenu_Api_Core::partialViewFullPath('_profile_menu.tpl'), array('viewer'=>$viewer));
		}
		$this->view->html_json_profile = json_encode($html_profile);

		
		/**
		 * SE Mini Menu
		 */
		$arr_objectParent =  array();
		$arr_allsub_name_menu = array();
		$navigation = Engine_Api::_()
			->getApi('menus', 'seminimenu')
			->getNavigation('core_mini');
		$arr_navigation = $navigation->toArray();
		$arr_advmenu = array();
		$item_parent = $arr_navigation[0];
		$name_parent = $item_parent['class'];
		$arr_parents = array();
		foreach($navigation as $item)
		{
			if($item->submenu)
			{
				if($item_parent && !in_array($name_parent, $arr_parents) && !$item_parent['submenu'])
				{
					$arr_parents[] = $name_parent;
				}
				if($item->name != 'core_mini_messages')
				{
					$arr_advmenu[$name_parent]['items'][] = $item;
					$arr_allsub_name_menu[] = $item->name;
				}
			}
			else
			{
				$name_parent = $item->name;
				$arr_advmenu[$name_parent]['parent'] = $item;
			}
			$item_parent = $item->toArray();
		}

		foreach ($arr_advmenu as $key => $values)
		{
			if(!empty($values['items']) && !empty($values['parent']))
			{
				$html = $this->view->partial(Seminimenu_Api_Core::partialViewFullPath('_sub_mini_menu.tpl'), array('key'=> $key,'parent_item'=>$values['parent'], 'sub_menus'=> $values['items']));
				$arr_objectParent[$key] = json_encode($html);
			}
		}
		$this->view->arr_sub_mini = $arr_allsub_name_menu;
		$this->view->arr_objectParent = $arr_objectParent;
	}
}
