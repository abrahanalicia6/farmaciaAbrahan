<?php
include_once 'Conexion.php';

class Lote {
    private $acceso;
    public $objetos;

    public function __construct() {
        $db = new Conexion(); // Crear una instancia de la conexión
        $this->acceso = $db->pdo; // Asignar la conexión a $acceso
    }
    function crear($id_producto,$proveedor,$stock,$vencimiento){
           // Verificar si el laboratorio ya existe
        $sql = "INSERT INTO lote(stock,vencimiento,lote_id_prod,lote_id_prov) values (:stock,:vencimiento,:id_producto,:id_proveedor)";
        $query = $this->acceso->prepare($sql);
        $query->execute([':stock' => $stock,':vencimiento' => $vencimiento,':id_producto' => $id_producto,':id_proveedor' => $proveedor]);
        echo 'add';
        
    }
    function buscar(){
        if(!empty($_POST['consulta'])){
            $consulta=$_POST['consulta'];
            $sql="SELECT id_lote,stock,vencimiento,concentracion,adicional, producto.nombre as prod_nombre, laboratorio.nombre as
            lab_nombre, tipo_producto.nombre as tipo_nombre, presentacion.nombre as presentacion_nombre,proveedor.nombre
            as proveedor, producto.avatar as logo FROM lote JOIN proveedor ON lote_id_prov=id_proveedor JOIN 
            producto ON lote_id_prod=id_producto JOIN laboratorio ON prod_lab=id_laboratorio JOIN 
            tipo_producto on prod_tip_prod=id_tip_prod JOIN presentacion on prod_pre=id_presentacion and producto.nombre 
            like :consulta ORDER BY producto.nombre limit 25";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
        else{
            $sql="SELECT id_lote,stock,vencimiento,concentracion,adicional, 
            producto.nombre as prod_nombre, laboratorio.nombre as lab_nombre, tipo_producto.nombre as tipo_nombre, 
            presentacion.nombre as presentacion_nombre,proveedor.nombre as proveedor, producto.avatar as logo 
            FROM lote JOIN proveedor ON lote_id_prov=id_proveedor JOIN producto ON lote_id_prod=id_producto 
            JOIN laboratorio ON prod_lab=id_laboratorio JOIN tipo_producto on prod_tip_prod=id_tip_prod 
            JOIN presentacion on prod_pre=id_presentacion and producto.nombre not like '' ORDER BY 
            producto.nombre limit 25";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }
    function editar($id,$stock){
        $sql = "UPDATE lote SET stock=:stock where id_lote=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute([':id' => $id,':stock' => $stock]);
        echo 'edit';
    }
    function borrar($id){
        $sql="DELETE FROM lote WHERE id_lote=:id";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id));
        if(!empty($query->execute(array(':id'=>$id)))){
            echo 'borrado';
        }
        else{
            echo 'noborrado';
        }
    }
    function devolver($id_lote,$cantidad,$vencimiento,$producto,$proveedor){
        $sql="SELECT * FROM lote WHERE id_lote=:id_lote";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_lote'=>$id_lote));
        $lote=$query->fetchall();
        if(!empty($lote)){
            $sql = "UPDATE lote SET stock = stock + :cantidad WHERE id_lote = :id_lote";
            $query = $this->acceso->prepare($sql);
            $query->execute([':cantidad' => $cantidad,':id_lote' => $id_lote]);
        }
        else{
            $sql="SELECT * FROM lote WHERE vencimiento=:vencimiento AND lote_id_prod=:producto AND lote_id_prov=:proveedor";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':vencimiento'=>$vencimiento,':producto'=>$producto,':proveedor'=>$proveedor));
            $lote_nuevo=$query->fetchall();
            foreach ($lote_nuevo as $objeto) {
                $id_lote_nuevo = $objeto->id_lote;
            }
            if(!empty($lote_nuevo)){
                $sql = "UPDATE lote SET stock=:stock+cantidad WHERE id_lote=:id_lote";
                $query = $this->acceso->prepare($sql);
                $query->execute([':cantidad' => $cantidad,':id_lote' => $id_lote_nuevo]);
            }
            else{
                $sql = "INSERT INTO lote(id_lote,stock,vencimiento,lote_id_prod,lote_id_prov) VALUES(:id_lote,:stock,:vencimiento,:producto,:proveedor)";
                $query = $this->acceso->prepare($sql);
                $query->execute([':id_lote' => $id_lote,':stock' => $cantidad,':vencimiento' => $vencimiento,':producto' => $producto,':proveedor' => $proveedor]);
            }
        }
    }
}
    ?>