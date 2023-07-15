<?php
    class ClientesModel extends Query{
        private $cedula, $nombre, $telefono, $direccion, $id, $estado;
        public function __construct(){
            parent::__construct();
        }
        public function getClientes(){
            $sql = "SELECT * FROM clientes WHERE id != 1";
            $data = $this->selectAll($sql);
            return $data;
        }
        public function RegistrarCliente(string $cedula, string $nombre, string $telefono, string $direccion){
            $this->cedula = $cedula;
            $this->nombre = $nombre;
            $this->telefono = $telefono;
            $this->direccion = $direccion;
            $verificar = "SELECT * FROM clientes WHERE cedula = '$this->cedula'";
            $existe = $this->select($verificar);
            if (empty($existe)) {
                $sql = "INSERT INTO clientes(cedula, nombre, telefono, direccion) VALUES (? ,? ,? ,? )";
                $datos = array($this->cedula, $this->nombre, $this->telefono, $this->direccion);
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
        public function ModificarCliente(string $cedula, string $nombre, string $telefono, string $direccion, int $id){
            $this->cedula       = $cedula;
            $this->nombre       = $nombre;
            $this->telefono     = $telefono;
            $this->direccion    = $direccion;
            $this->id           = $id;
                $sql = "UPDATE clientes SET cedula = ?, nombre = ?, telefono = ?, direccion = ? WHERE id = ?";
                $datos = array($this->cedula, $this->nombre, $this->telefono, $this->direccion, $this->id);
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
            $sql = "SELECT * FROM clientes WHERE id = $id";
            $data = $this->select($sql); 
            return $data;
        }
        public function EliminarCliente(int $estado, int $id){
            $this->estado = $estado;
            $this->id = $id;
            $sql = "UPDATE clientes SET estado = ? WHERE id = ?";
            $datos = array($this->estado, $this->id);
            $data = $this->guardar($sql, $datos);
            return $data;
        }
    }
?>