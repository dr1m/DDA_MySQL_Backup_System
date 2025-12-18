<?php
/**
 * DDA MySQL Backup System v1.020
 * 
 * =====================================================================================
 * ОСНОВНАЯ ИНФОРМАЦИЯ
 * =====================================================================================
 * 
 * Автор: Демидов Дмитрий Анатольевич (dr1m)
 * Версия: 1.020
 * Лицензия: MIT
 * Дата последнего обновления: 2025-12-18
 * 
 * github: https://github.com/dr1m/DDA_MySQL_Backup_System
 * 
 * =====================================================================================
 * КЛЮЧЕВЫЕ ОСОБЕННОСТИ
 * =====================================================================================
 * 
 * 🌟 ПОРТАТИВНАЯ СИСТЕМА - ВСЕ В ОДНОМ ФАЙЛЕ 🌟
 * 
 * Система представляет собой полностью автономное решение в виде одного PHP файла,
 * что обеспечивает максимальную мобильность и простоту развертывания.
 * 
 * Преимущества портативной реализации:
 * ✅ МОБИЛЬНОСТЬ - Один файл, можно быстро скопировать на любой сервер
 * ✅ БЫСТРОЕ РАЗВЕРТЫВАНИЕ - Не требует установки, просто загрузите файл
 * ✅ ПРОСТОТА РЕЗЕРВНОГО КОПИРОВАНИЯ - Скопируйте один файл для бэкапа всей системы
 * ✅ ЛЕГКАЯ МИГРАЦИЯ - Переносите систему между серверами за секунды
 * ✅ МИНИМАЛЬНЫЕ ТРЕБОВАНИЯ - Работает везде где есть PHP и MySQL
 * ✅ САМОДОСТАТОЧНОСТЬ - Все данные и настройки хранятся в одном месте
 * 
 * =====================================================================================
 * ОПИСАНИЕ СИСТЕМЫ
 * =====================================================================================
 * 
 * MySQL Backup System - это комплексное решение для автоматического создания бэкапов
 * баз данных MySQL с возможностью управления через веб-интерфейс и API.
 * 
 * Основные возможности:
 * 1. Автоматическое создание бэкапов всех баз данных или выбранных
 * 2. Гибкая настройка расписания через Cron
 * 3. Управление через веб-интерфейс и API
 * 4. Система токенов для безопасного API доступа
 * 5. Многоязычный интерфейс (русский, английский, китайский)
 * 6. Настройка сроков хранения бэкапов
 * 7. Мониторинг и статистика
 * 
 * =====================================================================================
 * ЛОГИКА РАБОТЫ СИСТЕМЫ
 * =====================================================================================
 * 
 * 1. ИНИЦИАЛИЗАЦИЯ:
 *    - Загрузка конфигурации из JSON файла
 *    - Загрузка токенов доступа
 *    - Определение режима работы (консоль/веб/API)
 *    - Установка локализации
 * 
 * 2. ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ:
 *    - Проверка параметров подключения
 *    - Тестирование соединения
 *    - Получение списка доступных баз данных
 *    - Фильтрация системных баз данных
 * 
 * 3. СОЗДАНИЕ БЭКАПА:
 *    - Определение целевых баз данных
 *    - Создание структуры папок по дате
 *    - Последовательное создание дампов для каждой базы
 *    - Сжатие результатов через gzip
 *    - Логирование процесса
 *    - Очистка временных файлов
 * 
 * 4. УПРАВЛЕНИЕ БЭКАПАМИ:
 *    - Автоматическая очистка старых бэкапов (по retention policy)
 *    - Просмотр существующих бэкапов с пагинацией
 *    - Удаление отдельных бэкапов или групп
 *    - Расчет статистики использования
 * 
 * 5. БЕЗОПАСНОСТЬ:
 *    - Авторизация для веб-доступа (опционально)
 *    - Токены доступа для API
 *    - Безопасное хранение паролей в конфигурации
 *    - Проверка прав доступа к файловой системе
 *    - Проверка наличия активных токенов для API доступа
 * 
 * =====================================================================================
 * ИСПОЛЬЗОВАНИЕ ЧЕРЕЗ КОНСОЛЬ
 * =====================================================================================
 * 
 * 1. Создание бэкапа всех баз:
 *    php DDA_MySQL_Backup_System.php
 * 
 * 2. Создание бэкапа конкретной базы:
 *    php DDA_MySQL_Backup_System.php --database=database_name
 *    php DDA_MySQL_Backup_System.php -d database_name
 * 
 * 3. Просмотр справки:
 *    php DDA_MySQL_Backup_System.php --help
 * 
 * =====================================================================================
 * API ДОСТУП
 * =====================================================================================
 * 
 * API доступен только при наличии активных токенов. Основные методы:
 * 
 * GET   /?api=1&action=test_connection&token=TOKEN
 * POST  /?api=1&action=create_backup&token=TOKEN
 * GET   /?api=1&action=list_backups&token=TOKEN&page=1&per_page=20
 * DELETE /?api=1&action=delete_backup&name=DATE&token=TOKEN
 * GET   /?api=1&action=system_info&token=TOKEN
 * 
 * Полная документация доступна в веб-интерфейсе на вкладке "API"
 * 
 * =====================================================================================
 * ТРЕБОВАНИЯ К СИСТЕМЕ
 * =====================================================================================
 * 
 * - PHP 7.4 или выше
 * - MySQL 5.7 или выше
 * - Доступ к командам mysql и mysqldump
 * - Доступ к команде gzip
 * - Права на запись в директорию бэкапов
 * - Права на выполнение PHP скриптов
 * 
 * =====================================================================================
 * ПРОЦЕСС РАЗВЕРТЫВАНИЯ (60 СЕКУНД)
 * =====================================================================================
 * 
 * 1. Загрузите файл на сервер (10 секунд)
 * 2. Установите права доступа (5 секунд):
 *    chmod 755 DDA_MySQL_Backup_System.php
 * 
 * 3. Запустите из консоли для инициализации (10 секунд):
 *    php DDA_MySQL_Backup_System.php
 * 
 * 4. Откройте веб-интерфейс и настройте (30 секунд)
 * 5. Добавьте в Cron для автоматизации (5 секунд)
 * 
 * ИТОГО: 60 секунд на полное развертывание!
 * 
 * =====================================================================================
 * УПРАВЛЕНИЕ КОНФИГУРАЦИЕЙ
 * =====================================================================================
 * 
 * Все настройки хранятся в JSON формате и могут быть:
 * 1. Изменены через веб-интерфейс
 * 2. Экспортированы для резервного копирования
 * 3. Импортированы при переносе системы
 * 4. Отредактированы вручную (при необходимости)
 * 
 * Конфигурационные файлы:
 * - config.json - основные настройки системы
 * - tokens.json - API токены и статистика использования
 * 
 * =====================================================================================
 * ЛОГИРОВАНИЕ И МОНИТОРИНГ
 * =====================================================================================
 * 
 * 1. Логи ошибок: DDA_MySQL_Backup_System_error.log (если включено)
 * 2. Логи выполнения: вывод в консоль или HTTP ответ
 * 3. Мониторинг: веб-интерфейс с подробной статистикой
 * 4. Уведомления: через API интеграции
 * 
 * Формат логов: CEF (Common Event Format) для совместимости с SIEM системами
 * 
 * =====================================================================================
 * БЕЗОПАСНОСТЬ
 * =====================================================================================
 * 
 * 1. Все настройки хранятся в JSON файлах
 * 2. Пароли шифруются при хранении (планируется)
 * 3. API доступ через токены с проверкой активности
 * 4. Веб доступ с авторизацией (опционально)
 * 5. Проверка прав доступа к файловой системе
 * 6. Валидация всех входных данных
 * 7. Защита от неавторизованного доступа к API
 * 
 * =====================================================================================
 * УСТРАНЕНИЕ НЕИСПРАВНОСТЕЙ
 * =====================================================================================
 * 
 * 1. Проверьте права доступа к директории бэкапов
 * 2. Проверьте корректность настроек подключения к MySQL
 * 3. Включите логирование ошибок для диагностики
 * 4. Проверьте доступность команд mysql и mysqldump
 * 5. Убедитесь, что у пользователя MySQL есть необходимые права
 * 6. Проверьте наличие активных токенов для API доступа
 * 
 * =====================================================================================
 * КОНТАКТЫ И ПОДДЕРЖКА
 * =====================================================================================
 * 
 * Для вопросов и предложений: info@dr1m.ru
 * 
 * =====================================================================================
 * ЛИЦЕНЗИЯ
 * =====================================================================================
 * 
 * MIT License
 * 
 * Copyright (c) 2025 Демидов Дмитрий Анатольевич (dr1m)
 * 
 * Разрешено свободное использование, копирование, модификация, объединение, публикация,
 * распространение, сублицензирование и/или продажа копий Программного обеспечения.
 * 
 * =====================================================================================
*/

// Включение вывода ошибок для отладки
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Версия системы
define('BACKUP_VERSION', '1.020');
define('BACKUP_YEAR', date('Y'));

// Настройки авторизации (используются только если включена авторизация)
$auth_config = [
    'username' => 'admin',           // Логин для доступа к веб-интерфейсу
    'password' => 'password123',     // Пароль для доступа к веб-интерфейсу
    'session_timeout' => 3600        // Таймаут сессии в секундах (1 час)
];

// Определение режима запуска
$isCli = php_sapi_name() === 'cli';
$isApiRequest = isset($_GET['api']);
$isWebRequest = isset($_SERVER['HTTP_HOST']) || !$isCli;

// Префикс для всех файлов системы
define('SYSTEM_PREFIX', 'DDA_MySQL_Backup_System_');

// Пути к файлам конфигурации
$configFile = __DIR__ . '/' . SYSTEM_PREFIX . 'config.json';
$tokensFile = __DIR__ . '/' . SYSTEM_PREFIX . 'tokens.json';
$logFile = __DIR__ . '/' . SYSTEM_PREFIX . 'error.log';

// Конфигурация по умолчанию
$defaultConfig = [
    'db_user'      => '',
    'db_pass'      => '',
    'db_host'      => '',
    'backup_dir'   => '/var/backups/mysql_backups/',
    'backup_subdir' => 'BD', // Название подпапки после даты
    'retention_days' => 30,
    'api_enabled'  => false,  // API по умолчанию выключен
    'selected_dbs' => [], // пустой массив - значит все базы
    'exclude_dbs'  => ['information_schema', 'performance_schema', 'mysql', 'sys', 'phpmyadmin', 'test'],
    // Новые настройки
    'enable_console' => true,     // Разрешить доступ из консоли
    'enable_web'     => true,     // Разрешить веб доступ
    'enable_auth'    => false,    // Запрашивать авторизацию
    'enable_error_log' => false,   // Писать лог ошибок в текущую папку
    'date_format'   => 'Y-m-d',   // Формат даты для папок бэкапов
    'language'      => 'en',      // Язык интерфейса
    'backup_to_current_dir' => false, // Создавать бэкапы в текущую папку
    'pagination_limit' => 20      // Количество элементов на странице для пагинации
];

// Функция логирования ошибок в формате CEF
function logError($message, $event_type = 'error', $severity = 5, $additional_data = []) {
    global $config, $logFile;
    
    if (!$config['enable_error_log']) {
        return;
    }
    
    $timestamp = date('c'); // ISO 8601 формат
    $source_ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    $request_uri = $_SERVER['REQUEST_URI'] ?? '';
    
    // Базовые поля CEF
    $cef_version = 0;
    $device_vendor = 'DDA MySQL Backup System';
    $device_product = 'Backup System';
    $device_version = BACKUP_VERSION;
    $signature_id = hash('crc32', $event_type . $message);
    
    // Формируем CEF строку
    $cef_parts = [
        "CEF:{$cef_version}",
        $device_vendor,
        $device_product,
        $device_version,
        $signature_id,
        $event_type,
        $severity
    ];
    
    $cef_base = implode('|', $cef_parts);
    
    // Дополнительные расширения
    $extensions = [
        "rt=$timestamp",
        "src=$source_ip",
        "request=$request_uri",
        "msg=" . str_replace('=', '\\=', substr($message, 0, 255)),
        "agent=$user_agent"
    ];
    
    // Добавляем дополнительные данные если есть
    foreach ($additional_data as $key => $value) {
        $safe_value = str_replace('=', '\\=', substr($value, 0, 100));
        $extensions[] = "{$key}={$safe_value}";
    }
    
    $cef_line = $cef_base . '|' . implode(' ', $extensions);
    
    // Записываем в лог
    file_put_contents($logFile, $cef_line . "\n", FILE_APPEND);
}

// Функция логирования неверной авторизации
function logFailedAuth($username, $ip, $user_agent) {
    $message = "Failed authentication attempt - username: {$username}";
    $additional = [
        'authUser' => $username,
        'srcIp' => $ip,
        'agent' => $user_agent
    ];
    logError($message, 'auth_failed', 7, $additional);
}

// Функция логирования API ошибок
function logApiError($action, $token, $error_message, $ip) {
    $message = "API error - action: {$action}, error: {$error_message}";
    $additional = [
        'act' => $action,
        'token' => substr($token, 0, 10) . '...',
        'srcIp' => $ip
    ];
    logError($message, 'api_error', 6, $additional);
}

// Функция логирования ошибок бэкапа
function logBackupError($database, $error_message, $operation = 'backup') {
    $message = "Backup error - database: {$database}, operation: {$operation}, error: {$error_message}";
    $additional = [
        'db' => $database,
        'operation' => $operation
    ];
    logError($message, 'backup_error', 6, $additional);
}

// Функция логирования ошибок подключения к БД
function logDbConnectionError($host, $user, $error_message) {
    $message = "Database connection error - host: {$host}, user: {$user}, error: {$error_message}";
    $additional = [
        'dbHost' => $host,
        'dbUser' => $user
    ];
    logError($message, 'db_connection_error', 8, $additional);
}

// Функция логирования успешных действий
function logSuccess($action, $details = '') {
    $message = "Success - action: {$action}, details: {$details}";
    logError($message, 'success', 3, ['act' => $action]);
}

// Загрузка токенов
function loadTokens($tokensFile) {
    if (file_exists($tokensFile)) {
        $tokens = json_decode(file_get_contents($tokensFile), true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $tokens;
        }
    }
    return [];
}

// Сохранение токенов
function saveTokens($tokens, $tokensFile) {
    return file_put_contents($tokensFile, json_encode($tokens, JSON_PRETTY_PRINT));
}

// Создание или загрузка конфигурации
if (file_exists($configFile)) {
    $config = json_decode(file_get_contents($configFile), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $config = $defaultConfig;
    }
    // Добавляем отсутствующие ключи
    $config = array_merge($defaultConfig, $config);
} else {
    $config = $defaultConfig;
}

// Загрузка токенов
$tokens = loadTokens($tokensFile);

// Если токенов нет, создаем первый
if (empty($tokens)) {
    $tokens['default'] = [
        'token' => bin2hex(random_bytes(32)),
        'name' => 'Основной токен',
        'enabled' => true,
        'created_at' => date('Y-m-d H:i:s'),
        'last_used' => null,
        'usage_count' => 0
    ];
    saveTokens($tokens, $tokensFile);
}

// Сохранение конфигурации
function saveConfig($config, $configFile) {
    return file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT));
}

// Проверка активных токенов
function hasActiveTokens($tokens) {
    foreach ($tokens as $tokenData) {
        if ($tokenData['enabled']) {
            return true;
        }
    }
    return false;
}

// Проверка доступности API
$apiEnabled = $config['api_enabled'] && hasActiveTokens($tokens);

