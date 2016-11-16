<?php
class Socialplace_Installer extends Engine_Package_Installer_Module {
    public function onInstall() {
		$this -> _addSocialPlaceHomePage();
        $this -> _addSocialPlaceListingPage();
		$this -> _addSocialPlaceCreatePlacePage();
		$this -> _addViewPlacePage();
		$this -> _addSocialPlaceManagePage();
        $this -> _addDirectionPage();
		parent::onInstall();
    }

    protected function _addDirectionPage()
    {
        $db = $this->getDb();

        $page_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'socialplace_place_direction')
            ->limit(1)
            ->query()
            ->fetchColumn();

        if(!$page_id) {
            $db->insert('engine4_core_pages', array(
                'name' => 'socialplace_place_direction',
                'displayname' => 'Social Place - Direction Page',
                'title' => 'Social Place - Direction Page',
                'description' => 'Social Place - Direction Page',
                'custom' => 0
            ));
            $page_id = $db->lastInsertId();

            // Insert top
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'top',
                'page_id' => $page_id,
                'order' => 1,
            ));
            $top_id = $db->lastInsertId();

            //Insert main
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'main',
                'page_id' => $page_id,
                'order' => 2,
            ));
            $main_id = $db->lastInsertId();

            //Insert top-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $page_id,
                'parent_content_id' => $top_id,
            ));
            $top_middle_id = $db->lastInsertId();

            // Insert main-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $page_id,
                'parent_content_id' => $main_id,
                'order' => 2,
            ));
            $main_middle_id = $db->lastInsertId();

            //Insert menu
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'socialplace.browse-menu',
                'page_id' => $page_id,
                'parent_content_id' => $top_middle_id,
                'order' => 1,
            ));

            //Insert content
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'core.content',
                'page_id' => $page_id,
                'parent_content_id' => $main_middle_id,
                'order' => 1,
            ));
        }
    }

	protected function _addSocialPlaceHomePage() 
	{
        $db = $this->getDb();
        
        $page_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'socialplace_index_browse')
            ->limit(1)
            ->query()
            ->fetchColumn();
            
        if(!$page_id) {
            $db->insert('engine4_core_pages', array(
                'name' => 'socialplace_index_browse',
                'displayname' => 'Social Place - Home Page',
                'title' => 'Social Place - Home Page',
                'description' => 'Social Place - Home Page',
                'custom' => 0
            ));
            $page_id = $db->lastInsertId();
            
            // Insert top
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'top',
                'page_id' => $page_id,
                'order' => 1,
            ));
            $top_id = $db->lastInsertId();
            
            //Insert main
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'main',
                'page_id' => $page_id,
                'order' => 2,
            ));
            $main_id = $db->lastInsertId();
            
            //Insert top-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $page_id,
                'parent_content_id' => $top_id,
            ));
            $top_middle_id = $db->lastInsertId();
            
            // Insert main-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $page_id,
                'parent_content_id' => $main_id,
                'order' => 2,
            ));
            $main_middle_id = $db->lastInsertId();  
            
            //Insert menu
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'socialplace.browse-menu',
                'page_id' => $page_id,
                'parent_content_id' => $top_middle_id,
                'order' => 1,
            ));
            
            // Insert socialplace.featured-region
            $db -> insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'socialplace.featured-region',
                'page_id' => $page_id,
                'parent_content_id' => $main_middle_id,
                'order' => 1,
                'params' => '{"title":"Featured Regions"}',
            ));
            
            //Insert browse place
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'socialplace.browse-place',
                'page_id' => $page_id,
                'parent_content_id' => $main_middle_id,
                'order' => 2,
            ));

            // Insert main-right
            $db -> insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'right',
                'page_id' => $page_id,
                'parent_content_id' => $main_id,
                'order' => 2,
            ));
            $main_right_id = $db -> lastInsertId();

            // Insert socialplace.search-form
            $db -> insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'socialplace.search-form',
                'page_id' => $page_id,
                'parent_content_id' => $main_right_id,
                'order' => 1,
                'params' => '{"title":"Search Place"}',
            ));
            
            // Insert socialplace.most-liked-places
            $db -> insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'socialplace.most-liked-places',
                'page_id' => $page_id,
                'parent_content_id' => $main_right_id,
                'order' => 2,
                'params' => '{"title":"Most Liked Place"}',
            ));

            // Insert socialplace.most-rated-places
            $db -> insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'socialplace.most-rated-places',
                'page_id' => $page_id,
                'parent_content_id' => $main_right_id,
                'order' => 3,
                'params' => '{"title":"Most Rated Place"}',
            ));

        }
    }
    
    protected function _addSocialPlaceListingPage() 
    {
        $db = $this->getDb();
        
        $page_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'socialplace_index_listing')
            ->limit(1)
            ->query()
            ->fetchColumn();
            
        if(!$page_id) {
            $db->insert('engine4_core_pages', array(
                'name' => 'socialplace_index_listing',
                'displayname' => 'Social Place - Listing Page',
                'title' => 'Social Place - Listing Page',
                'description' => 'Social Place - Listing Page',
                'custom' => 0
            ));
            $page_id = $db->lastInsertId();
            
            // Insert top
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'top',
                'page_id' => $page_id,
                'order' => 1,
            ));
            $top_id = $db->lastInsertId();
            
            //Insert main
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'main',
                'page_id' => $page_id,
                'order' => 2,
            ));
            $main_id = $db->lastInsertId();
            
            //Insert top-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $page_id,
                'parent_content_id' => $top_id,
            ));
            $top_middle_id = $db->lastInsertId();
            
            // Insert main-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $page_id,
                'parent_content_id' => $main_id,
                'order' => 2,
            ));
            $main_middle_id = $db->lastInsertId();  
            
            //Insert menu
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'socialplace.browse-menu',
                'page_id' => $page_id,
                'parent_content_id' => $top_middle_id,
                'order' => 1,
            ));
            
            //Insert browse place
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'socialplace.browse-place',
                'page_id' => $page_id,
                'parent_content_id' => $main_middle_id,
                'order' => 2,
            ));

            // Insert main-right
            $db -> insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'right',
                'page_id' => $page_id,
                'parent_content_id' => $main_id,
                'order' => 2,
            ));
            $main_right_id = $db -> lastInsertId();

            // Insert socialplace.search-form
            $db -> insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'socialplace.search-form',
                'page_id' => $page_id,
                'parent_content_id' => $main_right_id,
                'order' => 1,
                'params' => '{"title":"Search Places"}',
            ));
            
            // Insert socialplace.most-liked-places
            $db -> insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'socialplace.most-liked-places',
                'page_id' => $page_id,
                'parent_content_id' => $main_right_id,
                'order' => 2,
                'params' => '{"title":"Most Liked Place"}',
            ));

            // Insert socialplace.most-rated-places
            $db -> insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'socialplace.most-rated-places',
                'page_id' => $page_id,
                'parent_content_id' => $main_right_id,
                'order' => 3,
                'params' => '{"title":"Most Rated Place"}',
            ));

        }
    }

	protected function _addSocialPlaceCreatePlacePage() 
	{
        $db = $this->getDb();
        
        $page_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'socialplace_index_create')
            ->limit(1)
            ->query()
            ->fetchColumn();
            
        if(!$page_id) {
            $db->insert('engine4_core_pages', array(
                'name' => 'socialplace_index_create',
                'displayname' => 'Social Place - Create Place Page',
                'title' => 'Social Place - Create Place Page',
                'description' => 'Social Place - Create Place Page',
                'custom' => 0
            ));
            $page_id = $db->lastInsertId();
            
            // Insert top
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'top',
                'page_id' => $page_id,
                'order' => 1,
            ));
            $top_id = $db->lastInsertId();
            
            //Insert main
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'main',
                'page_id' => $page_id,
                'order' => 2,
            ));
            $main_id = $db->lastInsertId();
            
            //Insert top-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $page_id,
                'parent_content_id' => $top_id,
            ));
            $top_middle_id = $db->lastInsertId();
            
            // Insert main-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $page_id,
                'parent_content_id' => $main_id,
                'order' => 2,
            ));
            $main_middle_id = $db->lastInsertId();  
            
            //Insert menu
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'socialplace.browse-menu',
                'page_id' => $page_id,
                'parent_content_id' => $top_middle_id,
                'order' => 1,
            ));
            
            //Insert core content
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'core.content',
                'page_id' => $page_id,
                'parent_content_id' => $main_middle_id,
                'order' => 1,
            ));                      
        }
    }
    
	private function _addViewPlacePage()
	{
		$db = $this->getDb();
		
		$page_id = $db -> select() 
		-> from('engine4_core_pages', 'page_id') 
		-> where('name = ?', 'socialplace_place_view') 
		-> limit(1) -> query() -> fetchColumn();

		// insert if it doesn't exist yet
		if (!$page_id)
		{
			// Insert page
			$db -> insert('engine4_core_pages', array(
				'name' => 'socialplace_place_view',
				'displayname' => 'Social Place - Place Profile Page',
				'title' => 'Social Place - Place Profile Page',
				'description' => 'Social Place - Place Profile Page',
				'custom' => 0,
			));
			$page_id = $db -> lastInsertId();

			// Insert top
			$db -> insert('engine4_core_content', array(
				'type' => 'container',
				'name' => 'top',
				'page_id' => $page_id,
				'order' => 1,
			));
			$top_id = $db -> lastInsertId();

			// Insert main
			$db -> insert('engine4_core_content', array(
				'type' => 'container',
				'name' => 'main',
				'page_id' => $page_id,
				'order' => 2,
			));
			$main_id = $db -> lastInsertId();
			
			// Insert top-middle
			$db -> insert('engine4_core_content', array(
				'type' => 'container',
				'name' => 'middle',
				'page_id' => $page_id,
				'parent_content_id' => $top_id,
				'order' => 1,
			));
			$top_middle_id = $db -> lastInsertId();

			//Insert menu
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'socialplace.browse-menu',
                'page_id' => $page_id,
                'parent_content_id' => $top_middle_id,
                'order' => 1,
            ));
			
            // Insert profile cover 
			$db -> insert('engine4_core_content', array(
				'type' => 'widget',
				'name' => 'socialplace.profile-cover',
				'page_id' => $page_id,
				'parent_content_id' => $top_middle_id,
				'order' => 2,
			));
            
			// Insert main-middle
			$db -> insert('engine4_core_content', array(
				'type' => 'container',
				'name' => 'middle',
				'page_id' => $page_id,
				'parent_content_id' => $main_id,
				'order' => 1,
			));
			$main_middle_id = $db -> lastInsertId();
			
			// Insert container tab
			$db -> insert('engine4_core_content', array(
				'type' => 'widget',
				'name' => 'core.container-tabs',
				'page_id' => $page_id,
				'parent_content_id' => $main_middle_id,
				'order' => 1,
				'params' => '{"max":"6","title":"","nomobile":"0","name":"core.container-tabs"}',
			));
			$main_container_id = $db -> lastInsertId();
			
			// Insert profile socialplace.profile-info
			$db -> insert('engine4_core_content', array(
				'type' => 'widget',
				'name' => 'socialplace.profile-info',
				'page_id' => $page_id,
				'parent_content_id' => $main_container_id,
				'order' => 1,
				'params' => '{"title":"Location","titleCount":true}',
			));
			
			// insert socialplace.profile-photos
			$db -> insert('engine4_core_content', array(
				'type' => 'widget',
				'name' => 'socialplace.profile-photos',
				'page_id' => $page_id,
				'parent_content_id' => $main_container_id,
				'order' => 162,
				'params' => '{"title":"Photos"}',
			));
			
			// Insert main-right
			$db -> insert('engine4_core_content', array(
				'type' => 'container',
				'name' => 'right',
				'page_id' => $page_id,
				'parent_content_id' => $main_id,
				'order' => 2,
			));
			$main_right_id = $db -> lastInsertId();
			
			// Insert socialplace.profile-nearest-location
			$db -> insert('engine4_core_content', array(
				'type' => 'widget',
				'name' => 'socialplace.profile-nearest-location',
				'page_id' => $page_id,
				'parent_content_id' => $main_right_id,
				'order' => 1,
				'params' => '{"title":"Nearest Place"}',
			));

            // Insert socialplace.profile-rating
            $db -> insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'socialplace.profile-rating',
                'page_id' => $page_id,
                'parent_content_id' => $main_right_id,
                'order' => 2,
                'params' => '{"title":"Place Rating"}',
            ));

            // Insert main-left
            $db -> insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'left',
                'page_id' => $page_id,
                'parent_content_id' => $main_id,
                'order' => 1,
            ));
            $main_left_id = $db -> lastInsertId();

            // Insert socialplace.profile-options
            $db -> insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'socialplace.profile-options',
                'page_id' => $page_id,
                'parent_content_id' => $main_left_id,
                'order' => 1,
                'params' => '{"title":"Place Options"}',
            ));
		}
	}

    protected function _addSocialPlaceManagePage()
    {
        $db = $this->getDb();

        $page_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'socialplace_index_manage')
            ->limit(1)
            ->query()
            ->fetchColumn();

        if(!$page_id) {
            $db->insert('engine4_core_pages', array(
                'name' => 'socialplace_index_manage',
                'displayname' => 'Social Place - Manage Place Page',
                'title' => 'Social Place - Manage Place Page',
                'description' => 'Social Place - Manage Place Page',
                'custom' => 0
            ));
            $page_id = $db->lastInsertId();

            // Insert top
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'top',
                'page_id' => $page_id,
                'order' => 1,
            ));
            $top_id = $db->lastInsertId();

            //Insert main
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'main',
                'page_id' => $page_id,
                'order' => 2,
            ));
            $main_id = $db->lastInsertId();

            //Insert top-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $page_id,
                'parent_content_id' => $top_id,
            ));
            $top_middle_id = $db->lastInsertId();

            // Insert main-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $page_id,
                'parent_content_id' => $main_id,
                'order' => 2,
            ));
            $main_middle_id = $db->lastInsertId();

            //Insert menu
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'socialplace.browse-menu',
                'page_id' => $page_id,
                'parent_content_id' => $top_middle_id,
                'order' => 1,
            ));

            //Insert content
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'core.content',
                'page_id' => $page_id,
                'parent_content_id' => $main_middle_id,
                'order' => 1,
            ));
        }
    }
}