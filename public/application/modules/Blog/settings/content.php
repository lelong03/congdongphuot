<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Blog
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: content.php 9747 2012-07-26 02:08:08Z john $
 * @author     John
 */
return array(
  array(
    'title' => 'Featured Blogs',
    'description' => 'Displays featured blog entries.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.featured-blogs',
  ),
  array(
    'title' => 'Blog Categories',
    'description' => 'Displays blog categories.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.blog-categories',
  ),
  array(
    'title' => 'Profile Blogs',
    'description' => 'Displays a member\'s blog entries on their profile.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.profile-blogs',
    'isPaginated' => true,
    'defaultParams' => array(
      'title' => 'Blogs',
      'titleCount' => true,
    ),
    'requirements' => array(
      'subject' => 'user',
    ),
  ),
  array(
    'title' => 'Popular Blog Entries',
    'description' => 'Displays a list of most viewed blog entries.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.list-popular-blogs',
    'isPaginated' => true,
    'defaultParams' => array(
      'title' => 'Popular Blog Entries',
    ),
    'requirements' => array(
      'no-subject',
    ),
    'adminForm' => array(
      'elements' => array(
        array(
          'Radio',
          'popularType',
          array(
            'label' => 'Popular Type',
            'multiOptions' => array(
              'view' => 'Views',
              'comment' => 'Comments',
            ),
            'value' => 'comment',
          )
        ),
      )
    ),
  ),
  array(
    'title' => 'Recent Blog Entries',
    'description' => 'Displays a list of recently posted blog entries.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.list-recent-blogs',
    'isPaginated' => true,
    'defaultParams' => array(
      'title' => 'Recent Blog Entries',
    ),
    'requirements' => array(
      'no-subject',
    ),
    'adminForm' => array(
      'elements' => array(
        array(
          'Radio',
          'recentType',
          array(
            'label' => 'Recent Type',
            'multiOptions' => array(
              'creation' => 'Creation Date',
              'modified' => 'Modified Date',
            ),
            'value' => 'creation',
          )
        ),
      )
    ),
  ),
  
  array(
    'title' => 'Blog Gutter Search',
    'description' => 'Displays a search form in the blog gutter.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.gutter-search',
  ),
  array(
    'title' => 'Blog Gutter Menu',
    'description' => 'Displays a menu in the blog gutter.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.gutter-menu',
  ),
  array(
    'title' => 'Blog Gutter Photo',
    'description' => 'Displays the owner\'s photo in the blog gutter.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.gutter-photo',
  ),
  
  array(
    'title' => 'Blog Browse Search',
    'description' => 'Displays a search form in the blog browse page.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.browse-search',
    'requirements' => array(
      'no-subject',
    ),
  ),
  array(
    'title' => 'Blog Browse Menu',
    'description' => 'Displays a menu in the blog browse page.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.browse-menu',
    'requirements' => array(
      'no-subject',
    ),
  ),
  array(
    'title' => 'Blog Browse Quick Menu',
    'description' => 'Displays a small menu in the blog browse page.',
    'category' => 'Blogs',
    'type' => 'widget',
    'name' => 'blog.browse-menu-quick',
    'requirements' => array(
      'no-subject',
    ),
  ),
) ?>