// Локализация
$translations = [
    'en' => [
        'title' => 'DDA MySQL Backup System',
        'subtitle' => 'MySQL database backups. Configuration, management and API access',
        'dashboard' => 'Dashboard',
        'backups' => 'Backups',
        'tokens' => 'Tokens',
        'api' => 'API',
        'settings' => 'Settings',
        'available_databases' => 'Available databases',
        'total_backup_size' => 'Total backup size',
        'total_backup_files' => 'Total backup files',
        'retention_days' => 'Retention period (days)',
        'mysql_server' => 'MySQL Server',
        'quick_actions' => 'Quick Actions',
        'create_backup' => 'Create backup',
        'cleanup_old' => 'Cleanup old',
        'view_backups' => 'View backups',
        'manage_tokens' => 'Manage tokens',
        'system_status' => 'System Status',
        'backup_directory' => 'Backup directory',
        'backup_structure' => 'Backup structure',
        'api_access' => 'API Access',
        'console_run' => 'Console run',
        'backup_history' => 'Backup History',
        'new_backup' => 'New backup',
        'date' => 'Date',
        'files' => 'Files',
        'total_size' => 'Total size',
        'path' => 'Path',
        'actions' => 'Actions',
        'delete' => 'Delete',
        'no_backups_found' => 'No backups found',
        'api_tokens_management' => 'API Tokens Management',
        'add_new_token' => 'Add new token',
        'token_name' => 'Token name',
        'add' => 'Add',
        'active' => 'Active',
        'inactive' => 'Inactive',
        'created' => 'Created',
        'used' => 'Used',
        'last_used' => 'Last used',
        'disable' => 'Disable',
        'enable' => 'Enable',
        'api_documentation' => 'API Documentation',
        'system_settings' => 'System Settings',
        'test_connection' => 'Test connection',
        'mysql_host' => 'MySQL Host',
        'mysql_user' => 'MySQL User',
        'mysql_password' => 'MySQL Password',
        'backup_dir' => 'Backup directory',
        'backup_subdir' => 'Subfolder name after date',
        'backup_folder_structure' => 'Backup folder structure',
        'select_databases' => 'Select databases for backup',
        'select_all' => 'Select all',
        'deselect_all' => 'Deselect all',
        'access_settings' => 'Access Settings',
        'allow_console_access' => 'Allow console access',
        'allow_web_access' => 'Allow web access',
        'require_authentication' => 'Require authentication',
        'write_error_log' => 'Write error log to current folder',
        'date_format_settings' => 'Date Format Settings',
        'date_format' => 'Date format',
        'language_settings' => 'Language Settings',
        'language' => 'Language',
        'save_settings' => 'Save settings',
        'test_connection_result' => 'Test connection result',
        'close' => 'Close',
        'success' => 'Success',
        'error' => 'Error',
        'connection_successful' => '✅ Connection successfully established',
        'connection_failed' => '❌ Connection failed',
        'login_required' => 'Login required',
        'login_to_system' => 'Login to access the system',
        'login' => 'Login',
        'password' => 'Password',
        'sign_in' => 'Sign In',
        'invalid_credentials' => 'Invalid login or password',
        'version' => 'Version',
        'developed_by' => '',
        'not_specified' => 'Not specified',
        'both' => 'Both',
        'console_only' => 'Console only',
        'web_only' => 'Web only',
        'none' => 'None',
        'confirm' => 'Confirm',
        'method' => 'Method',
        'dates' => 'Dates (comma separated)',
        'database' => 'Database name',
        'json_required' => 'JSON required in request body',
        'console_access' => 'Run backups from command line',
        'web_access' => 'Access web interface',
        'auth_access' => 'Require login for web access',
        'error_logging' => 'Log errors to file',
        'access_mode' => 'Access mode',
        'structure_explanation' => 'Date folder / Backup subfolder / Database files',
        'cron_examples' => 'Cron Examples',
        'cron_example_1' => 'Daily backup at 2 AM using API',
        'cron_example_2' => 'Daily backup at 3 AM using console',
        'cron_example_3' => 'Specific database backup at 4 AM',
        'test_connection_info' => 'Test MySQL connection with current credentials',
        'logout' => 'Logout',
        'exit' => 'Exit',
        'backup_to_current_dir' => 'Backup to current folder',
        'backup_to_current_dir_help' => 'Create backups in the current folder instead of the specified backup directory',
        'backup_count' => 'Backup count',
        'creating_backup' => 'Creating backup...',
        'backup_created_success' => 'Backup successfully created',
        'pagination_settings' => 'Pagination Settings',
        'pagination_limit' => 'Items per page',
        'page' => 'Page',
        'of' => 'of',
        'previous' => 'Previous',
        'next' => 'Next',
        'first' => 'First',
        'last' => 'Last',
        'no_active_tokens' => 'No active tokens. API functionality is disabled.',
        'enable_at_least_one_token' => 'Enable at least one token to use API functionality.',
        'api_disabled_no_tokens' => 'API is disabled because there are no active tokens.',
        'api_disabled_in_settings' => 'API is disabled in system settings.'
    ],
    'ru' => [
        'title' => 'DDA MySQL Backup System',
        'subtitle' => 'Создание бэкапов баз данных MySQL. Настройка, управление и API доступ',
        'dashboard' => 'Дашборд',
        'backups' => 'Бэкапы',
        'tokens' => 'Токены',
        'api' => 'API',
        'settings' => 'Настройки',
        'available_databases' => 'Доступных баз данных',
        'total_backup_size' => 'Общий размер бэкапов',
        'total_backup_files' => 'Всего файлов бэкапов',
        'retention_days' => 'Срок хранения (дней)',
        'mysql_server' => 'Сервер MySQL',
        'quick_actions' => 'Быстрые действия',
        'create_backup' => 'Создать бэкап',
        'cleanup_old' => 'Очистить старые',
        'view_backups' => 'Просмотреть бэкапы',
        'manage_tokens' => 'Управление токенами',
        'system_status' => 'Состояние системы',
        'backup_directory' => 'Директория для бэкапов',
        'backup_structure' => 'Структура папок бэкапа',
        'api_access' => 'API доступ',
        'console_run' => 'Запуск из консоли',
        'backup_history' => 'История бэкапов',
        'new_backup' => 'Новый бэкап',
        'date' => 'Дата',
        'files' => 'Файлов',
        'total_size' => 'Общий размер',
        'path' => 'Путь',
        'actions' => 'Действия',
        'delete' => 'Удалить',
        'no_backups_found' => 'Бэкапы не найдены',
        'api_tokens_management' => 'Управление API токенами',
        'add_new_token' => 'Добавить новый токен',
        'token_name' => 'Имя токена',
        'add' => 'Добавить',
        'active' => 'Активен',
        'inactive' => 'Неактивен',
        'created' => 'Создан',
        'used' => 'Использован',
        'last_used' => 'Последнее использование',
        'disable' => 'Отключить',
        'enable' => 'Включить',
        'api_documentation' => 'Документация API',
        'system_settings' => 'Настройки системы',
        'test_connection' => 'Тест подключения',
        'mysql_host' => 'Хост MySQL',
        'mysql_user' => 'Пользователь MySQL',
        'mysql_password' => 'Пароль MySQL',
        'backup_dir' => 'Директория хранения бэкапов',
        'backup_subdir' => 'Название подпапки после даты',
        'backup_folder_structure' => 'Структура папок бэкапа',
        'select_databases' => 'Выбор баз данных для бэкапа',
        'select_all' => 'Выделить все',
        'deselect_all' => 'Снять выделение',
        'access_settings' => 'Настройки доступа',
        'allow_console_access' => 'Разрешить доступ из консоли',
        'allow_web_access' => 'Разрешить веб доступ',
        'require_authentication' => 'Запрашивать авторизацию',
        'write_error_log' => 'Писать лог ошибок в текущую папку',
        'date_format_settings' => 'Настройки формата даты',
        'date_format' => 'Формат даты',
        'language_settings' => 'Настройки языка',
        'language' => 'Язык',
        'save_settings' => 'Сохранить настройки',
        'test_connection_result' => 'Результат теста подключения',
        'close' => 'Закрыть',
        'success' => 'Успешно',
        'error' => 'Ошибка',
        'connection_successful' => '✅ Подключение успешно установлено',
        'connection_failed' => '❌ Ошибка подключения',
        'login_required' => 'Требуется авторизация',
        'login_to_system' => 'Для доступа к системе требуется авторизация',
        'login' => 'Логин',
        'password' => 'Пароль',
        'sign_in' => 'Войти',
        'invalid_credentials' => 'Неверный логин или пароль',
        'version' => 'Версия',
        'developed_by' => '',
        'not_specified' => 'Не указан',
        'both' => 'Оба',
        'console_only' => 'Только консоль',
        'web_only' => 'Только веб',
        'none' => 'Нет',
        'confirm' => 'Подтвердить',
        'method' => 'Метод',
        'dates' => 'Даты (через запятую)',
        'database' => 'Имя базы данных',
        'json_required' => 'Требуется JSON в теле запроса',
        'console_access' => 'Запуск бэкапов из командной строки',
        'web_access' => 'Доступ к веб-интерфейсу',
        'auth_access' => 'Требовать авторизацию для доступа',
        'error_logging' => 'Записывать ошибки в файл',
        'access_mode' => 'Режим доступа',
        'structure_explanation' => 'Папка с датой / Подпапка с бэкапами / Файлы баз данных',
        'cron_examples' => 'Примеры для Cron',
        'cron_example_1' => 'Ежедневный бэкап в 2:00 через API',
        'cron_example_2' => 'Ежедневный бэкап в 3:00 через консоль',
        'cron_example_3' => 'Бэкап конкретной БД в 4:00',
        'test_connection_info' => 'Проверить подключение к MySQL с текущими учетными данными',
        'logout' => 'Выход',
        'exit' => 'Выход',
        'backup_to_current_dir' => 'В текущую папку',
        'backup_to_current_dir_help' => 'Создавать бэкапы в текущую папку вместо указанной директории',
        'backup_count' => 'Кол-во бэкапов',
        'creating_backup' => 'Создание бэкапа...',
        'backup_created_success' => 'Бэкап успешно создан',
        'pagination_settings' => 'Настройки пагинации',
        'pagination_limit' => 'Элементов на странице',
        'page' => 'Страница',
        'of' => 'из',
        'previous' => 'Назад',
        'next' => 'Вперед',
        'first' => 'Первая',
        'last' => 'Последняя',
        'no_active_tokens' => 'Нет активных токенов. Функциональность API отключена.',
        'enable_at_least_one_token' => 'Включите хотя бы один токен для использования API.',
        'api_disabled_no_tokens' => 'API отключен, так как нет активных токенов.',
        'api_disabled_in_settings' => 'API отключен в настройках системы.'
    ],
    'cn' => [
        'title' => 'MySQL 备份系统',
        'subtitle' => 'MySQL 数据库备份。配置、管理和 API 访问',
        'dashboard' => '仪表板',
        'backups' => '备份',
        'tokens' => '令牌',
        'api' => 'API',
        'settings' => '设置',
        'available_databases' => '可用数据库',
        'total_backup_size' => '总备份大小',
        'total_backup_files' => '总备份文件',
        'retention_days' => '保留期限 (天数)',
        'mysql_server' => 'MySQL 服务器',
        'quick_actions' => '快速操作',
        'create_backup' => '创建备份',
        'cleanup_old' => '清理旧文件',
        'view_backups' => '查看备份',
        'manage_tokens' => '管理令牌',
        'system_status' => '系统状态',
        'backup_directory' => '备份目录',
        'backup_structure' => '备份结构',
        'api_access' => 'API 访问',
        'console_run' => '控制台运行',
        'backup_history' => '备份历史',
        'new_backup' => '新建备份',
        'date' => '日期',
        'files' => '文件',
        'total_size' => '总大小',
        'path' => '路径',
        'actions' => '操作',
        'delete' => '删除',
        'no_backups_found' => '未找到备份',
        'api_tokens_management' => 'API 令牌管理',
        'add_new_token' => '添加新令牌',
        'token_name' => '令牌名称',
        'add' => '添加',
        'active' => '激活',
        'inactive' => '未激活',
        'created' => '创建时间',
        'used' => '使用次数',
        'last_used' => '最后使用',
        'disable' => '禁用',
        'enable' => '启用',
        'api_documentation' => 'API 文档',
        'system_settings' => '系统设置',
        'test_connection' => '测试连接',
        'mysql_host' => 'MySQL 主机',
        'mysql_user' => 'MySQL 用户',
        'mysql_password' => 'MySQL 密码',
        'backup_dir' => '备份目录',
        'backup_subdir' => '日期后子文件夹名称',
        'backup_folder_structure' => '备份文件夹结构',
        'select_databases' => '选择要备份的数据库',
        'select_all' => '全选',
        'deselect_all' => '取消全选',
        'access_settings' => '访问设置',
        'allow_console_access' => '允许控制台访问',
        'allow_web_access' => '允许网页访问',
        'require_authentication' => '需要身份验证',
        'write_error_log' => '将错误日志写入当前文件夹',
        'date_format_settings' => '日期格式设置',
        'date_format' => '日期格式',
        'language_settings' => '语言设置',
        'language' => '语言',
        'save_settings' => '保存设置',
        'test_connection_result' => '连接测试结果',
        'close' => '关闭',
        'success' => '成功',
        'error' => '错误',
        'connection_successful' => '✅ 连接成功建立',
        'connection_failed' => '❌ 连接失败',
        'login_required' => '需要登录',
        'login_to_system' => '登录以访问系统',
        'login' => '登录',
        'password' => '密码',
        'sign_in' => '登录',
        'invalid_credentials' => '用户名或密码错误',
        'version' => '版本',
        'developed_by' => '',
        'not_specified' => '未指定',
        'both' => '两者',
        'console_only' => '仅控制台',
        'web_only' => '仅网页',
        'none' => '无',
        'confirm' => '确认',
        'method' => '方法',
        'dates' => '日期（逗号分隔）',
        'database' => '数据库名称',
        'json_required' => '请求体中需要 JSON',
        'console_access' => '从命令行运行备份',
        'web_access' => '访问网页界面',
        'auth_access' => '需要登录才能访问',
        'error_logging' => '将错误记录到文件',
        'access_mode' => '访问模式',
        'structure_explanation' => '日期文件夹 / 备份子文件夹 / 数据库文件',
        'cron_examples' => 'Cron 示例',
        'cron_example_1' => '每天 2:00 通过 API 备份',
        'cron_example_2' => '每天 3:00 通过控制台备份',
        'cron_example_3' => '每天 4:00 备份特定数据库',
        'test_connection_info' => '使用当前凭据测试 MySQL 连接',
        'logout' => '退出',
        'exit' => '退出',
        'backup_to_current_dir' => '备份到当前文件夹',
        'backup_to_current_dir_help' => '在当前文件夹中创建备份而不是指定的备份目录',
        'backup_count' => '备份数量',
        'creating_backup' => '正在创建备份...',
        'backup_created_success' => '备份创建成功',
        'pagination_settings' => '分页设置',
        'pagination_limit' => '每页项目数',
        'page' => '页面',
        'of' => '的',
        'previous' => '上一页',
        'next' => '下一页',
        'first' => '第一页',
        'last' => '最后一页',
        'no_active_tokens' => '没有活动的令牌。API功能已禁用。',
        'enable_at_least_one_token' => '启用至少一个令牌以使用API功能。',
        'api_disabled_no_tokens' => 'API已禁用，因为没有活动的令牌。',
        'api_disabled_in_settings' => 'API已在系统设置中禁用。'
    ]
];

// Получаем текущий язык
$current_lang = $config['language'] ?? 'en';
$t = $translations[$current_lang] ?? $translations['en'];

// Проверка авторизации (только для веб-интерфейса)
function checkAuth() {
    global $auth_config, $config;
    
    if (!$config['enable_auth']) {
        return true; // Авторизация отключена
    }
    
    session_start();
    
    // Проверяем активность сессии
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $auth_config['session_timeout'])) {
        session_unset();
        session_destroy();
        return false;
    }
    
    $_SESSION['last_activity'] = time();
    
    // Если уже авторизован
    if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
        return true;
    }
    
    // Проверка отправленных данных
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if ($username === $auth_config['username'] && $password === $auth_config['password']) {
            $_SESSION['authenticated'] = true;
            $_SESSION['last_activity'] = time();
            logSuccess('login_success', "User: {$username}");
            return true;
        } else {
            // Логируем неудачную попытку авторизации
            $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
            $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
            logFailedAuth($username, $ip, $user_agent);
        }
    }
    
    return false;
}

/**
 * Тест подключения к БД
 */
function testDbConnection($config) {
    // Проверяем заполненность полей
    if (empty($config['db_host']) || empty($config['db_user']) || empty($config['db_pass'])) {
        $error_msg = '❌ Не заполнены параметры подключения: хост, пользователь или пароль';
        logDbConnectionError($config['db_host'], $config['db_user'], 'Empty connection parameters');
        return [
            'success' => false,
            'message' => $error_msg
        ];
    }
    
    // Пытаемся получить список баз данных для проверки подключения
    $command = "mysql -u {$config['db_user']} -p'{$config['db_pass']}' -h {$config['db_host']} -e 'SHOW DATABASES' -s --skip-column-names 2>&1";
    
    $output = [];
    $return_var = 0;
    exec($command, $output, $return_var);
    
    // Фильтруем предупреждение о пароле
    $filtered_output = array_filter($output, function($line) {
        return strpos($line, 'Using a password on the command line interface can be insecure') === false;
    });
    
    if ($return_var === 0) {
        // Проверяем, что получили ответ от сервера
        $databases = array_filter($filtered_output, function($db) {
            $db = trim($db);
            return !empty($db) && strpos($db, 'ERROR') === false;
        });
        
        $db_count = count($databases);
        
        if ($db_count > 0) {
            logSuccess('db_connection_test', "Host: {$config['db_host']}, Databases found: {$db_count}");
            return [
                'success' => true,
                'message' => "✅ Подключение успешно установлено\n✅ Найдено баз данных: $db_count\n" . implode("\n", array_slice($databases, 0, 10))
            ];
        } else {
            // Если соединение установлено, но баз данных нет (возможно нет прав)
            logSuccess('db_connection_test', "Host: {$config['db_host']}, Connection successful but no databases found");
            return [
                'success' => true,
                'message' => "✅ Подключение успешно установлено\nℹ️ Базы данных не найдены или нет прав на их просмотр"
            ];
        }
    } else {
        $error_message = implode("\n", $filtered_output);
        logDbConnectionError($config['db_host'], $config['db_user'], $error_message);
        return [
            'success' => false,
            'message' => '❌ Ошибка подключения: ' . $error_message
        ];
    }
}

/**
 * Основная функция бэкапа
 */
