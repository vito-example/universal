<?php

return [

    'fake_data_seeder'  => env('FAKE_DATA_SEEDER',true),

    /**
     * Handcrafted member.
     */
    'handcrafted_by'        => 'Vito Makhatadze',

    'version'               => 'v.1',

    /**
     * Handcrafted member url.
     */
    'handcrafted_by_url'        => 'https://www.linkedin.com/in/vito-maxatadze-67b451197/',

    /**
     * Admin user avatar url.
     */
    'user_avatar'           => 'admin_resources/img/placeholders/avatars/avatar_tazo.jpg',

    /**
     * Project name.
     */
    'project_name'          => env('PROJECT_NAME', 'Vito Panel'),

    /**
     * Project avatar url.
     */
    'project_avatar'        => 'admin_resources/img/placeholders/avatars/avatar2.jpg',

    /**
     * Login background image url
     */
    'login_background_image'    => 'admin_resources/img/placeholders/headers/login_header.jpg',

    /**
     * Login page logo.
     */
    'login_logo'                => [
        [
            'src'       => '/img/persepro.png',
            'style'     => 'width: 100px'
        ]
    ],

    'login_web_modules'     => [],

    /**
     * Admin user
     */
    'admin_user_name'           => env('ADMIN_USER_EMAIL', 'tazo@github.ge'),
    'admin_user_password'       => env('ADMIN_USER_PASSWORD', ''),

    /**
     * Image upload config.
     */
    'image'         => [

        /**
         * Enable or disable upload resolutions.
         */
        'upload_resolutions'    => env('UPLOAD_IMAGE_RESOLUTIONS', false),

        /**
         * Resolution list.
         */
        'resolutions'   => [
            600,
            1200,
            1800
        ]

    ]


];
