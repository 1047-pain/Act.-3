<?php
declare(strict_types=1);
require_once __DIR__.'/../config/database.php';

class Usuario {
    public static function autenticar(string $usuario, string $password): ?array {
        $st = db()->prepare('SELECT u.*, r.nombre_rol FROM usuarios u JOIN roles r ON r.id=u.rol_id WHERE u.usuario=? AND u.estado=1 LIMIT 1');
        $st->execute([$usuario]); $row = $st->fetch();
        if ($row && password_verify($password, $row['password_hash'])) return $row;
        return null;
    }
    public static function all(): array {
        return db()->query('SELECT u.id,u.usuario,u.email,u.estado,r.nombre_rol FROM usuarios u JOIN roles r ON r.id=u.rol_id ORDER BY u.id DESC')->fetchAll();
    }
}
