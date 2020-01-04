<?php

return [
    [
        'name' => 'home',
        'route'=> 'admin.home',
        'glyphicon' => 'fa fa-home fa-fw',
        'hide' => false
    ],
    [
        'name' => 'news.label',
        'glyphicon' => 'fa fa-newspaper-o',
        'permissions'   => ['news.read', 'news_categories.read'],
        'child'=> [
            [
                'name' => 'list',
                'route'=> 'admin.news.index',
                'glyphicon' => 'glyphicon glyphicon-th-list fa-fw',
                'permissions'   => ['news.read'],
                'hide' => false
            ],
            [
                'name' => 'news.category',
                'route'=> 'admin.news-categories.index',
                'permissions'   => ['news_categories.read'],
                'glyphicon' => 'fa fa-sitemap fa-fw',
                'hide' => false
            ],
        ]
    ],
    [
        'name' => 'utility.slider',
        'route'=> 'admin.sliders.index',
        'glyphicon' => 'fa fa-sliders fa-fw',
        'role'   => 'system',
        'hide' => false
    ],
    [
        'name' => 'feedback',
        'route'=> 'admin.feedbacks.index',
        'glyphicon' => 'fa fa-exchange fa-fw',
        'hide' => false,
        'permissions'   => ['feedbacks.read'],
    ],
    [
        'name' => 'experience',
        'route'=> 'admin.experiences.index',
        'glyphicon' => 'fa fa-rss fa-fw',
        'hide' => false,
        'permissions'   => ['experiences.read'],
    ],
    [
        'name' => 'users.label',
        'glyphicon' => 'fa fa-users',
        'permissions'   => ['roles.read', 'users.read'],
        'hide' => false,
        'child'=> [
            [
                'name' => 'users.role',
                'route'=> 'admin.roles.index',
                'permissions'   => ['roles.read'],
                'glyphicon' => 'fa fa-university',
                'hide' => false
            ],
            [
                'name' => 'users.admin',
                'route'=> 'admin.users.index',
                'permissions'   => ['users.read'],
                'glyphicon' => 'glyphicon glyphicon-th-list fa-fw',
                'hide' => false
            ],
        ]
    ],
    [
        'name' => 'news.static_page',
        'route'=> 'admin.static-pages.index',
        'role'   => 'system',
        'glyphicon' => 'fa fa-leanpub fa-fw',
        'hide' => false
    ],
    [
        'name' => 'settings.label',
        'glyphicon' => 'fa fa-cog fa-fw',
        'role'   => 'system',
        'hide' => false,
        'child'=> [
            [
                'name' => 'settings.caches.flushall',
                'route'=> 'admin.caches.flushall',
                'role'   => 'system',
                'glyphicon' => 'fa fa-spinner fa-fw',
                'hide' => false
            ],
        ]
    ],
];
