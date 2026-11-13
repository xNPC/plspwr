# Деплой и обновления (production)

Документ описывает, как безопасно выложить сайт на хостинг и обновлять его, **не теряя данные, внесённые в админке** (страницы, блоки, товары, меню, настройки, загрузки, заявки).

## 1. Что важно знать

- **Контент живёт в БД и в `storage/app/public`** (загрузки/attachments Orchid, сидовые ассеты `img/`, `import/`). Их нельзя перетирать при обновлениях.
- **`db:seed` после начала наполнения не запускать.** Сидеры приведены к безопасному виду для уже заполненной БД (создают только отсутствующие записи, не удаляют меню/блоки и не перезаписывают отредактированные поля), но полагаться на них для обновления контента на проде не нужно. Для первого поднятия пустой БД — допустимо один раз.
- **Никогда на проде:** `php artisan migrate:fresh` / `migrate:fresh --seed` — полностью пересоздают БД.
- Проект рассчитан на **два домена** (ru/en) через `APP_LOCALE_DOMAIN_RU/EN` (`config/locale.php`, `app/Http/Middleware/SetLocaleFromDomain.php`): при совпадении хоста локаль определяется по домену, без `/en`-префикса. Оба домена должны смотреть в один `public/`.

## 2. Требования к серверу

- PHP **8.3+** (проект разработан/проверялся на 8.5) и Composer.
- Расширения: `pdo_mysql`, `mbstring`, `openssl`, `intl`, `fileinfo`, `ctype`, `tokenizer`, `xml`, `curl`, `json`; рекомендуется `gd` или `imagick` (работа с изображениями).
- MySQL 8.x (строгий режим поддерживается).
- Веб-сервер: DocumentRoot → `public/`. Apache с `mod_rewrite` (есть `public/.htaccess`) или эквивалентные правила для Nginx (все запросы к несуществующим файлам → `public/index.php`).
- Node.js/npm — **только если** фронтенд собирается на сервере; иначе `public/build` привозится в составе релиза.
- Права на запись для веб-пользователя: `storage/` и `bootstrap/cache/`.

## 3. Первый деплой (чистая БД)

1. **Код**: выложить проект на сервер (без `vendor/`, `node_modules/`, `.env`, `public/storage`, `public/build` — см. `.gitignore`). Убедиться, что присутствуют `storage/app/public/img` и `storage/app/public/import` (сидовые ассеты, на них ссылаются данные).
2. **`.env`**: создать на сервере (не коммитить). Ориентир — `.env.example`. Ключевые значения для прода:
   - `APP_NAME="НПП Импульсные технологии"`
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `APP_URL=https://<основной-ru-домен>`
   - `APP_LOCALE=ru`, `APP_FALLBACK_LOCALE=ru`, `APP_DEFAULT_LOCALE=ru`
   - `APP_LOCALE_DOMAIN_RU=<ru-домен>` (напр. `plspwr.ru`)
   - `APP_LOCALE_DOMAIN_EN=<en-домен>` (напр. `plspwr.com`)
   - `APP_URL_SCHEME=https` (если используется)
   - `APP_KEY=` → сгенерировать: `php artisan key:generate` (**не менять** после начала работы)
   - `DB_CONNECTION=mysql`, `DB_HOST/PORT/DATABASE/USERNAME/PASSWORD` — боевые
   - `SESSION_DRIVER=database`, `SESSION_LIFETIME=120`, `SESSION_SECURE_COOKIE=true` (на HTTPS)
   - `CACHE_STORE=database`, `QUEUE_CONNECTION=database`
   - `FILESYSTEM_DISK=local` (дефолт); публичные загрузки/attachments — диск `public`
   - `MAIL_MAILER/MAIL_HOST/MAIL_PORT/MAIL_USERNAME/MAIL_PASSWORD/MAIL_SCHEME/MAIL_FROM_*` — боевой SMTP. Пока он не настроен (`MAIL_MAILER=log`), уведомления о заявках пишутся в `storage/logs/laravel.log`. Получатели задаются в админке: **Настройки → «Получатели заявок»** (несколько адресов — через запятую или по одному в строке; если пусто — берётся контактный e-mail сайта).
   - `LOG_CHANNEL=stack`, `LOG_LEVEL=warning` (или `error`)
3. **Зависимости и билд**:
   - `composer install --no-dev --optimize-autoloader`
   - фронтенд: либо `npm ci && npm run build` на этапе деплоя, либо заранее собранный `public/build` (с `manifest.json`) в составе релиза.
