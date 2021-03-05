<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',
    'defaultImg' => [
        'max' => ['with' => 1500, 'height' => 1500], //for validate
        'size'=> [
            'original' => ['width' => 0, 'height' => 0],
            'small' => ['width' => 80, 'height' => 0],
            'medium' => ['width' => 250, 'height' => 0],
            'large' => ['width' => 800, 'height' => 0],
        ]
    ],
    'data' => [
        'user' => [
            'size'=> [
                'medium' => ['width' => 64, 'height' => 64],
                'small' => ['width' => 40, 'height' => 40],
                'large' => ['width' => 140, 'height' => 140],
            ]
        ],
        'news' => [
            'size'=> [
                'medium' => ['width' => 851, 'height' => 0],
                'small' => ['width' => 378, 'height' => 260],
                'large' => ['width' => 570, 'height' => 0],
            ]
        ],
        'page' => [
            'size'=> [
                'medium' => ['width' => 851, 'height' => 0],
                'small' => ['width' => 93, 'height' => 0],
                'large' => ['width' => 570, 'height' => 0],
            ]
        ],
        'stores' => [
            'dir' => 'stores',
            'size'=> [
                'original' => ['width' => 0, 'height' => 0],
                'small' => ['width' => 80, 'height' => 0],
                'dropzone' => ['width' => 120, 'height' => 0],
                'medium' => ['width' => 600, 'height' => 400],
                'large' => ['width' => 800, 'height' => 0],
            ]
        ],
        'product' => [
            'dir' => 'product',
            'size'=> [
                'original' => ['width' => 0, 'height' => 0],
                'small' => ['width' => 80, 'height' => 0],
                'dropzone' => ['width' => 120, 'height' => 0],
                'medium' => ['width' => 600, 'height' => 400],
                'large' => ['width' => 800, 'height' => 0],
            ]
        ],
        'activity' => [
            'dir' => 'activity',
            'size'=> [
                'original' => ['width' => 0, 'height' => 0],
                'small' => ['width' => 80, 'height' => 0],
                'medium' => ['width' => 450, 'height' => 0],
                'large' => ['width' => 800, 'height' => 0],
            ]
        ],
        'linen' => [
            'dir' => 'linen',
            'size'=> [
                'original' => ['width' => 0, 'height' => 0],
                'small' => ['width' => 80, 'height' => 0],
                'medium' => ['width' => 450, 'height' => 0],
                'large' => ['width' => 800, 'height' => 0],
            ]
        ],
        'page_intro' => [
            'size'=> [
                'tiny' => ['width' => 70, 'height' => 0],
                'small' => ['width' => 100, 'height' => 0],
                'medium' => ['width' => 250, 'height' => 0],
                'mediumx2' => ['width' => 350, 'height' => 0],
                'large' => ['width' => 630, 'height' => 0],
                'largex2' => ['width' => 800, 'height' => 0],

                'mediumx4' => ['width' => 470, 'height' => 0],
                'mediumx3' => ['width' => 950, 'height' => 0],
                'maxheight' => ['width' => 1400, 'height' => 0],
            ]
        ],
        'intro_detail' => [
            'size'=> [
                'tiny' => ['width' => 70, 'height' => 0],
                'small' => ['width' => 100, 'height' => 0],
                'medium' => ['width' => 250, 'height' => 0],
                'mediumx2' => ['width' => 350, 'height' => 0],
                'large' => ['width' => 630, 'height' => 0],
                'largex2' => ['width' => 800, 'height' => 0],

                'mediumx4' => ['width' => 470, 'height' => 0],
                'mediumx3' => ['width' => 950, 'height' => 0],
                'maxheight' => ['width' => 1400, 'height' => 0],
            ]
        ],
        'confighome' => [
            'dir' => 'confighome',
            'size'=> [
                'original' => ['width' => 0, 'height' => 0],
                'small' => ['width' => 80, 'height' => 0],
                'medium' => ['width' => 450, 'height' => 0],
                'large' => ['width' => 800, 'height' => 0],
            ]
        ],
        'feature' => [
            'dir' => 'feature',
            'max' => ['with' => 1500, 'height' => 1500], //for validate
            'size'=> [
                'original' => ['width' => 0, 'height' => 0],
                'small' => ['width' => 100, 'height' => 0],
                'slide' => ['width' => 600, 'height' => 400],
                'large' => ['width' => 1300, 'height' => 0],
                'largeMax' => ['width' => 1920, 'height' => 0],
            ]
        ],
        'company' => [
            'dir' => 'company',
            'max' => ['with' => 1500, 'height' => 1500], //for validate
            'size'=> [
                'original' => ['width' => 0, 'height' => 0],
                'small' => ['width' => 100, 'height' => 0],
                'slide' => ['width' => 600, 'height' => 400],
                'large' => ['width' => 1300, 'height' => 0],
            ]
        ],
        'config' => [
            'max' => ['with' => 845, 'height' => 845], //for validate
            'size'=> [
                'medium_seo' => ['width' => 250, 'height' => 0],
                'seo' => ['width' => 800, 'height' => 800],
                'medium' => ['width' => 450, 'height' => 0],
            ]
        ],
        'category' => [],
        'file' => [],
        'avatar' => [
            'max' => ['with' => 500, 'height' => 500], //for validate
            'size'=> [
                'small2' => ['width' => 40, 'height' => 0],
                'large' => ['width' => 200, 'height' => 0]
            ]
        ],
        'gallery' => [
            'dir' => 'gallery',
            'max' => ['with' => 1500, 'height' => 1500], //for validate
            'size'=> [
                'original' => ['width' => 0, 'height' => 0],
                'small' => ['width' => 150, 'height' => 0],
                'slide' => ['width' => 350, 'height' => 0],
                'large' => ['width' => 640, 'height' => 0],
            ]
        ]
    ]

];
