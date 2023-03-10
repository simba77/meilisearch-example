<?php

require_once __DIR__ . '/vendor/autoload.php';

use Meilisearch\Client;

$client = new Client('http://meilisearch:7700');
$index = $client->index('catalog');


$index->updateSettings(
    [
        'rankingRules' => [
            'words',
            'typo',
            'proximity',
            'attribute',
            'sort',
            'exactness',
        ],
        'distinctAttribute' => null,
        'searchableAttributes' => [
            'name',
            'badName',
            'model',
            'searchName',
            'article',
            'barcode',
        ],
        'filterableAttributes' => [
            'model',
            'article',
            'barcode',
            'sections',
        ],
        'displayedAttributes' => ['*'],
        'stopWords' => [
            'на', // Дисплей на iphone 7
            'для',
            //'с',

            //предлоги в неправильной раскладке
            ',tp',
            ',kbp',
            //'d',
            'dvtcnj',
            'dyt',
            'lkz',
            'lj',
            'pf',
            'bp',
            'bp-pf',
            'bp-gjl',
            //'r',
            'rhjvt',
            'vt;le',
            'yf',
            'yfl',
            //'j',
            'jn',
            'gthtl',
            'gj',
            'gjl',
            'ghb',
            'ghj',
            'hflb',
            //'c',
            'crdjpm',
            'chtlb',
            //'e',
            'xthtp',

        ],
        'sortableAttributes' => [
            'name',
            'model',
        ],
        'synonyms' => [
            // Дисплей на iphone икс
            // Дисплей на iphone 10
            'iphone 10' => ['iphone x', 'iphone ten', 'iphone икс'],
            'iphone ten' => ['iphone x', 'iphone 10', 'iphone икс'],
            'iphone икс' => ['iphone x', 'iphone 10', 'iphone ten'],
            'айфон' => ['iphone'],
            'phone' => ['iphone'],
            'сенсор' => ['тачскрин', 'тач'],

            'айфон 5с' => ['iphone 5c'],

            //сокращенные наименования
            //'дисп' => ['дисплей'],
            //'iph' => ['iphone'],

            // Дисплей на iphone семь плюс
            'пять' => ['5'],
            'шесть' => ['6'],
            'семь' => ['7'],
            'восемь' => ['8'],
            'девять' => ['9'],
            'десять' => ['10', 'X'],
            'одиннадцать' => ['11'],
            'двенадцать' => ['12'],
            'тринадцать' => ['13'],

            'плюс' => ['plus'],
            'про' => ['pro'],
            'про макс' => ['pro max'],

            'ксиоми' => ['xiaomi', 'сяоми'],
            'сяоми' => ['xiaomi', 'ксиоми'],
            'редми' => ['redmi', 'mi'],
            'поко' => ['poco'],
            'ноут' => ['note'],
            'нот' => ['note'],
        ],
        'typoTolerance' => [
            'enabled' => true,
            'minWordSizeForTypos' => [
                'oneTypo' => 3,
                'twoTypos' => 5
            ],
            'disableOnWords' => [],
            'disableOnAttributes' => ['article', 'barcode']
        ],
        'pagination' => [
            'maxTotalHits' => 5000
        ],
        'faceting' => [
            'maxValuesPerFacet' => 100
        ]
    ]
);

$result = $index->getSettings();

dd($result);
