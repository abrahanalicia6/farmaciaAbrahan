<?php
include_once 'Conexion.php';

class DetalleVenta {
    private $acceso;
    public $objetos;

    public function __construct() {
        $db = new Conexion(); // Crear una instancia de la conexión
        $this->acceso = $db->pdo; // Asignar la conexión a $acceso
    }
    function recuperar($id_venta){
        $sql="SELECT * FROM detalle_venta WHERE id_det_venta=:id_venta ";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_venta'=>$id_venta));
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
    function borrar($id_detalle){
        $sql="DELETE FROM detalle_venta WHERE id_detalle=:id_detalle";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_detalle'=>$id_detalle));
    }
}

?>
