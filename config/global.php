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
                'character' => 3600,
                'guild' => 3600,
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
                    'icon' => 'images/sro/etc/fort_jangan.jpg',
                ],
                3 => [
                    'name' => 'Hotan',
                    'icon' => 'images/sro/etc/fort_hotan.jpg',
                ],
                4 => [
                    'name' => 'Constantinople',
                    'icon' => 'images/sro/etc/fort_constantinople.jpg',
                ],
                6 => [
                    'name' => 'Bandit',
                    'icon' => 'images/sro/etc/fort_bijeokdan.jpg',
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
