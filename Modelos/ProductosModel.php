<?php
header('Access-Control-Allow-Origin: *');
    class ProductosModel extends Query{
        private $codigo, $descripcion, $precio_compra, $precio_venta, $categoria, $id, $estado, $img;
        public function __construct(){
            parent::__construct();
        }
        public function getProductos(){
            $sql = "SELECT p.*, c.id AS idcategoria, c.nombre AS nombrecategoria FROM productos  p INNER JOIN categorias c ON p.id_categoria = c.id WHERE p.estado = 1";
            $data = $this->selectAll($sql);
            return $data;
        }
        public function getCategorias(){
            $sql = "SELECT * FROM categorias WHERE estado = 1";
            $data = $this->selectAll($sql);
            return $data;
        }
        public function RegistrarProducto(string $codigo, string $descripcion, string $precio_compra, string $precio_venta, int $categoria, string $img){
            $this->codigo = $codigo;
            $this->descripcion = $descripcion;
            $this->precio_compra = $precio_compra;
            $this->precio_venta = $precio_venta;
            $this->categoria = $categoria;
            $this->img = $img;
            $verificar = "SELECT * FROM productos WHERE codigo = '$this->codigo'";
            $existe = $this->select($verificar);
            if (empty($existe)) {
                $sql = "INSERT INTO productos(codigo, descripcion, precio_compra, precio_venta, id_categoria, foto) VALUES (?, ?, ?, ?, ?, ?)";
                $datos = array($this->codigo, $this->descripcion, $this->precio_compra, $this->precio_venta ,$this->categoria, $this->img);
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
        public function ModificarProducto(string $codigo, string $descripcion, string $precio_compra, string $precio_venta, int $categoria, string $img, int $id){
            $this->codigo = $codigo;
            $this->descripcion = $descripcion;
            $this->precio_compra = $precio_compra;
            $this->precio_venta = $precio_venta;
            $this->categoria = $categoria;
            $this->id = $id;
            $this->img = $img;
            $sql = "UPDATE productos SET codigo = ?, descripcion = ?, precio_compra = ?, precio_venta = ?, id_categoria = ?, foto = ? WHERE id = ?";
                $datos = array($this->codigo, $this->descripcion, $this->precio_compra, $this->precio_venta, $this->categoria, $this->img, $this->id);
                $data = $this->guardar($sql, $datos);
                if ($data == 1) {
                    $res = "modificado";
                }
                else{
                    $res = "error";
                }
            return $res;
        }
        public function EditarProducto(int $id){
            $sql = "SELECT * FROM productos WHERE id = $id";
            $data = $this->select($sql); 
            return $data;
        }
        public function AccionProducto(int $estado, int $id){
            $this->estado = $estado;
            $this->id = $id;
            $sql = "UPDATE productos SET estado = ? WHERE id = ?";
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