function runBackup($config, $specific_database = null) {
    $temp_files = []; // Для отслеживания временных файлов
    
    try {
        // Проверяем заполненность полей подключения
        if (empty($config['db_host']) || empty($config['db_user']) || empty($config['db_pass'])) {
            $error_msg = "Не заполнены параметры подключения к БД";
            logBackupError('all', $error_msg, 'connection');
            throw new Exception($error_msg);
        }
        
        // Получаем список всех баз данных
        $all_databases = getAllDatabases($config);
        
        if (empty($all_databases)) {
            $error_msg = "Не найдено баз данных для бэкапа";
            logBackupError('all', $error_msg, 'no_databases');
            throw new Exception($error_msg);
        }
        
        // Если выбраны конкретные базы - фильтруем
        $databases_to_backup = $all_databases;
        if (!empty($config['selected_dbs'])) {
            $databases_to_backup = array_intersect($all_databases, $config['selected_dbs']);
        }
        
        // Исключаем системные базы (включая mysql)
        $databases_to_backup = array_filter($databases_to_backup, function($db) use ($config) {
            return !in_array($db, $config['exclude_dbs']);
        });
        
        // Если указана конкретная база
        if ($specific_database) {
            if (!in_array($specific_database, $databases_to_backup)) {
                $error_msg = "База данных '{$specific_database}' не найдена или исключена из бэкапа";
                logBackupError($specific_database, $error_msg, 'database_not_found');
                throw new Exception($error_msg);
            }
            $databases_to_backup = [$specific_database];
        }
        
        if (empty($databases_to_backup)) {
            $error_msg = "Нет баз данных для бэкапа после применения фильтров";
            logBackupError('all', $error_msg, 'filtered_no_databases');
            throw new Exception($error_msg);
        }
        
        $output = "Найдено баз данных: " . count($all_databases) . "\n";
        $output .= "Будет создано бэкапов: " . count($databases_to_backup) . "\n";
        
        // Определяем базовую директорию для бэкапа
        $base_backup_dir = $config['backup_to_current_dir'] ? __DIR__ : $config['backup_dir'];
        
        // Создаем структуру папок: base_backup_dir/текущая_дата/backup_subdir/
        $current_date = date($config['date_format']);
        $backup_subdir = !empty($config['backup_subdir']) ? $config['backup_subdir'] : 'BD';
        $backup_dir = rtrim($base_backup_dir, '/') . '/' . $current_date . '/' . $backup_subdir . '/';
        
        if (!createDirectories($backup_dir)) {
            $error_msg = "Не удалось создать директории для бэкапа";
            logBackupError('all', $error_msg, 'directory_creation');
            throw new Exception($error_msg);
        }
        
        $output .= "Директория для бэкапа: $backup_dir\n";
        $output .= "Базовый каталог: " . ($config['backup_to_current_dir'] ? "Текущая папка" : $config['backup_dir']) . "\n";
        
        // Очистка старых бэкапов (только если не в текущей папке)
        $cleaned = [];
        if (!$config['backup_to_current_dir']) {
            $cleaned = cleanupOldBackups($config['backup_dir'], $config['retention_days'], $config['date_format']);
            if (!empty($cleaned)) {
                $output .= "Удалены старые бэкапы: " . implode(', ', $cleaned) . "\n";
                logSuccess('cleanup_old_backups', "Cleaned: " . implode(', ', $cleaned));
            }
        } else {
            $output .= "Очистка старых бэкапов отключена (работа в текущей папке)\n";
        }
        
        // Делаем бэкап каждой базы
        $success_count = 0;
        $backup_details = [];
        
        foreach ($databases_to_backup as $database) {
            $result = backupDatabase($database, $backup_dir, $config);
            $output .= $result['message'] . "\n";
            if ($result['success']) {
                $success_count++;
                $backup_details[] = $result;
                // Добавляем временные файлы для удаления
                if (isset($result['temp_file']) && file_exists($result['temp_file'])) {
                    $temp_files[] = $result['temp_file'];
                }
            } else {
                logBackupError($database, $result['message'], 'backup_failed');
            }
        }
        
        $output .= "Успешно создано бэкапов: $success_count из " . count($databases_to_backup) . "\n";
        
        // Удаляем временные файлы
        foreach ($temp_files as $temp_file) {
            if (file_exists($temp_file) && !@unlink($temp_file)) {
                $output .= "Предупреждение: Не удалось удалить временный файл: $temp_file\n";
                logError("Failed to delete temp file: {$temp_file}", 'temp_file_error', 4);
            }
        }
        
        if ($success_count > 0) {
            logSuccess('backup_completed', "Databases: {$success_count}/" . count($databases_to_backup) . ", Path: {$backup_dir}, Current folder: " . ($config['backup_to_current_dir'] ? 'yes' : 'no'));
        }
        
        return [
            'success' => true,
            'message' => $output,
            'backup_dir' => $backup_dir,
            'backup_base_dir' => $base_backup_dir,
            'backup_to_current_dir' => $config['backup_to_current_dir'],
            'total_databases' => count($all_databases),
            'backup_databases' => count($databases_to_backup),
            'successful_backups' => $success_count,
            'date' => $current_date,
            'cleaned' => $cleaned,
            'details' => $backup_details
        ];
        
    } catch (Exception $e) {
        // Удаляем временные файлы в случае ошибки
        foreach ($temp_files as $temp_file) {
            if (file_exists($temp_file)) {
                @unlink($temp_file);
            }
        }
        
        $error_msg = "❌ Ошибка: " . $e->getMessage() . "\n";
        logError($error_msg, 'backup_fatal_error', 9, ['exception' => $e->getMessage()]);
        
        return [
            'success' => false,
            'message' => $error_msg,
            'error' => $e->getMessage()
        ];
    }
}

/**
 * Получает список всех баз данных
 */
function getAllDatabases($config) {
    // Проверяем заполненность полей
    if (empty($config['db_host']) || empty($config['db_user']) || empty($config['db_pass'])) {
        throw new Exception("Не заполнены параметры подключения к БД");
    }
    
    // Используем env для безопасной передачи пароля
    putenv("MYSQL_PWD={$config['db_pass']}");
    $command = "mysql -u {$config['db_user']} -h {$config['db_host']} -e 'SHOW DATABASES' -s --skip-column-names";
    
    $output = [];
    $return_var = 0;
    exec($command . ' 2>&1', $output, $return_var);
    
    // Очищаем env переменную
    putenv("MYSQL_PWD=");
    
    if ($return_var !== 0) {
        // Фильтруем предупреждение о пароле из вывода
        $filtered_output = array_filter($output, function($line) {
            return strpos($line, 'Using a password on the command line interface can be insecure') === false;
        });
        $error_msg = "Ошибка подключения к MySQL: " . implode("\n", $filtered_output);
        logDbConnectionError($config['db_host'], $config['db_user'], $error_msg);
        throw new Exception($error_msg);
    }
    
    // Возвращаем все базы, исключая предупреждение о пароле
    $databases = array_filter($output, function($db) {
        $db = trim($db);
        return !empty($db) && strpos($db, 'Using a password') === false;
    });
    
    return array_values($databases);
}

/**
 * Создает бэкап одной базы данных
 */
function backupDatabase($database, $backup_dir, $config) {
    $timestamp = date('H-i-s');
    $backup_file = $backup_dir . $database . '_' . $timestamp . '.sql';
    
    $message = "Бэкап базы: $database... ";
    
    // Создаем временный файл для дампа
    $temp_file = $backup_dir . 'temp_' . $database . '_' . $timestamp . '.sql';
    
    // Используем env для безопасной передачи пароля
    putenv("MYSQL_PWD={$config['db_pass']}");
    
    // Команда mysqldump с основными опциями
    $command = "mysqldump -u {$config['db_user']} -h {$config['db_host']} " .
               "--single-transaction --routines --triggers --events " .
               "--add-drop-database --databases {$database} > {$temp_file} 2>&1";
    
    $output = [];
    $return_var = 0;
    exec($command, $output, $return_var);
    
    // Очищаем env переменную
    putenv("MYSQL_PWD=");
    
    // Фильтруем предупреждение о пароле
    $filtered_output = array_filter($output, function($line) {
        return strpos($line, 'Using a password on the command line interface can be insecure') === false;
    });
    
    if ($return_var !== 0) {
        $error_message = implode("\n  -> ", $filtered_output);
        $message .= "❌ ОШИБКА\n  -> " . $error_message;
        
        // Удаляем временный файл если он создался
        if (file_exists($temp_file)) {
            unlink($temp_file);
        }
        
        logBackupError($database, $error_message, 'mysqldump_failed');
        
        return [
            'success' => false,
            'message' => $message,
            'database' => $database
        ];
    }
    
    // Проверяем что временный файл создан и не пустой
    if (file_exists($temp_file) && filesize($temp_file) > 0) {
        $file_size = filesize($temp_file);
        $formatted_size = formatFileSize($file_size);
        
        // Перемещаем временный файл в финальный
        if (rename($temp_file, $backup_file)) {
            // Сжимаем файл
            if (compressFile($backup_file)) {
                $compressed_size = file_exists($backup_file . '.gz') ? filesize($backup_file . '.gz') : 0;
                $message .= "✅ OK ({$formatted_size} -> " . formatFileSize($compressed_size) . ")";
                $final_size = $compressed_size;
                $final_file = $backup_file . '.gz';
            } else {
                $message .= "✅ OK ({$formatted_size})";
                $final_size = $file_size;
                $final_file = $backup_file;
            }
            
            return [
                'success' => true,
                'message' => $message,
                'database' => $database,
                'file' => $final_file,
                'size' => $final_size,
                'formatted_size' => formatFileSize($final_size),
                'temp_file' => $temp_file // Для последующего удаления
            ];
        } else {
            $message .= "❌ ОШИБКА: не удалось переместить файл";
            // Удаляем временный файл
            if (file_exists($temp_file)) {
                unlink($temp_file);
            }
            logBackupError($database, 'Failed to move temp file', 'file_move_failed');
            return [
                'success' => false,
                'message' => $message,
                'database' => $database,
                'temp_file' => $temp_file
            ];
        }
    } else {
        $message .= "❌ ОШИБКА: файл не создан или пустой";
        // Удаляем временный файл
        if (file_exists($temp_file)) {
            unlink($temp_file);
        }
        logBackupError($database, 'Temp file empty or not created', 'file_creation_failed');
        return [
            'success' => false,
            'message' => $message,
            'database' => $database,
            'temp_file' => $temp_file
        ];
    }
}

/**
 * Сжимает файл используя gzip
 */
function compressFile($file_path) {
    if (file_exists($file_path)) {
        $command = "gzip -9 {$file_path}";
        exec($command, $output, $return_var);
        
        return $return_var === 0;
    }
    return false;
}

/**
 * Создает необходимые директории
 */
function createDirectories($path) {
    if (!file_exists($path)) {
        if (!mkdir($path, 0755, true)) {
            error_log("Ошибка: Не удалось создать директорию: $path");
            logError("Ошибка: Не удалось создать директорию: $path", 'directory_creation_error', 6);
            return false;
        }
    }
    
    if (!is_writable($path)) {
        error_log("Ошибка: Нет прав на запись в директорию: $path");
        logError("Ошибка: Нет прав на запись в директорию: $path", 'directory_permission_error', 6);
        return false;
    }
    
    return true;
}

/**
 * Очистка старых бэкапов
 */
function cleanupOldBackups($backup_dir, $retention_days, $date_format = 'Y-m-d') {
    if (!is_dir($backup_dir)) {
        return [];
    }
    
    $deleted = [];
    $items = scandir($backup_dir);
    $current_time = time();
    
    foreach ($items as $item) {
        if ($item == '.' || $item == '..') continue;
        
        $item_path = $backup_dir . '/' . $item;
        
        if (is_dir($item_path)) {
            // Пробуем распарсить дату из имени папки согласно формату
            $date = DateTime::createFromFormat($date_format, $item);
            if ($date) {
                $item_time = $date->getTimestamp();
                $age_in_days = ($current_time - $item_time) / (60 * 60 * 24);
                
                if ($age_in_days > $retention_days) {
                    if (deleteDirectory($item_path)) {
                        $deleted[] = $item;
                    } else {
                        logError("Failed to delete old backup: {$item}", 'backup_cleanup_error', 5);
                    }
                }
            }
        }
    }
    
    return $deleted;
}

/**
 * Удаление директории с бэкапом
 */
function deleteBackup($backup_dir, $backup_name, $date_format = 'Y-m-d') {
    $backup_path = rtrim($backup_dir, '/') . '/' . $backup_name;
    
    if (!is_dir($backup_path)) {
        logError("Backup directory not found: {$backup_name}", 'backup_delete_error', 5);
        return false;
    }
    
    // Проверяем что имя папки соответствует формату даты
    $date = DateTime::createFromFormat($date_format, $backup_name);
    if (!$date) {
        logError("Invalid date format for backup: {$backup_name}", 'backup_delete_error', 5);
        return false;
    }
    
    return deleteDirectory($backup_path);
}

/**
 * Удаление выбранных бэкапов
 */
function deleteSelectedBackups($backup_dir, $backup_names, $date_format = 'Y-m-d') {
    $deleted = [];
    $errors = [];
    
    foreach ($backup_names as $backup_name) {
        if (deleteBackup($backup_dir, $backup_name, $date_format)) {
            $deleted[] = $backup_name;
            logSuccess('backup_deleted', "Backup: {$backup_name}");
        } else {
            $errors[] = $backup_name;
            logError("Failed to delete backup: {$backup_name}", 'backup_delete_error', 6);
        }
    }
    
    return [
        'deleted' => $deleted,
        'errors' => $errors
    ];
}

/**
 * Удаление директории
 */
function deleteDirectory($dir) {
    if (!is_dir($dir)) return false;
    
    $items = scandir($dir);
    
    foreach ($items as $item) {
        if ($item == '.' || $item == '..') continue;
        
        $path = $dir . '/' . $item;
        
        if (is_dir($path)) {
            deleteDirectory($path);
        } else {
            unlink($path);
        }
    }
    
    return rmdir($dir);
}

/**
 * Получение списка существующих бэкапов с пагинацией
 */
function getExistingBackups($config, $page = 1, $perPage = 20) {
    $backups = [];
    
    // Определяем базовую директорию для поиска бэкапов
    $backup_dir = $config['backup_to_current_dir'] ? __DIR__ : $config['backup_dir'];
    
    if (!is_dir($backup_dir)) {
        return ['backups' => [], 'total' => 0, 'pages' => 0, 'current_page' => $page];
    }
    
    $dates = scandir($backup_dir);
    
    foreach ($dates as $date) {
        if ($date == '.' || $date == '..') continue;
        
        $date_path = rtrim($backup_dir, '/') . '/' . $date;
        if (is_dir($date_path)) {
            // Проверяем соответствует ли имя папки формату даты
            $parsed_date = DateTime::createFromFormat($config['date_format'], $date);
            if ($parsed_date) {
                $subdir_path = $date_path . '/' . $config['backup_subdir'] . '/';
                if (is_dir($subdir_path)) {
                    $files = scandir($subdir_path);
                    $backup_files = [];
                    $total_size = 0;
                    
                    foreach ($files as $file) {
                        if ($file == '.' || $file == '..') continue;
                        $file_path = $subdir_path . $file;
                        if (file_exists($file_path)) {
                            $file_size = filesize($file_path);
                            $total_size += $file_size;
                            $backup_files[] = [
                                'name' => $file,
                                'path' => $file_path,
                                'size' => $file_size,
                                'formatted_size' => formatFileSize($file_size),
                                'date' => $date
                            ];
                        }
                    }
                    
                    if (!empty($backup_files)) {
                        $backups[$date] = [
                            'date' => $date,
                            'path' => $subdir_path,
                            'files' => $backup_files,
                            'count' => count($backup_files),
                            'total_size' => $total_size,
                            'formatted_total_size' => formatFileSize($total_size)
                        ];
                    }
                }
            }
        }
    }
    
    // Сортировка по дате (новые сверху)
    uksort($backups, function($a, $b) use ($config) {
        $dateA = DateTime::createFromFormat($config['date_format'], $a);
        $dateB = DateTime::createFromFormat($config['date_format'], $b);
        return $dateB->getTimestamp() - $dateA->getTimestamp();
    });
    
    // Применяем пагинацию
    $total = count($backups);
    $pages = ceil($total / $perPage);
    $page = max(1, min($page, $pages));
    $offset = ($page - 1) * $perPage;
    $paginated_backups = array_slice($backups, $offset, $perPage, true);
    
    return [
        'backups' => $paginated_backups,
        'total' => $total,
        'pages' => $pages,
        'current_page' => $page,
        'per_page' => $perPage
    ];
}

/**
 * Получение количества дней с бэкапами
 */
function getBackupDaysCount($config) {
    $backup_dir = $config['backup_to_current_dir'] ? __DIR__ : $config['backup_dir'];
    
    if (!is_dir($backup_dir)) {
        return 0;
    }
    
    $dates = scandir($backup_dir);
    $count = 0;
    
    foreach ($dates as $date) {
        if ($date == '.' || $date == '..') continue;
        
        $date_path = rtrim($backup_dir, '/') . '/' . $date;
        if (is_dir($date_path)) {
            $parsed_date = DateTime::createFromFormat($config['date_format'], $date);
            if ($parsed_date) {
                $subdir_path = $date_path . '/' . $config['backup_subdir'] . '/';
                if (is_dir($subdir_path) && count(scandir($subdir_path)) > 2) {
                    $count++;
                }
            }
        }
    }
    
    return $count;
}

/**
 * Получение общего количества файлов бэкапов
 */
function getTotalBackupFiles($config) {
    $backups = getExistingBackups($config, 1, 1000); // Большое число чтобы получить все
    $total = 0;
    foreach ($backups['backups'] as $backup) {
        $total += $backup['count'];
    }
    return $total;
}

/**
 * Получение общего размера всех бэкапов
 */
function getTotalBackupSize($config) {
    $backups = getExistingBackups($config, 1, 1000); // Большое число чтобы получить все
    $total_size = 0;
    foreach ($backups['backups'] as $backup) {
        $total_size += $backup['total_size'];
    }
    return $total_size;
}

/**
 * Форматирует размер файла в читаемый вид
 */
function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' B';
    }
}

