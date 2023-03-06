<?php

require_once __DIR__ . '/vendor/autoload.php';

use Meilisearch\Client;

$client = new Client('http://meilisearch:7700');

// https://green-spark.ru/products_codododsdf.json

$products = json_decode(file_get_contents('products.json'));

// Удаляем все документы из индекса
$client->index('catalog')->deleteAllDocuments();

// Обновление или создание индекса
$result = $client->index('catalog')->updateDocuments($products);

// Простое добавление документов
// $result = $client->index('catalog')->addDocuments($products);

dd($result);
