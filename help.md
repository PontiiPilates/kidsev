Спасибо большое, эти команды уже который раз меня выручают:

# 1. Остановить всё
docker compose down

# 2. УДАЛИТЬ ВСЕ ДАННЫЕ MySQL
sudo rm -rf ./docker/mysql/data/

# 3. Запустить заново
docker compose up -d mysql


1. Полный сброс проекта (ядерная опция)
bash

# Останавливаем всё, удаляем ВСЕ данные, образы, тома
docker compose down -v --rmi all --remove-orphans

# Полная очистка Docker
docker system prune -a -f --volumes

# Запуск с нуля
docker compose up -d --build