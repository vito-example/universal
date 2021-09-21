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
    'blog'     => [
        'default'   => $default_permissions
    ],
    'project'     => [
        'default'   => $default_permissions
    ],
    'service'     => [
        'default'   => $default_permissions
    ],
    'team'     => [
        'default'   => $default_permissions
    ],
];
