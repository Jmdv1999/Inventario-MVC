<?php
    class UsuariosModel extends Query{
        private $usuario, $nombre, $clave, $id_caja, $id, $estado;
        public function __construct(){
            parent::__construct();
        }
        public function getUsuario(string $usuario, string $clave){
            $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND clave = '$clave'";
            $data = $this->select($sql);
            return $data;
        }
        public function getUsuarios(){
            $sql = "SELECT users.*, cajas.id as id_caja, cajas.caja FROM usuarios users INNER JOIN caja cajas WHERE users.id_caja = cajas.id";
            $data = $this->selectAll($sql);
            return $data;
        }
        public function getCajas(){
            $sql = "SELECT * FROM caja WHERE estado = 1";
            $data = $this->selectAll($sql);
            return $data;
        }
        public function getPermisos(){
            $sql = "SELECT * FROM permisos";
            $data = $this->selectAll($sql);
            return $data;
        }
    
        public function RegistrarUsuaio(string $usuario, string $nombre, string $clave, int $id_caja){
            $this->usuario = $usuario;
            $this->nombre = $nombre;
            $this->clave = $clave;
            $this->id_caja = $id_caja;
            $verificar = "SELECT * FROM usuarios WHERE usuario = '$this->usuario'";
            $existe = $this->select($verificar);
            if (empty($existe)) {
                $sql = "INSERT INTO usuarios(usuario, nombre, clave, id_caja) VALUES (? ,? ,? ,? )";
                $datos = array($this->usuario, $this->nombre, $this->clave, $this->id_caja);
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
        public function ModificarUsuaio(string $usuario, string $nombre, int $id_caja, int $id){
            $this->usuario = $usuario;
            $this->nombre = $nombre;
            $this->id_caja = $id_caja;
            $this->id = $id;
                $sql = "UPDATE usuarios SET usuario = ?, nombre = ?, id_caja = ? WHERE id = ?";
                $datos = array($this->usuario, $this->nombre, $this->id_caja, $this->id);
                $data = $this->guardar($sql, $datos);
                if ($data == 1) {
                    $res = "modificado";
                }
                else{
                    $res = "error";
                }
            return $res;
        }
        public function EditarUser(int $id){
            $sql = "SELECT * FROM usuarios WHERE id = $id";
            $data = $this->select($sql); 
            return $data;
        }
        public function AccionUser(int $estado, int $id){
            $this->estado = $estado;
            $this->id = $id;
            $sql = "UPDATE usuarios SET estado = ? WHERE id = ?";
            $datos = array($this->estado, $this->id);
            $data = $this->guardar($sql, $datos);
            return $data;
        }
        public function getPass(string $clave, int $id){
            $sql = "SELECT * FROM usuarios WHERE clave = '$clave' AND id = $id";
            $data = $this->select($sql); 
            return $data;
        }
        public function modificarPass(string $clave, int $id){
            $sql = "UPDATE usuarios SET clave = ? WHERE id = ?";
            $datos = array($clave, $id);
            $data = $this->guardar($sql, $datos);
            return $data;
        }
        public function guardarPermisos(int $id_usuario, int $id_permiso)
        {
            $sql = "INSERT INTO detalle_permisos(id_usuario, id_permiso) VALUES (?,?)";
            $datos = array($id_usuario, $id_permiso);
            $data = $this->guardar($sql, $datos);
            if ($data == 1) {
                $res = "ok";
            }
            else{
                $res = "error";
            }
            return $res;
        }
        public function eleminarPermisos($id_usuario){
            $sql = "DELETE FROM detalle_permisos WHERE id_usuario = ?";
            $datos = array($id_usuario);
            $data = $this->guardar($sql, $datos);
            if ($data == 1) {
                $res = "ok";
            }
            else{
                $res = "error";
            }
            return $res;
        }
        public function getDetallePermisos(int $id_usuario){
            $sql ="SELECT * FROM detalle_permisos WHERE id_usuario = $id_usuario";
            $data = $this->selectAll($sql);
            return $data;
        }
        public function VerificarPermiso(int $id_usuario, string $nombre){
            $sql = "SELECT p.id, p.permiso, d.id AS id_detalle, d.id_usuario, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_usuario AND p.permiso = '$nombre'";
            $data = $this->selectAll($sql);
            return $data;
        }
    }
