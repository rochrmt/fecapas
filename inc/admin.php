<?php

declare(strict_types=1);

require_once __DIR__ . '/content.php';

function start_admin_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    session_name('fecapas_admin');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'httponly' => true,
        'samesite' => 'Strict',
    ]);
    session_start();
}

function send_security_headers(): void
{
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header("Permissions-Policy: camera=(), microphone=(), geolocation=()");
}

function is_admin_configured(): bool
{
    return is_file(AUTH_FILE) && admin_password_hash() !== null;
}

function admin_password_hash(): ?string
{
    if (!is_file(AUTH_FILE)) {
        return null;
    }

    $json = file_get_contents(AUTH_FILE);
    $auth = is_string($json) ? json_decode($json, true) : null;
    $hash = is_array($auth) ? ($auth['password_hash'] ?? null) : null;

    return is_string($hash) && $hash !== '' ? $hash : null;
}

function configure_admin_password(string $password): void
{
    if (strlen($password) < 10) {
        throw new InvalidArgumentException('Le mot de passe doit contenir au moins 10 caractères.');
    }

    ensure_storage_directories();
    $payload = json_encode(
        ['password_hash' => password_hash($password, PASSWORD_DEFAULT)],
        JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES,
    );

    if (!is_string($payload) || file_put_contents(AUTH_FILE, $payload . PHP_EOL, LOCK_EX) === false) {
        throw new RuntimeException('Le mot de passe administrateur n’a pas pu être enregistré.');
    }

    @chmod(AUTH_FILE, 0600);
}

function admin_is_authenticated(): bool
{
    return ($_SESSION['admin_authenticated'] ?? false) === true;
}

function authenticate_admin(string $password): bool
{
    $hash = admin_password_hash();

    if ($hash === null || !password_verify($password, $hash)) {
        return false;
    }

    session_regenerate_id(true);
    $_SESSION['admin_authenticated'] = true;
    $_SESSION['login_attempts'] = 0;

    return true;
}

function logout_admin(): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $parameters = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $parameters['path'], '', $parameters['secure'], true);
    }

    session_destroy();
}

function csrf_token(): string
{
    if (!isset($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function verify_csrf_token(string $token): bool
{
    $savedToken = $_SESSION['csrf_token'] ?? '';

    return is_string($savedToken) && $savedToken !== '' && hash_equals($savedToken, $token);
}

function clean_text(mixed $value, int $maximumLength = 3000): string
{
    if (!is_string($value)) {
        return '';
    }

    $value = trim(str_replace(["\r\n", "\r"], "\n", $value));

    return substr($value, 0, $maximumLength);
}

function clean_url(mixed $value): string
{
    $url = clean_text($value, 1200);

    if ($url === '') {
        return '';
    }

    if (filter_var($url, FILTER_VALIDATE_URL) === false) {
        throw new InvalidArgumentException('Une URL fournie est invalide.');
    }

    $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));

    if (!in_array($scheme, ['http', 'https'], true)) {
        throw new InvalidArgumentException('Seules les URL HTTP et HTTPS sont acceptées.');
    }

    return $url;
}

function process_image_upload(string $fieldName, string $currentPath): string
{
    $file = $_FILES[$fieldName] ?? null;

    if (!is_array($file) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return $currentPath;
    }

    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Le téléversement de l’image a échoué.');
    }

    $size = (int) ($file['size'] ?? 0);

    if ($size <= 0 || $size > 8 * 1024 * 1024) {
        throw new InvalidArgumentException('L’image doit peser moins de 8 Mo.');
    }

    $temporaryPath = $file['tmp_name'] ?? '';

    if (!is_string($temporaryPath) || !is_uploaded_file($temporaryPath)) {
        throw new RuntimeException('Le fichier téléversé est invalide.');
    }

    $mimeType = (new finfo(FILEINFO_MIME_TYPE))->file($temporaryPath);
    $extensions = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
    ];

    if (!is_string($mimeType) || !isset($extensions[$mimeType]) || getimagesize($temporaryPath) === false) {
        throw new InvalidArgumentException('Formats acceptés : JPG, PNG, WebP et GIF.');
    }

    ensure_storage_directories();
    $filename = date('Ymd-His') . '-' . bin2hex(random_bytes(8)) . '.' . $extensions[$mimeType];
    $destination = UPLOAD_DIRECTORY . '/' . $filename;

    if (!move_uploaded_file($temporaryPath, $destination)) {
        throw new RuntimeException('L’image n’a pas pu être enregistrée.');
    }

    @chmod($destination, 0644);

    return 'uploads/' . $filename;
}

function update_scalar_section(array $content, string $section, array $allowedKeys): array
{
    foreach ($allowedKeys as $key) {
        $content[$section][$key] = clean_text($_POST[$key] ?? '');
    }

    return $content;
}
