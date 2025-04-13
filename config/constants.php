<?php

return [
    'hwantitles' => [
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
    'viplevel' => [
        "level_access"=>4,
        "level"=>[
            0=>"Normal",
            1=>"Iron",
            2=>"Bronze",
            3=>"Silver",
            4=>"Gold",
            5=>"Platinum",
            6=>"VIP"
        ],
        "type"=>[
            0=>"General",
            1=>"VIP",
            2=>"New",
            3=>"Returne",
            4=>"Free"
        ]
    ],
    'eventschedule' => [
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
    'skillmastery' => [
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
    'job' => [
        '0' => 'None',
        '1' => 'Trader',
        '2' => 'Thief',
        '3' => 'Hunter',

        'none' => '0',
        'trader' => '1',
        'thief' => '2',
        'hunter' => '3',
    ],
    'skill' => [
    ],
    'guild' => [
        'permission' => [
            'all' => -1,
            'join' => 1,
            'withdraw' => 2,
            'union' => 4,
            'storage' => 8,
            'notice' => 16,
        ],
        'permission_names' => [
            -1 => 'All',
            1 => 'Join',
            2 => 'Withdraw',
            4 => 'Union',
            8 => 'Storage',
            16 => 'Notice',
        ],
        'siege' => [
            '1' => 'Commander',
            '2' => 'Deputy Commander',
            '4' => 'Fortress War Administrator',
            '8' => 'Production Administrator',
            '16' => 'Training Administrator',
            '32' => 'Military Engineer',
        ],
    ],
    'siege' => [
        'names' => [
            // SiegeID => Name
            '1' => 'Jangan',
            '3' => 'Hotan',
            '4' => 'Constantinople',
            '6' => 'Bandit',
        ],
    ],
    'inventory' => [
        'slots' => [
            'helm' => '0',
            'chest' => '1',
            'shoulders' => '2',
            'gauntlet' => '3',
            'pants' => '4',
            'boots' => '5',
            'weapon' => '6',
            'shield' => '7',
            'job' => '8',
            'earring' => '9',
            'necklace' => '10',
            'lring' => '11',
            'rring' => '12',
        ],
    ],
    'item' => [
        'rarity' => [
            '0' => 'Normal',
            '1' => 'Seal of Nova',
            '2' => 'Seal of Moon',
            '3' => 'Seal of Sun',
            '6' => 'Set',
        ],
        'soxclass' => [
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
            '0' => 'Female',
            '1' => 'Male',
        ],
        'country' => [
            '0' => 'Chinese',
            '1' => 'Europe',
        ],
        'race' => [
            'CH' => 'Chinese',
            'EU' => 'European',
        ],
        'clothdetail' => [
            'FA' => 'Foot',
            'HA' => 'Head',
            'CA' => 'Head',
            'SA' => 'Shoulder',
            'BA' => 'Chest',
            'LA' => 'Legs',
            'AA' => 'Hands'
        ],
        'clothtype' => [
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
        'weapontype' => [
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
        'jobdetail' => [
            0 => 'Head',
            1 => 'Chest',
            2 => 'Shoulder',
            3 => 'Hands',
            4 => 'Legs',
            5 => 'Foot',
        ],
        'jobdegree' => [
            1 => 'Lowest Quality',
            2 => 'Low Quality',
            3 => 'Medium Quality',
        ],
        'jobtype' => [
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
        'avatartype' => [
            0 => 'Avatar Flag',
            1 => 'Avatar Attach',
            2 => 'Avatar Hat',
            4 => 'Avatar Dress',
            9 => 'Devil spirit\'s'
        ],
    ],
];