// API обработка запросов
if ($isApiRequest) {
    header('Content-Type: application/json');
    
    $response = ['status' => 'error', 'message' => ''];
    $client_ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    
    // Проверяем доступность API
    if (!$config['api_enabled']) {
        $response['message'] = $t['api_disabled_in_settings'];
        logApiError('api_disabled', 'no_token', 'API disabled in settings', $client_ip);
        echo json_encode($response, JSON_PRETTY_PRINT);
        exit;
    }
    
    // Проверяем наличие активных токенов
    if (!hasActiveTokens($tokens)) {
        $response['message'] = $t['api_disabled_no_tokens'];
        logApiError('api_disabled', 'no_token', 'No active tokens', $client_ip);
        echo json_encode($response, JSON_PRETTY_PRINT);
        exit;
    }
    
    $headers = getallheaders();
    $requestToken = $_GET['token'] ?? $headers['X-API-Token'] ?? null;
    
    // Проверка токена
    if (!$requestToken) {
        $response['message'] = 'Токен не предоставлен';
        logApiError('no_action', 'no_token', 'Token not provided', $client_ip);
        echo json_encode($response, JSON_PRETTY_PRINT);
        exit;
    }
    
    // Поиск токена
    $foundToken = null;
    $tokenName = null;
    foreach ($tokens as $name => $tokenData) {
        if ($tokenData['token'] === $requestToken && $tokenData['enabled']) {
            $foundToken = $tokenData;
            $tokenName = $name;
            break;
        }
    }
    
    if (!$foundToken) {
        $response['message'] = 'Неверный или отключенный токен';
        logApiError('auth', $requestToken, 'Invalid or disabled token', $client_ip);
        echo json_encode($response, JSON_PRETTY_PRINT);
        exit;
    }
    
    // Обновление статистики использования токена
    $tokens[$tokenName]['last_used'] = date('Y-m-d H:i:s');
    $tokens[$tokenName]['usage_count'] = ($tokens[$tokenName]['usage_count'] ?? 0) + 1;
    saveTokens($tokens, $tokensFile);
    
    $action = $_GET['action'] ?? '';
    $method = $_SERVER['REQUEST_METHOD'];
    
    switch ($action) {
        case 'test_connection':
            if ($method !== 'GET') {
                $response['message'] = 'Метод должен быть GET';
                logApiError($action, $requestToken, 'Invalid method', $client_ip);
                echo json_encode($response, JSON_PRETTY_PRINT);
                exit;
            }
            $result = testDbConnection($config);
            echo json_encode($result, JSON_PRETTY_PRINT);
            break;
            
        case 'create_backup':
            if ($method !== 'POST') {
                $response['message'] = 'Метод должен быть POST';
                logApiError($action, $requestToken, 'Invalid method', $client_ip);
                echo json_encode($response, JSON_PRETTY_PRINT);
                exit;
            }
            // Получаем конкретную базу данных из параметра
            $specific_database = $_GET['database'] ?? null;
            $result = runBackup($config, $specific_database);
            echo json_encode($result, JSON_PRETTY_PRINT);
            break;
            
        case 'list_backups':
            if ($method !== 'GET') {
                $response['message'] = 'Метод должен быть GET';
                logApiError($action, $requestToken, 'Invalid method', $client_ip);
                echo json_encode($response, JSON_PRETTY_PRINT);
                exit;
            }
            
            // Параметры пагинации
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : $config['pagination_limit'];
            $perPage = max(1, min($perPage, 100)); // Ограничение от 1 до 100
            
            $result = getExistingBackups($config, $page, $perPage);
            $response['status'] = 'success';
            $response['backups'] = $result['backups'];
            $response['pagination'] = [
                'total' => $result['total'],
                'pages' => $result['pages'],
                'current_page' => $result['current_page'],
                'per_page' => $result['per_page']
            ];
            logSuccess('api_list_backups', "Token: {$tokenName}, Page: {$page}, PerPage: {$perPage}");
            echo json_encode($response, JSON_PRETTY_PRINT);
            break;
            
        case 'delete_backup':
            if ($method !== 'DELETE') {
                $response['message'] = 'Метод должен быть DELETE';
                logApiError($action, $requestToken, 'Invalid method', $client_ip);
                echo json_encode($response, JSON_PRETTY_PRINT);
                exit;
            }
            $backupName = $_GET['name'] ?? '';
            if (empty($backupName)) {
                $response['message'] = 'Не указано имя бекапа';
                logApiError($action, $requestToken, 'Backup name not specified', $client_ip);
                echo json_encode($response, JSON_PRETTY_PRINT);
                exit;
            }
            
            // Определяем директорию для удаления бэкапа
            $backup_dir = $config['backup_to_current_dir'] ? __DIR__ : $config['backup_dir'];
            
            if (deleteBackup($backup_dir, $backupName, $config['date_format'])) {
                $response['status'] = 'success';
                $response['message'] = 'Бекап удален: ' . $backupName;
                logSuccess('api_backup_deleted', "Backup: {$backupName}, Token: {$tokenName}");
            } else {
                $response['message'] = 'Не удалось удалить бекап: ' . $backupName;
                logApiError($action, $requestToken, "Failed to delete backup: {$backupName}", $client_ip);
            }
            echo json_encode($response, JSON_PRETTY_PRINT);
            break;
            
        case 'delete_selected_backups':
            if ($method !== 'DELETE') {
                $response['message'] = 'Метод должен быть DELETE';
                logApiError($action, $requestToken, 'Invalid method', $client_ip);
                echo json_encode($response, JSON_PRETTY_PRINT);
                exit;
            }
            $backupNames = $_GET['names'] ?? '';
            if (empty($backupNames)) {
                $response['message'] = 'Не указаны имена бекапов';
                logApiError($action, $requestToken, 'Backup names not specified', $client_ip);
                echo json_encode($response, JSON_PRETTY_PRINT);
                exit;
            }
            
            $backupNames = explode(',', $backupNames);
            $backup_dir = $config['backup_to_current_dir'] ? __DIR__ : $config['backup_dir'];
            $result = deleteSelectedBackups($backup_dir, $backupNames, $config['date_format']);
            
            $response['status'] = 'success';
            $response['message'] = 'Операция завершена';
            $response['deleted'] = $result['deleted'];
            $response['errors'] = $result['errors'];
            echo json_encode($response, JSON_PRETTY_PRINT);
            break;
            
        case 'delete_all_backups':
            if ($method !== 'DELETE') {
                $response['message'] = 'Метод должен быть DELETE';
                logApiError($action, $requestToken, 'Invalid method', $client_ip);
                echo json_encode($response, JSON_PRETTY_PRINT);
                exit;
            }
            $backups = getExistingBackups($config, 1, 1000);
            $backupNames = array_keys($backups['backups']);
            $backup_dir = $config['backup_to_current_dir'] ? __DIR__ : $config['backup_dir'];
            $result = deleteSelectedBackups($backup_dir, $backupNames, $config['date_format']);
            
            $response['status'] = 'success';
            $response['message'] = 'Операция завершена';
            $response['deleted'] = $result['deleted'];
            $response['errors'] = $result['errors'];
            echo json_encode($response, JSON_PRETTY_PRINT);
            break;
            
        case 'system_info':
            if ($method !== 'GET') {
                $response['message'] = 'Метод должен быть GET';
                logApiError($action, $requestToken, 'Invalid method', $client_ip);
                echo json_encode($response, JSON_PRETTY_PRINT);
                exit;
            }
            
            try {
                $all_dbs = getAllDatabases($config);
                $total_databases = count($all_dbs);
            } catch (Exception $e) {
                $total_databases = 0;
            }
            
            $backups = getExistingBackups($config, 1, 1000);
            $total_size = getTotalBackupSize($config);
            $total_files = getTotalBackupFiles($config);
            $backup_days = getBackupDaysCount($config);
            
            $response['status'] = 'success';
            $response['info'] = [
                'total_databases' => $total_databases,
                'selected_databases' => $config['selected_dbs'],
                'excluded_databases' => $config['exclude_dbs'],
                'total_backups' => $total_files,
                'backup_days' => $backup_days,
                'total_size' => formatFileSize($total_size),
                'retention_days' => $config['retention_days'],
                'backup_dir' => $config['backup_dir'],
                'backup_subdir' => $config['backup_subdir'],
                'backup_to_current_dir' => $config['backup_to_current_dir'],
                'current_dir' => __DIR__,
                'backup_structure' => $config['backup_to_current_dir'] ? __DIR__ . '/' . date($config['date_format']) . '/' . $config['backup_subdir'] . '/' : $config['backup_dir'] . date($config['date_format']) . '/' . $config['backup_subdir'] . '/',
                'api_enabled' => $config['api_enabled'] && hasActiveTokens($tokens),
                'active_tokens' => hasActiveTokens($tokens),
                'pagination_limit' => $config['pagination_limit'],
                'config_file' => $configFile,
                'tokens_file' => $tokensFile,
                'enable_console' => $config['enable_console'],
                'enable_web' => $config['enable_web'],
                'enable_auth' => $config['enable_auth'],
                'enable_error_log' => $config['enable_error_log'],
                'date_format' => $config['date_format'],
                'language' => $config['language']
            ];
            logSuccess('api_system_info', "Token: {$tokenName}");
            echo json_encode($response, JSON_PRETTY_PRINT);
            break;
            
        case 'update_retention':
            if ($method !== 'PUT') {
                $response['message'] = 'Метод должен быть PUT';
                logApiError($action, $requestToken, 'Invalid method', $client_ip);
                echo json_encode($response, JSON_PRETTY_PRINT);
                exit;
            }
            $retention_days = $_GET['days'] ?? '';
            if (empty($retention_days) || !is_numeric($retention_days)) {
                $response['message'] = 'Неверное количество дней';
                logApiError($action, $requestToken, 'Invalid retention days', $client_ip);
                echo json_encode($response, JSON_PRETTY_PRINT);
                exit;
            }
            
            $config['retention_days'] = (int)$retention_days;
            if (saveConfig($config, $configFile)) {
                $response['status'] = 'success';
                $response['message'] = 'Срок хранения обновлен: ' . $retention_days . ' дней';
                logSuccess('api_update_retention', "Days: {$retention_days}, Token: {$tokenName}");
            } else {
                $response['message'] = 'Ошибка сохранения настроек';
                logApiError($action, $requestToken, 'Failed to save config', $client_ip);
            }
            echo json_encode($response, JSON_PRETTY_PRINT);
            break;
            
        case 'update_settings':
            if ($method !== 'PUT') {
                $response['message'] = 'Метод должен быть PUT';
                logApiError($action, $requestToken, 'Invalid method', $client_ip);
                echo json_encode($response, JSON_PRETTY_PRINT);
                exit;
            }
            
            $input = json_decode(file_get_contents('php://input'), true);
            if (!$input) {
                $response['message'] = 'Неверный JSON в теле запроса';
                logApiError($action, $requestToken, 'Invalid JSON in request body', $client_ip);
                echo json_encode($response, JSON_PRETTY_PRINT);
                exit;
            }
            
            // Обновляем только разрешенные поля
            $allowed_fields = ['db_user', 'db_pass', 'db_host', 'backup_dir', 'backup_subdir', 'selected_dbs', 'api_enabled', 'enable_console', 'enable_web', 'enable_auth', 'enable_error_log', 'date_format', 'language', 'backup_to_current_dir', 'pagination_limit'];
            foreach ($allowed_fields as $field) {
                if (isset($input[$field])) {
                    $config[$field] = $input[$field];
                }
            }
            
            if (saveConfig($config, $configFile)) {
                $response['status'] = 'success';
                $response['message'] = 'Настройки обновлены';
                logSuccess('api_update_settings', "Token: {$tokenName}, Fields: " . implode(',', array_keys($input)));
            } else {
                $response['message'] = 'Ошибка сохранения настроек';
                logApiError($action, $requestToken, 'Failed to save config', $client_ip);
            }
            echo json_encode($response, JSON_PRETTY_PRINT);
            break;
            
        default:
            $response['message'] = 'Неизвестное действие. Доступные: test_connection (GET), create_backup (POST), list_backups (GET), delete_backup (DELETE), delete_selected_backups (DELETE), delete_all_backups (DELETE), system_info (GET), update_retention (PUT), update_settings (PUT)';
            logApiError('unknown', $requestToken, 'Unknown action', $client_ip);
            echo json_encode($response, JSON_PRETTY_PRINT);
    }
    exit;
}

// Если запуск из консоли
if ($isCli) {
    // Проверяем доступность консольного режима
    if (!$config['enable_console']) {
        echo "❌ Консольный режим отключен в настройках\n";
        logError("Console mode disabled", 'console_access_denied', 7);
        exit(1);
    }
    
    // Проверяем аргументы командной строки
    $options = getopt("d:", ["database:"]);
    $specific_database = $options['d'] ?? $options['database'] ?? null;
    
    $result = runBackup($config, $specific_database);
    echo $result['message'];
    exit($result['success'] ? 0 : 1);
}

// Проверка доступа к веб-интерфейсу
if ($isWebRequest && !$config['enable_web']) {
    die("❌ Веб-доступ отключен в настройках");
}

// Проверка авторизации
if ($isWebRequest && $config['enable_auth'] && !checkAuth()) {
    // Показываем страницу авторизации
    ?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $t['login_required'] ?> - DDA MySQL Backup System</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            body {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                background: #ffffff;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
                overflow: hidden;
                position: relative;
            }
            
            /* Анимированный фон с кругами */
            .background {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 0;
                overflow: hidden;
            }
            
            .circle {
                position: absolute;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, rgba(102, 126, 234, 0.05) 70%, transparent 100%);
                animation: float 15s infinite ease-in-out;
                pointer-events: none;
            }
            
            .circle:nth-child(1) {
                width: 200px;
                height: 200px;
                top: 10%;
                left: 5%;
                background: radial-gradient(circle, rgba(102, 126, 234, 0.08) 0%, rgba(102, 126, 234, 0.03) 70%, transparent 100%);
                animation-delay: 0s;
            }
            
            .circle:nth-child(2) {
                width: 150px;
                height: 150px;
                top: 60%;
                left: 80%;
                background: radial-gradient(circle, rgba(118, 75, 162, 0.06) 0%, rgba(118, 75, 162, 0.02) 70%, transparent 100%);
                animation-delay: 2s;
                animation-duration: 18s;
            }
            
            .circle:nth-child(3) {
                width: 250px;
                height: 250px;
                top: 80%;
                left: 10%;
                background: radial-gradient(circle, rgba(52, 152, 219, 0.07) 0%, rgba(52, 152, 219, 0.02) 70%, transparent 100%);
                animation-delay: 4s;
                animation-duration: 20s;
            }
            
            .circle:nth-child(4) {
                width: 180px;
                height: 180px;
                top: 20%;
                left: 70%;
                background: radial-gradient(circle, rgba(231, 76, 60, 0.05) 0%, rgba(231, 76, 60, 0.01) 70%, transparent 100%);
                animation-delay: 6s;
                animation-duration: 17s;
            }
            
            .circle:nth-child(5) {
                width: 120px;
                height: 120px;
                top: 75%;
                left: 85%;
                background: radial-gradient(circle, rgba(46, 204, 113, 0.04) 0%, rgba(46, 204, 113, 0.01) 70%, transparent 100%);
                animation-delay: 8s;
                animation-duration: 16s;
            }
            
            @keyframes float {
                0%, 100% {
                    transform: translate(0, 0) scale(1);
                    opacity: 0.6;
                }
                25% {
                    transform: translate(20px, 30px) scale(1.1);
                    opacity: 0.8;
                }
                50% {
                    transform: translate(-15px, 20px) scale(0.9);
                    opacity: 0.4;
                }
                75% {
                    transform: translate(10px, -15px) scale(1.05);
                    opacity: 0.7;
                }
            }
            
            .login-container {
                background: white;
                border-radius: 12px;
                padding: 40px;
                width: 100%;
                max-width: 400px;
                box-shadow: 0 20px 40px rgba(0,0,0,0.1);
                position: relative;
                z-index: 1;
            }
            
            .login-header {
                text-align: center;
                margin-bottom: 30px;
            }
            
            .login-header h1 {
                color: #333;
                margin-bottom: 8px;
                font-size: 1.5rem;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
            }
            
            .login-header p {
                color: #666;
                font-size: 0.9rem;
            }
            
            .form-group {
                margin-bottom: 20px;
            }
            
            .form-group label {
                display: block;
                margin-bottom: 8px;
                font-weight: 500;
                color: #333;
                font-size: 0.95rem;
            }
            
            .form-control {
                width: 100%;
                padding: 12px 16px;
                border: 1px solid #ddd;
                border-radius: 6px;
                font-size: 0.95rem;
                transition: all 0.2s;
                background: white;
            }
            
            .form-control:focus {
                outline: none;
                border-color: #667eea;
                box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            }
            
            .btn {
                width: 100%;
                padding: 12px;
                border: none;
                border-radius: 6px;
                font-size: 0.95rem;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.2s;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                text-decoration: none;
            }
            
            .btn-primary {
                background: #667eea;
                color: white;
            }
            
            .btn-primary:hover {
                background: #5a67d8;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
            }
            
            .message {
                padding: 12px;
                border-radius: 6px;
                margin-bottom: 20px;
                display: flex;
                align-items: center;
                gap: 12px;
                animation: fadeIn 0.3s ease;
            }
            
            .message.error {
                background: #ffebee;
                color: #c62828;
                border: 1px solid #ffcdd2;
            }
            
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            .version {
                font-size: 0.8rem;
                color: #999;
                text-align: center;
                margin-top: 20px;
                padding-top: 20px;
                border-top: 1px solid #eee;
            }
        </style>
    </head>
    <body>
        <!-- Анимированный фон -->
        <div class="background">
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
            <div class="circle"></div>
        </div>
        
        <div class="login-container">
            <div class="login-header">
                <h1><i class="fas fa-database"></i> DDA MySQL Backup System</h1>
                <p><?= $t['login_to_system'] ?></p>
            </div>
            
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])): ?>
                <div class="message error">
                    <i class="fas fa-exclamation-circle"></i>
                    <div><?= $t['invalid_credentials'] ?></div>
                </div>
            <?php endif; ?>
            
            <form method="POST" id="loginForm">
                <div class="form-group">
                    <label for="username"><?= $t['login'] ?>:</label>
                    <input type="text" id="username" name="username" class="form-control" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="password"><?= $t['password'] ?>:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                
                <button type="submit" name="login" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> <?= $t['sign_in'] ?>
                </button>
            </form>
            
            <div class="version">
                <?= $t['version'] ?> <?= BACKUP_VERSION ?>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Обработка POST запросов (веб интерфейс)
