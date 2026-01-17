## Развёртывание проекта

### Засев базы данных
```shell
docker compose exec app php artisan migrate:refresh --seed
```

### Наполнение базы данных реальными данными из файлов
```shell
docker compose exec app php artisan app:parse-csv
```