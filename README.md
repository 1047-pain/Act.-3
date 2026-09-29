# Actividad 3 U3 - Proyecto Web II

Aplicación PHP + MySQL basada en el módulo responsive Bootstrap entregado previamente.

## Funcionalidades
- Login seguro con `password_hash()` / `password_verify()`.
- Sesiones y cierre de sesión.
- Roles Administrador y Usuario.
- Protección de rutas en servidor.
- CRUD de productos para Administrador.
- Consulta para Usuario.
- Paginación dinámica con AJAX + jQuery + MySQL (`LIMIT/OFFSET`).
- Exportación PDF, Excel y Word.
- Interfaz responsive Bootstrap y rejilla de 12 columnas.

## Instalación en XAMPP
1. Copiar `ACTIVIDAD3_SOLUCION` dentro de `C:\xampp\htdocs\`.
2. Abrir XAMPP y activar Apache y MySQL.
3. Entrar a phpMyAdmin.
4. Importar `database/actividad3.sql`.
5. Verificar `config/database.php` (por defecto root sin contraseña).
6. Abrir `http://localhost/ACTIVIDAD3_SOLUCION/login.php`.

## Usuarios de prueba
- Administrador: `admin` / `admin123`
- Usuario: `usuario` / `usuario123`

## Notas
Excel y Word se generan mediante exportación HTML compatible con sus formatos. El PDF se genera desde PHP sin depender de una instalación externa, para que el proyecto funcione inmediatamente en XAMPP.
