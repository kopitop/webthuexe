<?php

return [
    'car' => [
        'status' => [
            'suspend' => 0,
            'available' => 1,
            'rented' => 2,
        ]
    ],
    'order' => [
        'status' => [
            'pending' => 0,
            'approved' => 1,
            'rejected' => 2,
        ]
    ],
    'regex' => [
        'idFromSlug' => '/(?(?<=.))(?<=-)\d+$|\d+$/',
        'danh-muc-slug' => '/^danh-muc\/.+$/',
        'xe-slug' => '/^xe.*$/',
    ],
];
