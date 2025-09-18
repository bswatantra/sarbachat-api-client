<?php

declare(strict_types=1);

return [
    'scopes' => [
        'facebook' => [
            'email',
            'public_profile',
            // 'user_posts',
            'pages_show_list',
            // 'pages_read_engagement',
            // 'pages_manage_metadata',
            // 'pages_messaging',
            // 'pages_messaging_subscriptions',
            // 'business_management',
            // 'pages_manage_engagement',
            'pages_manage_posts',
            // 'pages_read_user_content'
        ],
        'instagram' => [
            'instagram_basic',
            // 'instagram_manage_messages',
            // 'pages_show_list',
            // 'pages_read_engagement',
            // 'pages_manage_metadata',
            // 'pages_messaging',
            // 'pages_messaging_subscriptions',
            // 'email',
            // 'business_management',
            // 'instagram_content_publish',
            // 'instagram_manage_comments'
        ],
    ],
];
