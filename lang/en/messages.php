<?php

return [
    'response' => [
        'error' => 'Internal Server Error',
        'errors' => [
            'get_converted_music_problem' => 'A problem occurred while converting the music',
            'get_music_download_url_problem' => 'A problem occurred while obtaining the music download URL',
            'get_music_real_name_problem' => 'A problem occurred while retrieving the real name of the music',
            'get_music_download_url_request_failed' => 'A problem occurred while sending a request for the music download URL',
            'file_not_found' => 'File not found',
            'all_api_key_limits_rejected' => 'All API key limits have been reached',
            'delete_expired_musics_failed' => 'An error occurred while deleting the expired music'
        ],
        'success' => [
            'get_trend_musics' => 'Trend musics list',
            'music_download_prepared' => '"Prepared for music download'
        ]
    ]
];