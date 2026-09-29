<?php
declare(strict_types=1);
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

function require_login(): void {
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php'); exit;
    }
}
function require_role(string ...$roles): void {
    require_login();
    if (!in_array($_SESSION['rol'] ?? '', $roles, true)) {
        header('Location: acceso_denegado.php'); exit;
    }
}
function is_admin(): bool { return ($_SESSION['rol'] ?? '') === 'Administrador'; }
