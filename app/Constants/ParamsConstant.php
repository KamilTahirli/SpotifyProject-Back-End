<?php

namespace App\Constants;

class ParamsConstant
{
    /** @const */
    public const TREND_MUSICS = [
        "context" => [
            "client" => [
                "clientName" => "WEB",
                "clientVersion" => "2.20240313.05.00"
            ]
        ],
        "query" => "azeri 2024",
        "params" => "Eg-KAQwIARAAGAAgACgAMABqChADEAQQCRAFEAo%3D"
    ];


    /** @const */
    public const SEARCH_MUSIC = [
        "context" => [
            "client" => [
                "clientName" => "WEB",
                "clientVersion" => "2.20240313.05.00"
            ]
        ],
        "params" => "Eg-KAQwIARAAGAAgACgAMABqChADEAQQCRAFEAo%3D"
    ];

    /** @const */
    public const SEARCH_ARTIST_MUSICS = [
        "context" => [
            "client" => [
                "clientName" => "WEB",
                "clientVersion" => "2.20240313.05.00"
            ]
        ],
        "params" => "Eg-KAQwIARAAGAAgACgAMABqChADEAQQCRAFEAo%3D"
    ];


    /** @const */
    public const SEARCH_CATEGORY_MUSICS = [
        "context" => [
            "client" => [
                "clientName" => "WEB",
                "clientVersion" => "2.20240313.05.00"
            ]
        ],
        "params" => "Eg-KAQwIARAAGAAgACgAMABqChADEAQQCRAFEAo%3D"
    ];

    /** @const */
    public const MUSIC_DETAIL = [
        "context" => [
            "client" => [
                "clientName" => "WEB",
                "clientVersion" => "2.20240313.05.00"
            ]
        ],
    ];

    /** @const */
    public const MAX_RESULTS = [
        "TREND" => 10,
        "SEARCH" => 10,
        "SEARCH_NEXT" => 10,
        "ARTIST_MUSICS" => 10,
        "ARTIST_MUSICS_NEXT" => 10,
        "SIMILAR" => 10,
        "LIMITED_ARTISTS_LIST" => 5,
        "ALL_ARTISTS_LIST" => 6,
        "LIMITED_CATEGORIES_LIST" => 8,
        "ALL_CATEGORIES_LIST" => 10,
        "CATEGORY_MUSICS" => 10,
        "CATEGORY_MUSICS_NEXT" => 10
    ];
}