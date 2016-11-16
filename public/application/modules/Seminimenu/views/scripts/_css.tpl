/* SeMiniMenu Notification */
li.seminimenu_notification
{
	padding-top: [notification_padding_top]!important;
}
li.seminimenu_notification div.seminimenu_mini_wrapper a.seminimenu_NotifiIcon
{
	background-image: url([notification_background_image])!important;
}
/* Sub main menu*/
li.seminimenu_downservicesMain ul.seminimenu_pulldownMainWrapper
{
	background-color: [main_menu_sub_menu_background_color];
	background-color: #[main_menu_sub_menu_background_color];	
}
li.seminimenu_downservicesMain ul.seminimenu_pulldownMainWrapper > li a
{
	color: [main_menu_sub_menu_link_color];
	color: #[main_menu_sub_menu_link_color];
}
li.seminimenu_downservicesMain ul.seminimenu_pulldownMainWrapper > li a:hover
{
	color: [main_menu_sub_menu_link_hover_color];
	color: #[main_menu_sub_menu_link_hover_color];
}
li.seminimenu_downservicesMain > a:link, li.seminimenu_downservicesMain > a:visited,
li.seminimenu_downservicesMain:hover > a:link, li.seminimenu_downservicesMain:hover > a:visited
{
 	background-position: right [main_menu_sub_menu_vertical_arrow] !important;
}