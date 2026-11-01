<?php
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function url(string $path = ''): string
{
    return BASE_PATH . '/' . ltrim($path, '/');
}

function asset(string $path): string
{
    return url('assets/' . ltrim($path, '/'));
}

function redirect(string $path): never
{
    header('Location: ' . (str_starts_with($path, 'http') ? $path : url($path)));
    exit;
}

function fetch_all(string $sql, array $params = []): array
{
    $statement = db()->prepare($sql);
    $statement->execute($params);
    return $statement->fetchAll();
}

function fetch_one(string $sql, array $params = []): array|false
{
    $statement = db()->prepare($sql);
    $statement->execute($params);
    return $statement->fetch();
}

function run_query(string $sql, array $params = []): PDOStatement
{
    $statement = db()->prepare($sql);
    $statement->execute($params);
    return $statement;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function verify_csrf(): void
{
    $token = $_POST['csrf_token'] ?? '';
    if (!$token || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(419);
        exit('Your form session expired. Please go back and try again.');
    }
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

function get_flashes(): array
{
    $messages = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $messages;
}

function format_date(?string $date, string $format = 'd M Y'): string
{
    return $date ? date($format, strtotime($date)) : 'Not set';
}

function format_time(?string $time): string
{
    return $time ? date('g:i A', strtotime($time)) : 'Not set';
}

function status_badge(string $status): string
{
    $classes = [
        'approved' => 'success', 'active' => 'success', 'completed' => 'success',
        'registered' => 'success', 'ongoing' => 'info',
        'pending' => 'warning', 'upcoming' => 'warning', 'scheduled' => 'info',
        'rejected' => 'danger', 'cancelled' => 'danger', 'inactive' => 'secondary',
        'withdrawn' => 'secondary', 'maintenance' => 'danger',
    ];
    $class = $classes[$status] ?? 'secondary';
    return '<span class="badge text-bg-' . $class . '">' . e(ucfirst($status)) . '</span>';
}

function active_class(string $page, string $activePage): string
{
    return $page === $activePage ? 'active' : '';
}

function client_validation(): string
{
    return 'needs-validation';
}
