<?php

require('../api/Config/DBconfig.php');


$tabla=$_POST['tabla'];
$tokenEvento=$_POST['tokenevento'];

$lang=isset($_SESSION['lang']) ? $_SESSION['lang'] : 'es';
$querycategorias="SELECT a.idCategoria, b.categoria_es, b.categoria_en
FROM tbl_categorias_eventos a
INNER JOIN tbl_categorias b ON a.idCategoria = b.id
INNER JOIN tbl_eventos c ON a.idEvento = c.id
WHERE c.tag ='$tokenEvento' and b.tipo='$tabla'
ORDER BY b.categoria_$lang ASC";
$categorias=$basededatos->connect()->prepare($querycategorias);
$categorias->execute();     
$Allcategorias=$categorias->fetchAll(PDO::FETCH_ASSOC);





print json_encode($Allcategorias, JSON_UNESCAPED_UNICODE);