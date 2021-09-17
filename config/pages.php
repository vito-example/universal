<?php

return [

    'modules' => [

        'home' => [
            'slider' => [
                'activeLocaleKey' => 'en',
                'key' => 'slider',
                'label' => '',
                'status' => 1,
                'inputs' => [
                    [
                        'images' => [],
                        'label' => 'multi_fields',
                        'name' => 'fields',
                        'type' => 'multi_fields',
                        'is_translation' => false,
                        'is_required' => false,
                        'additional_fields' => [
                            [
                                'label' => 'title',
                                'name' => 'title',
                                'type' => 'text',
                                'is_translation' => true,
                                'is_required' => false,
                                'locale' => []
                            ],
                            ['label' => 'description',
                                'name' => 'description',
                                'type' => 'wysiwig',
                                'is_translation' => true,
                                'is_required' => false,
                                'locale' => []
                            ],
                            [
                                'label' => 'button_text',
                                'name' => 'button_text',
                                'type' => 'text',
                                'is_translation' => true,
                                'is_required' => false,
                                'locale' => []
                            ],
                            [
                                'label' => 'button_link',
                                'name' => 'button_link',
                                'type' => 'text',
                                'is_translation' => false,
                                'is_required' => false,
                                'locale' => []
                            ],
                            [
                                'label' => 'image',
                                'name' => 'image',
                                'type' => 'image',
                                'is_translation' => false,
                                'is_required' => false,
                                'file' => []
                            ],
                        ]
                    ]

                ]
            ],
            'companies' => [
                'activeLocaleKey' => 'en',
                'key' => 'companies',
                'label' => '',
                'status' => 1,
                'inputs' => [
                    [
                        'label' => 'title',
                        'name' => 'title',
                        'type' => 'text',
                        'is_translation' => true,
                        'is_required' => false,
                        'locale' => []
                    ],
                    [
                        'images' => [],
                        'label' => 'multi_fields',
                        'name' => 'fields',
                        'type' => 'multi_fields',
                        'is_translation' => false,
                        'is_required' => false,
                        'additional_fields' => [
                            [
                                'label' => 'action_url',
                                'name' => 'action_url',
                                'type' => 'text',
                                'is_translation' => false,
                                'is_required' => false,
                            ],
                            [
                                'label' => 'image',
                                'name' => 'image',
                                'type' => 'image',
                                'is_translation' => false,
                                'is_required' => false,
                                'file' => []
                            ],
                        ]
                    ]
                ]
            ],

            'trainings' => [
                'activeLocaleKey' => 'en',
                'key' => 'trainings',
                'label' => '',
                'status' => 1,
                'inputs' => []
            ],
            'online_trainings' => [
                'activeLocaleKey' => 'en',
                'key' => 'online_trainings',
                'label' => '',
                'status' => 1,
                'inputs' => []
            ],
            'news' => [
                'activeLocaleKey' => 'en',
                'key' => 'news',
                'label' => '',
                'status' => 1,
                'inputs' => [
                    [
                        'label' => 'title',
                        'name' => 'title',
                        'type' => 'text',
                        'is_translation' => true,
                        'is_required' => false,
                        'locale' => []
                    ],
                    [
                        'label' => 'description',
                        'name' => 'description',
                        'type' => 'wysiwig',
                        'is_translation' => true,
                        'is_required' => false,
                        'locale' => []
                    ],
                ]
            ],
            'about' => [
                'activeLocaleKey' => 'en',
                'key' => 'about',
                'label' => '',
                'status' => 1,
                'inputs' => [
                    [
                        'label' => 'title',
                        'name' => 'title',
                        'type' => 'text',
                        'is_translation' => true,
                        'is_required' => false,
                        'locale' => []
                    ],
                    [
                        'label' => 'description',
                        'name' => 'description',
                        'type' => 'wysiwig',
                        'is_translation' => true,
                        'is_required' => false,
                        'locale' => []
                    ],
                    [
                        'label' => 'banner_image',
                        'name' => 'banner_image',
                        'type' => 'image',
                        'is_translation' => false,
                        'is_required' => false,
                        'image' => []
                    ],
                ]
            ],
            'trainers' => [
                'activeLocaleKey' => 'en',
                'key' => 'trainers',
                'label' => '',
                'status' => 1,
                'inputs' => [
                    [
                        'label' => 'title',
                        'name' => 'title',
                        'type' => 'text',
                        'is_translation' => true,
                        'is_required' => false,
                        'locale' => []
                    ],
                    [
                        'label' => 'description',
                        'name' => 'description',
                        'type' => 'wysiwig',
                        'is_translation' => true,
                        'is_required' => false,
                        'locale' => []
                    ],
                ]
            ],
            'statistic' => [
                'activeLocaleKey' => 'en',
                'key' => 'statistic',
                'label' => '',
                'status' => 1,
                'inputs' => [
                    [
                        'label' => 'title',
                        'name' => 'title',
                        'type' => 'text',
                        'is_translation' => true,
                        'is_required' => false,
                        'locale' => []
                    ],
                    [
                        'label' => 'description',
                        'name' => 'description',
                        'type' => 'wysiwig',
                        'is_translation' => true,
                        'is_required' => false,
                        'locale' => []
                    ],
                    [
                        'images' => [],
                        'label' => 'multi_fields',
                        'name' => 'fields',
                        'type' => 'multi_fields',
                        'is_translation' => false,
                        'is_required' => false,
                        'additional_fields' => [
                            [
                                'label' => 'value',
                                'name' => 'value',
                                'type' => 'text',
                                'is_translation' => true,
                                'is_required' => false,
                            ],
                            [
                                'label' => 'key',
                                'name' => 'key',
                                'type' => 'text',
                                'is_translation' => true,
                                'is_required' => false,
                            ],
                        ]
                    ]
                ]
            ],

        ],
        'about' => [
            'background_image' => [
                'activeLocaleKey' => 'ka',
                'key' => 'background_image',
                'label' => '',
                'status' => 1,
                'attribute' => [
                    'container' => '',
                    'background_color' => ''
                ],
                'inputs' => [
                    [
                        'label' => 'header_image',
                        'name' => 'header_image',
                        'type' => 'image',
                        'is_translation' => false,
                        'is_required' => false,
                        'image' => []
                    ],
                ]
            ],
            'section_one' => [
                'activeLocaleKey' => 'en',
                'key' => 'section_one',
                'label' => '',
                'status' => 1,
                'inputs' => [
                    [
                        'label' => 'title',
                        'name' => 'title',
                        'type' => 'text',
                        'is_translation' => true,
                        'is_required' => false,
                        'locale' => []
                    ],
                    [
                        'label' => 'description',
                        'name' => 'description',
                        'type' => 'wysiwig',
                        'is_translation' => true,
                        'is_required' => false,
                        'locale' => []
                    ],
                    [
                        'images' => [],
                        'label' => 'multi_fields',
                        'name' => 'fields',
                        'type' => 'multi_fields',
                        'is_translation' => false,
                        'is_required' => false,
                        'additional_fields' => [
                            [
                                'label' => 'image',
                                'name' => 'image',
                                'type' => 'image',
                                'is_translation' => false,
                                'is_required' => false,
                                'file' => []
                            ],
                        ]
                    ]
                ]
            ],
            'section_two' => [
                'activeLocaleKey' => 'en',
                'key' => 'section_two',
                'label' => '',
                'status' => 1,
                'inputs' => [
                    [
                        'label' => 'title',
                        'name' => 'title',
                        'type' => 'text',
                        'is_translation' => true,
                        'is_required' => false,
                        'locale' => []
                    ],
                    [
                        'label' => 'description',
                        'name' => 'description',
                        'type' => 'wysiwig',
                        'is_translation' => true,
                        'is_required' => false,
                        'locale' => []
                    ],
                    [
                        'images' => [],
                        'label' => 'multi_fields',
                        'name' => 'fields',
                        'type' => 'multi_fields',
                        'is_translation' => false,
                        'is_required' => false,
                        'additional_fields' => [
                            [
                                'label' => 'image',
                                'name' => 'image',
                                'type' => 'image',
                                'is_translation' => false,
                                'is_required' => false,
                                'file' => []
                            ],
                        ]
                    ]
                ]
            ],
            'galleries' => [
                'activeLocaleKey' => 'en',
                'key' => 'galleries',
                'label' => '',
                'status' => 1,
                'inputs' => [
                    [
                        'label' => 'title',
                        'name' => 'title',
                        'type' => 'text',
                        'is_translation' => true,
                        'is_required' => false,
                        'locale' => []
                    ],
                    [
                        'images' => [],
                        'label' => 'multi_fields',
                        'name' => 'fields',
                        'type' => 'multi_fields',
                        'is_translation' => false,
                        'is_required' => false,
                        'additional_fields' => [
                            [
                                'label' => 'image',
                                'name' => 'image',
                                'type' => 'image',
                                'is_translation' => false,
                                'is_required' => false,
                                'file' => []
                            ],
                        ]
                    ]
                ]
            ],
        ],
        'beta-modal' => [
            'beta-modal' => [
                'activeLocaleKey' => 'ka',
                'key' => 'beta-modal',
                'label' => '',
                'status' => 1,
                'inputs' => [
                    [
                        'label' => 'description',
                        'name' => 'description',
                        'type' => 'wysiwig',
                        'is_translation' => true,
                        'is_required' => false
                    ]
                ]
            ],
        ],
        'contact' => [
            'contact' => [
                'activeLocaleKey' => 'ka',
                'key' => 'contact',
                'label' => '',
                'status' => 1,
                'inputs' => [
                    [
                        'label' => 'title',
                        'name' => 'title',
                        'type' => 'text',
                        'is_translation' => true,
                        'is_required' => false,
                        'locale' => []
                    ],
                    [
                        'label' => 'description',
                        'name' => 'description',
                        'type' => 'wysiwig',
                        'is_translation' => true,
                        'is_required' => false,
                        'locale' => []
                    ],
                    [
                        'label' => 'banner_image',
                        'name' => 'banner_image',
                        'type' => 'image',
                        'is_translation' => false,
                        'is_required' => false,
                        'image' => []
                    ],
                    [
                        'label' => 'address',
                        'name' => 'address',
                        'type' => 'text',
                        'is_translation' => true,
                        'is_required' => false
                    ],
                    [
                        'label' => 'phone',
                        'name' => 'phone',
                        'type' => 'text',
                        'is_translation' => false,
                        'is_required' => false
                    ],
                    [
                        'label' => 'email',
                        'name' => 'email',
                        'type' => 'text',
                        'is_translation' => false,
                        'is_required' => false
                    ],
                    [
                        'label' => 'map_iframe',
                        'name' => 'map_iframe',
                        'type' => 'text',
                        'is_translation' => false,
                        'is_required' => false
                    ],
                ]
            ],
        ],
        'social' => [
            'social' => [
                'activeLocaleKey' => 'ka',
                'key' => 'social',
                'label' => '',
                'status' => 1,
                'inputs' => [
                    [
                        'label' => 'facebook',
                        'name' => 'facebook',
                        'type' => 'text',
                        'is_translation' => false,
                        'is_required' => false
                    ],
                    [
                        'label' => 'twitter',
                        'name' => 'twitter',
                        'type' => 'text',
                        'is_translation' => false,
                        'is_required' => false
                    ],
                    [
                        'label' => 'youtube',
                        'name' => 'youtube',
                        'type' => 'text',
                        'is_translation' => false,
                        'is_required' => false
                    ],
                    [
                        'label' => 'linkedin',
                        'name' => 'linkedin',
                        'type' => 'text',
                        'is_translation' => false,
                        'is_required' => false
                    ],
                    [
                        'label' => 'instagram',
                        'name' => 'instagram',
                        'type' => 'text',
                        'is_translation' => false,
                        'is_required' => false
                    ],
                ]
            ],
        ],
        'seo' => [
            'default' => [
                'activeLocaleKey' => 'ka',
                'key' => 'default',
                'status' => 1,
                'label' => '',
                'inputs' => [
                    [
                        'label' => 'seo_title',
                        'name' => 'seo_title',
                        'type' => 'text',
                        'is_translation' => true,
                        'is_required' => false
                    ],
                    [
                        'label' => 'seo_description',
                        'name' => 'seo_description',
                        'type' => 'textarea',
                        'is_translation' => true,
                        'is_required' => false
                    ],
                    [
                        'label' => 'seo_og_title',
                        'name' => 'seo_og_title',
                        'type' => 'text',
                        'is_translation' => true,
                        'is_required' => false
                    ],
                    [
                        'label' => 'seo_og_description',
                        'name' => 'seo_og_description',
                        'type' => 'textarea',
                        'is_translation' => true,
                        'is_required' => false
                    ],
                    [
                        'label' => 'seo_keywords',
                        'name' => 'seo_keywords',
                        'type' => 'textarea',
                        'is_translation' => true,
                        'is_required' => false
                    ],
                    [
                        'label' => 'seo_og_image',
                        'name' => 'seo_og_image',
                        'type' => 'image',
                        'is_translation' => false,
                        'is_required' => false,
                        'image' => []
                    ],
                ]
            ],
            'analytic' => [
                'activeLocaleKey' => 'ka',
                'key' => 'analytic',
                'status' => 1,
                'label' => '',
                'inputs' => [
                    [
                        'label' => 'analytic_scripts',
                        'name' => 'analytic_scripts',
                        'type' => 'textarea',
                        'is_translation' => false,
                        'is_required' => false
                    ]
                ]
            ],
        ],
        'setting' => [
            'mailer' => [
                'activeLocaleKey' => 'ka',
                'key' => 'mailer',
                'label' => '',
                'status' => 1,
                'inputs' => [
                    [
                        'label' => 'email',
                        'name' => 'email',
                        'type' => 'text',
                        'is_translation' => false,
                        'is_required' => false,
                        'locale' => []
                    ],
                    [
                        'label' => 'subject',
                        'name' => 'subject',
                        'type' => 'text',
                        'is_translation' => false,
                        'is_required' => false,
                        'locale' => []
                    ],
                ]
            ],
        ],

    ]

];
