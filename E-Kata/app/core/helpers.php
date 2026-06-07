<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

function base_url(string $path = ''): string
{
    $path = ltrim($path, '/');
    return rtrim(BASE_URL, '/') . '/' . $path;
}

function redirect(string $to): void
{
    header('Location: ' . $to);
    exit;
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function money_mga(int $cents): string
{
    $amount = $cents / 100;
    return number_format($amount, 0, ',', ' ') . ' Ar';
}

function csrf_token(): string
{
    if (empty($_SESSION[CSRF_KEY])) {
        $_SESSION[CSRF_KEY] = bin2hex(random_bytes(32));
    }
    return (string)$_SESSION[CSRF_KEY];
}

function csrf_validate(?string $token): bool
{
    if (!$token || empty($_SESSION[CSRF_KEY])) { return false; }
    return hash_equals((string)$_SESSION[CSRF_KEY], (string)$token);
}

function flash_set(string $type, string $message): void
{
    $_SESSION[FLASH_KEY] = ['type' => $type, 'message' => $message];
}

function flash_get(): ?array
{
    if (empty($_SESSION[FLASH_KEY])) { return null; }
    $f = $_SESSION[FLASH_KEY];
    unset($_SESSION[FLASH_KEY]);
    return is_array($f) ? $f : null;
}

function is_logged_in(): bool
{
    return !empty($_SESSION['user']);
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function require_login(): void
{
    if (is_logged_in()) { return; }
    flash_set('warning', 'Veuillez vous connecter pour continuer.');
    redirect(base_url('index.php?c=auth&a=login'));
}

function is_admin(): bool
{
    return !empty($_SESSION['user']) && ($_SESSION['user']['role'] ?? '') === 'admin';
}

function require_admin(): void
{
    if (is_admin()) { return; }
    http_response_code(403);
    flash_set('danger', 'Accès refusé.');
    redirect(base_url('index.php'));
}

function cart_count(): int
{
    $cart = $_SESSION['cart'] ?? [];
    if (!is_array($cart)) { return 0; }
    $sum = 0;
    foreach ($cart as $qty) { $sum += (int)$qty; }
    return $sum;
}

