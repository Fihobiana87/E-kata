<?php
declare(strict_types=1);

// --- Base URL ---
// Sur XAMPP/Apache : http://localhost/E-Kata/public/
// Adaptez si besoin (ex: http://localhost/ekata/public/)
define('BASE_URL', '/E-Kata/public/');

// --- Base de données ---
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'ekata');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// --- Sécurité ---
define('CSRF_KEY', 'ekata_csrf');
define('FLASH_KEY', 'ekata_flash');

