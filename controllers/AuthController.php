<?php
declare(strict_types=1);
require_once __DIR__.'/../models/Usuario.php';
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

$error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $usuario=trim($_POST['usuario']??''); $password=$_POST['password']??'';
    $u=Usuario::autenticar($usuario,$password);
    if($u){ session_regenerate_id(true); $_SESSION['usuario_id']=$u['id']; $_SESSION['usuario']=$u['usuario']; $_SESSION['rol']=$u['nombre_rol']; header('Location: index.php'); exit; }
    $error='Usuario, contraseña o estado de cuenta incorrectos.';
}
require __DIR__.'/../views/login.php';
