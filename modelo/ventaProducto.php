<?php
include_once 'Conexion.php';

class ventaProducto {
    private $acceso;
    public $objetos;

    public function __construct() {
        $db = new Conexion(); // Crear una instancia de la conexión
        $this->acceso = $db->pdo; // Asignar la conexión a $acceso
    }
    function ver($id){
        $sql="SELECT precio,cantidad,producto.nombre AS producto,concentracion,adicional,laboratorio.nombre as laboratorio,
        presentacion.nombre AS presentacion, tipo_producto.nombre as tipo, subtotal
        FROM venta_producto JOIN producto ON producto_id_producto = id_producto and venta_id_venta=:id 
        JOIN laboratorio ON prod_lab = id_laboratorio
        JOIN tipo_producto ON prod_tip_prod = id_tip_prod
        JOIN presentacion ON prod_pre = id_presentacion ";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id));
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
    function borrar($id_venta){
        $sql="DELETE FROM venta_producto WHERE venta_id_venta=:id_venta";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_venta'=>$id_venta));
    }
}

?>
