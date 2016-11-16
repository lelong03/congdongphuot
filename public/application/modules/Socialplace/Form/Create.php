<?php

class Socialplace_Form_Create extends Engine_Form
{
    public $_error = array();
    protected $_location;
    protected $_place;

    public function getLocation()
    {
        return $this->_location;
    }

    public function setLocation($location)
    {
        $this->_location = $location;
    }

    public function getPlace()
    {
        return $this->_place;
    }

    public function setPlace($place)
    {
        $this->_place = $place;
    }

    public function init()
    {
        $this
            ->setTitle('Post New Place')
            ->setDescription("Post your new place information below, then click 'Post Place' to publish your place.")
            ->setAttrib('name', 'places_create');

        $user = Engine_Api::_()->user()->getViewer();
        $user_level = Engine_Api::_()->user()->getViewer()->level_id;

        $this->addElement('Text', 'title', array(
            'label' => 'Place Title',
            'allowEmpty' => false,
            'required' => true,
            'filters' => array(
                new Engine_Filter_Censor(),
                'StripTags',
                new Engine_Filter_StringLength(array('max' => '63'))
            ),
            'autofocus' => 'autofocus',
        ));

        $this->addElement('Text', 'full_address', array(
            'label' => 'Full Address',
            'description' => 'Enter when Google can not find your location',
            'filters' => array(
                new Engine_Filter_Censor(),
                'StripTags',
                new Engine_Filter_StringLength(array('max' => '255'))
            ),
        ));
        $this->full_address->getDecorator("Description")->setOption("placement", "append");

        $this->addElement('Dummy', 'location_map', array(
            'label' => 'Place Location',
            'decorators' => array(array(
                'ViewScript',
                array(
                    'viewScript' => '_location_search.tpl',
                    'class' => 'form element',
                    'location' => $this->_location,
                )
            )),
        ));

        $regionTbl = Engine_Api::_()->getItemTable('socialplace_region');
        $options = $regionTbl->getParentRegionsAssoc();
        $this->addElement('select', 'region_id', array(
            'label' => 'Place Region',
            'multiOptions' => $options,
        ));

        $this->addElement('hidden', 'location_address', array(
            'value' => '0',
            'allowEmpty' => false,
            'required' => true,
            'order' => '97'
        ));

        $this->addElement('hidden', 'latitude', array(
            'value' => '0',
            'order' => '98'
        ));

        $this->addElement('hidden', 'longitude', array(
            'value' => '0',
            'order' => '99'
        ));

        // init to
        $this->addElement('Text', 'tags', array(
            'label' => 'Tags (Keywords)',
            'autocomplete' => 'off',
            'description' => 'Separate tags with commas.',
            'filters' => array(
                new Engine_Filter_Censor(),
            ),
        ));
        $this->tags->getDecorator("Description")->setOption("placement", "append");

        // prepare categories
        $categories = Engine_Api::_()->getDbtable('categories', 'socialplace')->getCategoriesAssoc();
        if (count($categories) > 0) {
            $this->addElement('Select', 'category_id', array(
                'label' => 'Category',
                'multiOptions' => $categories,
            ));
        }

        $allowed_html = Engine_Api::_()->authorization()->getPermission($user_level, 'place', 'auth_html');
        $upload_url = "";

        if (Engine_Api::_()->authorization()->isAllowed('album', $user, 'create')) {
            $upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'upload-photo'), 'socialplace_general', true);
        }

        $editorOptions = array(
            'upload_url' => $upload_url,
            'html' => (bool)$allowed_html,
        );

        if (!empty($upload_url)) {
            $editorOptions['plugins'] = array(
                'table', 'fullscreen', 'media', 'preview', 'paste',
                'code', 'image', 'textcolor', 'jbimages', 'link'
            );

            $editorOptions['toolbar1'] = array(
                'undo', 'redo', 'removeformat', 'pastetext', '|', 'code',
                'media', 'image', 'jbimages', 'link', 'fullscreen',
                'preview'
            );
        }

        $this->addElement('TinyMce', 'body', array(
            'label' => 'Place Description',
            //'disableLoadDefaultDecorators' => true,
            'required' => true,
            'allowEmpty' => false,
            /*
            'decorators' => array(
              'ViewHelper'
            ),
            */
            'editorOptions' => $editorOptions,
            'filters' => array(
                new Engine_Filter_Censor(),
                new Engine_Filter_Html(array('AllowedTags' => $allowed_html))),
        ));

        $this->addElement('Checkbox', 'search', array(
            'label' => 'Show this place in search results',
            'value' => 1,
        ));

        // Photo
        $this->addElement('File', 'photo', array(
            'label' => 'Main Photo',
            'allowEmpty' => false,
            'required' => true,
        ));
        $this->photo->addValidator('Extension', false, 'jpg,png,gif,jpeg');

        // Price
        $this->addElement('Text', 'price', array(
            'label' => 'Price',
            'description' => 'Enter min price of your place. Set 0 is call to get the price',
            'allowEmpty' => false,
            'required' => true,
            'value' => 0,
            'validators' => array(
                array('Float', true),
                new Engine_Validate_AtLeast(0),
            ),
        ));
        $this->price->getDecorator("Description")->setOption("placement", "append");

        //Phone
        $this->addElement('Text', 'phone', array(
            'label' => 'Phone',
            'allowEmpty' => true,
            'required' => false,
            'validators' => array(
                array('StringLength', false, array(1, 64)),
            ),
            'filters' => array(
                'StripTags',
                new Engine_Filter_Censor(),
            ),
        ));

        // add more phone
        $this->addElement('Cancel', 'add_more_phone', array(
            'label' => 'Add more phone',
            'link' => true,
            'ignore' => true,
            'onclick' => 'javascript:void(0)'
        ));


        $availableLabels = array(
            'everyone' => 'Everyone',
            'registered' => 'All Registered Members',
            'owner_network' => 'Friends and Networks',
            'owner_member_member' => 'Friends of Friends',
            'owner_member' => 'Friends Only',
            'owner' => 'Just Me'
        );

        // Element: auth_view
        $viewOptions = (array)Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('place', $user, 'auth_view');
        $viewOptions = array_intersect_key($availableLabels, array_flip($viewOptions));

        if (!empty($viewOptions) && count($viewOptions) >= 1) {
            // Make a hidden field
            if (count($viewOptions) == 1) {
                $this->addElement('hidden', 'auth_view', array('value' => key($viewOptions)));
                // Make select box
            } else {
                $this->addElement('Select', 'auth_view', array(
                    'label' => 'Privacy',
                    'description' => 'Who may see this place?',
                    'multiOptions' => $viewOptions,
                    'value' => key($viewOptions),
                ));
                $this->auth_view->getDecorator('Description')->setOption('placement', 'append');
            }
        }

        // Element: auth_comment
        $commentOptions = (array)Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('place', $user, 'auth_comment');
        $commentOptions = array_intersect_key($availableLabels, array_flip($commentOptions));

        if (!empty($commentOptions) && count($commentOptions) >= 1) {
            // Make a hidden field
            if (count($commentOptions) == 1) {
                $this->addElement('hidden', 'auth_comment', array('value' => key($commentOptions)));
                // Make select box
            } else {
                $this->addElement('Select', 'auth_comment', array(
                    'label' => 'Comment Privacy',
                    'description' => 'Who may post comments on this place?',
                    'multiOptions' => $commentOptions,
                    'value' => key($commentOptions),
                ));
                $this->auth_comment->getDecorator('Description')->setOption('placement', 'append');
            }
        }


        // Element: submit
        $this->addElement('Button', 'submit', array(
            'label' => 'Post Place',
            'type' => 'submit',
        ));
    }

    public function postPlace()
    {
        $values = $this->getValues();

        $user = Engine_Api::_()->user()->getViewer();
        $title = $values['title'];
        $body = $values['body'];
        $category_id = $values['category_id'];
        $tags = preg_split('/[,]+/', $values['tags']);

        $db = Engine_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            // Transaction
            $table = Engine_Api::_()->getDbtable('places', 'socialplace');

            // insert the place into the database
            $row = $table->createRow();
            $row->owner_id = $user->getIdentity();
            $row->owner_type = $user->getType();
            $row->category_id = $category_id;
            $row->creation_date = date('Y-m-d H:i:s');
            $row->modified_date = date('Y-m-d H:i:s');
            $row->title = $title;
            $row->body = $body;
            $row->save();

            $place_id = $row->place_id;

            if ($tags) {
                $this->handleTags($place_id, $tags);
            }

            $attachment = Engine_Api::_()->getItem($row->getType(), $place_id);
            $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($user, $row, 'place_new');
            Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $attachment);
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
        //$action = $api->addActivity($viewer, $viewer, 'status', $body);
        //$api->attachActivity($action, $attachment);
    }

    public function handleTags($place_id, $tags)
    {
        $tagTable = Engine_Api::_()->getDbtable('tags', 'place');
        $tabMapTable = Engine_Api::_()->getDbtable('tagmaps', 'place');
        $tagDup = array();
        foreach ($tags as $tag) {
            $tag = htmlspecialchars((trim($tag)));
            if (!in_array($tag, $tagDup) && $tag != "" && strlen($tag) < 20) {
                $tag_id = $this->checkTag($tag);
                // check if it is new. if new, createnew tag. else, get the tag_id and insert
                if (!$tag_id) {
                    $tag_id = $this->createNewTag($tag, $place_id, $tagTable);
                }

                $tabMapTable->insert(array(
                    'place_id' => $place_id,
                    'tag_id' => $tag_id
                ));
                $tagDup[] = $tag;
            }
            if (strlen($tag) >= 20) {
                $this->_error[] = $tag;
            }
        }
    }

    public function checkTag($text)
    {
        $table = Engine_Api::_()->getDbtable('tags', 'place');
        $select = $table->select()->order('text ASC')->where('text = ?', $text);
        $results = $table->fetchRow($select);
        $tag_id = "";
        if ($results) $tag_id = $results->tag_id;
        return $tag_id;
    }

    public function createNewTag($text, $place_id, $tagTable)
    {
        $row = $tagTable->createRow();
        $row->text = $text;
        $row->save();
        $tag_id = $row->tag_id;

        return $tag_id;
    }

}