4. **Laravel**:
   - `php artisan storage:link`
   - `php artisan migrate --force`
   - `php artisan db:seed --force` — **один раз** на пустой БД для стартовой структуры (страницы/блоки/меню/настройки/каталог/админ). После этого сидеры для наполнения не использовать.
   - `php artisan config:cache && php artisan route:cache && php artisan view:cache`
5. **Сразу после первого входа**:
   - Сменить пароль/почту администратора (дефолт сидера: `admin@imp-tech.local` / `admin1234`, логин `/admin`).
   - Проверить контакты/настройки в админке.
6. **Проверка**: главная и ключевые страницы в обеих локалях (по доменам), `/sitemap.xml`, `/robots.txt`, загрузка файлов в админке, форма заявок (попадание в `Leads`), отдача картинок из `/storage/...`.

## 4. Обновление кода (без потери данных)

Выполнять на каждом релизе. **БД не пересоздавать, сидеры не запускать.**

1. **Бэкап** (рекомендуется перед каждым обновлением): дамп БД + копия `storage/app/public`.
2. **Выложить новый код**, сохранив нетронутыми:
   - `.env`
   - `storage/app/public/` (все загрузки и ассеты)
   - саму БД
3. **Команды**:
   - `composer install --no-dev --optimize-autoloader`
   - `php artisan migrate --force` (только новые миграции)
   - `php artisan storage:link` (если симлинк отсутствует)
   - `php artisan optimize:clear` (или `config:clear && route:clear && view:clear && cache:clear`)
   - при необходимости прогреть кэш: `php artisan config:cache && php artisan route:cache && php artisan view:cache`
4. **Фронтенд**: обновить `public/build` (пересборка/из релиза), иначе манифест и ассеты разойдутся.
5. **Права**: `storage/`, `bootstrap/cache/` доступны на запись.
6. **Проверка**: сайт, админка, загрузки/отдача файлов, лог `storage/logs/laravel.log`.

> Рекомендация: вести код в git и деплоить релизом/`pull`, исключая из перезаписи `.env` и `storage/app/public`. При ручной (FTP/rsync) заливке особенно внимательно не затереть эти каталоги/файл.

## 5. Что хранить и бэкапить

- **БД** — весь контент, пользователи/роли, заявки, метаданные вложений.
- **`storage/app/public/`** — загруженные из админки файлы и сидовые `img/`, `import/`.
- **`.env`** и при наличии `storage/*.key`.
- **`public/build/`** — артефакт сборки (воспроизводим из исходников `resources/` + lock-файлов).

## 6. Известные моменты

- **Индексация поисковиками**: управляется переменной `SEO_INDEXABLE` (`.env`), по умолчанию **выключена** (`config/seo.php` → `indexable = false`): `robots.txt` отдаёт `Disallow: /`, все страницы — `noindex, nofollow`. После наполнения контентом поставьте `SEO_INDEXABLE=true` и выполните `php artisan config:clear && php artisan config:cache`.
- **Загрузки в репозитории**: `storage/app/public/img`, `import` и папка `2026` с используемыми на страницах файлами закоммичены (см. `storage/app/public/.gitignore`). Новые загрузки из админки в `2026/...` тоже станут видимы git — коммитьте их, если файл используется в контенте, иначе они останутся только на сервере.

- **Почта/заявки**: форма (`app/Livewire/LeadForm.php`) сохраняет лид в БД и сразу отправляет уведомление (`App\Mail\NewLeadMail` через `App\Services\LeadNotifier`) на адреса из админки (Настройки → «Получатели заявок»; пусто — контактный e-mail). Ошибки SMTP логируются и не ломают форму. Пока не настроен `MAIL_MAILER=smtp` с боевыми `MAIL_*`, письма уходят в лог. Смена получателей в админке не требует правки `.env`/кэша.
- **SEO на реальных доменах**: sitemap/robots/hreflang формируются с учётом `locale.domains` — после выкладки проверить корректность абсолютных URL, canonical/og на боевых доменах.
- **Сессии/кэш/очередь** в БД — требуют выполненных миграций; отдельный queue worker сейчас не критичен, но понадобится при появлении фоновых задач.
- **Реальный контент/логотип/фото** наполняются на хостинге через админку (это штатный сценарий). Перед каждым обновлением — бэкап БД и `storage/app/public`.
