<?php

return [
    'parent'=> 'danh_muc_cha_id',
    'primary_key' => 'id',
    'generate_url'   => true,
    'childNode' => 'child',
    'body' => [
        'id',
        'ten',
        'ten_url',
    ],
    'html' => [
        'label' => 'ten_hien_thi',
        'href'  => 'id'
    ],
    'dropdown' => [
        'prefix' => '',
        'label' => 'ten_hien_thi',
        'value' => 'id'
    ]
];
