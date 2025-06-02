<?php
include_once 'Conexion.php';
class Producto {
    private $acceso;
    public $objetos;
    public function __construct() {
        $db = new Conexion(); // Crear una instancia de la conexión
        $this->acceso = $db->pdo; // Asignar la conexión a $acceso
    }
    public function crear($nombre, $concentracion, $adicional, $precio, $laboratorio, $tipo, $presentacion, $avatar) {
        // Verificar si el laboratorio ya existe
        $sql = "SELECT id_producto FROM producto WHERE nombre=:nombre and concentracion=:concentracion and adicional=:adicional and prod_lab=:laboratorio and prod_tip_prod=:tipo and prod_pre=:presentacion";
        $query = $this->acceso->prepare($sql);
        $query->execute([':nombre' => $nombre,':concentracion' => $concentracion,':adicional' => $adicional,':laboratorio' => $laboratorio,':tipo' => $tipo,':presentacion' => $presentacion]);
        $this->objetos = $query->fetchAll();

        if (!empty($this->objetos)) {
            echo 'noadd'; // El laboratorio ya existe
        } else {
            // Insertar el nuevo laboratorio
            $sql = "INSERT INTO producto (nombre,concentracion,adicional,precio,prod_lab,prod_tip_prod,prod_pre,avatar) VALUES (:nombre,:concentracion,:adicional,:precio,:laboratorio,:tipo,:presentacion,:avatar)";
            $query = $this->acceso->prepare($sql);
            $query->execute([':nombre' => $nombre,':concentracion' => $concentracion,':adicional' => $adicional,':laboratorio' => $laboratorio,':tipo' => $tipo,':presentacion' => $presentacion,':precio' => $precio,':avatar' => $avatar]);
            echo 'add'; // Laboratorio agregado con éxito
        }
    }
    public function editar($id,$nombre,$concentracion,$adicional,$precio,$laboratorio,$tipo,$presentacion) {
        // Verificar si el laboratorio ya existe
        $sql = "SELECT id_producto FROM producto WHERE id_producto!=:id and nombre=:nombre and concentracion=:concentracion and adicional=:adicional and prod_lab=:laboratorio and prod_tip_prod=:tipo and prod_pre=:presentacion";
        $query = $this->acceso->prepare($sql);
        $query->execute([':id'=>$id,':nombre' => $nombre,':concentracion' => $concentracion,':adicional' => $adicional,':laboratorio' => $laboratorio,':tipo' => $tipo,':presentacion' => $presentacion]);
        $this->objetos = $query->fetchAll();

        if (!empty($this->objetos)) {
            echo 'noedit'; // El laboratorio ya existe
        } else {
            // Insertar el nuevo laboratorio
            $sql = "UPDATE producto SET nombre=:nombre, concentracion=:concentracion, adicional=:adicional, prod_lab=:laboratorio, prod_tip_prod=:tipo, prod_pre=:presentacion, precio=:precio where id_producto=:id";
            $query = $this->acceso->prepare($sql);
            $query->execute([':id'=>$id,':nombre' => $nombre,':concentracion' => $concentracion,':adicional' => $adicional,':laboratorio' => $laboratorio,':tipo' => $tipo,':presentacion' => $presentacion,':precio' => $precio]);
            echo 'edit'; // Laboratorio agregado con éxito
        }
    }
    function buscar(){
        if(!empty($_POST['consulta'])){
            $consulta=$_POST['consulta'];
            $sql="SELECT id_producto, producto.nombre as nombre, concentracion, adicional, 
            precio, laboratorio.nombre as laboratorio, tipo_producto.nombre as tipo, presentacion.nombre as presentacion,
            producto.avatar as avatar,prod_lab,prod_tip_prod,prod_pre FROM producto JOIN laboratorio ON prod_lab=id_laboratorio JOIN tipo_producto ON 
            prod_tip_prod=id_tip_prod JOIN presentacion on prod_pre=id_presentacion and producto.nombre like :consulta limit 25";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
        else{
            $sql="SELECT id_producto, producto.nombre as nombre, concentracion, adicional, 
            precio, laboratorio.nombre as laboratorio, tipo_producto.nombre as tipo, presentacion.nombre as presentacion,
            producto.avatar as avatar,prod_lab,prod_tip_prod,prod_pre FROM producto JOIN laboratorio ON prod_lab=id_laboratorio JOIN tipo_producto ON 
            prod_tip_prod=id_tip_prod JOIN presentacion on prod_pre=id_presentacion and producto.nombre not like '' order by producto.nombre limit 25";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }
    function cambiar_logo($id,$nombre){
        $sql="UPDATE producto SET avatar=:nombre WHERE id_producto=:id";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id,':nombre'=>$nombre));
    }
    function borrar($id){
        $sql="DELETE FROM producto WHERE id_producto=:id";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id));
        if(!empty($query->execute(array(':id'=>$id)))){
            echo 'borrado';
        }
        else{
            echo 'noborrado';
        }
    }
    function obtener_stock($id){
        $sql="SELECT SUM(stock) as total FROM lote where lote_id_prod=:id";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id));
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
    function buscar_id($id){
        $sql="SELECT id_producto, producto.nombre as nombre, concentracion, adicional, 
        precio, laboratorio.nombre as laboratorio, tipo_producto.nombre as tipo, presentacion.nombre as presentacion,
        producto.avatar as avatar,prod_lab,prod_tip_prod,prod_pre FROM producto JOIN laboratorio ON prod_lab=id_laboratorio JOIN tipo_producto ON 
        prod_tip_prod=id_tip_prod JOIN presentacion on prod_pre=id_presentacion where id_producto=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id));
        $this->objetos=$query->fetchall();
        return $this->objetos;
    }
}
?>
