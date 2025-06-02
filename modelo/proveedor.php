<?php
include_once 'Conexion.php';

class Proveedor {
    private $acceso;
    public $objetos;

    public function __construct() {
        $db = new Conexion(); // Crear una instancia de la conexión
        $this->acceso = $db->pdo; // Asignar la conexión a $acceso
    }

    public function crear($nombre,$telefono,$correo,$direccion,$avatar) {
        // Verificar si el laboratorio ya existe
        $sql = "SELECT id_proveedor FROM proveedor WHERE nombre = :nombre";
        $query = $this->acceso->prepare($sql);
        $query->execute([':nombre' => $nombre]);
        $this->objetos = $query->fetchAll();

        if (!empty($this->objetos)) {
            echo 'noadd'; // El laboratorio ya existe
        } else {
            // Insertar el nuevo laboratorio
            $sql = "INSERT INTO proveedor(nombre,telefono,correo,direccion,avatar) VALUES (:nombre,:telefono,:correo,:direccion,:avatar)";
            $query = $this->acceso->prepare($sql);
            $query->execute([':nombre' => $nombre,':telefono' => $telefono,':correo' => $correo,':direccion' => $direccion,':avatar' => $avatar]);
            echo 'add'; // Laboratorio agregado con éxito
        }
    }
    function buscar(){
        if(!empty($_POST['consulta'])){
            $consulta=$_POST['consulta'];
            $sql="SELECT * FROM proveedor WHERE nombre LIKE :consulta";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
        else{
            $sql="SELECT * FROM proveedor WHERE nombre NOT LIKE '' ORDER BY id_proveedor desc LIMIT 20";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchall();
            return $this->objetos;
        }
    }
    function cambiar_logo($id,$nombre){
        $sql="UPDATE proveedor SET avatar=:nombre WHERE id_proveedor=:id";
        $query=$this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id,':nombre'=>$nombre));
    }
    function borrar($id){
        $sql="DELETE FROM proveedor WHERE id_proveedor=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id));
        if(!empty($query->execute(array(':id'=>$id)))){
            echo 'borrado';
        }
        else{
            echo 'noborrado';
        }
    }
    function editar($id,$nombre,$telefono,$correo,$direccion){
            $sql = "SELECT id_proveedor FROM proveedor WHERE id_proveedor!=:id and nombre=:nombre";
            $query = $this->acceso->prepare($sql);
            $query->execute([':id'=>$id,':nombre' => $nombre]);
            $this->objetos = $query->fetchAll();
            if(!empty($this->objetos)){
                echo 'noedit';
            }

            else {
            $sql ="UPDATE proveedor SET nombre=:nombre, telefono=:telefono, correo=:correo, direccion=:direccion WHERE id_proveedor=:id";
            $query = $this->acceso->prepare($sql);
            $query->execute([':id'=>$id,':nombre' => $nombre,':telefono' => $telefono,':correo' => $correo,':direccion' => $direccion]);
            echo 'edit';
            }
            
    }
    function rellenar_proveedores(){
        $sql = "SELECT * FROM proveedor order by nombre asc";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }
}


    

?>
