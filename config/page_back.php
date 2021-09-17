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
                        'label' => 'Images',
                        'name' => 'images',
                        'type' => 'multi_image',
                        'is_translation' => false,
                        'is_required' => false,
                        'additional_fields' => [
                            [
                                'label' => 'title',
                                'name' => 'title',
                                'type' => 'wysiwig',
                                'is_translation' => true,
                                'is_required' => false,
                                'locales' => []
                            ],
                        ]
                    ]
                ]
            ],
            'blocks' => [
                'activeLocaleKey' => 'en',
                'key' => 'blocks',
                'label' => '',
                'status' => 1,
                'inputs' => [
                    [
                        'images' => [],
                        'label' => 'Images',
                        'name' => 'images',
                        'type' => 'multi_image',
                        'is_translation' => false,
                        'is_required' => false,
                        'additional_fields' => [
                            [
                                'label' => 'sub_title',
                                'name' => 'sub_title',
                                'type' => 'wysiwig',
                                'is_translation' => true,
                                'is_required' => false,
                                'locales' => []
                            ],
                            [
                                'label' => 'action_url',
                                'name' => 'action_url',
                                'type' => 'text',
                                'is_translation' => false,
                                'is_required' => false,
                            ]
                        ]
                    ]
                ]
            ],
            'icon_blocks' => [
                'activeLocaleKey' => 'en',
                'key' => 'icon_blocks',
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
                                'label' => 'icon',
                                'name' => 'icon',
                                'type' => 'text',
                                'is_translation' => false,
                                'is_required' => false
                            ],
                            [
                                'label' => 'title',
                                'name' => 'title',
                                'type' => 'text',
                                'is_translation' => true,
                                'is_required' => false,
                                'locales' => []
                            ],
                            [
                                'label' => 'sub_title',
                                'name' => 'sub_title',
                                'type' => 'wysiwig',
                                'is_translation' => true,
                                'is_required' => false,
                                'locales' => []
                            ],
                            [
                                'label' => 'action_url',
                                'name' => 'action_url',
                                'type' => 'text',
                                'is_translation' => false,
                                'is_required' => false,
                            ]
                        ]
                    ]
                ]
            ],
        ],
        'privacy' => [
            'policy' => [
                'activeLocaleKey' => 'ka',
                'key' => 'privacy',
                'label' => '',
                'status' => 1,
                'attribute' => [
                    'container' => '',
                    'background_color' => ''
                ],
                'inputs' => [
                    [
                        'label' => 'description',
                        'name' => 'description',
                        'type' => 'wysiwig',
                        'is_translation' => true,
                        'is_required' => false
                    ],
                    [
                        'label' => 'header_title',
                        'name' => 'header_title',
                        'type' => 'wysiwig',
                        'is_translation' => true,
                        'is_required' => false
                    ],
                    [
                        'label' => 'header_image',
                        'name' => 'header_image',
                        'type' => 'image',
                        'is_translation' => false,
                        'is_required' => false,
                        'image' => []
                    ],
                ]
            ]
        ],
        'terms' => [
            'terms' => [
                'activeLocaleKey' => 'ka',
                'key' => 'terms',
                'label' => '',
                'status' => 1,
                'attribute' => [
                    'container' => '',
                    'background_color' => ''
                ],
                'inputs' => [
                    [
                        'label' => 'description',
                        'name' => 'description',
                        'type' => 'wysiwig',
                        'is_translation' => true,
                        'is_required' => false
                    ],
                    [
                        'label' => 'header_title',
                        'name' => 'header_title',
                        'type' => 'wysiwig',
                        'is_translation' => true,
                        'is_required' => false
                    ],
                    [
                        'label' => 'header_image',
                        'name' => 'header_image',
                        'type' => 'image',
                        'is_translation' => false,
                        'is_required' => false,
                        'image' => []
                    ],
                ]
            ]
        ],
        'faq' => [
            'faq' => [
                'activeLocaleKey' => 'ka',
                'key' => 'faq',
                'label' => '',
                'status' => 1,
                'attribute' => [
                    'container' => '',
                    'background_color' => ''
                ],
                'inputs' => [
                    [
                        'label' => 'description',
                        'name' => 'description',
                        'type' => 'wysiwig',
                        'is_translation' => true,
                        'is_required' => false
                    ],
                    [
                        'label' => 'header_title',
                        'name' => 'header_title',
                        'type' => 'wysiwig',
                        'is_translation' => true,
                        'is_required' => false
                    ],
                    [
                        'label' => 'header_image',
                        'name' => 'header_image',
                        'type' => 'image',
                        'is_translation' => false,
                        'is_required' => false,
                        'image' => []
                    ],
                ]
            ]
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
                        'label' => 'title',
                        'name' => 'title',
                        'type' => 'text',
                        'is_translation' => true,
                        'is_required' => false
                    ],
                    [
                        'label' => 'sub_title',
                        'name' => 'sub_title',
                        'type' => 'text',
                        'is_translation' => true,
                        'is_required' => false
                    ],
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
            'block' => [
                'activeLocaleKey' => 'en',
                'key' => 'block',
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
                        'label' => 'sub_title',
                        'name' => 'sub_title',
                        'type' => 'wysiwig',
                        'is_translation' => true,
                        'is_required' => false,
                        'locale' => []
                    ],
                    [
                        'label' => 'action_button_title',
                        'name' => 'action_button_title',
                        'type' => 'text',
                        'is_translation' => true,
                        'is_required' => false,
                        'locale' => []
                    ],
                    [
                        'label' => 'action_button_url',
                        'name' => 'action_button_url',
                        'type' => 'text',
                        'is_translation' => false,
                        'is_required' => false
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
                                'label' => 'icon',
                                'name' => 'icon',
                                'type' => 'text',
                                'is_translation' => false,
                                'is_required' => false
                            ],
                            [
                                'label' => 'title',
                                'name' => 'title',
                                'type' => 'text',
                                'is_translation' => true,
                                'is_required' => false,
                                'locales' => []
                            ],
                            [
                                'label' => 'sub_title',
                                'name' => 'sub_title',
                                'type' => 'wysiwig',
                                'is_translation' => true,
                                'is_required' => false,
                                'locales' => []
                            ],
                            [
                                'label' => 'action_url',
                                'name' => 'action_url',
                                'type' => 'text',
                                'is_translation' => false,
                                'is_required' => false,
                            ]
                        ]
                    ]
                ]
            ],
            'text' => [
                'activeLocaleKey' => 'en',
                'key' => 'text',
                'label' => '',
                'status' => 1,
                'inputs' => [
                    [
                        'label' => 'content',
                        'name' => 'content',
                        'type' => 'wysiwig',
                        'is_translation' => true,
                        'is_required' => false,
                        'locale' => []
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
                        'label' => 'address',
                        'name' => 'address',
                        'type' => 'text',
                        'is_translation' => true,
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

    ]

];
