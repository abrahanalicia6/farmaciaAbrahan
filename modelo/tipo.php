<?php
include_once 'Conexion.php';
class Tipo {
    private $acceso;
    public $objetos;

    public function __construct() {
        $db = new Conexion(); // Crear una instancia de la conexión
        $this->acceso = $db->pdo; // Asignar la conexión a $acceso
    }
    public function crear($nombre) {
        // Verificar si el laboratorio ya existe
        $sql = "SELECT id_tip_prod FROM tipo_producto WHERE nombre=:nombre";
        $query = $this->acceso->prepare($sql);
        $query->execute([':nombre' => $nombre]);
        $this->objetos = $query->fetchAll();
        if (!empty($this->objetos)) {
            echo 'noadd'; // El laboratorio ya existe
        } else {
            // Insertar el nuevo laboratorio
            $sql = "INSERT INTO tipo_producto(nombre) VALUES (:nombre);";
            $query = $this->acceso->prepare($sql);
            $query->execute([':nombre' => $nombre]);
            echo 'add'; // Laboratorio agregado con éxito
        }
    }
    function buscar(){
        if(!empty($_POST['consulta'])){
            $consulta=$_POST['consulta'];
            $sql="SELECT * FROM tipo_producto WHERE nombre LIKE :consulta";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
        else{
            $sql="SELECT * FROM tipo_producto WHERE nombre NOT LIKE '' ORDER BY id_tip_prod LIMIT 20";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }
    function borrar($id){
        $sql="DELETE FROM tipo_producto WHERE id_tip_prod=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id));
        if(!empty($query->execute(array(':id'=>$id)))){
            echo 'borrado';
        }
        else{
            echo 'noborrado';
        }
    }
    function editar($nombre,$id_editado){
        $sql="UPDATE tipo_producto SET nombre=:nombre WHERE id_tip_prod=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id_editado,':nombre'=>$nombre));
        echo 'edit';
    }
    function rellenar_tipos(){
        $sql="SELECT * FROM tipo_producto order by nombre asc";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }
}
?>