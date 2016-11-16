<?php
$lengthUnit = Engine_Api::_()->getApi('settings', 'core')->getSetting('socialplace.lengthunit', 'mile');
return array(
	array(
        'title' => 'Social Place Featured Regions',
        'description' => 'Displays featured Regions',
        'category' => 'Social Places',
        'type' => 'widget',
        'name' => 'socialplace.featured-region',
        'defaultParams' => array(
            'title' => 'Featured Regions',
        ),
    ),
	array(
        'title' => 'Social Place Browse Menu',
        'description' => 'Displays a menu in the browse page.',
        'category' => 'Social Places',
        'type' => 'widget',
        'name' => 'socialplace.browse-menu',
        'requirements' => array(
            'no-subject',
        ),
	),
	array(
        'title' => 'Social Place Search Form',
        'description' => 'Displays a search form to search place',
        'category' => 'Social Places',
        'type' => 'widget',
        'name' => 'socialplace.search-form',
        'requirements' => array(
        ),
	),
	array(
		'title' => 'Social Place Manage Search',
		'description' => 'Displays a search form in the Social Place manage page.',
		'category' => 'Social Places',
		'type' => 'widget',
		'name' => 'socialplace.manage-search',
		'requirements' => array(
				'no-subject',
		),
	),
	array(
        'title' => 'Social Place Profile Rating',
        'description' => 'Displays a place rating block',
        'category' => 'Social Places',
        'type' => 'widget',
        'name' => 'socialplace.profile-rating',
        'requirements' => array(
        ),
	),
	array(
        'title' => 'Social Place Profile Cover',
        'description' => 'Displays a place cover',
        'category' => 'Social Places',
        'type' => 'widget',
        'name' => 'socialplace.profile-cover',
        'requirements' => array(
        ),
	),
	array(
        'title' => 'Social Place Profile Info',
        'description' => 'Displays a place info',
        'category' => 'Social Places',
        'type' => 'widget',
        'name' => 'socialplace.profile-info',
        'defaultParams' => array(
	      'title' => 'Info',
	    ),
	),
	array(
        'title' => 'Social Place Profile Options',
        'description' => 'Displays a place options',
        'category' => 'Social Places',
        'type' => 'widget',
        'name' => 'socialplace.profile-options',
        'requirements' => array(
        ),
	),
	array(
	    'title' => 'Social Place Profile Photos',
	    'description' => 'Displays a place\'s photos on it\'s profile.',
	    'category' => 'Social Places',
	    'type' => 'widget',
	    'name' => 'socialplace.profile-photos',
	    'isPaginated' => true,
	    'defaultParams' => array(
	      'title' => 'Photos',
	      'titleCount' => true,
	    ),
	    'requirements' => array(
	      'subject' => 'place',
	    ),
  	),
	array(
        'title' => 'Social Place Browse Place',
        'description' => 'Displays list of place',
        'category' => 'Social Places',
        'type' => 'widget',
        'name' => 'socialplace.browse-place',
        'isPaginated' => true,
		'defaultParams' => array(
      		'title' => '',
    	),
        'adminForm' => array(
			'elements' => array(
				array(
					'Text',
					'title',
					array(
						'label' => 'Title'
					)
				),	
				array(
					'Heading',
					'mode_enabled',
					array(
						'label' => 'Which view modes are enabled?'
					)
				),
				array(
					'Radio',
					'mode_list',
					array(
						'label' => 'List view.',
						'multiOptions' => array(
							1 => 'Yes.',
							0 => 'No.',
						),
						'value' => 1,
					)
				),
				array(
					'Radio',
					'mode_map',
					array(
						'label' => 'Map view.',
						'multiOptions' => array(
							1 => 'Yes.',
							0 => 'No.',
						),
						'value' => 1,
					)
				),
				array(
					'Radio',
					'view_mode',
					array(
							'label' => 'Which view mode is default?',
							'multiOptions' => array(
								'list' => 'List view.',
								'map' => 'Map view.',
							),
							'value' => 'list',
					)
				),
				
			)
		)
	),
    array(
        'title' => 'Social Place Profile Nearest Places',
        'description' => 'Displays a list of most nearest location places.',
        'category' => 'Social Places',
        'type' => 'widget',
        'name' => 'socialplace.profile-nearest-location',
        'isPaginated' => false,
        'defaultParams' => array(
            'title' => 'Nearest Places',
        ),
        'requirements' => array(
            'subject' => 'place',
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'Text',
                    'title',
                    array(
                        'label' => 'Title',
                        'title' => 'Nearest Places',
                        'value' => 'Nearest Places'
                    )
                ),
                array(
                    'Text',
                    'radius',
                    array(
                        'label' => 'Radius',
                        'description' => "Within the radius of distance ($lengthUnit)",
                        'value' => 500,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0))
                        ),
                    )
                ),
                array(
                    'Text',
                    'max',
                    array(
                        'label' => 'Max Item Count',
                        'description' => 'Number of places in this widget.',
                        'value' => 5,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0))
                        ),
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'Social Place Most Liked Places',
        'description' => 'Displays a list of most liked places.',
        'category' => 'Social Places',
        'type' => 'widget',
        'name' => 'socialplace.most-liked-places',
        'isPaginated' => true,
        'defaultParams' => array(
            'title' => 'Most liked Places',
        ),
        'requirements' => array(
            'subject' => 'place',
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'Text',
                    'title',
                    array(
                        'label' => 'Title',
                        'title' => 'Most Liked Places',
                        'value' => 'Most Liked Places'
                    )
                ),
            )
        ),
    ),
    array(
        'title' => 'Social Place Most Rated Places',
        'description' => 'Displays a list of most rated places.',
        'category' => 'Social Places',
        'type' => 'widget',
        'name' => 'socialplace.most-rated-places',
        'isPaginated' => true,
        'defaultParams' => array(
            'title' => 'Most Rated Places',
        ),
        'requirements' => array(
            'subject' => 'place',
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'Text',
                    'title',
                    array(
                        'label' => 'Title',
                        'title' => 'Most Rated Places',
                        'value' => 'Most Rated Places'
                    )
                ),
            )
        ),
    ),
);