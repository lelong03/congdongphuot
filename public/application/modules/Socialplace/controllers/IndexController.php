<?php

class Socialplace_IndexController extends Core_Controller_Action_Standard
{
	public function indexAction()
	{
		$this->view->someVar = 'someVal';
	}

	public function browseAction()
	{
		$this->_helper->content->setNoRender()->setEnabled();
		//$this->_helper->content->setEnabled();
	}

	public function listingAction()
	{
		$this->_helper->content->setNoRender()->setEnabled();
		//$this->_helper->content->setEnabled();
	}

	public function createAction()
	{
		$this -> view -> show_contact = false;
		if( !$this->_helper->requireUser()->isValid() ) return;

		//if( !$this->_helper->requireAuth()->setAuthParams('place', null, 'create')->isValid()) {
		if( !Engine_Api::_()->authorization()->isAllowed('place', null, 'create')) {
			$this -> view -> show_contact = true;
			//return;
		}

		// Render
		$this->_helper->content
		//->setNoRender()
		->setEnabled()
		;

		// set up data needed to check quota
		$viewer = Engine_Api::_()->user()->getViewer();
		$params['user_id'] = $viewer->getIdentity();
		$paginator = Engine_Api::_()->getItemTable('place')->getPlacesPaginator($params);

		$this->view->quota = $quota = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'place', 'max');
		$this->view->current_count = $paginator->getTotalItemCount();

		// Prepare form
		$this->view->form = $form = new Socialplace_Form_Create();
		
		// If not post or form not valid, return
		if( !$this->getRequest()->isPost() ) 
		{
			return;
		}
		if( !$form->isValid($this->getRequest()->getPost()) ) 
		{
			return;
		}
		$values = $form->getValues();
		if ($values['location_address'] == '')
		{
			$form->addError("Please enter the location address");
			return;
		}
		
		// Process
		$table = Engine_Api::_()->getItemTable('place');
		$db = $table->getAdapter();
		$db->beginTransaction();

		try {
			// Create place
			$viewer = Engine_Api::_()->user()->getViewer();
			$values = array_merge($form->getValues(), array(
		        'owner_type' => $viewer->getType(),
		        'owner_id' => $viewer->getIdentity(),
				'user_id' => $viewer->getIdentity(),
			));
            if (isset($values['full_address']) && $values['full_address'] != '')
            {
                $values['address'] = $values['full_address'];
            }
            else
            {
                $values['address'] = $values['location_address'];
            }
			$values['location'] = (isset($_POST['location']) && $_POST['location'] )
				? $_POST['location']
				: $value['location_address'];
			$place = $table->createRow();

			// Check phones
			$sub_fone = $this -> _getParam('sub_phone', array());
            array_unshift($sub_fone, $values['phone']);
            $values['phone'] = $sub_fone;

			$place->setFromArray($values);
			$place->save();
		
			// Auth
			$auth = Engine_Api::_()->authorization()->context;
			$roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

			if( empty($values['auth_view']) ) {
				$values['auth_view'] = 'everyone';
			}

			if( empty($values['auth_comment']) ) {
				$values['auth_comment'] = 'everyone';
			}

			$viewMax = array_search($values['auth_view'], $roles);
			$commentMax = array_search($values['auth_comment'], $roles);

			foreach( $roles as $i => $role ) {
				$auth->setAllowed($place, $role, 'view', ($i <= $viewMax));
				$auth->setAllowed($place, $role, 'comment', ($i <= $commentMax));
			}

			// Add tags
			$tags = preg_split('/[,]+/', $values['tags']);
			$place->tags()->addTagMaps($viewer, $tags);

			// Add photo
			if (!empty($values['photo']))
			{
				$place -> setPhoto($form -> photo);
			}
			
			// Add activity only if place is published
			if( $values['draft'] == 0 ) {
				//$action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $place, 'place_new');

				// make sure action exists before attaching the place to the activity
				if( $action ) {
					//Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $place);
				}

			}

			// Commit
			$db->commit();
		}

		catch( Exception $e )
		{
			$db->rollBack();
			throw $e;
		}

