<?php

require_once __DIR__ . '/vendor/autoload.php';

use B1rdex\Text\LangCorrect;
use Meilisearch\Client;

$client = new Client('http://meilisearch:7700');

$searchQuery = $_GET['query'] ?? '';

$matchingAll = isset($_REQUEST['matching']) && $_REQUEST['matching'] === 'all';

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
<!--    <div class="mt-3 mb-4">
        <a href="create-index.php" class="btn btn-outline-primary me-2">Создать индекс</a>
        <a href="index-settings.php" class="btn btn-outline-primary">Обновить настройки</a>
    </div>-->
    <h3>Поиск</h3>
    <form action="" method="get">
<!--        <div class="mb-2">
            <label>
                <input type="checkbox" name="matching" value="all" <?php /*= $matchingAll ? 'checked' : '' */?>> Точный поиск
            </label>
        </div>-->
        <input type="search" class="form-control" name="query" value="<?= htmlspecialchars($searchQuery) ?>">
        <div class="my-3">
            <button class="btn btn-primary" type="submit">Найти</button>
        </div>
    </form>

    <?php

    if (empty($searchQuery)) {
        exit();
    }

    // Если кавычка одна, то удаляем её. Если больше, то оставляем.
    if(substr_count($searchQuery, '"') === 1) {
        $searchQuery = str_replace('"', '', $searchQuery);
    }

    //facets
    $config = [
        'attributesToHighlight' => ['*'],
        'sort' => ['model:asc'],
        'limit' => 50,
        'facets' => ['model', 'sections']
    ];

    $results = $client->index('catalog')->search(($matchingAll ? '"' . $searchQuery . '"' : $searchQuery), $config);

    if (!$results->count()) {
        $lang = new \B1rdex\Text\LangCorrect();
        $result = $lang->parse($searchQuery, LangCorrect::KEYBOARD_LAYOUT);

        echo '<div class="alert alert-danger">' . $result . '</div>';

        $results = $client->index('catalog')->search(($matchingAll ? '"' . $result . '"' : $result), $config);
    }

    foreach ($results->getHits() as $hit) {
        ?>
        <div class="card mb-2">
            <div class="card-body">
                <div class="fw-bold"><?= $hit['_formatted']['name'] ?></div>
                <div class="small"><?= $hit['_formatted']['searchName'] ?></div>
                <div class="small">Модель: <?= $hit['_formatted']['model'] ?></div>
                <div class="small">Артикул: <?= $hit['_formatted']['article'] ?></div>
                <div class="small">Штрих-код: <?= $hit['_formatted']['barcode'] ?></div>
                <div class="small">ID: <?= $hit['_formatted']['id'] ?></div>
            </div>
        </div>
        <?php
    }

    ?>

    <?php

    if($results->count()) {
        $models = $results->getFacetDistribution()['sections'] ?? [];
        ?>
        <div class="mb-3">
            <h4 class="mt-4">Разделы</h4>
            <?php
            foreach ($models as $model => $count) {
                ?>
                <button type="button" class="btn btn-sm btn-primary mb-2">
                    <?= $model ?> <span class="badge bg-white text-black"><?= $count ?></span>
                </button>
                <?php
            }
            ?>
        </div>
        <?php
    }

    //dd($results); ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</body>
</html>




