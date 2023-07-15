<?php
class CategoriasModel extends Query{
    private $id, $nombre, $estado;
    public function __construct(){
        parent::__construct();
    }
    public function getCategorias(){
        $sql = "SELECT * FROM categorias WHERE id != 1";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function RegistrarCategoria(string $nombre){
        $this->nombre = $nombre;
        $verificar = "SELECT * FROM categorias WHERE nombre = '$this->nombre'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO categorias(nombre) VALUES (?)";
            $datos = array( $this->nombre);
            $data = $this->guardar($sql, $datos);
            if ($data == 1) {
                $res = "ok";
            }
            else{
                $res = "error";
            }
        }else{
            $res = "existe";
        }
        return $res;
    }
    public function ModificarCategoria(string $nombre, int $id){
        $this->nombre = $nombre;
        $this->id = $id;
        $sql = "UPDATE categorias SET nombre = ? WHERE id = ?";
        $datos = array($this->nombre, $this->id);
        $data = $this->guardar($sql, $datos);
        if($data == 1){
            $res = "modificado";
        }
        else{
            $res = "error";
        }
        return $res;
    }
    public function EditarCategoria(int $id){
        $sql = "SELECT * FROM categorias WHERE id = $id";
        $data = $this->select($sql); 
        return $data;
    }
    public function AccionCategoria(int $estado, int $id){
        $this->estado = $estado;
        $this->id = $id;
        $sql = "UPDATE categorias SET estado = ? WHERE id = ?";
        $datos = array($this->estado, $this->id);
        $data = $this->guardar($sql, $datos);
        return $data;
    }
    public function VerificarPermiso(int $id_usuario, string $nombre){
        $sql = "SELECT p.id, p.permiso, d.id AS id_detalle, d.id_usuario, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_usuario AND p.permiso = '$nombre'";
        $data = $this->selectAll($sql);
        return $data;
    }
}
?>