<?php

return [
    'general' => [
        'options' => [
            'server_name' => 'Silkroad Online',
            'server_desc' => "Silkroad Online is a World's first blockbuster Free to play MMORPG. Silkroad Olnine puts players deep into ancient Chinese, Islamic, and European civilization. Enjoy Silkroad's hardcore PvP, personal dungeon system, never ending fortress war and be the top of the highest heroes!",
            'server_url' => 'https://isro-portal/',
            'favicon' => 'images/favicon.ico',
            'logo' => 'images/logo.png',
            'timezone' => 'Africa/Cairo',
            'theme' => 'default',
            'theme_color_mode' => 'dark', //switch, light, dark
            'max_level' => 140,
            'free_silk' => 0,
            'free_premium_silk' => 0,
            'debug' => true,
            'register_disable' => false,
            'register_confirmation' => false,
        ],
        'connection' => [
            'host' => '192.168.1.101',
            'port' => '1433',
            'user' => 'sa',
            'password' => '123456',
            'db_website' => 'SRO_Portal',
            'db_portal' => 'GB_JoymaxPortal',
            'db_account' => 'SILKROAD_R_ACCOUNT',
            'db_shard' => 'SILKROAD_R_SHARD',
            'db_log' => 'SILKROAD_R_SHARD_LOG',
        ],
        'smtp' => [
            'enable' => true,
            'host' => 'smtp.mailtrap.io',
            'port' => 2525,
            'username' => '',
            'password' => '',
            'encryption' => 'tls',
        ],
        'captcha' => [
            'enable' => false,
            'sitekey' => '',
            'secret' => '',
        ],
        'cache' => [
            'enable' => true,
            'data' => [
                'news' => 86400, //1 day
                'download' => 604800, //1 week
                'pages' => 3600,
                'account' => 3600,
                'online_counter' => 0, //no cache
                'event_schedule' => 3600,
                'fortress_war' => 3600,
                'unique_history' => 3600,
                'globals_history' => 3600,
                'ranking_player' => 3600,
                'ranking_guild' => 3600,
                'ranking_unique' => 3600,
                'ranking_unique_monthly' => 3600,
                'ranking_job' => 3600,
                'ranking_honor' => 3600,
                'ranking_fortress-player' => 3600,
                'ranking_fortress-guild' => 3600,
            ]
        ],
        'sliders' => [
            0 => [
                'title' => 'Example headline',
                'title_color' => '#fff',
                'desc' => 'Some representative placeholder content for the first slide of the carousel.',
                'desc_color' => '#fff',
                'image' => 'https://wallpapercave.com/wp/wp7441040.jpg',
                'btn-label' => 'Sign Up',
                'btn-url' => '#',
            ],
            1 => [
                'title' => 'Example headline',
                'title_color' => '#fff',
                'desc' => 'Some representative placeholder content for the first slide of the carousel.',
                'desc_color' => '#fff',
                'image' => 'https://wallpapercave.com/wp/wp7441040.jpg',
                'btn-label' => 'Play Now',
                'btn-url' => '#',
            ],
            2 => [
                'title' => 'Example headline',
                'title_color' => '#fff',
                'desc' => 'Some representative placeholder content for the first slide of the carousel.',
                'desc_color' => '#fff',
                'image' => 'https://wallpapercave.com/wp/wp7441040.jpg',
                'btn-label' => 'Download Now',
                'btn-url' => '#',
            ],
        ],
        'hero' => [
            'hero_background' => 'https://wallpapercave.com/wp/wp7441040.jpg',
            'hero_label_color' => '#fff',
        ],
        'news-category' => [
            'news' => '<span class="badge text-bg-warning">News</span>',
            'update' => '<span class="badge text-bg-primary">Update</span>',
            'event' => '<span class="badge text-bg-success">Event</span>',
        ],
        'footer' => [
            'general' => [
                1 => [
                    'name' => 'Home',
                    'url' => '#',
                    'image' => '',
                ],
                2 => [
                    'name' => 'Privacy Policy',
                    'url' => '#',
                    'image' => '',
                ],
                3 => [
                    'name' => 'Terms & Conditions',
                    'url' => '#',
                    'image' => '',
                ],
            ],
            'social' => [
                1 => [
                    'name' => 'Facebook',
                    'url' => 'https://www.facebook.com/',
                    'image' => '',
                ],
                2 => [
                    'name' => 'Discord',
                    'url' => 'https://discord.com/',
                    'image' => '',
                ],
                3 => [
                    'name' => 'Youtube',
                    'url' => 'https://www.youtube.com/',
                    'image' => '',
                ],
            ],
            'backlink' => [
                1 => [
                    'name' => 'Elitepvpers',
                    'url' => 'https://www.elitepvpers.com/forum/sro-pserver-advertising/',
                    'image' => '',
                ],
                2 => [
                    'name' => 'SIlkroad4arab',
                    'url' => 'https://www.silkroad4arab.com/vb/forumdisplay.php?f=85',
                    'image' => '',
                ],
                3 => [
                    'name' => 'SroCave',
                    'url' => 'https://srocave.com/forum/sro-private-server-advertising.34/',
                    'image' => '',
                ],
            ],
        ],
    ],
    'widgets' => [
        'globals_history' => [
            'enable' => true,
            'limit' => 5,
        ],
        'unique_history' => [
            'enable' => true,
            'limit' => 5,
        ],
        'top_player' => [
            'enable' => true,
            'limit' => 5,
        ],
        'top_guild' => [
            'enable' => true,
            'limit' => 5,
        ],
        'discord' => [
            'enable' => true,
            'server_id' => '1004443821570019338',
        ],
        'online_counter' => [
            'enable' => true,
            'max_player' => 1000,
            'fake_player' => 250,
        ],
        'server_info' => [
            'enable' => true,
            'data' => [
                1 => [
                    //To changing icon https://fontawesome.com/icons
                    'icon' => '<i class="fas fa-fw fa-check"></i>',
                    'name' => 'Cap',
                    'value' => '140'
                ],
                2 => [
                    'icon' => '<i class="fa fa-fw fa-flask"></i>',
                    'name' => 'EXP & SP',
                    'value' => '1x'
                ],
                3 => [
                    'icon' => '<i class="fa fa-fw fa-users"></i>',
                    'name' => 'Party EXP',
                    'value' => '1x'
                ],
                4 => [
                    'icon' => '<i class="fa fa-fw fa-coins"></i>',
                    'name' => 'Gold',
                    'value' => '1x'
                ],
                5 => [
                    'icon' => '<i class="fa fa-fw fa-coins"></i>',
                    'name' => 'Drop',
                    'value' => '1x'
                ],
                6 => [
                    'icon' => '<i class="fa fa-fw fa-star"></i>',
                    'name' => 'Trade goods',
                    'value' => '1x'
                ],
                7 => [
                    'icon' => '<i class="fa fa-fw fa-exclamation"></i>',
                    'name' => 'HWID Limit',
                    'value' => '1'
                ],
                8 => [
                    'icon' => '<i class="fa fa-fw fa-exclamation"></i>',
                    'name' => 'IP Limit',
                    'value' => '1'
                ],
            ],
        ],
        'event_schedule' => [
            'enable' => true,
            'data' => [
                'roc' => 'Roc',
                'medusa' => 'Medusa',
                'special' => 'Special Trade',
                'fortress' => 'Fortress War',
                'selkis_neith' => 'Selket & Neith',
                'anubis_isis' => 'Anubis & Isis',
                'haroeris_seth' => 'Haroeris & Seth',
                'ctf' => 'Capture The Flag (CTF)',
                'ba_random' => 'Battle Arena (Random)',
                'ba_party' => 'Battle Arena (Party)',
                'ba_guild' => 'Battle Arena (Guild)',
                'ba_job' => 'Battle Arena (Job)',
                'survival_solo' => 'Survival (Solo)',
                'survival_party' => 'Survival (Party)',
            ],
        ],
        'fortress_war' => [
            'enable' => true,
            'data' => [
                1 => [
                    'name' => 'Jangan',
                    'icon' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAgY0hSTQAAeiYAAICEAAD6AAAAgOgAAHUwAADqYAAAOpgAABdwnLpRPAAAABl0RVh0U29mdHdhcmUAUGFpbnQuTkVUIHYzLjUuODc7gF0AAAK8SURBVDhPpZNtTI1hGMdtz6PTMeoc5mTO6qyWlzTh8MGQZKZMNi9nEpUhSyWzZhPVvEyjWZSNo5dRFArpzVkfzixhxxbJZmF9YbMUkc1m0vRzPY9SjW/u7b/75br///t/39d1jxs3qimKYtam0vMvDMX0Pf9sGklV1T76PTDQCggGPbx7UULXq1KJKX3anjFkWTAOn8pA2w9+PKLzw0Uhe6hIXkZ9ehSfv7ppe3ach80ZXHcmdg2LSG/Q7BoF3+h/2t/xskg2rKPa5i0Cr6mT01yC3sE67ltMuPMdtLdnkZm6uFs43/840RShg5sNcTrpjTbvbgKv8fTK+NuDAu5Jf11QVZbA2bzV+hvpAjp5sJ2WTif3J02Cr81gNMobuMBs4oNqpaf1qC5wtzwFp9mP2sIYYjf7/xbRBX4+oXjhVDwrZ4uTL4JGgRtMZnq9Iqi5k8Stq0lcPBeL0zqNY4ts7Nwxc0Tg00c3xSEqbYqBAR8L+PgIAsB3AY8NMTQqNq5IbKtipECZyI0gP+ITg0YEnrcWcXqukbeKmXav6bQZrDwzhNJoXEq9ahGyPynKBPIUH1yqL/mRVuISAkcEWh8UymIwh5fP4JZzPY8a9lN3bROl4qREmUxVcRRXjodTeWYVp2x+3IgNZlu8bUTAdTubFlcGJxUvqjIjSVdUijPtpInlJNWbkoN2suQKNTmR8ogmTqaHsHPLkIPhTFx27qYyYxEVQtJSeSlrKWWKhYrxflzLjaRW1qrlGjdPzCchPnhMGvVCyj20trcgP4qaIxE0zQygLHcJHrmzRzFRkb8C96wALmSGcSJtHo7o6e81jl7Fo0t53y57z/7U+RTkhFNywE5lcijlyXM4n21n754wEuOCiI6Y0jOqlPVvMKYiJdiXEhfMdkcgDsn1hvggEjdaiV1j0Wz//Zn+9zv/AmCerVg+UIPjAAAAAElFTkSuQmCC',
                ],
                3 => [
                    'name' => 'Hotan',
                    'icon' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAgY0hSTQAAeiYAAICEAAD6AAAAgOgAAHUwAADqYAAAOpgAABdwnLpRPAAAABl0RVh0U29mdHdhcmUAUGFpbnQuTkVUIHYzLjUuODc7gF0AAAI5SURBVDhPpVNfSFNhFL+3OzDpQeqh8E3ywUIwRkIFIgOL8CEKqcAHwagVlRWzf1CxQHLM7E2WFAvFahFLsweLle5ls2YY1WhdTCG9i6Zmjaa7aDJ+3XPave4y37pw7vfnnN/v+53vnE8Qcj5JktbTUhuxmmV9HLPqRyCLxZJcVmeQnn6NdNyL2bEnmPvcgnfPL2s+KUkxJrC2UaifupSawvzMB8QjdpRsEqGMXOKRTH7ZhMlQAwa6T7K6LKaA5BZqpv5Rf+DXmBtyqJMBB21FeN9fZ8xp/SnoRuhRLTzOGiJZNJQQY/pnjIOX0wkTCQHJ5NBtDHQe4hgajVRospRSoLw5xs5d5WuxMPcFUx+f4Zv8CpPhw4j0XWBQ8QYBuyvX4YVnD7zXbf9I6JdKRBhMTjptenwIo30HIIaHIN5sZfDwfZtBQHH+tsoVgvn4PSRiHsxO9GtEaxALtjE4k8lAgAqxod5Q4HdXoNtZhoetO/IVkIrSYglKtBei4wyDC3q8EKurWDaloNtjV8UKwe+vHaYUiIBki3VaGrZqrXw1hgK6I0rBl6tgId5l3DDdwffxYciBvbw34t+HaMCBsK+WTyeCO1e3o/2s1VwJZfQuqyCwXi69iWgcfOCA87gVG4uEvDJyIxHB26cXTUrcTdtMNx/0NTNJtoQqd3FuK8uDRxHoshskOgEp6O3Yj/ZzW3HjRGluK/MzMHWkRpi8dX4nXKetcJ0qx7UjZWixb8aVxi0EzH9M//uc/wJzr6izEbwcCQAAAABJRU5ErkJggg==',
                ],
                4 => [
                    'name' => 'Constantinople',
                    'icon' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAP3RFWHRHZW5lcmF0ZWQgYnkAR2VuZXJhdGVkIGJ5IHRoZSBEZXZlbG9wZXIncyBJbWFnZSBMaWJyYXJ5IChEZXZJTCk++VvxAAAAB3RFWHRBdXRob3IAqa7MSAAAAAx0RVh0RGVzY3JpcHRpb24AEwkhIwAAAlZJREFUOI11k11IU2EYx//nnOWWHaY0ESEl20UMNOhCaKB9SjGEFEuNwgQVKbqoqCAvdmFEoX1oddFFBCkZZDdRCZlRi0JChCZR4kcmNvzY8GNrc57mzvl3obMdmw88V+/z/73P+z7/R1BVDfEhSSJVVROQIBKdiWsLzn8LQ5JEJhLnvfL9f6aqGla6oKpqhLmGBz7NE4AudzybJFJqaW8b50rtsi4mrun/zblxJ7HFSZhreOizn29HZ3nkTg8LurxESi1hvU7X88u03RtZhQAAzw2EiNTTLMy3Mjx+hfKuVsrbr3JJ8dNRYKZsrWfa7nZ+7SrivrwMwlTG3JYhAqAIACWWjYAyi3c/ynD4RBsMWWmAZRsgSVCUZIQ32+DXBJx1fsGHgT2AMQW+0Zl/fwCATT0zhFzJDXkPmVr6kmpUZWSuk5Gfp1h/4Rgtpd2U7Y8JuZI77w6vPsGwAhEkSeSl4QXcPngLgWAAi4FfMEZGsBD0IzvDhLnuIYjmdOTfb0RPVSZi49SNsS7LhGCfA4orCSXFhYAgwHH8BZ48fQ1vxxjc19yILumnqAM8mIhACL5BUXkLeqfKgcVRGJM3wT1fjaMn2+GZJqamQ+sDxsYCKK5qRa+3An+y7WBSJmCQsZieA7fWgMabj2CMRnUAQ5yhBEkS2eGJ4v3+ZgjeCVBbbldYUhAadMHX8BEj9Tbo7BxzVLwjq/tDRHIFleE67rVvJUxltN0Y1DlQ58REkIselYHvZ1iYb2Vu81BC8bqAGKSic5I5TYlvjqWwdp3jI7Z56603APwFHFmZpeP1n4kAAAAASUVORK5CYII=',
                ],
                6 => [
                    'name' => 'Bandit',
                    'icon' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAgY0hSTQAAeiYAAICEAAD6AAAAgOgAAHUwAADqYAAAOpgAABdwnLpRPAAAAwBQTFRFAAAADwUAHh4eJA0AKA4ALRAAMxIANxMANBQBOxUAPRYAPhcBODg4Pz4+QBcAThwATR0CUSEGWSABXSEAXSUIWygNZiQBZycFZSsKbjIRbzMSeTAIfDEIfjQLfDcRezsYfzsYQkFBV1ZWXFtbYWBgaGdnamlpa2pqb25uenh4enl5fHt7f319gT0Zi0MckkMZnkscjU0pk0skk08qm1o1nlkyn1o0qU0aq1corVksplw2q180uGY7l2dNrWhBt25GsXVTw3NHxXBCy3lN0H5TuYVo04BTwZN615d115l375Vj5Zt1/9g9m5mZqKenqaiorKqqs7GxtLOz97mX78q298eu/sms98y1+dS//9O7/9S7w8LC0M/P0tDQ29ra3t7e39/f4N/f/9fA/93L/+HR/+TV/+ja/+nc4uHh4+Pj5OPjAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAxIPgcAAAAQB0Uk5T////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////AFP3ByUAAAAZdEVYdFNvZnR3YXJlAFBhaW50Lk5FVCB2My41Ljg3O4BdAAAA2UlEQVQoU2NgwADxfn4MDGmhHuYMDMoqWkDpeH//xAyQMlVtJQ1NkEC0f1ZGQAyPopqOqgZYBRNTZmZgLA+vujYDgxpQII5JjIkpKIGHh4FBgMEXpFfP08SYiYmBQVzOWgbI/c8QlRTpbSbLImjk7GYA5P5nSBdOMQwzZZHiduSCCESESCenujJLWoq4WIAFRMOFg90dWBRsOF3YwQJWPnwcYbYsLE4sPhIggf8M/Kxewg7MClwsQiDefyBm9WGzY9X1YQZzgPg/AwOzPbM+I4QNIkBCQBeBAQC7RkQfNj4PRwAAAABJRU5ErkJggg==',
                ],
            ],
        ],
    ],
    'ranking' => [
        'menu' => [
            'ranking_player' => [
                'enable' => true,
                'name' => 'Player Ranking',
                'icon' => 'fa fa-users',
                'route' => 'ranking.player',
            ],
            'ranking_guild' => [
                'enable' => true,
                'name' => 'Guild Ranking',
                'icon' => 'fa fa-users',
                'route' => 'ranking.guild',
            ],
            'ranking_unique' => [
                'enable' => true,
                'name' => 'Unique Ranking',
                'icon' => 'fa fa-users',
                'route' => 'ranking.unique',
            ],
            'ranking_unique-monthly' => [
                'enable' => true,
                'name' => 'Unique Ranking (Monthly)',
                'icon' => 'fa fa-users',
                'route' => 'ranking.unique-monthly',
            ],
            'ranking_job' => [
                'enable' => true,
                'name' => 'Job Ranking',
                'icon' => 'fa fa-users',
                'route' => 'ranking.job',
            ],
            'ranking-honor' => [
                'enable' => true,
                'name' => 'Honor Ranking',
                'icon' => 'fa fa-users',
                'route' => 'ranking.honor',
            ],
            'ranking-fortress-player' => [
                'enable' => true,
                'name' => 'Fortress War (Player)',
                'icon' => 'fa fa-users',
                'route' => 'ranking.fortress-player',
            ],
            'ranking-fortress-guild' => [
                'enable' => true,
                'name' => 'Fortress War (Guild)',
                'icon' => 'fa fa-users',
                'route' => 'ranking.fortress-guild',
            ],
        ],
        'job_menu' => [
            'ranking_job_all' => [
                'enable' => true,
                'name' => 'All',
                'icon' => 'fa fa-users',
                'route' => 'ranking.job-all',
            ],
            'ranking_job_hunters' => [
                'enable' => true,
                'name' => 'Hunters',
                'icon' => 'fa fa-users',
                'route' => 'ranking.job-hunter',
            ],
            'ranking_job_thieves' => [
                'enable' => true,
                'name' => 'Thieves',
                'icon' => 'fa fa-users',
                'route' => 'ranking.job-thieve',
            ],
            'ranking_job_traders' => [
                'enable' => false,
                'name' => 'Traders',
                'icon' => 'fa fa-users',
                'route' => 'ranking.job-trader',
            ],
        ],
        'top_icons' => [
            1 => 'images/rank1.png',
            2 => 'images/rank2.png',
            3 => 'images/rank3.png',
        ],
        'unique_points' => [
            'MOB_CH_TIGERWOMAN' => [
                'id' => 1954,
                'name' => 'Tiger Girl',
                'points' => 1
            ],
            'MOB_OA_URUCHI' => [
                'id' => 1982,
                'name' => 'Uruchi',
                'points' => 2
            ],
            'MOB_KK_ISYUTARU' => [
                'id' => 2002,
                'name' => 'Isyutaru',
                'points' => 3
            ],
            'MOB_TK_BONELORD' => [
                'id' => 3810,
                'name' => 'Lord Yarkan',
                'points' => 4
            ],
            'MOB_RM_TAHOMET' => [
                'id' => 3875,
                'name' => 'Demon Shaitan',
                'points' => 5
            ],
            'MOB_AM_IVY' => [
                'id' => 14778,
                'name' => 'Captain Ivy',
                'points' => 2
            ],
            'MOB_EU_KERBEROS' => [
                'id' => 5871,
                'name' => 'Cerberus',
                'points' => 1
            ],
            'MOB_RM_ROC' => [
                'id' => 3877,
                'name' => 'Roc',
                'points' => 15
            ],
            'MOB_TQ_WHITESNAKE' => [
                'id' => 14839,
                'name' => 'Medusa',
                'points' => 10
            ],
        ],
        'hwan_titles' => [
            'CH' => [
                1 => 'Captain',
                2 => 'General',
                3 => 'Senior General',
                4 => 'Chief General',
                5 => 'Vice Lord',
                6 => 'General Lord',
            ],
            'EU' => [
                1 => 'Knight',
                2 => 'Baronet',
                3 => 'Baron',
                4 => 'Count',
                5 => 'Marquis',
                6 => 'Duke',
            ],
        ],
        'skill_mastery' => [
            257 => [
                "name" => "Blade",
                "icon" => "mastery_sword.png"
            ],
            258 => [
                "name" => "Glavie",
                "icon" => "mastery_spear.png"
            ],
            259 => [
                "name" => "Bow",
                "icon" => "mastery_bow.png"
            ],
            273 => [
                "name" => "Cold",
                "icon" => "mastery_cold.png"
            ],
            274 => [
                "name" => "Lightning",
                "icon" => "mastery_lightning.png"
            ],
            275 => [
                "name" => "Fire",
                "icon" => "mastery_fire.png"
            ],
            276 => [
                "name" => "Force",
                "icon" => "mastery_gigong.png"
            ],
            277 => [
                "name" => "Recovery",
                "icon" => "mastery_water.png"
            ],
            513 => [
                "name" => "Warrior",
                "icon" => "eu_warrior.png"
            ],
            514 => [
                "name" => "Wizard",
                "icon" => "eu_wizard.png"
            ],
            515 => [
                "name" => "Rogue",
                "icon" => "eu_rog.png"
            ],
            516 => [
                "name" => "Warlock",
                "icon" => "eu_warlock.png"
            ],
            517 => [
                "name" => "Bard",
                "icon" => "eu_bard.png"
            ],
            518 => [
                "name" => "Cleric",
                "icon" => "eu_cleric.png"
            ],
        ],
        'honor_level' => [
            1 => 'images/com_honor_level_1.PNG',
            2 => 'images/com_honor_level_2.PNG',
            3 => 'images/com_honor_level_3.PNG',
            4 => 'images/com_honor_level_4.PNG',
            5 => 'images/com_honor_level_5.PNG',
        ],
        'job_type' => [
            0 => 'None',
            1 => 'Trader',
            2 => 'Thief',
            3 => 'Hunter',
        ],
        'job_type_icons' => [
            1 => [
                'name' => 'Thief',
                'icon' => 'images/ingame/com_job_thief.PNG'
            ],
            2 => [
                'name' => 'Hunter',
                'icon' => 'images/ingame/com_job_hunter.PNG',
            ],
            3 => [
                'name' => 'Trader',
                'icon' => 'images/ingame/com_job_merchant.PNG',
            ],
        ],
        'vip_level' => [
            "level_access" => 4,
            "level" => [
                0 => "Normal",
                1 => "Iron",
                2 => "Bronze",
                3 => "Silver",
                4 => "Gold",
                5 => "Platinum",
                6 => "VIP"
            ],
            "type" => [
                0 => "General",
                1 => "VIP",
                2 => "New",
                3 => "Returne",
                4 => "Free"
            ]
        ],
        'guild' => [
            'permission' => [
                -1 => 'All',
                1 => 'Join',
                2 => 'Withdraw',
                4 => 'Union',
                8 => 'Storage',
                16 => 'Notice',
            ],
            'authority' => [
                1 => 'Leader',
                2 => 'Deputy Commander',
                4 => 'Fortress War Administrator',
                8 => 'Production Administrator',
                16 => 'Training Administrator',
                32 => 'Military Engineer',
            ],
        ],
    ],
    'item' => [
        'inventory' => [
            'slots' => [
                0 => 'helm',
                1 => 'chest' ,
                2 => 'shoulders',
                3 => 'gauntlet',
                4 => 'pants',
                5 => 'boots',
                6 => 'weapon',
                7 => 'shield',
                8 => 'job',
                9 => 'earring',
                10 => 'necklace',
                11 => 'lring',
                12 => 'rring',
            ],
        ],
        'sox_type' => [
            3 => 'Seal of Heavy Storm',
            2 => 'Seal of Star',
            1 => 'Seal of Moon',
            0 => 'Seal of Sun'
        ],
        'sox_class' => [
            'SET_A_RARE' => [
                0 => 'Destruction',
                1 => 'Destruction',
                2 => 'Destruction',
                3 => 'Destruction',
                4 => 'Destruction',
                5 => 'Destruction',
                6 => 'Power',
                7 => 'Protection',
                9 => 'Myth',
                10 => 'Myth',
                11 => 'Myth',
                12 => 'Myth',
            ],
            'SET_B_RARE' => [
                0 => 'Immortality',
                1 => 'Immortality',
                2 => 'Immortality',
                3 => 'Immortality',
                4 => 'Immortality',
                5 => 'Immortality',
                6 => 'Fight',
                7 => 'Guard',
                9 => 'Legend',
                10 => 'Legend',
                11 => 'Legend',
                12 => 'Legend',
            ],
        ],
        'sex' => [
            0 => 'Female',
            1 => 'Male',
        ],
        'country' => [
            0 => 'Chinese',
            1 => 'Europe',
        ],
        'race' => [
            'CH' => 'Chinese',
            'EU' => 'European',
        ],
        'cloth_detail' => [
            'FA' => 'Foot',
            'HA' => 'Head',
            'CA' => 'Head',
            'SA' => 'Shoulder',
            'BA' => 'Chest',
            'LA' => 'Legs',
            'AA' => 'Hands'
        ],
        'cloth_type' => [
            'CH' => [
                'CLOTHES' => 'Garment',
                'HEAVY' => 'Armor',
                'LIGHT' => 'Protector'
            ],
            'EU' => [
                'CLOTHES' => 'Robe',
                'HEAVY' => 'Heavy armor',
                'LIGHT' => 'Light armor'
            ]
        ],
        'weapon_type' => [
            'CH' => [
                'TBLADE' => 'Glavie',
                'SPEAR' => 'Spear',
                'SWORD' => 'Sword',
                'BLADE' => 'Blade',
                'BOW' => 'Bow',
                'SHIELD' => 'Shield'
            ],
            'EU' => [
                'AXE' => 'Dual axe',
                'CROSSBOW' => 'Crossbow',
                'DAGGER' => 'Dagger',
                'DARKSTAFF' => 'Dark staff',
                'HARP' => 'Harp',
                'SHIELD' => 'Shield',
                'STAFF' => 'Light staff',
                'SWORD' => 'Onehand sword',
                'TSTAFF' => 'Twohand staff',
                'TSWORD' => 'Twohand sword'
            ]
        ],
        'avatar_type' => [
            0 => 'Avatar Flag',
            1 => 'Avatar Attach',
            2 => 'Avatar Hat',
            4 => 'Avatar Dress',
            9 => 'Devil spirit\'s'
        ],
        'job_detail' => [
            0 => 'Head',
            1 => 'Chest',
            2 => 'Shoulder',
            3 => 'Hands',
            4 => 'Legs',
            5 => 'Foot',
        ],
        'job_degree' => [
            1 => 'Lowest Quality',
            2 => 'Low Quality',
            3 => 'Medium Quality',
        ],
        'job_type' => [
            2 => [
                1 => 'Hunter Equipment (weapon)',
            ],
            1 => [
                1 => 'Hunter Equipment (head)',
                2 => 'Hunter Equipment (shoulder)',
                3 => 'Hunter Equipment (tunic)',
                4 => 'Hunter Equipment (pants)',
                5 => 'Hunter Equipment (gloves)',
                6 => 'Hunter Equipment (shoes)',
            ],
            3 => [
                1 => 'Hunter Equipment (earrging)',
                2 => 'Hunter Equipment (necklace)',
                3 => 'Hunter Equipment (ring)',
            ],
            5 => [
                1 => 'Thief Equipment (weapon)',
            ],
            4 => [
                1 => 'Thief Equipment (head)',
                2 => 'Thief Equipment (shoulder)',
                3 => 'Thief Equipment (tunic)',
                4 => 'Thief Equipment (pants)',
                5 => 'Thief Equipment (gloves)',
                6 => 'Thief Equipment (shoes)',
            ],
            6 => [
                1 => 'Thief Equipment (earrging)',
                2 => 'Thief Equipment (necklace)',
                3 => 'Thief Equipment (ring)',
            ],
        ],
    ],
];
