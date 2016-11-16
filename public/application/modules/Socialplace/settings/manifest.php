<?php return array(
    'package' =>
        array(
            'type' => 'module',
            'name' => 'socialplace',
            'version' => '4.0.1',
            'path' => 'application/modules/Socialplace',
            'title' => 'Social Places',
            'description' => 'Social Places',
            'author' => 'Tracy Dev',
            'callback' => array(
                'path' => 'application/modules/Socialplace/settings/install.php',
                'class' => 'Socialplace_Installer',
            ),
            'actions' =>
                array(
                    0 => 'install',
                    1 => 'upgrade',
                    2 => 'refresh',
                    3 => 'enable',
                    4 => 'disable',
                ),
            'directories' =>
                array(
                    0 => 'application/modules/Socialplace',
                ),
            'files' =>
                array(
                    0 => 'application/languages/en/socialplace.csv',
                ),
        ),
    'items' =>
        array(
            0 => 'place',
            1 => 'socialplace_place',
            2 => 'socialplace_category',
            3 => 'socialplace_album',
            4 => 'socialplace_photo',
            5 => 'socialplace_rating',
            6 => 'socialplace_region',
        ),
    'routes' =>
        array(
            'socialplace_extended' =>
                array(
                    'route' => 'places/:controller/:action/*',
                    'defaults' =>
                        array(
                            'module' => 'socialplace',
                            'controller' => 'index',
                            'action' => 'index',
                        ),
                    'reqs' =>
                        array(
                            'controller' => '\\D+',
                            'action' => '\\D+',
                        ),
                ),
            'socialplace_general' =>
                array(
                    'route' => 'places/:action/*',
                    'defaults' =>
                        array(
                            'module' => 'socialplace',
                            'controller' => 'index',
                            'action' => 'browse',
                        ),
                    'reqs' =>
                        array(
                            'action' => '(index|browse|create|get-my-location|display-map-view|manage|listing)',
                        ),
                ),
            'socialplace_specific' =>
                array(
                    'route' => 'places/:action/:place_id/*',
                    'defaults' =>
                        array(
                            'module' => 'socialplace',
                            'controller' => 'place',
                            'action' => 'index',
                        ),
                    'reqs' =>
                        array(
                            'action' => '(edit|delete|direction)',
                            'place_id' => '\\d+',
                        ),
                ),
            'socialplace_place_view' => array(
                'route' => 'places/view/:place_id/:slug',
                'defaults' => array(
                    'module' => 'socialplace',
                    'controller' => 'place',
                    'action' => 'view',
                    'slug' => '',
                ),
                'reqs' => array(
                    'place_id' => '\d+'
                ),
            ),
            'socialplace_photo' => array(
                'route' => 'place/:action',
                'defaults' => array(
                    'module' => 'socialplace',
                    'controller' => 'index',
                    'action' => 'upload-photo',
                ),
                'reqs' => array(
                    'controller' => '\D+',
                    'action' => '\D+',
                )
            ),
        )
); ?>