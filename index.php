<?php

require_once __DIR__ . '/vendor/autoload.php';

use Meilisearch\Client;

$client = new Client('http://meilisearch:7700');

$searchQuery = $_GET['query'] ?? '';

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
          crossorigin="anonymous">
    <style>
        em {
            background: #d8ffbb;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="mt-3 mb-4">
        <a href="create-index.php" class="btn btn-outline-primary me-2">Создать индекс</a>
        <a href="index-settings.php" class="btn btn-outline-primary">Обновить настройки</a>
    </div>
    <h3>Поиск</h3>
    <form action="" method="get">
        <input type="search" class="form-control" name="query" value="<?= htmlspecialchars($searchQuery) ?>">
        <div class="my-3">
            <button class="btn btn-primary" type="submit">Найти</button>
        </div>
    </form>

    <?php

    if (empty($searchQuery)) {
        exit();
    }

    $results = $client->index('catalog')
        ->search($searchQuery, [
            'attributesToHighlight' => ['name']
        ]);


    foreach ($results->getHits() as $hit) {
        ?>
        <div class="card mb-2">
            <div class="card-body">
                <div class="fw-bold"><?= $hit['_formatted']['name'] ?></div>
                <div class="small"><?= $hit['_formatted']['searchName'] ?></div>
                <div class="small">Артикул: <?= $hit['_formatted']['article'] ?></div>
                <div class="small">Штрих-код: <?= $hit['_formatted']['barcode'] ?></div>
            </div>
        </div>
        <?php
    }

    dd($results); ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</body>
</html>




