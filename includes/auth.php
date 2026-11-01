<?php
function current_user(): ?array
{
    if (empty($_SESSION['user_id'])) {
        return null;
    }

    static $user = null;
    if ($user === null) {
        $user = fetch_one('SELECT id, student_id, full_name, email, role FROM users WHERE id = ?', [$_SESSION['user_id']]);
        if (!$user) {
            session_destroy();
            return null;
        }
    }
    return $user;
}

function is_logged_in(): bool
{
    return current_user() !== null;
}

function is_admin(): bool
{
    return (current_user()['role'] ?? '') === 'admin';
}

function require_login(): void
{
    if (!is_logged_in()) {
        flash('warning', 'Please log in to continue.');
        redirect('login.php');
    }
}

function require_student(): void
{
    require_login();
    if (is_admin()) {
        redirect('admin/index.php');
    }
}

function require_admin(): void
{
    require_login();
    if (!is_admin()) {
        flash('danger', 'You do not have permission to access the admin panel.');
        redirect('student/dashboard.php');
    }
}
