<?php
declare(strict_types=1);
require_once __DIR__.'/../config/database.php';

class Producto {
    public static function contar(string $search='', string $categoria=''): int {
        [$where,$params] = self::filtros($search,$categoria);
        $st=db()->prepare("SELECT COUNT(*) FROM productos $where"); $st->execute($params); return (int)$st->fetchColumn();
    }
    public static function listar(int $limit,int $offset,string $search='',string $categoria=''): array {
        [$where,$params] = self::filtros($search,$categoria);
        $sql="SELECT id,nombre,descripcion,categoria,precio,cantidad,created_at FROM productos $where ORDER BY id DESC LIMIT :lim OFFSET :off";
        $st=db()->prepare($sql); foreach($params as $k=>$v) $st->bindValue($k,$v); $st->bindValue(':lim',$limit,PDO::PARAM_INT); $st->bindValue(':off',$offset,PDO::PARAM_INT); $st->execute(); return $st->fetchAll();
    }
    private static function filtros(string $search,string $categoria): array {
        $w=[];$p=[]; if($search!==''){ $w[]='(nombre LIKE :q OR descripcion LIKE :q)'; $p[':q']='%'.$search.'%'; }
        if($categoria!=='' && $categoria!=='Todas'){ $w[]='categoria=:cat'; $p[':cat']=$categoria; }
        return [$w?'WHERE '.implode(' AND ',$w):'',$p];
    }
    public static function find(int $id): ?array { $s=db()->prepare('SELECT * FROM productos WHERE id=?');$s->execute([$id]);return $s->fetch()?:null; }
    public static function save(array $d): int { $s=db()->prepare('INSERT INTO productos(nombre,descripcion,categoria,precio,cantidad) VALUES(?,?,?,?,?)');$s->execute([$d['nombre'],$d['descripcion'],$d['categoria'],$d['precio'],$d['cantidad']]);return (int)db()->lastInsertId(); }
    public static function update(int $id,array $d): void { $s=db()->prepare('UPDATE productos SET nombre=?,descripcion=?,categoria=?,precio=?,cantidad=? WHERE id=?');$s->execute([$d['nombre'],$d['descripcion'],$d['categoria'],$d['precio'],$d['cantidad'],$id]); }
    public static function delete(int $id): void { $s=db()->prepare('DELETE FROM productos WHERE id=?');$s->execute([$id]); }
    public static function categorias(): array { return db()->query('SELECT DISTINCT categoria FROM productos ORDER BY categoria')->fetchAll(PDO::FETCH_COLUMN); }
    public static function estadisticas(): array { return db()->query("SELECT COUNT(*) total, SUM(categoria='Tecnología') tecnologia, SUM(categoria='Oficina') oficina, SUM(categoria='Accesorios') accesorios FROM productos")->fetch(); }
    public static function todos(): array { return db()->query('SELECT id,nombre,descripcion,categoria,precio,cantidad,created_at FROM productos ORDER BY id DESC')->fetchAll(); }
}
