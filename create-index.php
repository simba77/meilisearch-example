<?php

require_once __DIR__ . '/vendor/autoload.php';

use Meilisearch\Client;

$client = new Client('http://meilisearch:7700');

// https://green-spark.ru/products_codododsdf.json

$products = json_decode(file_get_contents('products.json'));

$result = $client->index('catalog')->addDocuments($products);

dd($result);
