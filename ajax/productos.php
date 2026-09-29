<?php
declare(strict_types=1); require_once __DIR__.'/../middleware/auth.php'; require_login(); require_once __DIR__.'/../models/Producto.php'; header('Content-Type: application/json; charset=utf-8');
try {
  $accion=$_GET['accion']??'listar';
  if($accion==='listar'){ $page=max(1,(int)($_GET['page']??1));$limit=5;$search=trim($_GET['search']??'');$cat=trim($_GET['categoria']??'');$total=Producto::contar($search,$cat);$pages=max(1,(int)ceil($total/$limit));$page=min($page,$pages);$items=Producto::listar($limit,($page-1)*$limit,$search,$cat); echo json_encode(['ok'=>true,'items'=>$items,'page'=>$page,'pages'=>$pages,'total'=>$total]); exit; }
  require_role('Administrador');
  $method=$_SERVER['REQUEST_METHOD']; $data=json_decode(file_get_contents('php://input'),true) ?: $_POST;
  if($accion==='guardar' && $method==='POST'){ foreach(['nombre','categoria','precio','cantidad'] as $f) if(!isset($data[$f]) || trim((string)$data[$f])==='') throw new Exception('Complete los campos obligatorios.'); $d=['nombre'=>trim($data['nombre']),'descripcion'=>trim($data['descripcion']??''),'categoria'=>trim($data['categoria']),'precio'=>(float)$data['precio'],'cantidad'=>(int)$data['cantidad']]; if($d['precio']<=0||$d['cantidad']<0) throw new Exception('Precio o cantidad inválidos.'); $id=(int)($data['id']??0); if($id) Producto::update($id,$d); else $id=Producto::save($d); echo json_encode(['ok'=>true,'id'=>$id]); exit; }
  if($accion==='obtener'){ $p=Producto::find((int)($_GET['id']??0)); echo json_encode(['ok'=>(bool)$p,'producto'=>$p]); exit; }
  if($accion==='eliminar' && $method==='POST'){ Producto::delete((int)($data['id']??0)); echo json_encode(['ok'=>true]); exit; }
  throw new Exception('Acción no válida.');
} catch(Throwable $e){ http_response_code(400); echo json_encode(['ok'=>false,'error'=>$e->getMessage()]); }
