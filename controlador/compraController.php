<?php
include '../modelo/venta.php';
include_once '../modelo/Conexion.php';
$venta = new Venta();
session_start();
$vendedor = $_SESSION['usuario'];
if($_POST['funcion']=='registrar_compra'){
    $total=$_POST['total'];
    $nombre=$_POST['nombre'];
    $dni=$_POST['dni'];
    $productos=json_decode($_POST['json']);
    date_default_timezone_set('America/Argentina/Salta');
    $fecha = date('Y-m-d H:i:s');
    $venta->Crear($nombre,$dni,$total,$fecha,$vendedor);
    $venta->ultima_venta();
    foreach ($venta->objetos as $objeto) {
        $id_venta = $objeto->ultima_venta;
        echo $id_venta;
    }
    try {
        $db = new Conexion();
        $conexion = $db->pdo;
        $conexion->beginTransaction();
        foreach ($productos as $prod) {
            $cantidad = $prod->cantidad;
            while ($cantidad != 0) {
                $sql="SELECT * FROM lote where vencimiento = (SELECT MIN(vencimiento) from lote where lote_id_prod=:id) and lote_id_prod=:id";
                $query = $conexion->prepare($sql);
                $query->execute(array(':id'=>$prod->id));
                $lote=$query->fetchall();
                foreach ($lote as $llote) {
                    if($cantidad<$llote->stock){
                        $sql="INSERT INTO detalle_venta(det_cantidad,det_vencimiento,id_det_lote,id_det_prod,lote_id_prov,id_det_venta) values ('$cantidad','$llote->vencimiento','$llote->id_lote','$prod->id','$llote->lote_id_prov','$id_venta')";
                        $conexion->exec($sql);
                        $conexion->exec("UPDATE lote SET stock= stock-'$cantidad' where id_lote='$llote->id_lote'");
                        $cantidad=0;
                    }
                    if($cantidad==$llote->stock){
                        $sql="INSERT INTO detalle_venta(det_cantidad,det_vencimiento,id_det_lote,id_det_prod,lote_id_prov,id_det_venta) values ('$cantidad','$llote->vencimiento','$llote->id_lote','$prod->id','$llote->lote_id_prov','$id_venta')";
                        $conexion->exec($sql);
                        $conexion->exec("DELETE FROM lote where id_lote='$llote->id_lote'");
                        $cantidad=0;
                    }
                    if($cantidad>$llote->stock){
                        $sql="INSERT INTO detalle_venta(det_cantidad,det_vencimiento,id_det_lote,id_det_prod,lote_id_prov,id_det_venta) values ('$llote->stock','$llote->vencimiento','$llote->id_lote','$prod->id','$llote->lote_id_prov','$id_venta')";
                        $conexion->exec($sql);
                        $conexion->exec("DELETE FROM lote where id_lote='$llote->id_lote'");
                        $cantidad=$cantidad-$llote->stock;
                        
                    }
                }
            }
            $subtotal = $prod->cantidad*$prod->precio;
            $conexion->exec("INSERT INTO venta_producto(cantidad,subtotal,producto_id_producto,venta_id_venta) values('$prod->cantidad','$subtotal','$prod->id','$id_venta')");
        }
        $conexion->commit();
    } catch (Exception $error) {
        $conexion->rollBack();
        $venta->borrar($id_venta);
        echo $error->getMessage();
    }
}



?>