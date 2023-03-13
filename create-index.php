<?php

require_once __DIR__ . '/vendor/autoload.php';

use Meilisearch\Client;

$client = new Client('http://meilisearch:7700');

// https://green-spark.ru/products_codododsdf.json

$products = json_decode(file_get_contents('products.json'), true);

// $products = array_splice($products, 0, 10);



function convertName(string $name)
{
    $letters = [
        #CASE_UPPER         #case_lower
        "\xd0\x81" => '~', "\xd1\x91" => '`', #Ё ё
        "\xd0\x90" => 'F', "\xd0\xb0" => 'f', #А а
        "\xd0\x91" => '<', "\xd0\xb1" => ',', #Б б
        "\xd0\x92" => 'D', "\xd0\xb2" => 'd', #В в
        "\xd0\x93" => 'U', "\xd0\xb3" => 'u', #Г г
        "\xd0\x94" => 'L', "\xd0\xb4" => 'l', #Д д
        "\xd0\x95" => 'T', "\xd0\xb5" => 't', #Е е
        "\xd0\x96" => ':', "\xd0\xb6" => ';', #Ж ж
        "\xd0\x97" => 'P', "\xd0\xb7" => 'p', #З з
        "\xd0\x98" => 'B', "\xd0\xb8" => 'b', #И и
        "\xd0\x99" => 'Q', "\xd0\xb9" => 'q', #Й й
        "\xd0\x9a" => 'R', "\xd0\xba" => 'r', #К к
        "\xd0\x9b" => 'K', "\xd0\xbb" => 'k', #Л л
        "\xd0\x9c" => 'V', "\xd0\xbc" => 'v', #М м
        "\xd0\x9d" => 'Y', "\xd0\xbd" => 'y', #Н н
        "\xd0\x9e" => 'J', "\xd0\xbe" => 'j', #О о
        "\xd0\x9f" => 'G', "\xd0\xbf" => 'g', #П п
        #CASE_UPPER         #case_lower
        "\xd0\xa0" => 'H', "\xd1\x80" => 'h', #Р р
        "\xd0\xa1" => 'C', "\xd1\x81" => 'c', #С с
        "\xd0\xa2" => 'N', "\xd1\x82" => 'n', #Т т
        "\xd0\xa3" => 'E', "\xd1\x83" => 'e', #У у
        "\xd0\xa4" => 'A', "\xd1\x84" => 'a', #Ф ф
        "\xd0\xa5" => '{', "\xd1\x85" => '[', #Х х
        "\xd0\xa6" => 'W', "\xd1\x86" => 'w', #Ц ц
        "\xd0\xa7" => 'X', "\xd1\x87" => 'x', #Ч ч
        "\xd0\xa8" => 'I', "\xd1\x88" => 'i', #Ш ш
        "\xd0\xa9" => 'O', "\xd1\x89" => 'o', #Щ щ
        "\xd0\xaa" => '}', "\xd1\x8a" => ']', #Ъ ъ
        "\xd0\xab" => 'S', "\xd1\x8b" => 's', #Ы ы
        "\xd0\xac" => 'M', "\xd1\x8c" => 'm', #Ь ь
        "\xd0\xad" => '"', "\xd1\x8d" => "'", #Э э
        "\xd0\xae" => '>', "\xd1\x8e" => '.', #Ю ю
        "\xd0\xaf" => 'Z', "\xd1\x8f" => 'z', #Я я
    ];
    $letters = array_merge($letters, array_flip($letters));

    $nameParts = explode(' ', $name);
    $nameParts = array_filter($nameParts, function ($item) {
        return mb_strlen($item) > 3;
    });

    $name = implode(' ', $nameParts);
    // dd($result, $nameParts);

    return strtr($name, $letters);
}

$products = array_map(function ($item) {
    $item['badName'] = convertName($item['name']);
    return $item;
}, $products);

// Удаляем все документы из индекса
$client->index('catalog')->deleteAllDocuments();


// Обновление или создание индекса
$result = $client->index('catalog')->updateDocuments($products);

// Простое добавление документов
// $result = $client->index('catalog')->addDocuments($products);

dd($result);
