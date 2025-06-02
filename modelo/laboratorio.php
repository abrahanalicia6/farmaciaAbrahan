<?php
include_once 'Conexion.php';

class Laboratorio {
    private $acceso;
    public $objetos;

    public function __construct() {
        $db = new Conexion(); // Crear una instancia de la conexión
        $this->acceso = $db->pdo; // Asignar la conexión a $acceso
    }

    public function crear($nombre, $avatar) {
        // Verificar si el laboratorio ya existe
        $sql = "SELECT id_laboratorio FROM laboratorio WHERE nombre = :nombre";
        $query = $this->acceso->prepare($sql);
        $query->execute([':nombre' => $nombre]);
        $this->objetos = $query->fetchAll();

        if (!empty($this->objetos)) {
            echo 'noadd'; // El laboratorio ya existe
        } else {
            // Insertar el nuevo laboratorio
            $sql = "INSERT INTO laboratorio (nombre, avatar) VALUES (:nombre, :avatar)";
            $query = $this->acceso->prepare($sql);
            $query->execute([':nombre' => $nombre, ':avatar' => $avatar]);
            echo 'add'; // Laboratorio agregado con éxito
        }
    }
    function buscar(){
        if(!empty($_POST['consulta'])){
            $consulta=$_POST['consulta'];
            $sql="SELECT * FROM laboratorio WHERE nombre LIKE :consulta";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
        else{
            $sql="SELECT * FROM laboratorio WHERE nombre NOT LIKE '' ORDER BY id_laboratorio  LIMIT 20";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }
    
    function cambiar_logo($id,$nombre){
        $sql="SELECT avatar FROM laboratorio WHERE id_laboratorio=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id));
        $this->objetos = $query->fetchall();
            $sql="UPDATE laboratorio SET avatar=:nombre WHERE id_laboratorio=:id";
            $query=$this->acceso->prepare($sql);
            $query->execute(array(':id'=>$id,':nombre'=>$nombre));
        return $this->objetos;
    }
    function borrar($id){
        $sql="DELETE FROM laboratorio WHERE id_laboratorio=:id";
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
        $sql="UPDATE laboratorio SET nombre=:nombre WHERE id_laboratorio=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id_editado,':nombre'=>$nombre));
        echo 'edit';
    }
    function rellenar_laboratorios(){
        $sql="SELECT * FROM laboratorio order by nombre asc";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }
}
?>
