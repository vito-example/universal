<?php

$default_permissions = [

    'index'       => [
        'key' => '{module_name}_index',
        'label' => '{module_name} index'
    ],
    'create'       => [
        'key' => '{module_name}_create',
        'label' => '{module_name} create'
    ],
    'update'       => [
        'key' => '{module_name}_update',
        'label' => '{module_name} update'
    ],
    'delete'       => [
        'key' => '{module_name}_delete',
        'label' => '{module_name} delete'
    ]

];

return [
    'text'     => [
        'default'   => $default_permissions
    ],
    'user'     => [
        'default'   => $default_permissions
    ],
    'role'     => [
        'default'   => $default_permissions
    ],
    'activity'     => [
        'default'   => $default_permissions
    ],
    'direction'     => [
        'default'   => $default_permissions
    ],
    'lecturer'     => [
        'default'   => $default_permissions,
        'show' => [
            'key'   => 'show',
            'label' => 'show'
        ],
        'export' => [
            'key'   => 'export',
            'label' => 'export'
        ],
    ],
    'citizenship'     => [
        'default'   => $default_permissions
    ],
    'customer'     => [
        'default'   => $default_permissions,
        'export' => [
            'key'   => 'export',
            'label' => 'export'
        ],
        'update_status' => [
            'key'   => 'update_status',
            'label' => 'update_status'
        ],
        'show_profile'  => [
            'key'   => 'show_profile',
            'label' => 'show_profile'
        ],
        'login_as_customer' => [
            'key'   => 'login_as_customer',
            'label' => 'login_as_customer'
        ],
    ],
    'event'     => [
        'default'   => $default_permissions,
        'moderator' => [
            'key'   => 'event_moderator',
            'label' => 'event_moderator'
        ],
        'full_manage' => [
            'key'   => 'full_manage',
            'label' => 'full_manage'
        ],
        'status_update' => [
            'key'   => 'status_update',
            'label' => 'status_update'
        ],
        'show' => [
            'key'   => 'show',
            'label' => 'show'
        ],
        'calendar' => [
            'key'   => 'calendar',
            'label' => 'calendar'
        ],
        'show_questions' => [
            'key'   => 'show_questions',
            'label' => 'show_questions'
        ],
        'status_update_200' => [
            'key'   => 'status_update_200',
            'label' => 'Update Status Processing'
        ],
        'status_update_300' => [
            'key'   => 'status_update_300',
            'label' => 'Update Status Organized'
        ],
        'status_update_400' => [
            'key'   => 'status_update_400',
            'label' => 'Update Status Completed'
        ],
        'status_update_500' => [
            'key'   => 'status_update_500',
            'label' => 'Update Status Declined'
        ],
        'status_update_600' => [
            'key'   => 'status_update_600',
            'label' => 'Update Status Canceled'
        ]
    ],
    'event_session'     => [
        'default'   => $default_permissions,
        'show' => [
            'key'   => 'show',
            'label' => 'show'
        ],
        'delete_attendees' => [
            'key'   => 'delete_attendees',
            'label' => 'delete_attendees'
        ],
        'status_update' => [
            'key'   => 'status_update',
            'label' => 'status_update'
        ],
        'status_update_100' => [
            'key'   => 'status_update_100',
            'label' => 'Update Status Active'
        ],
        'status_update_200' => [
            'key'   => 'status_update_200',
            'label' => 'Update Status Completed'
        ],
    ],
    'event_session_attempt'     => [
        'default'   => $default_permissions,
        'show' => [
            'key'   => 'show',
            'label' => 'show'
        ],
    ],
    'session_request'     => [
        'default'   => $default_permissions,
        'show' => [
            'key'   => 'show',
            'label' => 'show'
        ],
        'status_update' => [
            'key'   => 'status_update',
            'label' => 'status_update'
        ],
        'status_update_100' => [
            'key'   => 'status_update_100',
            'label' => 'Update Status Active'
        ],
        'status_update_200' => [
            'key'   => 'status_update_200',
            'label' => 'Update Status Completed'
        ],
        'status_update_300' => [
            'key'   => 'status_update_300',
            'label' => 'Update Status Completed'
        ],
    ],
    'company_activity'     => [
        'default'   => $default_permissions
    ],
    'doctor_type'     => [
        'default'   => $default_permissions
    ],
    'blog'     => [
        'default'   => $default_permissions
    ],
    'company'     => [
        'default'   => $default_permissions,
        'show' => [
            'key'   => 'show',
            'label' => 'show'
        ],
    ],
    'company_employee'     => [
        'default'   => $default_permissions,
        'show' => [
            'key' => 'show',
            'label' => 'show',
        ],
        'export' => [
            'key'   => 'export',
            'label' => 'export'
        ],
    ],

    'reviews'     => [
        'default'   => $default_permissions
    ],
];
