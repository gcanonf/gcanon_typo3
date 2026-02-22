<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'gcanonSitePackage',
    'description' => 'First site package of gcanon.de site',
    'category' => 'templates',
    'constraints' => [
        'depends' => [
            'bootstrap_package' => '15.0.0-15.99.99',
        ],
        'conflicts' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Gcanon\\Gcanonsitepackage\\' => 'Classes',
        ],
    ],
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'Gustavo Canon',
    'author_email' => 'gustavo@gcanon.de',
    'author_company' => 'gcanon',
    'version' => '1.0.0',
];
