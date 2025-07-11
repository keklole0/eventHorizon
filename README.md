# Event Horizon

**Event Horizon** — современная платформа для поиска, создания и управления мероприятиями.

## Возможности

- Регистрация и авторизация пользователей
- Создание, редактирование и удаление мероприятий
- Поиск и фильтрация мероприятий по названию, описанию, дате, адресу и категориям
- Система лайков и комментариев для мероприятий
- Оставление отзывов организаторам
- Личный кабинет пользователя с историей участия и избранными событиями
- Административная панель для управления пользователями, категориями, мероприятиями и сообщениями
- Интерактивная карта (Яндекс.Карты) для отображения мест проведения
- Современный адаптивный дизайн

## Технологии

- **Backend:** Laravel 10+, PHP 8+
- **Frontend:** Blade, CSS3, JavaScript (Vanilla)
- **База данных:** MySQL / MariaDB
- **Карта:** Yandex.Maps API
- **Почта:** Laravel Mail (SMTP)
- **Прочее:** DaData API (подсказки адреса), FontAwesome, jQuery (только для DaData)

## Установка

1. Клонируйте репозиторий:
   ```bash
   git clone https://github.com/your-username/event-horizon.git
   cd event-horizon
   ```

2. Установите зависимости:
   ```bash
   composer install
   npm install
   ```

3. Создайте файл окружения:
   ```bash
   cp .env.example .env
   ```

4. Сгенерируйте ключ приложения:
   ```bash
   php artisan key:generate
   ```

5. Настройте параметры подключения к БД и почте в `.env`.

6. Выполните миграции и заполните базу тестовыми данными:
   ```bash
   php artisan migrate --seed
   ```

7. Соберите фронтенд-ассеты:
   ```bash
   npm run build
   ```

8. Запустите сервер:
   ```bash
   php artisan serve
   ```

9. Откройте сайт в браузере:
   ```
   http://127.0.0.1:8000
   ```

## Структура проекта

- `app/Http/Controllers` — контроллеры сайта и админки
- `app/Models` — модели Eloquent
- `resources/views` — Blade-шаблоны
- `public/css`, `public/js` — стили и скрипты
- `database/migrations`, `database/seeders` — миграции и сидеры
- `routes/web.php` — основные маршруты

## Контакты

- Автор: Данил
- Email: keklole0@gmail.com
- Telegram: @keklole

---

**Event Horizon** — ваш портал в мир интересных событий!
