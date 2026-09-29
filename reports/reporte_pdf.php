<?php
require_once __DIR__.'/../middleware/auth.php'; require_login(); require_once __DIR__.'/../models/Producto.php';
$rows=Producto::todos();
function pdfText(string $s): string { $s=str_replace(['\\','(',')'],['\\\\','\\(','\\)'],$s); return iconv('UTF-8','windows-1252//TRANSLIT',$s) ?: $s; }
$lines=['PROYECTO WEB - REPORTE DE PRODUCTOS','Fecha: '.date('d/m/Y H:i'),'','ID   PRODUCTO                 CATEGORIA       PRECIO        CANTIDAD','---------------------------------------------------------------'];
foreach($rows as $r){$lines[]=sprintf('%-4s %-24s %-15s $%-11s %-8s',$r['id'],mb_strimwidth($r['nombre'],0,24,'','UTF-8'),mb_strimwidth($r['categoria'],0,15,'','UTF-8'),number_format((float)$r['precio'],0,',','.'),$r['cantidad']);}
$stream="BT /F1 10 Tf 45 800 Td "; foreach($lines as $i=>$line){if($i>0)$stream.="0 -16 Td ";$stream.='('.pdfText($line).') Tj ';}$stream.='ET';
$objects=[];$objects[]='<< /Type /Catalog /Pages 2 0 R >>';$objects[]='<< /Type /Pages /Kids [3 0 R] /Count 1 >>';$objects[]='<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 842] /Resources << /Font << /F1 5 0 R >> >> /Contents 4 0 R >>';$objects[]='<< /Length '.strlen($stream).' >>\nstream\n'.$stream.'\nendstream';$objects[]='<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>';
$pdf="%PDF-1.4\n";$offs=[0];foreach($objects as $n=>$obj){$offs[] = strlen($pdf);$pdf.=($n+1)." 0 obj\n".$obj."\nendobj\n";}$xref=strlen($pdf);$pdf.="xref\n0 ".(count($objects)+1)."\n0000000000 65535 f \n";for($i=1;$i<=count($objects);$i++)$pdf.=sprintf('%010d 00000 n \n',$offs[$i]);$pdf.="trailer\n<< /Size ".(count($objects)+1)." /Root 1 0 R >>\nstartxref\n$xref\n%%EOF";header('Content-Type: application/pdf');header('Content-Disposition: inline; filename="reporte_productos.pdf"');echo $pdf;
