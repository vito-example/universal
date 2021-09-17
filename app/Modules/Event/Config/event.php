<?php

use App\Models\User;
use App\Modules\Company\Models\Company;
use App\Modules\Event\Http\Resources\EventConnections\CompanyEventConnectionResource;
use App\Modules\Event\Http\Resources\EventConnections\UserEventConnectionResource;

return [

    /**
     * Currencies
     */
    'currencies' => [
        [
            'value' => 'gel',
            'label' => 'Georgian Lari'
        ]
    ],

    'connections' => [
        'users' => [
            'entity' => User::class,
            'resource' => UserEventConnectionResource::class
        ],
        'companies' => [
            'entity' => Company::class,
            'resource' => CompanyEventConnectionResource::class
        ]
    ],

    /**
     * Files attributes.
     */
    'files_attributes' => [
        [
            'enable' => true,
            'label' => 'name',
            'name' => 'name',
            'type' => 'text',
            'is_translation' => false,
            'is_required' => false
        ],
        [
            'enable' => true,
            'label' => 'file',
            'name' => 'file',
            'type' => 'file',
            'is_translation' => false,
            'is_required' => false,
            'file' => []
        ]
    ],

    /**
     * Banners attributes
     */
    'banners_attributes' => [
        [
            'enable' => true,
            'label' => 'image',
            'name' => 'image',
            'type' => 'image',
            'is_translation' => false,
            'is_required' => false,
            'file' => []
        ],
    ],
    'humans_attributes' => [
        'lecturers' => [
            [
                'enable' => true,
                'is_dynamic' => true,
                'label' => 'entity_type',
                'name' => 'entity_type',
                'type' => 'select',
                'is_translation' => false,
                'is_required' => false,
                'value' => 'lecturers',
                'options' => [
                    [
                        'value' => 'lecturers',
                        'label' => 'ლექტორები'
                    ],
                ]
            ],
            [
                'enable' => true,
                'label' => 'lecturers',
                'name' => 'lecturers',
                'type' => 'select',
                'is_translation' => false,
                'is_required' => false,
                'options' => []
            ],
        ],
    ],
    /**
     * Banners attributes
     */
    'sessions_attributes' => [
        'sessions' => [
            [
                'enable' => true,
                'label' => 'max_person',
                'name' => 'max_person',
                'type' => 'number',
                'is_translation' => false,
                'min' => 1,
                'value' => 1,
                'placeholder' => 'enter_max_persons',
                'is_required' => false
            ],
            [
                'enable' => true,
                'label' => 'start_date',
                'name' => 'start_date',
                'type' => 'datetime',
                'is_translation' => false,
                'is_required' => true,
                'placeholder' => 'enter_start_date'
            ],
            [
                'enable' => true,
                'label' => 'end_date',
                'name' => 'end_date',
                'type' => 'datetime',
                'is_translation' => false,
                'is_required' => true,
                'placeholder' => 'enter_end_date'
            ],
            [
                'enable' => true,
                'is_dynamic' => true,
                'label' => 'timezone',
                'name' => 'timezone',
                'type' => 'select',
                'is_translation' => false,
                'is_required' => true,
                'value' => 'Asia/Tbilisi',
                'session_id' => null,
                'options' => array_map(fn($item) => (new \App\Modules\Event\Http\Resources\Timezone\TimezoneItemResource($item))->toArray(),DateTimeZone::listIdentifiers(DateTimeZone::ALL))
            ],
            [
                'enable' => true,
                'is_dynamic' => false,
                'label' => 'status',
                'name' => 'status',
                'type' => 'select_session',
                'is_translation' => false,
                'is_required' => false,
                'value' => 100,
                'options' => [
                    [
                        'value' => 100,
                        'label' => 'status_active'
                    ],
                    [
                        'value' => 200,
                        'label' => 'status_completed'
                    ],
                ]
            ],
            [
                'enable' => true,
                'is_dynamic' => false,
                'label' => 'session_type',
                'name' => 'type',
                'type' => 'select_session_type',
                'is_translation' => false,
                'is_required' => false,
                'value' => 100,
                'user_list' => [],
                'user_list_options' => [],
                'options' => collect((new \App\Modules\Event\Http\Resources\Session\EventSessionTypeOptions())->toArray()),
            ],
            [
                'enable' => true,
                'label' => 'price',
                'name' => 'price',
                'type' => 'number',
                'is_translation' => false,
                'min' => 1,
                'value' => null,
                'placeholder' => 'price',
                'is_required' => false
            ],
            [
                'enable' => true,
                'label' => 'link',
                'name' => 'link',
                'type' => 'text',
                'is_translation' => false,
                'min' => 1,
                'value' => null,
                'placeholder' => 'link',
                'is_required' => false
            ],
        ]

    ],
];