$testResult = null;
$test_message = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['test_connection'])) {
        // Тест подключения к БД - используем текущие настройки из файла конфигурации
        $testResult = testDbConnection($config);
        $test_message = $testResult['message'];
    }
    elseif (isset($_POST['save_settings'])) {
        // Сохранение настроек
        $config['db_user'] = $_POST['db_user'];
        $config['db_pass'] = $_POST['db_pass'];
        $config['db_host'] = $_POST['db_host'];
        $config['backup_dir'] = rtrim($_POST['backup_dir'], '/') . '/';
        $config['backup_subdir'] = $_POST['backup_subdir'] ?? 'BD';
        $config['retention_days'] = (int)$_POST['retention_days'];
        $config['api_enabled'] = isset($_POST['api_enabled']);
        // Новые настройки
        $config['enable_console'] = isset($_POST['enable_console']);
        $config['enable_web'] = isset($_POST['enable_web']);
        $config['enable_auth'] = isset($_POST['enable_auth']);
        $config['enable_error_log'] = isset($_POST['enable_error_log']);
        $config['date_format'] = $_POST['date_format'] ?? 'Y-m-d';
        $config['language'] = $_POST['language'] ?? 'en';
        $config['backup_to_current_dir'] = isset($_POST['backup_to_current_dir']);
        $config['pagination_limit'] = isset($_POST['pagination_limit']) ? (int)$_POST['pagination_limit'] : 20;
        
        // Обработка выбранных баз данных
        if (isset($_POST['selected_dbs']) && is_array($_POST['selected_dbs'])) {
            $config['selected_dbs'] = $_POST['selected_dbs'];
        } else {
            $config['selected_dbs'] = [];
        }
        
        if (saveConfig($config, $configFile)) {
            $message = $t['success'] . " " . $t['save_settings'];
            logSuccess('settings_saved', 'Web interface');
            // Обновляем язык
            $current_lang = $config['language'];
            $t = $translations[$current_lang] ?? $translations['en'];
        } else {
            $error = $t['error'] . " " . $t['save_settings'];
            logError("Failed to save settings", 'settings_save_error', 6);
        }
    } 
    elseif (isset($_POST['create_backup'])) {
        // Создание бэкапа вручную
        $result = runBackup($config);
        
        if ($result['success']) {
            $message = $t['backup_created_success'];
            $backup_info = $result['message'];
            $backup_details = $result;
        } else {
            $error = $t['error'] . " " . $t['create_backup'] . ": " . $result['error'];
        }
    }
    elseif (isset($_POST['cleanup_backups'])) {
        // Очистка старых бэкапов
        $deleted = cleanupOldBackups($config['backup_dir'], $config['retention_days'], $config['date_format']);
        if (empty($deleted)) {
            $message = "ℹ️ " . sprintf($t['no_backups_found'] . " (%s " . $t['retention_days'] . ")", $config['retention_days']);
            logSuccess('cleanup_no_backups', "Retention: {$config['retention_days']} days");
        } else {
            $message = $t['success'] . " " . $t['cleanup_old'] . ": " . implode(', ', $deleted);
        }
    }
    elseif (isset($_POST['delete_backup'])) {
        // Удаление конкретного бэкапа
        $backupName = $_POST['backup_name'] ?? '';
        // Определяем директорию для удаления бэкапа
        $backup_dir = $config['backup_to_current_dir'] ? __DIR__ : $config['backup_dir'];
        if (deleteBackup($backup_dir, $backupName, $config['date_format'])) {
            $message = $t['success'] . " " . $t['delete'] . ": " . $backupName;
        } else {
            $error = $t['error'] . " " . $t['delete'] . ": " . $backupName;
        }
    }
    elseif (isset($_POST['add_token'])) {
        // Добавление нового токена
        $tokenName = trim($_POST['token_name']);
        if (empty($tokenName)) {
            $error = $t['error'] . " " . $t['token_name'];
            logError("Empty token name", 'token_add_error', 5);
        } elseif (isset($tokens[$tokenName])) {
            $error = $t['error'] . " " . $t['token_name'] . " " . $t['error'];
            logError("Token already exists: {$tokenName}", 'token_add_error', 5);
        } else {
            $tokens[$tokenName] = [
                'token' => bin2hex(random_bytes(32)),
                'name' => $tokenName,
                'enabled' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'last_used' => null,
                'usage_count' => 0
            ];
            if (saveTokens($tokens, $tokensFile)) {
                $message = $t['success'] . " " . $t['add'] . ": " . $tokenName;
                logSuccess('token_added', "Token: {$tokenName}");
            } else {
                $error = $t['error'] . " " . $t['save_settings'];
                logError("Failed to save token: {$tokenName}", 'token_save_error', 6);
            }
        }
    }
    elseif (isset($_POST['toggle_token'])) {
        // Включение/выключение токена
        $tokenName = $_POST['token_name'];
        if (isset($tokens[$tokenName])) {
            $tokens[$tokenName]['enabled'] = !$tokens[$tokenName]['enabled'];
            if (saveTokens($tokens, $tokensFile)) {
                $message = $t['success'] . " " . $t['token_name'] . " " . ($tokens[$tokenName]['enabled'] ? $t['enable'] : $t['disable']) . ": " . $tokenName;
                logSuccess('token_toggled', "Token: {$tokenName}, Status: " . ($tokens[$tokenName]['enabled'] ? 'enabled' : 'disabled'));
            } else {
                $error = $t['error'] . " " . $t['save_settings'];
                logError("Failed to toggle token: {$tokenName}", 'token_toggle_error', 6);
            }
        }
    }
    elseif (isset($_POST['delete_token'])) {
        // Удаление токена
        $tokenName = $_POST['token_name'];
        if (isset($tokens[$tokenName])) {
            if (count($tokens) <= 1) {
                $error = $t['error'] . " " . $t['delete'] . " " . $t['token_name'];
                logError("Cannot delete last token: {$tokenName}", 'token_delete_error', 6);
            } else {
                unset($tokens[$tokenName]);
                if (saveTokens($tokens, $tokensFile)) {
                    $message = $t['success'] . " " . $t['delete'] . ": " . $tokenName;
                    logSuccess('token_deleted', "Token: {$tokenName}");
                } else {
                    $error = $t['error'] . " " . $t['save_settings'];
                    logError("Failed to delete token: {$tokenName}", 'token_delete_error', 6);
                }
            }
        }
    }
    elseif (isset($_POST['logout'])) {
        // Выход из системы
        session_start();
        $username = $_SESSION['username'] ?? 'Unknown';
        session_unset();
        session_destroy();
        logSuccess('logout', "User: {$username}");
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Получение списка всех баз данных для выбора (исключая системные и тестовые)
$all_databases = [];
$filtered_databases = [];
try {
    $all_databases = getAllDatabases($config);
    $filtered_databases = array_filter($all_databases, function($db) use ($config) {
        return !in_array($db, $config['exclude_dbs']);
    });
} catch (Exception $e) {
    // Игнорируем ошибку подключения - просто не показываем базы
}

// Получение бэкапов с пагинацией
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = $config['pagination_limit'];
$backupsData = getExistingBackups($config, $page, $perPage);
$existing_backups = $backupsData['backups'];
$total_pages = $backupsData['pages'];
$current_page = $backupsData['current_page'];
$total_backups = $backupsData['total'];

$backup_days = getBackupDaysCount($config);

// Общая статистика
$total_backup_files = getTotalBackupFiles($config);
$total_size = getTotalBackupSize($config);

// Определяем активную вкладку
$activeTab = $_GET['tab'] ?? 'dashboard';

// Проверяем наличие активных токенов для API
$hasActiveTokens = hasActiveTokens($tokens);
$apiEnabled = $config['api_enabled'] && $hasActiveTokens;
?>
<!DOCTYPE html>
<html lang="<?= $current_lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $t['title'] ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #6c757d;
            --primary-light: #f8f9fa;
            --secondary-color: #495057;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --border-color: #dee2e6;
            --card-shadow: 0 2px 8px rgba(0,0,0,0.08);
            --hover-shadow: 0 4px 12px rgba(0,0,0,0.12);
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-300: #dee2e6;
            --gray-400: #ced4da;
            --gray-500: #adb5bd;
            --gray-600: #6c757d;
            --gray-700: #495057;
            --gray-800: #343a40;
            --gray-900: #212529;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8fafc;
            min-height: 100vh;
            padding: 20px;
            color: var(--dark-color);
            line-height: 1.6;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            min-height: calc(100vh - 40px);
        }
        
        .header {
            background: white;
            border-bottom: 1px solid var(--border-color);
            padding: 20px 32px;
            position: relative;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .header-title {
            flex: 1;
        }
        
        .header h1 {
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .header h1 .version {
            font-size: 0.8rem;
            color: var(--gray-500);
            font-weight: normal;
            margin-left: 8px;
        }
        
        .header p {
            color: var(--secondary-color);
            font-size: 0.95rem;
        }
        
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 32px;
            padding: 8px 16px;
            background: var(--gray-200);
            color: var(--gray-800);
            border: 1px solid var(--gray-300);
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        
        .logout-btn:hover {
            background: var(--gray-300);
            border-color: var(--gray-400);
            transform: translateY(-1px);
        }
        
        .tabs {
            display: flex;
            background: white;
            border-bottom: 1px solid var(--border-color);
            padding: 0 32px;
            flex-wrap: wrap;
        }
        
        .tab {
            padding: 16px 24px;
            cursor: pointer;
            border: none;
            background: none;
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--gray-600);
            transition: all 0.2s;
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }
        
        .tab:hover {
            color: var(--gray-800);
            background: var(--gray-100);
        }
        
        .tab.active {
            color: var(--gray-800);
            background: var(--gray-100);
        }
        
        .tab.active:after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--gray-800);
        }
        
        .tab.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .tab.disabled:hover {
            color: var(--gray-600);
            background: none;
        }
        
        .tab-content {
            padding: 32px;
            display: none;
            flex: 1;
        }
        
        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .card {
            background: white;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border-color);
        }
        
        .card:hover {
            box-shadow: var(--hover-shadow);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-color);
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .card-header h2 {
            color: var(--dark-color);
            font-size: 1.3rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        
        .stat-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s;
            border-top: 4px solid var(--gray-600);
        }
        
        .stat-card:hover {
            border-color: var(--gray-600);
            transform: translateY(-2px);
            box-shadow: var(--hover-shadow);
        }
        
        .stat-icon {
            font-size: 2rem;
            color: var(--gray-600);
            margin-bottom: 12px;
        }
        
        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark-color);
            margin: 8px 0;
        }
        
        .stat-label {
            color: var(--gray-600);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 500;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark-color);
            font-size: 0.95rem;
        }
        
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 0.95rem;
            transition: all 0.2s;
            background: white;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--gray-600);
            box-shadow: 0 0 0 3px var(--gray-200);
        }
        
        .form-control-small {
            max-width: 300px;
        }
        
        .form-control-password {
            max-width: 300px;
        }
        
        .form-row {
            display: flex;
            gap: 16px;
            margin-bottom: 20px;
        }
        
        .form-col {
            flex: 1;
        }
        
        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            cursor: pointer;
            margin-bottom: 12px;
            padding: 8px 0;
            border-bottom: 1px solid var(--gray-200);
        }
        
        .checkbox-group:last-child {
            border-bottom: none;
        }
        
        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            margin-top: 3px;
            flex-shrink: 0;
        }
        
        .checkbox-group label {
            margin: 0;
            cursor: pointer;
            font-weight: 500;
            color: var(--gray-700);
            font-size: 0.95rem;
            flex: 1;
        }
        
        .checkbox-help {
            display: block;
            font-size: 0.85rem;
            color: var(--gray-600);
            margin-top: 4px;
            line-height: 1.4;
        }
        
        .database-list-container {
            max-height: 300px;
            overflow-y: auto;
            padding: 15px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            background: var(--light-color);
            margin-top: 10px;
        }
        
        .database-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 10px;
        }
        
        .database-controls {
            display: flex;
            gap: 10px;
            margin-bottom: 8px; /* Уменьшено с 10px до 8px */
        }
        
        .database-controls .btn {
            padding: 6px 12px;
            font-size: 0.85rem;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        
        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.2);
        }
        
        .btn-primary {
            background: var(--gray-600);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--gray-700);
        }
        
        .btn-success {
            background: var(--success-color);
            color: white;
        }
        
        .btn-warning {
            background: var(--warning-color);
            color: white;
        }
        
        .btn-danger {
            background: var(--danger-color);
            color: white;
        }
        
        .btn-sm {
            padding: 6px 12px;
            font-size: 0.85rem;
        }
        
        .btn-outline {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--gray-700);
        }
        
        .btn-outline:hover {
            border-color: var(--gray-600);
            color: var(--gray-800);
            background: var(--gray-100);
        }
        
        .btn-gray-light {
            background: var(--gray-200);
            color: var(--gray-800);
            border: 1px solid var(--gray-300);
        }
        
        .btn-gray-light:hover {
            background: var(--gray-300);
            border-color: var(--gray-400);
        }
        
        .btn-gray-medium {
            background: var(--gray-400);
            color: var(--gray-800);
            border: 1px solid var(--gray-500);
        }
        
        .btn-gray-medium:hover {
            background: var(--gray-500);
            border-color: var(--gray-600);
        }
        
        .btn-gray-dark {
            background: var(--gray-600);
            color: white;
            border: 1px solid var(--gray-700);
        }
        
        .btn-gray-dark:hover {
            background: var(--gray-700);
            border-color: var(--gray-800);
        }
        
        .btn-disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .btn-disabled:hover {
            transform: none;
            box-shadow: none;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }
        
        .table th {
            background: var(--gray-100);
            padding: 14px 16px;
            text-align: left;
            font-weight: 600;
            color: var(--dark-color);
            border-bottom: 2px solid var(--border-color);
            font-size: 0.9rem;
        }
        
        .table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.9rem;
        }
        
        .table tr:hover {
            background: var(--gray-100);
        }
        
        .message {
            padding: 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.3s ease;
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .message.success {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }
        
        .message.error {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }
        
        .message.info {
            background: #e3f2fd;
            color: #1565c0;
            border: 1px solid #bbdefb;
        }
        
        .message.warning {
            background: #fff3e0;
            color: #ef6c00;
            border: 1px solid #ffcc80;
        }
        
        .action-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        
        .help-text {
            color: var(--gray-600);
            font-size: 0.85rem;
            margin-top: 6px;
            line-height: 1.4;
        }
        
        .structure-explanation {
            color: var(--gray-600);
            font-size: 0.85rem;
            margin-top: 8px;
            padding: 10px;
            background: var(--gray-100);
            border-radius: 4px;
            border-left: 3px solid var(--gray-400);
        }
        
        .cron-command {
            background: var(--gray-100);
            padding: 12px;
            border-radius: 6px;
            font-family: 'Monaco', 'Consolas', monospace;
            margin: 10px 0;
            font-size: 0.9rem;
            border-left: 4px solid var(--gray-600);
        }
        
        .cron-example {
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 10px;
        }
        
        .cron-example h4 {
            margin-bottom: 8px;
            color: var(--gray-800);
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--gray-600);
        }
        
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 16px;
            color: var(--gray-400);
        }
        
        .backup-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            margin-bottom: 12px;
            transition: all 0.2s;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .backup-item:hover {
            border-color: var(--gray-600);
            box-shadow: var(--card-shadow);
        }
        
        .backup-info h3 {
            margin-bottom: 4px;
            color: var(--dark-color);
        }
        
        .backup-meta {
            display: flex;
            gap: 16px;
            color: var(--gray-600);
            font-size: 0.85rem;
            flex-wrap: wrap;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .status-success {
            background: #e8f5e9;
            color: #2e7d32;
        }
        
        .status-warning {
            background: #fff3e0;
            color: #ef6c00;
        }
        
        .status-error {
            background: #ffebee;
            color: #c62828;
        }
        
        .token-list {
            display: grid;
            gap: 12px;
            margin-top: 20px;
        }
        
        .token-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            background: white;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .token-info h4 {
            margin-bottom: 4px;
            color: var(--dark-color);
        }
        
        .token-stats {
            display: flex;
            gap: 16px;
            font-size: 0.85rem;
            color: var(--gray-600);
            flex-wrap: wrap;
        }
        
        .token-actions {
            display: flex;
            gap: 8px;
        }
        
        .token-display {
            background: var(--gray-100);
            padding: 12px;
            border-radius: 6px;
            font-family: 'Monaco', 'Consolas', monospace;
            word-break: break-all;
            font-size: 0.85rem;
            border: 1px dashed var(--gray-300);
            margin-top: 8px;
        }
        
        .log-output {
            background: #1a1a1a;
            color: #e0e0e0;
            padding: 20px;
            border-radius: 8px;
            font-family: 'Monaco', 'Consolas', monospace;
            overflow-x: auto;
            max-height: 400px;
            overflow-y: auto;
            font-size: 0.85rem;
            line-height: 1.5;
            white-space: pre-wrap;
        }
        
        .api-endpoint {
            padding: 15px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            margin-bottom: 15px;
            background: white;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .api-endpoint:hover {
            border-color: var(--gray-600);
            background: var(--gray-100);
        }
        
        .api-endpoint h4 {
            margin-bottom: 10px;
            color: var(--dark-color);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .endpoint-method {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-right: 8px;
        }
        
        .method-get {
            background: #e3f2fd;
            color: #1976d2;
        }
        
        .method-post {
            background: #e8f5e9;
            color: #388e3c;
        }
        
        .method-put {
            background: #fff3e0;
            color: #f57c00;
        }
        
        .method-delete {
            background: #ffebee;
            color: #d32f2f;
        }
        
        .endpoint-url {
            background: var(--gray-100);
            padding: 10px;
            border-radius: 4px;
            font-family: 'Monaco', 'Consolas', monospace;
            font-size: 0.85rem;
            word-break: break-all;
            margin: 10px 0;
        }
        
        .endpoint-description {
            color: var(--gray-600);
            font-size: 0.9rem;
            margin: 10px 0;
        }
        
        .curl-example {
            background: #1a1a1a;
            color: #e0e0e0;
            padding: 15px;
            border-radius: 6px;
            font-family: 'Monaco', 'Consolas', monospace;
            font-size: 0.85rem;
            line-height: 1.5;
            margin: 10px 0;
            overflow-x: auto;
        }
        
        .response-example {
            background: var(--gray-100);
            padding: 15px;
            border-radius: 6px;
            font-family: 'Monaco', 'Consolas', monospace;
            font-size: 0.85rem;
            line-height: 1.5;
            margin: 10px 0;
            border-left: 4px solid var(--gray-600);
            overflow-x: auto;
        }
        
        .test-result {
            padding: 15px;
            border-radius: 6px;
            margin: 10px 0;
            font-family: 'Monaco', 'Consolas', monospace;
            font-size: 0.9rem;
            white-space: pre-wrap;
            animation: slideIn 0.3s ease;
            border-left: 4px solid var(--gray-600);
            background: white;
        }
        
        .test-result.success {
            border-left-color: var(--success-color);
            background: #f8f9fa;
        }
        
        .test-result.error {
            border-left-color: var(--danger-color);
            background: #f8f9fa;
        }
        
        .test-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .test-status.success {
            background: var(--success-color);
            color: white;
        }
        
        .test-status.error {
            background: var(--danger-color);
            color: white;
        }
        
        /* Пагинация */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .pagination-info {
            color: var(--gray-600);
            font-size: 0.9rem;
            margin: 0 16px;
        }
        
        .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 8px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            background: white;
            color: var(--gray-700);
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
        }
        
        .page-link:hover {
            background: var(--gray-100);
            border-color: var(--gray-500);
            color: var(--gray-800);
        }
        
        .page-link.active {
            background: var(--gray-600);
            border-color: var(--gray-600);
            color: white;
        }
        
        .page-link.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .page-link.disabled:hover {
            background: white;
            border-color: var(--border-color);
            color: var(--gray-700);
        }
        
        /* Модальное окно */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }
        
        .modal.active {
            display: flex;
        }
        
        .modal-content {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            animation: slideUp 0.3s ease;
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-header h3 {
            color: var(--dark-color);
            font-size: 1.2rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .modal-body {
            padding: 24px;
        }
        
        .modal-footer {
            padding: 20px 24px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }
        
        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--gray-600);
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
        }
        
        .close-btn:hover {
            background: var(--gray-100);
            color: var(--gray-800);
        }
        
        .footer {
            background: var(--gray-800);
            color: white;
            padding: 20px 32px;
            text-align: center;
            border-top: 1px solid var(--gray-700);
            margin-top: auto;
        }
        
        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .footer-logo {
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .footer-version {
            color: var(--gray-400);
            font-size: 0.9rem;
        }
        
        .footer-copyright {
            color: var(--gray-400);
            font-size: 0.9rem;
        }
        
        /* Стили для чекбоксов с пояснениями */
        .access-checkbox {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
            padding: 12px;
            background: var(--gray-50);
            border-radius: 6px;
            border: 1px solid var(--gray-200);
        }
        
        .access-checkbox input[type="checkbox"] {
            margin-top: 3px;
            margin-right: 12px;
            flex-shrink: 0;
        }
        
        .access-checkbox-content {
            flex: 1;
        }
        
        .access-checkbox label {
            display: block;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 4px;
            font-size: 0.95rem;
        }
        
        .access-checkbox .help-text {
            font-size: 0.85rem;
            color: var(--gray-600);
            line-height: 1.4;
            margin: 0;
        }
        
        .api-info-box {
            background: var(--gray-100);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 16px;
            margin-bottom: 20px;
        }
        
        .api-info-box h4 {
            margin-bottom: 8px;
            color: var(--gray-800);
            font-size: 1rem;
        }
        
        .api-info-box p {
            margin: 0;
            color: var(--gray-600);
            font-size: 0.9rem;
            line-height: 1.5;
        }
        
        @media (max-width: 768px) {
            body {
                padding: 12px;
            }
            
            .header-content {
                flex-direction: column;
            }
            
            .logout-btn {
                position: static;
                margin-top: 10px;
                align-self: flex-start;
            }
            
            .header-stats {
                width: 100%;
                justify-content: space-between;
            }
            
            .tabs {
                padding: 0 16px;
                overflow-x: auto;
                white-space: nowrap;
            }
            
            .tab {
                padding: 14px 16px;
            }
            
            .tab-content {
                padding: 20px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .action-buttons .btn {
                width: 100%;
                justify-content: center;
            }
            
            .table {
                display: block;
                overflow-x: auto;
            }
            
            .token-item {
                flex-direction: column;
                text-align: left;
                align-items: flex-start;
            }
            
            .token-actions {
                width: 100%;
                justify-content: flex-start;
            }
            
            .database-list {
                grid-template-columns: 1fr;
            }
            
            .form-row {
                flex-direction: column;
            }
            
            .footer-content {
                flex-direction: column;
                text-align: center;
            }
            
            .access-checkbox {
                padding: 10px;
            }
            
            .form-control-small, .form-control-password {
                max-width: 100%;
            }
            
            .pagination {
                flex-direction: column;
                gap: 12px;
            }
            
            .pagination-info {
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-content">
                <div class="header-title">
                    <h1><i class="fas fa-database"></i> <?= $t['title'] ?> <span class="version">v<?= BACKUP_VERSION ?></span></h1>
                    <p><?= $t['subtitle'] ?></p>
                </div>
            </div>
            <?php if ($config['enable_auth']): ?>
                <form method="POST" style="display: inline;">
                    <button type="submit" name="logout" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> <?= $t['logout'] ?>
                    </button>
                </form>
            <?php endif; ?>
        </div>
        
        <div class="tabs">
            <button class="tab <?= $activeTab == 'dashboard' ? 'active' : '' ?>" onclick="switchTab('dashboard')">
                <i class="fas fa-chart-line"></i> <?= $t['dashboard'] ?>
            </button>
            <button class="tab <?= $activeTab == 'backups' ? 'active' : '' ?>" onclick="switchTab('backups')">
                <i class="fas fa-history"></i> <?= $t['backups'] ?>
            </button>
            <button class="tab <?= $activeTab == 'tokens' ? 'active' : '' ?>" onclick="switchTab('tokens')">
                <i class="fas fa-key"></i> <?= $t['tokens'] ?>
            </button>
            <button class="tab <?= $activeTab == 'api' ? 'active' : '' ?> <?= !$apiEnabled ? 'disabled' : '' ?>" 
                    onclick="<?= $apiEnabled ? "switchTab('api')" : "return false" ?>"
                    <?= !$apiEnabled ? 'title="' . ($config['api_enabled'] ? $t['api_disabled_no_tokens'] : $t['api_disabled_in_settings']) . '"' : '' ?>>
                <i class="fas fa-code"></i> <?= $t['api'] ?>
                <?php if (!$apiEnabled): ?>
                    <i class="fas fa-exclamation-triangle" style="color: var(--warning-color); margin-left: 5px;"></i>
                <?php endif; ?>
            </button>
            <button class="tab <?= $activeTab == 'settings' ? 'active' : '' ?>" onclick="switchTab('settings')">
                <i class="fas fa-cog"></i> <?= $t['settings'] ?>
            </button>
        </div>
        
        <!-- Дашборд -->
        <div class="tab-content <?= $activeTab == 'dashboard' ? 'active' : '' ?>" id="dashboard">
            <?php if (isset($message)): ?>
                <div class="message success">
                    <i class="fas fa-check-circle"></i> 
                    <div><?= $message ?></div>
                </div>
                <?php if (isset($backup_info)): ?>
                <div class="card">
                    <div class="card-header">
                        <h2><i class="fas fa-terminal"></i> <?= $t['backup_history'] ?></h2>
                    </div>
                    <div class="log-output">
<?= htmlspecialchars($backup_info) ?>
                    </div>
                </div>
                <?php endif; ?>
            <?php elseif (isset($error)): ?>
                <div class="message error">
                    <i class="fas fa-exclamation-circle"></i> 
                    <div><?= $error ?></div>
                </div>
            <?php endif; ?>
            
            <?php if ($config['api_enabled'] && !$hasActiveTokens): ?>
                <div class="message warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <strong><?= $t['no_active_tokens'] ?></strong><br>
                        <?= $t['enable_at_least_one_token'] ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <div class="stat-value"><?= count($filtered_databases) ?></div>
                    <div class="stat-label"><?= $t['available_databases'] ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-archive"></i>
                    </div>
                    <div class="stat-value"><?= $backup_days ?></div>
                    <div class="stat-label"><?= $t['backup_count'] ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-hdd"></i>
                    </div>
                    <div class="stat-value"><?= formatFileSize($total_size) ?></div>
                    <div class="stat-label"><?= $t['total_backup_size'] ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-folder"></i>
                    </div>
                    <div class="stat-value"><?= $total_backup_files ?></div>
                    <div class="stat-label"><?= $t['total_backup_files'] ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-value"><?= $config['retention_days'] ?></div>
                    <div class="stat-label"><?= $t['retention_days'] ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-server"></i>
                    </div>
                    <div class="stat-value"><?= !empty($config['db_host']) ? htmlspecialchars($config['db_host']) : $t['not_specified'] ?></div>
                    <div class="stat-label"><?= $t['mysql_server'] ?></div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-bolt"></i> <?= $t['quick_actions'] ?></h2>
                </div>
                <div class="action-buttons">
                    <form method="POST" style="display: inline;">
                        <button type="submit" name="create_backup" class="btn btn-primary" onclick="showBackupNotification()">
                            <i class="fas fa-plus-circle"></i> <?= $t['create_backup'] ?>
                        </button>
                    </form>
                    <form method="POST" style="display: inline;">
                        <button type="submit" name="cleanup_backups" class="btn btn-gray-medium">
                            <i class="fas fa-trash-alt"></i> <?= $t['cleanup_old'] ?>
                        </button>
                    </form>
                    <a href="?tab=backups" class="btn btn-outline">
                        <i class="fas fa-list"></i> <?= $t['view_backups'] ?>
                    </a>
                    <a href="?tab=tokens" class="btn btn-outline">
                        <i class="fas fa-key"></i> <?= $t['manage_tokens'] ?>
                    </a>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-server"></i> <?= $t['system_status'] ?></h2>
                </div>
                <div class="form-group">
                    <label><?= $t['backup_directory'] ?>:</label>
                    <div class="cron-command"><?= htmlspecialchars($config['backup_dir']) ?></div>
                </div>
                
                <div class="form-group">
                    <label><?= $t['backup_structure'] ?>:</label>
                    <div class="cron-command" id="backupStructurePreview">
                        <?php 
                        $current_dir = __DIR__;
                        $backup_base = $config['backup_to_current_dir'] ? $current_dir : $config['backup_dir'];
                        $backup_structure = $backup_base . date($config['date_format']) . '/' . $config['backup_subdir'] . '/';
                        echo htmlspecialchars($backup_structure);
                        ?>
                    </div>
                    <div class="help-text">
                        <?php if ($config['backup_to_current_dir']): ?>
                            <i class="fas fa-info-circle"></i> <?= $t['backup_to_current_dir'] ?>: <?= htmlspecialchars($current_dir) ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label><?= $t['api_access'] ?>:</label>
                    <div class="status-badge <?= $apiEnabled ? 'status-success' : 'status-error' ?>">
                        <?= $apiEnabled ? $t['active'] : $t['inactive'] ?>
                    </div>
                    <?php if ($config['api_enabled'] && !$hasActiveTokens): ?>
                        <div class="help-text" style="color: var(--warning-color);">
                            <i class="fas fa-exclamation-triangle"></i> <?= $t['api_disabled_no_tokens'] ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label><?= $t['console_run'] ?>:</label>
                    <div class="cron-command">
                        php <?= htmlspecialchars(basename(__FILE__)) ?>
                    </div>
                </div>
            </div>
            
            <!-- Примеры для Cron -->
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-clock"></i> <?= $t['cron_examples'] ?></h2>
                </div>
                
                <div class="cron-example">
                    <h4><i class="fas fa-code"></i> <?= $t['cron_example_1'] ?></h4>
                    <div class="cron-command">
0 2 * * * curl -X POST '<?= htmlspecialchars((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[SCRIPT_NAME]") ?>?api=1&action=create_backup&token=<?= htmlspecialchars($tokens['default']['token'] ?? 'YOUR_TOKEN_HERE') ?>'
                    </div>
                </div>
                
                <div class="cron-example">
                    <h4><i class="fas fa-terminal"></i> <?= $t['cron_example_2'] ?></h4>
                    <div class="cron-command">
0 3 * * * php <?= htmlspecialchars(__FILE__) ?> > /var/log/mysql_backup.log 2>&1
                    </div>
                </div>
                
                <div class="cron-example">
                    <h4><i class="fas fa-database"></i> <?= $t['cron_example_3'] ?></h4>
                    <div class="cron-command">
0 4 * * * php <?= htmlspecialchars(__FILE__) ?> --database=your_database_name > /var/log/mysql_backup.log 2>&1
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Бэкапы -->
        <div class="tab-content <?= $activeTab == 'backups' ? 'active' : '' ?>" id="backups">
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-history"></i> <?= $t['backup_history'] ?></h2>
                    <div class="action-buttons">
                        <form method="POST" style="display: inline;">
                            <button type="submit" name="create_backup" class="btn btn-primary" onclick="showBackupNotification()">
                                <i class="fas fa-plus"></i> <?= $t['new_backup'] ?>
                            </button>
                        </form>
                    </div>
                </div>
                
                <?php if (empty($existing_backups)): ?>
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h3><?= $t['no_backups_found'] ?></h3>
                        <p><?= $t['new_backup'] ?></p>
                    </div>
                <?php else: ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th><?= $t['date'] ?></th>
                                <th><?= $t['files'] ?></th>
                                <th><?= $t['total_size'] ?></th>
                                <th><?= $t['path'] ?></th>
                                <th style="text-align: right;"><?= $t['actions'] ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($existing_backups as $date => $backup_data): ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($date) ?></strong>
                                    </td>
                                    <td><?= $backup_data['count'] ?></td>
                                    <td><?= $backup_data['formatted_total_size'] ?></td>
                                    <td>
                                        <code style="font-size: 0.85em;"><?= htmlspecialchars($backup_data['path']) ?></code>
                                    </td>
                                    <td style="text-align: right;">
                                        <form method="POST" style="display: inline-block;" onsubmit="return confirm('<?= $t['delete'] ?> <?= htmlspecialchars($date) ?>?')">
                                            <input type="hidden" name="backup_name" value="<?= htmlspecialchars($date) ?>">
                                            <button type="submit" name="delete_backup" class="btn btn-gray-medium btn-sm">
                                                <i class="fas fa-trash"></i> <?= $t['delete'] ?>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    
                    <!-- Пагинация -->
                    <?php if ($total_pages > 1): ?>
                        <div class="pagination">
                            <?php if ($current_page > 1): ?>
                                <a href="?tab=backups&page=1" class="page-link">
                                    <i class="fas fa-angle-double-left"></i> <?= $t['first'] ?>
                                </a>
                                <a href="?tab=backups&page=<?= $current_page - 1 ?>" class="page-link">
                                    <i class="fas fa-angle-left"></i> <?= $t['previous'] ?>
                                </a>
                            <?php else: ?>
                                <span class="page-link disabled">
                                    <i class="fas fa-angle-double-left"></i> <?= $t['first'] ?>
                                </span>
                                <span class="page-link disabled">
                                    <i class="fas fa-angle-left"></i> <?= $t['previous'] ?>
                                </span>
                            <?php endif; ?>
                            
                            <div class="pagination-info">
                                <?= $t['page'] ?> <?= $current_page ?> <?= $t['of'] ?> <?= $total_pages ?>
                                (<?= $total_backups ?> <?= strtolower($t['backups']) ?>)
                            </div>
                            
                            <?php if ($current_page < $total_pages): ?>
                                <a href="?tab=backups&page=<?= $current_page + 1 ?>" class="page-link">
                                    <?= $t['next'] ?> <i class="fas fa-angle-right"></i>
                                </a>
                                <a href="?tab=backups&page=<?= $total_pages ?>" class="page-link">
                                    <?= $t['last'] ?> <i class="fas fa-angle-double-right"></i>
                                </a>
                            <?php else: ?>
                                <span class="page-link disabled">
                                    <?= $t['next'] ?> <i class="fas fa-angle-right"></i>
                                </span>
                                <span class="page-link disabled">
                                    <?= $t['last'] ?> <i class="fas fa-angle-double-right"></i>
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Токены -->
        <div class="tab-content <?= $activeTab == 'tokens' ? 'active' : '' ?>" id="tokens">
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-key"></i> <?= $t['api_tokens_management'] ?></h2>
                </div>
                
                <?php if (!$hasActiveTokens && $config['api_enabled']): ?>
                    <div class="message warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong><?= $t['no_active_tokens'] ?></strong><br>
                            <?= $t['enable_at_least_one_token'] ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label><?= $t['add_new_token'] ?>:</label>
                    <form method="POST" class="action-buttons">
                        <input type="text" name="token_name" class="form-control" placeholder="<?= $t['token_name'] ?>" required style="flex: 1;">
                        <button type="submit" name="add_token" class="btn btn-primary">
                            <i class="fas fa-plus"></i> <?= $t['add'] ?>
                        </button>
                    </form>
                </div>
                
                <div class="token-list">
                    <?php foreach ($tokens as $name => $tokenData): ?>
                        <div class="token-item">
                            <div class="token-info">
                                <h4><?= htmlspecialchars($tokenData['name']) ?> 
                                    <span class="status-badge <?= $tokenData['enabled'] ? 'status-success' : 'status-error' ?>" style="margin-left: 8px;">
                                        <?= $tokenData['enabled'] ? $t['active'] : $t['inactive'] ?>
                                    </span>
                                </h4>
                                <div class="token-display"><?= htmlspecialchars($tokenData['token']) ?></div>
                                <div class="token-stats">
                                    <span><i class="far fa-calendar"></i> <?= $t['created'] ?>: <?= $tokenData['created_at'] ?></span>
                                    <span><i class="far fa-clock"></i> <?= $t['used'] ?>: <?= $tokenData['usage_count'] ?> <?= $t['used'] ?></span>
                                    <span><i class="fas fa-sync-alt"></i> <?= $t['last_used'] ?>: <?= $tokenData['last_used'] ?? $t['not_specified'] ?></span>
                                </div>
                            </div>
                            <div class="token-actions">
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="token_name" value="<?= htmlspecialchars($name) ?>">
                                    <button type="submit" name="toggle_token" class="btn btn-gray-light">
                                        <i class="fas fa-power-off"></i> <?= $tokenData['enabled'] ? $t['disable'] : $t['enable'] ?>
                                    </button>
                                </form>
                                <form method="POST" style="display: inline;" onsubmit="return confirm('<?= $t['delete'] ?> <?= htmlspecialchars($tokenData['name']) ?>?')">
                                    <input type="hidden" name="token_name" value="<?= htmlspecialchars($name) ?>">
                                    <button type="submit" name="delete_token" class="btn btn-gray-medium">
                                        <i class="fas fa-trash"></i> <?= $t['delete'] ?>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <!-- API -->
        <div class="tab-content <?= $activeTab == 'api' ? 'active' : '' ?>" id="api">
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-book"></i> <?= $t['api_documentation'] ?></h2>
                </div>
                
                <?php 
                // Получаем первый активный токен для примеров
                $firstActiveToken = null;
                $firstActiveTokenName = null;
                foreach ($tokens as $name => $tokenData) {
                    if ($tokenData['enabled']) {
                        $firstActiveToken = $tokenData['token'];
                        $firstActiveTokenName = $tokenData['name'];
                        break;
                    }
                }
                
                $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[SCRIPT_NAME]";
                ?>
                
                <?php if (!$apiEnabled): ?>
                    <div class="message error">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            <strong><?= $t['api_disabled_in_settings'] ?></strong><br>
                            <?php if (!$config['api_enabled']): ?>
                                <?= $t['api_disabled_in_settings'] ?>
                            <?php else: ?>
                                <?= $t['api_disabled_no_tokens'] ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Тест подключения -->
                    <div class="api-endpoint" onclick="executeEndpoint('test_connection', 'GET')">
                        <h4>
                            <span class="endpoint-method method-get">GET</span>
                            <i class="fas fa-plug"></i> <?= $t['test_connection'] ?>
                        </h4>
                        <div class="endpoint-description">
                            <?= $t['test_connection_info'] ?>
                        </div>
                        <div class="endpoint-url">
                            <?= htmlspecialchars($baseUrl) ?>?api=1&action=test_connection&token=<?= htmlspecialchars($firstActiveToken) ?>
                        </div>
                        <div class="curl-example">
curl -X GET \
  '<?= htmlspecialchars($baseUrl) ?>?api=1&action=test_connection&token=<?= htmlspecialchars($firstActiveToken) ?>' \
  -H 'Content-Type: application/json'
                        </div>
                        <div class="response-example">
{
  "success": true,
  "message": "<?= $t['connection_successful'] ?>"
}
                        </div>
                    </div>
                    
                    <!-- Создание бэкапа всех баз -->
                    <div class="api-endpoint" onclick="showMethodDialog('create_backup', 'POST')">
                        <h4>
                            <span class="endpoint-method method-post">POST</span>
                            <i class="fas fa-plus-circle"></i> <?= $t['create_backup'] ?>
                        </h4>
                        <div class="endpoint-description">
                            <?= $t['create_backup'] ?>
                        </div>
                        <div class="endpoint-url">
                            <?= htmlspecialchars($baseUrl) ?>?api=1&action=create_backup&token=<?= htmlspecialchars($firstActiveToken) ?>
                        </div>
                        <div class="curl-example">
curl -X POST \
  '<?= htmlspecialchars($baseUrl) ?>?api=1&action=create_backup&token=<?= htmlspecialchars($firstActiveToken) ?>' \
  -H 'Content-Type: application/json'
                        </div>
                        <div class="response-example">
{
  "success": true,
  "message": "<?= $t['backup_created_success'] ?>",
  "backup_dir": "<?php 
  $backup_base = $config['backup_to_current_dir'] ? __DIR__ : $config['backup_dir'];
  echo htmlspecialchars($backup_base . date($config['date_format']) . '/' . $config['backup_subdir'] . '/');
  ?>",
  "total_databases": 5,
  "backup_databases": 3,
  "successful_backups": 3,
  "date": "<?= date($config['date_format']) ?>",
  "cleaned": ["<?= date($config['date_format'], strtotime('-10 days')) ?>", "<?= date($config['date_format'], strtotime('-5 days')) ?>"]
}
                        </div>
                    </div>
                    
                    <!-- Создание бэкапа конкретной базы -->
                    <div class="api-endpoint" onclick="showCreateBackupDialog()">
                        <h4>
                            <span class="endpoint-method method-post">POST</span>
                            <i class="fas fa-database"></i> <?= $t['create_backup'] ?>
                        </h4>
                        <div class="endpoint-description">
                            <?= $t['create_backup'] ?>
                        </div>
                        <div class="endpoint-url">
                            <?= htmlspecialchars($baseUrl) ?>?api=1&action=create_backup&database=<span style="color: #6c757d;">{database_name}</span>&token=<?= htmlspecialchars($firstActiveToken) ?>
                        </div>
                        <div class="curl-example">
curl -X POST \
  '<?= htmlspecialchars($baseUrl) ?>?api=1&action=create_backup&database=my_database&token=<?= htmlspecialchars($firstActiveToken) ?>' \
  -H 'Content-Type: application/json'
                        </div>
                        <div class="response-example">
{
  "success": true,
  "message": "<?= $t['backup_created_success'] ?>",
  "backup_dir": "<?php 
  $backup_base = $config['backup_to_current_dir'] ? __DIR__ : $config['backup_dir'];
  echo htmlspecialchars($backup_base . date($config['date_format']) . '/' . $config['backup_subdir'] . '/');
  ?>",
  "total_databases": 5,
  "backup_databases": 1,
  "successful_backups": 1,
  "date": "<?= date($config['date_format']) ?>",
  "cleaned": ["<?= date($config['date_format'], strtotime('-10 days')) ?>", "<?= date($config['date_format'], strtotime('-5 days')) ?>"]
}
                        </div>
                    </div>
                    
                    <!-- Список бэкапов -->
                    <div class="api-endpoint" onclick="showListBackupsDialog()">
                        <h4>
                            <span class="endpoint-method method-get">GET</span>
                            <i class="fas fa-list"></i> <?= $t['backup_history'] ?>
                        </h4>
                        <div class="endpoint-description">
                            <?= $t['backup_history'] ?>
                        </div>
                        <div class="endpoint-url">
                            <?= htmlspecialchars($baseUrl) ?>?api=1&action=list_backups&token=<?= htmlspecialchars($firstActiveToken) ?>&page=<span style="color: #6c757d;">{page}</span>&per_page=<span style="color: #6c757d;">{per_page}</span>
                        </div>
                        <div class="curl-example">
curl -X GET \
  '<?= htmlspecialchars($baseUrl) ?>?api=1&action=list_backups&token=<?= htmlspecialchars($firstActiveToken) ?>&page=1&per_page=20' \
  -H 'Content-Type: application/json'
                        </div>
                        <div class="response-example">
{
  "status": "success",
  "backups": {
    "<?= date($config['date_format']) ?>": {
      "date": "<?= date($config['date_format']) ?>",
      "path": "<?php 
      $backup_base = $config['backup_to_current_dir'] ? __DIR__ : $config['backup_dir'];
      echo htmlspecialchars($backup_base . date($config['date_format']) . '/' . $config['backup_subdir'] . '/');
      ?>",
      "count": 3,
      "total_size": 5242880,
      "formatted_total_size": "5.00 MB"
    }
  },
  "pagination": {
    "total": 10,
    "pages": 2,
    "current_page": 1,
    "per_page": 20
  }
}
                        </div>
                    </div>
                    
                    <!-- Удаление конкретного бэкапа -->
                    <div class="api-endpoint" onclick="showDeleteDialog('delete_backup')">
                        <h4>
                            <span class="endpoint-method method-delete">DELETE</span>
                            <i class="fas fa-trash"></i> <?= $t['delete'] ?>
                        </h4>
                        <div class="endpoint-description">
                            <?= $t['delete'] ?>
                        </div>
                        <div class="endpoint-url">
                            <?= htmlspecialchars($baseUrl) ?>?api=1&action=delete_backup&name=<span style="color: #6c757d;">{date}</span>&token=<?= htmlspecialchars($firstActiveToken) ?>
                        </div>
                        <div class="curl-example">
curl -X DELETE \
  '<?= htmlspecialchars($baseUrl) ?>?api=1&action=delete_backup&name=<?= date($config['date_format'], strtotime('-1 day')) ?>&token=<?= htmlspecialchars($firstActiveToken) ?>' \
  -H 'Content-Type: application/json'
                        </div>
                        <div class="response-example">
{
  "status": "success",
  "message": "✅ <?= $t['delete'] ?>: <?= date($config['date_format'], strtotime('-1 day')) ?>"
}
                        </div>
                    </div>
                    
                    <!-- Удаление выбранных бэкапов -->
                    <div class="api-endpoint" onclick="showDeleteSelectedDialog()">
                        <h4>
                            <span class="endpoint-method method-delete">DELETE</span>
                            <i class="fas fa-trash-alt"></i> <?= $t['delete'] ?>
                        </h4>
                        <div class="endpoint-description">
                            <?= $t['delete'] ?>
                        </div>
                        <div class="endpoint-url">
                            <?= htmlspecialchars($baseUrl) ?>?api=1&action=delete_selected_backups&names=<span style="color: #6c757d;">{dates}</span>&token=<?= htmlspecialchars($firstActiveToken) ?>
                        </div>
                        <div class="curl-example">
curl -X DELETE \
  '<?= htmlspecialchars($baseUrl) ?>?api=1&action=delete_selected_backups&names=<?= date($config['date_format'], strtotime('-2 days')) ?>,<?= date($config['date_format'], strtotime('-3 days')) ?>&token=<?= htmlspecialchars($firstActiveToken) ?>' \
  -H 'Content-Type: application/json'
                        </div>
                        <div class="response-example">
{
  "status": "success",
  "message": "<?= $t['delete'] ?>",
  "deleted": ["<?= date($config['date_format'], strtotime('-2 days')) ?>", "<?= date($config['date_format'], strtotime('-3 days')) ?>"],
  "errors": []
}
                        </div>
                    </div>
                    
                    <!-- Удаление всех бэкапов -->
                    <div class="api-endpoint" onclick="showConfirmDialog('delete_all_backups', 'DELETE', '<?= $t['delete'] ?>?')">
                        <h4>
                            <span class="endpoint-method method-delete">DELETE</span>
                            <i class="fas fa-bomb"></i> <?= $t['delete'] ?>
                        </h4>
                        <div class="endpoint-description">
                            <?= $t['delete'] ?>
                        </div>
                        <div class="endpoint-url">
                            <?= htmlspecialchars($baseUrl) ?>?api=1&action=delete_all_backups&token=<?= htmlspecialchars($firstActiveToken) ?>
                        </div>
                        <div class="curl-example">
curl -X DELETE \
  '<?= htmlspecialchars($baseUrl) ?>?api=1&action=delete_all_backups&token=<?= htmlspecialchars($firstActiveToken) ?>' \
  -H 'Content-Type: application/json'
                        </div>
                        <div class="response-example">
{
  "status": "success",
  "message": "<?= $t['delete'] ?>",
  "deleted": ["<?= date($config['date_format'], strtotime('-1 day')) ?>", "<?= date($config['date_format'], strtotime('-2 days')) ?>", "<?= date($config['date_format'], strtotime('-3 days')) ?>"],
  "errors": []
}
                        </div>
                    </div>
                    
                    <!-- Информация о системе -->
                    <div class="api-endpoint" onclick="executeEndpoint('system_info', 'GET')">
                        <h4>
                            <span class="endpoint-method method-get">GET</span>
                            <i class="fas fa-info-circle"></i> <?= $t['system_status'] ?>
                        </h4>
                        <div class="endpoint-description">
                            <?= $t['system_status'] ?>
                        </div>
                        <div class="endpoint-url">
                            <?= htmlspecialchars($baseUrl) ?>?api=1&action=system_info&token=<?= htmlspecialchars($firstActiveToken) ?>
                        </div>
                        <div class="curl-example">
curl -X GET \
  '<?= htmlspecialchars($baseUrl) ?>?api=1&action=system_info&token=<?= htmlspecialchars($firstActiveToken) ?>' \
  -H 'Content-Type: application/json'
                        </div>
                        <div class="response-example">
{
  "status": "success",
  "info": {
    "total_databases": 5,
    "selected_databases": ["database1", "database2"],
    "excluded_databases": ["information_schema", "mysql"],
    "total_backups": 10,
    "backup_days": 5,
    "total_size": "1.2 GB",
    "retention_days": 30,
    "backup_dir": "<?= htmlspecialchars($config['backup_dir']) ?>",
    "backup_subdir": "<?= $config['backup_subdir'] ?>",
    "backup_to_current_dir": <?= $config['backup_to_current_dir'] ? 'true' : 'false' ?>,
    "current_dir": "<?= __DIR__ ?>",
    "backup_structure": "<?php 
    $backup_base = $config['backup_to_current_dir'] ? __DIR__ : $config['backup_dir'];
    echo htmlspecialchars($backup_base . date($config['date_format']) . '/' . $config['backup_subdir'] . '/');
    ?>",
    "api_enabled": <?= $apiEnabled ? 'true' : 'false' ?>,
    "active_tokens": <?= $hasActiveTokens ? 'true' : 'false' ?>,
    "pagination_limit": <?= $config['pagination_limit'] ?>,
    "enable_console": true,
    "enable_web": true,
    "enable_auth": false,
    "enable_error_log": false,
    "date_format": "<?= $config['date_format'] ?>",
    "language": "<?= $config['language'] ?>"
  }
}
                        </div>
                    </div>
                    
                    <!-- Установка срока хранения -->
                    <div class="api-endpoint" onclick="showUpdateRetentionDialog()">
                        <h4>
                            <span class="endpoint-method method-put">PUT</span>
                            <i class="fas fa-calendar-alt"></i> <?= $t['retention_days'] ?>
                        </h4>
                        <div class="endpoint-description">
                            <?= $t['retention_days'] ?>
                        </div>
                        <div class="endpoint-url">
                            <?= htmlspecialchars($baseUrl) ?>?api=1&action=update_retention&days=<span style="color: #6c757d;">{days}</span>&token=<?= htmlspecialchars($firstActiveToken) ?>
                        </div>
                        <div class="curl-example">
curl -X PUT \
  '<?= htmlspecialchars($baseUrl) ?>?api=1&action=update_retention&days=60&token=<?= htmlspecialchars($firstActiveToken) ?>' \
  -H 'Content-Type: application/json'
                        </div>
                        <div class="response-example">
{
  "status": "success",
  "message": "✅ <?= $t['retention_days'] ?>: 60 <?= $t['retention_days'] ?>"
}
                        </div>
                    </div>
                    
                    <!-- Обновление настроек -->
                    <div class="api-endpoint" onclick="showUpdateSettingsDialog()">
                        <h4>
                            <span class="endpoint-method method-put">PUT</span>
                            <i class="fas fa-sliders-h"></i> <?= $t['save_settings'] ?>
                        </h4>
                        <div class="endpoint-description">
                            <?= $t['save_settings'] ?>
                        </div>
                        <div class="endpoint-url">
                            <?= htmlspecialchars($baseUrl) ?>?api=1&action=update_settings&token=<?= htmlspecialchars($firstActiveToken) ?>
                        </div>
                        <div class="curl-example">
curl -X PUT \
  '<?= htmlspecialchars($baseUrl) ?>?api=1&action=update_settings&token=<?= htmlspecialchars($firstActiveToken) ?>' \
  -H 'Content-Type: application/json' \
  -d '{
    "db_user": "new_user",
    "db_pass": "new_password",
    "selected_dbs": ["db1", "db2"],
    "enable_error_log": true,
    "date_format": "Y-m-d",
    "language": "en",
    "backup_to_current_dir": false,
    "pagination_limit": 50
  }'
                        </div>
                        <div class="response-example">
{
  "status": "success",
  "message": "✅ <?= $t['save_settings'] ?>"
}
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Настройки -->
        <div class="tab-content <?= $activeTab == 'settings' ? 'active' : '' ?>" id="settings">
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-cog"></i> <?= $t['system_settings'] ?></h2>
                </div>
                
                <form method="POST" id="settingsForm">
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="db_host"><?= $t['mysql_host'] ?>:</label>
                                <input type="text" id="db_host" name="db_host" class="form-control" 
                                       value="<?= htmlspecialchars($config['db_host']) ?>" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label for="db_user"><?= $t['mysql_user'] ?>:</label>
                                <input type="text" id="db_user" name="db_user" class="form-control" 
                                       value="<?= htmlspecialchars($config['db_user']) ?>" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="db_pass"><?= $t['mysql_password'] ?>:</label>
                        <input type="password" id="db_pass" name="db_pass" class="form-control form-control-password" 
                               value="<?= htmlspecialchars($config['db_pass']) ?>" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="backup_dir"><?= $t['backup_dir'] ?>:</label>
                                <input type="text" id="backup_dir" name="backup_dir" class="form-control" 
                                       value="<?= htmlspecialchars($config['backup_dir']) ?>" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label for="backup_subdir"><?= $t['backup_subdir'] ?>:</label>
                                <input type="text" id="backup_subdir" name="backup_subdir" class="form-control" 
                                       value="<?= htmlspecialchars($config['backup_subdir']) ?>" required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Настройка создания бэкапов в текущую папку -->
                    <div class="form-group">
                        <h3 style="margin-top: 30px; margin-bottom: 15px;"><?= $t['backup_directory'] ?></h3>
                        
                        <div class="access-checkbox">
                            <input type="checkbox" id="backup_to_current_dir" name="backup_to_current_dir" 
                                   <?= $config['backup_to_current_dir'] ? 'checked' : '' ?>>
                            <div class="access-checkbox-content">
                                <label for="backup_to_current_dir"><?= $t['backup_to_current_dir'] ?></label>
                                <div class="help-text"><?= $t['backup_to_current_dir_help'] ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Настройки пагинации -->
                    <div class="form-group">
                        <h3 style="margin-top: 30px; margin-bottom: 15px;"><?= $t['pagination_settings'] ?></h3>
                        
                        <div class="form-group">
                            <label for="pagination_limit"><?= $t['pagination_limit'] ?>:</label>
                            <input type="number" id="pagination_limit" name="pagination_limit" class="form-control form-control-small" 
                                   value="<?= $config['pagination_limit'] ?>" min="1" max="100" required>
                            <div class="help-text"><?= $t['pagination_limit'] ?> (1-100)</div>
                        </div>
                    </div>
                    
                    <!-- Настройки формата даты -->
                    <div class="form-group">
                        <h3 style="margin-top: 30px; margin-bottom: 15px;"><?= $t['date_format_settings'] ?></h3>
                        
                        <div class="form-group">
                            <label for="date_format"><?= $t['date_format'] ?> (<?= date($config['date_format']) ?>):</label>
                            <select id="date_format" name="date_format" class="form-control form-control-small">
                                <option value="Y-m-d" <?= $config['date_format'] == 'Y-m-d' ? 'selected' : '' ?>>YYYY-MM-DD (<?= date('Y-m-d') ?>)</option>
                                <option value="d-m-Y" <?= $config['date_format'] == 'd-m-Y' ? 'selected' : '' ?>>DD-MM-YYYY (<?= date('d-m-Y') ?>)</option>
                                <option value="m-d-Y" <?= $config['date_format'] == 'm-d-Y' ? 'selected' : '' ?>>MM-DD-YYYY (<?= date('m-d-Y') ?>)</option>
                                <option value="Y.m.d" <?= $config['date_format'] == 'Y.m.d' ? 'selected' : '' ?>>YYYY.MM.DD (<?= date('Y.m.d') ?>)</option>
                                <option value="d.m.Y" <?= $config['date_format'] == 'd.m.Y' ? 'selected' : '' ?>>DD.MM.YYYY (<?= date('d.m.Y') ?>)</option>
                                <option value="Y_m_d" <?= $config['date_format'] == 'Y_m_d' ? 'selected' : '' ?>>YYYY_MM_DD (<?= date('Y_m_d') ?>)</option>
                                <option value="Ymd" <?= $config['date_format'] == 'Ymd' ? 'selected' : '' ?>>YYYYMMDD (<?= date('Ymd') ?>)</option>
                                <!-- Добавлены форматы со временем -->
                                <option value="Y-m-d H:i:s" <?= $config['date_format'] == 'Y-m-d H:i:s' ? 'selected' : '' ?>>YYYY-MM-DD HH:MM:SS (<?= date('Y-m-d H:i:s') ?>)</option>
                                <option value="Y-m-d_H-i-s" <?= $config['date_format'] == 'Y-m-d_H-i-s' ? 'selected' : '' ?>>YYYY-MM-DD_HH-MM-SS (<?= date('Y-m-d_H-i-s') ?>)</option>
                                <option value="d-m-Y H:i" <?= $config['date_format'] == 'd-m-Y H:i' ? 'selected' : '' ?>>DD-MM-YYYY HH:MM (<?= date('d-m-Y H:i') ?>)</option>
                                <option value="Y.m.d_H.i.s" <?= $config['date_format'] == 'Y.m.d_H.i.s' ? 'selected' : '' ?>>YYYY.MM.DD_HH.MM.SS (<?= date('Y.m.d_H.i.s') ?>)</option>
                                <option value="Ymd_His" <?= $config['date_format'] == 'Ymd_His' ? 'selected' : '' ?>>YYYYMMDD_HHMMSS (<?= date('Ymd_His') ?>)</option>
                            </select>
                            <div class="help-text"><?= $t['date_format'] ?>: <?= date($config['date_format']) ?></div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label><?= $t['backup_structure'] ?>:</label>
                        <div class="cron-command" id="backupStructurePreview">
                            <?php 
                            $current_dir = __DIR__;
                            $backup_base = $config['backup_to_current_dir'] ? $current_dir : $config['backup_dir'];
                            $backup_structure = $backup_base . date($config['date_format']) . '/' . $config['backup_subdir'] . '/';
                            echo htmlspecialchars($backup_structure);
                            ?>
                        </div>
                        <div class="help-text">
                            <?php if ($config['backup_to_current_dir']): ?>
                                <i class="fas fa-info-circle"></i> <?= $t['backup_to_current_dir'] ?>: <?= htmlspecialchars($current_dir) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <h3 style="margin-top: 30px; margin-bottom: 15px;"><?= $t['retention_days'] ?></h3>

                        <label for="retention_days"></label>
                        <input type="number" id="retention_days" name="retention_days" class="form-control form-control-small" 
                               value="<?= $config['retention_days'] ?>" min="1" max="365" required>
                    </div>
                    
                    <!-- Настройки языка -->
                    <div class="form-group">
                        <h3 style="margin-top: 30px; margin-bottom: 15px;"><?= $t['language_settings'] ?></h3>
                        
                        <div class="form-group">
                            <label for="language"></label>
                            <select id="language" name="language" class="form-control form-control-small">
                                <option value="en" <?= $config['language'] == 'en' ? 'selected' : '' ?>>English</option>
                                <option value="ru" <?= $config['language'] == 'ru' ? 'selected' : '' ?>>Русский</option>
                                <option value="cn" <?= $config['language'] == 'cn' ? 'selected' : '' ?>>中文</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Настройки доступа -->
                    <div class="form-group">
                        <h3 style="margin-top: 30px; margin-bottom: 15px;"><?= $t['access_settings'] ?></h3>
                        
                        <div class="access-checkbox">
                            <input type="checkbox" id="enable_console" name="enable_console" 
                                   <?= $config['enable_console'] ? 'checked' : '' ?>>
                            <div class="access-checkbox-content">
                                <label for="enable_console"><?= $t['allow_console_access'] ?></label>
                                <div class="help-text"><?= $t['console_access'] ?></div>
                            </div>
                        </div>
                        
                        <div class="access-checkbox">
                            <input type="checkbox" id="enable_web" name="enable_web" 
                                   <?= $config['enable_web'] ? 'checked' : '' ?>>
                            <div class="access-checkbox-content">
                                <label for="enable_web"><?= $t['allow_web_access'] ?></label>
                                <div class="help-text"><?= $t['web_access'] ?></div>
                            </div>
                        </div>
                        
                        <div class="access-checkbox">
                            <input type="checkbox" id="enable_auth" name="enable_auth" 
                                   <?= $config['enable_auth'] ? 'checked' : '' ?>>
                            <div class="access-checkbox-content">
                                <label for="enable_auth"><?= $t['require_authentication'] ?></label>
                                <div class="help-text"><?= $t['auth_access'] ?></div>
                            </div>
                        </div>
                        
                        <div class="access-checkbox">
                            <input type="checkbox" id="enable_error_log" name="enable_error_log" 
                                   <?= $config['enable_error_log'] ? 'checked' : '' ?>>
                            <div class="access-checkbox-content">
                                <label for="enable_error_log"><?= $t['write_error_log'] ?></label>
                                <div class="help-text"><?= $t['error_logging'] ?></div>
                            </div>
                        </div>
                        
                        <div class="access-checkbox">
                            <input type="checkbox" id="api_enabled" name="api_enabled" 
                                   <?= $config['api_enabled'] ? 'checked' : '' ?>>
                            <div class="access-checkbox-content">
                                <label for="api_enabled"><?= $t['api_access'] ?></label>
                                <div class="help-text"><?= $t['api_access'] ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <?php if (!empty($filtered_databases)): ?>
                    <div class="form-group">
                        <h3><?= $t['select_databases'] ?></h3>
                        
 <br>

                        <div class="database-controls">
                            <button type="button" class="btn btn-outline btn-sm" onclick="selectAllDatabases()">
                                <i class="fas fa-check-square"></i> <?= $t['select_all'] ?>
                            </button>
                            <button type="button" class="btn btn-outline btn-sm" onclick="deselectAllDatabases()">
                                <i class="fas fa-square"></i> <?= $t['deselect_all'] ?>
                            </button>
                        </div>
                       



                        <div class="database-list-container">
                            <div class="database-list" id="databaseList">
                                <?php 
                                // По умолчанию все базы должны быть выбраны, если не указано иное
                                $default_checked = empty($config['selected_dbs']) ? true : false;
                                foreach ($filtered_databases as $db): 
                                    $is_checked = $default_checked || in_array($db, $config['selected_dbs']);
                                ?>
                                    <div class="checkbox-group database-item">
                                        <input type="checkbox" id="db_<?= htmlspecialchars($db) ?>" name="selected_dbs[]" 
                                               value="<?= htmlspecialchars($db) ?>"
                                               <?= $is_checked ? 'checked' : '' ?>>
                                        <label for="db_<?= htmlspecialchars($db) ?>">
                                            <?= htmlspecialchars($db) ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                        <div class="message info">
                            <i class="fas fa-info-circle"></i>
                            <div><?= $t['test_connection'] ?></div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="action-buttons">
                        <button type="submit" name="save_settings" class="btn btn-primary">
                            <i class="fas fa-save"></i> <?= $t['save_settings'] ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Футер -->
        <div class="footer">
            <div class="footer-content">
                <div class="footer-logo">
                    <?= $t['title'] ?>
                </div>
                <div class="footer-version">
                    <?= $t['version'] ?> <?= BACKUP_VERSION ?>
                </div>
                <div class="footer-copyright">
                    © <?= BACKUP_YEAR ?> <?= $t['developed_by'] ?>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function switchTab(tabName) {
            // Проверяем, не отключена ли вкладка API
            if (tabName === 'api') {
                <?php if (!$apiEnabled): ?>
                    showNotification('<?= $config['api_enabled'] ? $t['api_disabled_no_tokens'] : $t['api_disabled_in_settings'] ?>', 'warning');
                    return false;
                <?php endif; ?>
            }
            
            // Обновляем URL без перезагрузки страницы
            const url = new URL(window.location);
            url.searchParams.set('tab', tabName);
            window.history.pushState({}, '', url);
            
            // Скрываем все вкладки
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Убираем активный класс со всех вкладок
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Показываем выбранную вкладку
            document.getElementById(tabName).classList.add('active');
            
            // Активируем соответствующую кнопку вкладки
            const activeTabButton = Array.from(document.querySelectorAll('.tab')).find(tab => 
                tab.textContent.includes(tabName.replace('_', ' ')) || 
                tab.onclick.toString().includes(`'${tabName}'`)
            );
            if (activeTabButton) {
                activeTabButton.classList.add('active');
            }
        }
        
        // Управление выбором баз данных
        function selectAllDatabases() {
            document.querySelectorAll('.database-item input[type="checkbox"]').forEach(checkbox => {
                checkbox.checked = true;
            });
        }
        
        function deselectAllDatabases() {
            document.querySelectorAll('.database-item input[type="checkbox"]').forEach(checkbox => {
                checkbox.checked = false;
            });
        }
        
        // Обновление предпросмотра структуры папок
        function updateBackupStructurePreview() {
            const backupDir = document.getElementById('backup_dir').value.trim();
            const backupSubdir = document.getElementById('backup_subdir').value.trim();
            const dateFormat = document.getElementById('date_format').value;
            const backupToCurrentDir = document.getElementById('backup_to_current_dir').checked;
            
            // Убираем слэш в конце если есть
            const cleanBackupDir = backupDir.replace(/\/+$/, '');
            const cleanBackupSubdir = backupSubdir || 'BD';
            
            // Создаем пример даты на основе формата с текущей датой
            let exampleDate = '';
            const now = new Date();
            const currentYear = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            
            // Создаем дату в зависимости от выбранного формата
            switch(dateFormat) {
                case 'Y-m-d':
                    exampleDate = `${currentYear}-${month}-${day}`;
                    break;
                case 'd-m-Y':
                    exampleDate = `${day}-${month}-${currentYear}`;
                    break;
                case 'm-d-Y':
                    exampleDate = `${month}-${day}-${currentYear}`;
                    break;
                case 'Y.m.d':
                    exampleDate = `${currentYear}.${month}.${day}`;
                    break;
                case 'd.m.Y':
                    exampleDate = `${day}.${month}.${currentYear}`;
                    break;
                case 'Y_m_d':
                    exampleDate = `${currentYear}_${month}_${day}`;
                    break;
                case 'Ymd':
                    exampleDate = `${currentYear}${month}${day}`;
                    break;
                // Форматы со временем
                case 'Y-m-d H:i:s':
                    exampleDate = `${currentYear}-${month}-${day} ${hours}:${minutes}:${seconds}`;
                    break;
                case 'Y-m-d_H-i-s':
                    exampleDate = `${currentYear}-${month}-${day}_${hours}-${minutes}-${seconds}`;
                    break;
                case 'd-m-Y H:i':
                    exampleDate = `${day}-${month}-${currentYear} ${hours}:${minutes}`;
                    break;
                case 'Y.m.d_H.i.s':
                    exampleDate = `${currentYear}.${month}.${day}_${hours}.${minutes}.${seconds}`;
                    break;
                case 'Ymd_His':
                    exampleDate = `${currentYear}${month}${day}_${hours}${minutes}${seconds}`;
                    break;
                default:
                    exampleDate = `${currentYear}-${month}-${day}`;
            }
            
            // Определяем базовую директорию
            const baseDir = backupToCurrentDir ? '<?= __DIR__ ?>' : cleanBackupDir;
            const structure = baseDir + '/' + exampleDate + '/' + cleanBackupSubdir + '/';
            document.getElementById('backupStructurePreview').textContent = structure;
            
            // Обновляем пояснение
            const helpText = document.querySelector('#backupStructurePreview + .helpText');
            if (backupToCurrentDir) {
                if (!helpText) {
                    const newHelpText = document.createElement('div');
                    newHelpText.className = 'help-text';
                    newHelpText.innerHTML = '<i class="fas fa-info-circle"></i> <?= $t['backup_to_current_dir'] ?>: <?= __DIR__ ?>';
                    document.getElementById('backupStructurePreview').parentNode.appendChild(newHelpText);
                } else {
                    helpText.innerHTML = '<i class="fas fa-info-circle"></i> <?= $t['backup_to_current_dir'] ?>: <?= __DIR__ ?>';
                }
            } else {
                if (helpText) {
                    helpText.remove();
                }
            }
        }
        
        // Уведомление о создании бэкапа
        function showBackupNotification() {
            showNotification('⏳ <?= $t['creating_backup'] ?>...', 'info');
        }
        
        // Выполнение API эндпоинтов
        function executeEndpoint(action, method) {
            let url = '<?= htmlspecialchars($baseUrl) ?>?api=1&action=' + action + '&token=<?= htmlspecialchars($firstActiveToken) ?>';
            
            // Открываем в новой вкладке
            window.open(url, '_blank');
            
            // Показываем уведомление
            showNotification('✅ <?= $t['backup_created_success'] ?>');
        }
        
        function showMethodDialog(action, method) {
            const confirmation = confirm(`<?= $t['method'] ?> ${method}. <?= $t['confirm'] ?>?`);
            if (confirmation) {
                executeEndpoint(action, method);
            }
        }
        
        function showConfirmDialog(action, method, message) {
            const confirmation = confirm(message);
            if (confirmation) {
                executeEndpoint(action, method);
            }
        }
        
        function showDeleteDialog(action) {
            const date = prompt('<?= $t['date'] ?> (<?= $config['date_format'] ?>):', '<?= date($config['date_format']) ?>');
            if (date) {
                let url = '<?= htmlspecialchars($baseUrl) ?>?api=1&action=' + action + '&name=' + encodeURIComponent(date) + '&token=<?= htmlspecialchars($firstActiveToken) ?>';
                window.open(url, '_blank');
                showNotification('✅ <?= $t['success'] ?>');
            }
        }
        
        function showDeleteSelectedDialog() {
            const dates = prompt('<?= $t['dates'] ?> (<?= $config['date_format'] ?>):', '<?= date($config['date_format']) ?>');
            if (dates) {
                let url = '<?= htmlspecialchars($baseUrl) ?>?api=1&action=delete_selected_backups&names=' + encodeURIComponent(dates) + '&token=<?= htmlspecialchars($firstActiveToken) ?>';
                window.open(url, '_blank');
                showNotification('✅ <?= $t['success'] ?>');
            }
        }
        
        function showCreateBackupDialog() {
            const database = prompt('<?= $t['database'] ?>:');
            if (database) {
                let url = '<?= htmlspecialchars($baseUrl) ?>?api=1&action=create_backup&database=' + encodeURIComponent(database) + '&token=<?= htmlspecialchars($firstActiveToken) ?>';
                window.open(url, '_blank');
                showNotification('✅ <?= $t['backup_created_success'] ?> ' + database);
            }
        }
        
        function showListBackupsDialog() {
            const page = prompt('<?= $t['page'] ?>:', '1');
            const perPage = prompt('<?= $t['pagination_limit'] ?>:', '<?= $config['pagination_limit'] ?>');
            
            if (page && perPage) {
                let url = '<?= htmlspecialchars($baseUrl) ?>?api=1&action=list_backups&token=<?= htmlspecialchars($firstActiveToken) ?>&page=' + encodeURIComponent(page) + '&per_page=' + encodeURIComponent(perPage);
                window.open(url, '_blank');
                showNotification('✅ <?= $t['success'] ?>');
            }
        }
        
        function showUpdateRetentionDialog() {
            const days = prompt('<?= $t['retention_days'] ?>:', '<?= $config["retention_days"] ?>');
            if (days && !isNaN(days) && days > 0) {
                let url = '<?= htmlspecialchars($baseUrl) ?>?api=1&action=update_retention&days=' + encodeURIComponent(days) + '&token=<?= htmlspecialchars($firstActiveToken) ?>';
                window.open(url, '_blank');
                showNotification('✅ <?= $t['success'] ?>');
            } else if (days !== null) {
                alert('❌ <?= $t['error'] ?>');
            }
        }
        
        function showUpdateSettingsDialog() {
            const settings = prompt('<?= $t['settings'] ?> JSON:', '{}');
            if (settings) {
                try {
                    JSON.parse(settings); // Проверяем валидность JSON
                    alert('⚠️ <?= $t['json_required'] ?>');
                } catch (e) {
                    alert('❌ <?= $t['error'] ?> JSON: ' + e.message);
                }
            }
        }
        
        function showNotification(message, type = 'success') {
            // Создаем элемент уведомления
            const notification = document.createElement('div');
            notification.className = 'notification';
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'info' ? 'var(--warning-color)' : type === 'warning' ? 'var(--warning-color)' : 'var(--success-color)'};
                color: white;
                padding: 12px 20px;
                border-radius: 6px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 1000;
                animation: slideInRight 0.3s ease;
                display: flex;
                align-items: center;
                gap: 10px;
                max-width: 300px;
            `;
            
            const icon = type === 'info' ? 'fas fa-info-circle' : type === 'warning' ? 'fas fa-exclamation-triangle' : 'fas fa-check-circle';
            notification.innerHTML = `<i class="${icon}"></i> <span>${message}</span>`;
            
            // Удаляем старые уведомления
            document.querySelectorAll('.notification').forEach(el => el.remove());
            
            document.body.appendChild(notification);
            
            // Автоматически скрываем через 3 секунды
            setTimeout(() => {
                notification.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, 3000);
            
            // Добавляем стили для анимации
            if (!document.querySelector('#notification-styles')) {
                const style = document.createElement('style');
                style.id = 'notification-styles';
                style.textContent = `
                    @keyframes slideInRight {
                        from { transform: translateX(100%); opacity: 0; }
                        to { transform: translateX(0); opacity: 1; }
                    }
                    @keyframes slideOutRight {
                        from { transform: translateX(0); opacity: 1; }
                        to { transform: translateX(100%); opacity: 0; }
                    }
                `;
                document.head.appendChild(style);
            }
        }
        
        // Инициализация при загрузке
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const tab = urlParams.get('tab') || 'dashboard';
            switchTab(tab);
            
            // Автоматически скрываем сообщения через 10 секунд
            setTimeout(() => {
                document.querySelectorAll('.message').forEach(msg => {
                    msg.style.opacity = '0';
                    msg.style.transition = 'opacity 0.3s';
                    setTimeout(() => {
                        if (msg.parentNode) {
                            msg.parentNode.removeChild(msg);
                        }
                    }, 300);
                });
            }, 10000);
            
            // Обновление предпросмотра структуры папок при изменении полей
            document.getElementById('backup_dir').addEventListener('input', updateBackupStructurePreview);
            document.getElementById('backup_subdir').addEventListener('input', updateBackupStructurePreview);
            document.getElementById('date_format').addEventListener('change', updateBackupStructurePreview);
            document.getElementById('backup_to_current_dir').addEventListener('change', updateBackupStructurePreview);
            
            // Инициализация предпросмотра
            updateBackupStructurePreview();
            
            // Обработка кликов по вкладкам
            document.querySelectorAll('.tab').forEach(tab => {
                tab.addEventListener('click', function() {
                    if (this.classList.contains('disabled')) {
                        return false;
                    }
                    const tabName = this.getAttribute('onclick').match(/'([^']+)'/)[1];
                    switchTab(tabName);
                });
            });
        });
    </script>
</body>
</html>