		return $this->_helper->redirector->gotoRoute(array('action' => 'manage'));
	}

	public function getMyLocationAction()
	{	
		$latitude = $this->_getParam('latitude');
		$longitude = $this->_getParam('longitude');
		$values  =  file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?latlng=$latitude,$longitude&sensor=true");
		echo $values;die;
	}

	public function uploadPhotoAction()
	{
		$viewer = Engine_Api::_()->user()->getViewer();

		$this->_helper->layout->disableLayout();

		if( !Engine_Api::_()->authorization()->isAllowed('album', $viewer, 'create') ) 
		{
			return false;
		}

		if( !$this->_helper->requireAuth()->setAuthParams('album', null, 'create')->isValid() ) return;

		if( !$this->_helper->requireUser()->checkRequire() )
		{
			$this->view->status = false;
			$this->view->error = Zend_Registry::get('Zend_Translate')->_('Max file size limit exceeded (probably).');
			return;
		}

		if( !$this->getRequest()->isPost() )
		{
			$this->view->status = false;
			$this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
			return;
		}
		if( !isset($_FILES['userfile']) || !is_uploaded_file($_FILES['userfile']['tmp_name']) )
		{
			$this->view->status = false;
			$this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid Upload');
			return;
		}

		$db = Engine_Api::_()->getDbtable('photos', 'album')->getAdapter();
		$db->beginTransaction();

		try
		{
			$viewer = Engine_Api::_()->user()->getViewer();

			$photoTable = Engine_Api::_()->getDbtable('photos', 'album');
			$photo = $photoTable->createRow();
			$photo->setFromArray(array(
		        'owner_type' => 'user',
		        'owner_id' => $viewer->getIdentity()
			));
			$photo->save();

			$photo->setPhoto($_FILES['userfile']);

			$this->view->status = true;
			$this->view->name = $_FILES['userfile']['name'];
			$this->view->photo_id = $photo->photo_id;
			$this->view->photo_url = $photo->getPhotoUrl();

			$table = Engine_Api::_()->getDbtable('albums', 'album');
			$album = $table->getSpecialAlbum($viewer, 'place');

			$photo->album_id = $album->album_id;
			$photo->save();

			if( !$album->photo_id )
			{
				$album->photo_id = $photo->getIdentity();
				$album->save();
			}

			$auth      = Engine_Api::_()->authorization()->context;
			$auth->setAllowed($photo, 'everyone', 'view',    true);
			$auth->setAllowed($photo, 'everyone', 'comment', true);
			$auth->setAllowed($album, 'everyone', 'view',    true);
			$auth->setAllowed($album, 'everyone', 'comment', true);


			$db->commit();

		} catch( Album_Model_Exception $e ) {
			$db->rollBack();
			$this->view->status = false;
			$this->view->error = $this->view->translate($e->getMessage());
			throw $e;
			return;

		} catch( Exception $e ) {
			$db->rollBack();
			$this->view->status = false;
			$this->view->error = Zend_Registry::get('Zend_Translate')->_('An error occurred.');
			throw $e;
			return;
		}
	}
	
	public function rateAction()
	{
		$viewer = Engine_Api::_() -> user() -> getViewer();
		$user_id = $viewer -> getIdentity();

		$rating = $this -> _getParam('rating');
		$place_id = $this -> _getParam('place_id');
		
		$table = Engine_Api::_() -> getDbtable('ratings', 'socialplace');
		$db = $table -> getAdapter();
		$db -> beginTransaction();

		try
		{
			$table -> setRating($place_id, $user_id, $rating);

			$place = Engine_Api::_() -> getItem('place', $place_id);
			$place -> rating = $table -> getRating($place -> getIdentity());
			$place -> save();

			$db -> commit();
		}
		catch (Exception $e)
		{
			$db -> rollBack();
			throw $e;
		}
		
		$total = $table -> ratingCount($place);

		$data = array();
		$data[] = array(
			'total' => $total,
			'rating' => $rating,
		);
		return $this -> _helper -> json($data);
		$data = Zend_Json::encode($data);
		$this -> getResponse() -> setBody($data);
	}

    //view map view
    public function displayMapViewAction()
    {
    	 ini_set('display_startup_errors', 1);
 ini_set('display_errors', 1);
 ini_set('error_reporting', -1);
        $placeIds = $this->_getParam('ids', '');
        if ($placeIds != '')
        {
            $placeIds = explode("_", $placeIds);
        }
        $placeTbl = Engine_Api::_()->getItemTable('place');
        $select = $placeTbl -> select() -> where("search = 1");


        if (is_array($placeIds) && count($placeIds))
        {
            $select -> where ("place_id IN (?)", $placeIds);
        }
        else
        {
            $select -> where ("0 = 1");
        }
        $places = $placeTbl->fetchAll($select);

        $datas = array();
        $contents = array();
        $http = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://'	;
        //$icon_clock     = $http.$_SERVER['SERVER_NAME'].$this->view->baseUrl().'/application/modules/Ynmember/externals/images/ynmember-maps-time.png';
        //$icon_persion   = $http.$_SERVER['SERVER_NAME'].$this->view->baseUrl().'/application/modules/Ynmember/externals/images/ynmember-maps-person.png';
        //$icon_star      = $http.$_SERVER['SERVER_NAME'].$this->view->baseUrl().'/application/modules/Ynmember/externals/images/ynmember-maps-close-black.png';
        $icon_pin     = $http.$_SERVER['SERVER_NAME'].$this->view->baseUrl().'/application/modules/Socialplace/externals/images/pin16.png';
        $icon_phone   = $http.$_SERVER['SERVER_NAME'].$this->view->baseUrl().'/application/modules/Socialplace/externals/images/phone.png';
        $icon_money   = $http.$_SERVER['SERVER_NAME'].$this->view->baseUrl().'/application/modules/Socialplace/externals/images/money.png';
        //$icon_new       = $http.$_SERVER['SERVER_NAME'].$this->view->baseUrl().'/application/modules/Ynmember/externals/images/icon-New.png';
        //$icon_guest     = $http.$_SERVER['SERVER_NAME'].$this->view->baseUrl().'/application/modules/Ynmember/externals/images/ynmember-maps-person.png';

        foreach($places as $place)
        {
            if($place -> latitude)
            {
                $icon = $http.$_SERVER['SERVER_NAME'].$this->view->baseUrl().'/application/modules/Socialplace/externals/images/pin24.png';
                $datas[] = array(
                    'place_id' => $place -> getIdentity(),
                    'latitude' => $place -> latitude,
                    'longitude' => $place -> longitude,
                    'icon' => $icon
                );
                $ratingContent = $this -> view -> partial('_review_rating.tpl', 'socialplace', array('rate_number' => $place -> rating));
                $textContent = '
					<div style="width: auto; min-height: 150px; ">
						<div style="float: left; width: 100px; ">
							<a href="'.$place->getHref().'" class="thumb" target="_parent" style="text-decoration: none;">
			        			<div style="background-image: url('.$place->getPhotoUrl('thumb.profile').'); background-size: cover; background-position: center; width: 100px; height: 120px; margin-bottom; 5px;"></div>
			        		</a>
			        		<div class="socialplace-review-item-rating">'.$ratingContent.'</div>
		      			</div>
	      				<div style="overflow: hidden; padding-left: 10px; line-height: 20px;">
					        <a href="'.$place->getHref().'" style="color: #679ac0; font-weight: bold; font-size: 15px; text-decoration: none;" target="_parent">
					         	'.$place->getTitle().'
					        </a>
					        <div>
					            <img src="'.$icon_pin.'" style="margin-right: 3px; vertical-align: -2px;">
					            <span>'.$place->address.'</span>
					        </div>
	        				
				';
				if(!empty($place->phone))
				{
					$phone = implode(', ', $place->phone);
					if ($phone != '')
					{
						$textContent .= '
							<div>
								<img src="'.$icon_phone.'" style="margin-right: 3px; vertical-align: -2px;">
								<span>'.$phone.'</span>
							</div>
						';	
					}
				}
				if($place -> price != '0')
				{
					$currency = Engine_Api::_()->getApi('settings', 'core')->getSetting('socialplace.currency', 'USD');
        			$c = ($currency == 'USD') ? '$' : 'đ';
					$price = number_format($place -> price) . $c;
					$textContent .= '
							<div>
								<img src="'.$icon_money.'" style="margin-right: 3px; vertical-align: -2px;">
								<span><strong>' . $price . '</strong></span>
							</div>
					';
				}
				$textContent .= '
							<div style="border-top: 1px solid #555; margin-top: 5px;">
					        	'.$this->view->string()->truncate($this->view->string()->stripTags($place->body), 300).'
					        </div>
			      		</div>
					</div>
				';
				$contents[] = $textContent;
            }
        }
        //print_r($datas); exit;
        echo $this ->view -> partial('_map_view.tpl', 'socialplace',array('datas'=>Zend_Json::encode($datas), 'contents' => Zend_Json::encode($contents)));
        exit();
    }

    public function manageAction()
    {
        if( !$this->_helper->requireUser()->isValid() ) return;

        // Render
        $this->_helper->content
            //->setNoRender()
            ->setEnabled()
        ;

        // Prepare data
        $viewer = Engine_Api::_()->user()->getViewer();
        $values = array();
        $this->view->canCreate = $this->_helper->requireAuth()->setAuthParams('place', null, 'create')->checkRequire();
        $formFilter = new Socialplace_Form_ManageSearch();
    	if ($formFilter -> isValid(Zend_Controller_Front::getInstance()->getRequest()->getParams()))
    	{
    		$values = $formFilter -> getValues();
    	}
        $this->view->formValues = array_filter($values);
        $values['user_id'] = $viewer->getIdentity();

        // Get paginator
        $this->view->paginator = $paginator = Engine_Api::_()->getItemTable('place')->getPlacesPaginator($values);
        $items_per_page = 10;
        $page = $this->_getParam('page', 1);
        $paginator->setItemCountPerPage($items_per_page);
        $this->view->paginator = $paginator->setCurrentPageNumber($page);
    }
}
