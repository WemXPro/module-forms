<?php

return [

    'name' => 'Forms Module',
    'icon' => 'https://imgur.png',
    'author' => 'WemX',
    'version' => '1.0.0',
    'wemx_version' => '1.0.0',

    'elements' => [

        'admin_menu' => 
        [
            [
                'name' => 'Forms Module',
                'icon' => '<i class="fas fa-book"></i>',
                'type' => 'dropdown',
                'items' => [
                    [
                        'name' => 'Forms',
                        'href' => '/admin/forms/',
                    ],
                    [
                        'name' => 'Submissions',
                        'href' => '/admin/submissions',
                    ],
                ],
            ],
            // ... add more menu items
        ],

    ],

];
