<?php

class Socialplace_Form_Search extends Engine_Form
{
    protected $_location;

    public function getLocation()
    {
        return $this->_location;
    }

    public function setLocation($location)
    {
        $this->_location = $location;
    }

    public function init()
    {
        $translate = Zend_Registry::get("Zend_Translate");

        //Set Form Layout And Attributes.
        $this->setAttribs(array('id' => 'place_filter_form',
            'class' => 'global_form_box',
            'method' => 'GET'
        ));

        //Page Id Field.
        $this->addElement('Hidden', 'page', array(
            'order' => 100,
        ));

        $this->addElement('Hidden', 'tag', array(
            'order' => 101,
        ));

        //Search Regions
        $regionTbl = Engine_Api::_()->getItemTable('socialplace_region');
        $options = $regionTbl->getParentRegionsAssoc();
        $this->addElement('select', 'region_id', array(
            'label' => 'Place Region',
            'multiOptions' => $options,
        ));

        //Search Text Field.
        $this->addElement('Text', 'keyword', array(
            'label' => 'Place Name',
        ));

        // Location
        $this->addElement('Text', 'location', array(
            'label' => 'Location',
            'decorators' => array(array(
                'ViewScript',
                array(
                    'viewScript' => '_location_search.tpl',
                    //'class' => 'form element',
                    'location' => $this->_location,
                )
            )),
        ));

        $lengthUnit = Engine_Api::_()->getApi('settings', 'core')->getSetting('socialplace.lengthunit', 'mile');
        $this->addElement('Text', 'within', array(
            'label' => "Radius ($lengthUnit)",
            //'placeholder' => $translate->translate('Radius (mile)..'),
            'maxlength' => '60',
            'required' => false,
            'style' => "display: block",
            'value' => 50,
            'validators' => array(
                array(
                    'Int',
                    true
                ),
                new Engine_Validate_AtLeast(0),
            ),
        ));

        $this->addElement('hidden', 'lat', array(
            'value' => '0',
            'order' => '98'
        ));

        $this->addElement('hidden', 'long', array(
            'value' => '0',
            'order' => '99'
        ));

        $currency = Engine_Api::_()->getApi('settings', 'core')->getSetting('socialplace.currency', 'USD');
        $currency = ($currency == 'USD') ? '$' : 'đ';
        //Min price
        $this->addElement('Text', 'min_price', array(
            'label' => 'Min Price' . " ($currency)",
            'validators' => array(
                array(
                    'Int',
                    true
                ),
                new Engine_Validate_AtLeast(0),
            ),
        ));

        //Max price
        $this->addElement('Text', 'max_price', array(
            'label' => 'Max Price' . " ($currency)",
            'validators' => array(
                array(
                    'Int',
                    true
                ),
                new Engine_Validate_AtLeast(0),
            ),
        ));

        // Category Field.
        $categories = Engine_Api::_()->getDbtable('categories', 'socialplace')->getCategoriesAssoc();
        if (count($categories) >= 1) {
            $this->addElement('MultiCheckbox', 'category_id', array(
                'label' => 'Category',
                'multiOptions' => $categories,
            ));
        }


        //Order Field
        $translate = Zend_Registry::get("Zend_Translate");
        $this->addElement('Select', 'order', array(
            'label' => 'Browse By',
            'multiOptions' => array(
                //'nearest' => $translate -> translate("Nearest Location"),
                '' => '',
                'high_price' => $translate->translate("High Price"),
                'low_price' => $translate->translate("Low Price"),
                'most_view' => $translate->translate("Most Viewed"),
                'most_like' => $translate->translate("Most Liked"),
                'most_comment' => $translate->translate("Most Commented"),
                'most_rating' => $translate->translate("Most Rated"),
            ),

        ));
        /*
        $this->addElement('Checkbox', 'has_photo', array(
              'label' => 'Only Members With Photos',
              'decorators' => array(
                    'ViewHelper',
                    array('Label', array('placement' => 'APPEND', 'tag' => 'label')),
                    array('HtmlTag', array('tag' => 'div'))
                    ),
        ));
        */
        // Buttons
        $this->addElement('Button', 'Search', array(
            'label' => 'Search',
            'type' => 'submit',
        ));
    }
}