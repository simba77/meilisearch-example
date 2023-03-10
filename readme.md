# Meilisearch

Тестирование возможностей Meilisearch.

## Как развернуть?

Если не установлен docker, то нужно скачать и установить с сайта https://www.docker.com/


Для простоты развертывания можно установить git https://git-scm.com/ и склонировать репозиторий с его помощью.

```bash
git clone https://github.com/simba77/meilisearch-example.git meilisearch
```

```bash
cd meilisearch
```

Или вручную скачать архивом и распаковать в нужную папку.

Открываем консоль и переходим в папку с проектом.

```bash
docker-compose up -d
```

Первый запуск скачает и установит вебсервер и meilisearch

После запуска нужно установить зависимости с помощью composer следующим образом:

Запускаем консоль в контейнере:

```bash
docker exec -it $(docker ps -q -f name=ubuntu.greenspark) bash
```

После этого выполняем:

```bash
composer install
```

На этом установка завершена.

Тестовые скрипты будут доступны в браузере по адресу:

http://localhost:8000/

Meilisearch будет доступен по адресу:

http://localhost:7700/

Создать индекс:

http://localhost:8000/create-index.php

Обновить настройки индекса:

http://localhost:8000/index-settings.php
