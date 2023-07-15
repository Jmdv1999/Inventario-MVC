<?php
class ComprasModel extends Query{
    public function __construct(){
        parent::__construct();
    }
    public function getProducto(string $codigo){
        $sql = "SELECT * FROM productos WHERE codigo = '$codigo'";
        $data = $this->select($sql);
        return $data;
    }
    public function listarProductos(){
        $sql = "SELECT * FROM productos";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getProductos(int $id){
        $sql = "SELECT * FROM productos WHERE id = '$id'";
        $data = $this->select($sql);
        return $data;
    }
    public function registrarDetalle(int $id_producto, int $id_usuario, string $precio, string $cantidad, string $subtotal){
        $sql = "INSERT INTO detalles_temp_compras(id_producto, id_usuario, precio, cantidad, subtotal) VALUES (?,?,?,?,?)";
        $datos = array($id_producto, $id_usuario, $precio, $cantidad, $subtotal);
        $data = $this->guardar($sql, $datos);
        if($data == 1){
            $res = "ok";
        }
        else{
            $res = "error";
        }
        return $res;
    }
    public function getDetalle(int $id){
        $sql = "SELECT d.*, p.id AS id_producto, p.descripcion FROM detalles_temp_compras d INNER JOIN productos p ON d.id_producto = p.id WHERE d.id_usuario = $id";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function calcularCompra(int $id_usuario){
        $sql = "SELECT subtotal, SUM(subtotal) AS total FROM detalles_temp_compras WHERE id_usuario = $id_usuario";
        $data = $this->select($sql);
        return $data;
    }
    public function borrarCompra(int $id){
        $sql = "DELETE FROM detalles_temp_compras WhERE id = ?";
        $datos = array($id);
        $data = $this->guardar($sql, $datos);
        if($data == 1){
            $res = "ok";
        }
        else{
            $res = "error";
        }
        return $res;
    }
    public function consultarDetalle(int $id_producto, int $id_usuario){
        $sql = "SELECT * FROM detalles_temp_compras WHERE id_producto = $id_producto AND id_usuario = $id_usuario";
        $data = $this->select($sql);
        return $data;
    }
    public function actualizarDetalle(string $precio, string $cantidad, string $subtotal, int $id_producto, int $id_usuario){
        $sql = "UPDATE detalles_temp_compras SET precio = ?, cantidad = ?, subtotal = ? WHERE id_producto = ? AND id_usuario = ?";
        $datos = array($precio, $cantidad, $subtotal, $id_producto, $id_usuario );
        $data = $this->guardar($sql, $datos);
        if($data == 1){
            $res = "modificado";
        }
        else{
            $res = "error";
        }
        return $res;
    }
    public function registrarCompra(string $total){
        $sql = "INSERT INTO compras (total) VALUES (?)";
        $datos = array($total);
        $data = $this->guardar($sql, $datos);
        if($data == 1){
            $res = "ok";
        }
        else{
            $res = "error";
        }
        return $res;
    }
    public function idCompra(){
        $sql = "SELECT MAX(id) AS id FROM compras ";
        $data = $this->select($sql);
        return $data;
    }
    public function registrarDetalleCompra(int $id_compra, int $id_producto,string $cantidad, string $precio, string $subtotal){
        $sql = "INSERT INTO detalles_compra(id_compra, id_producto, cantidad, precio, subtotal) VALUES (?,?,?,?,?)";
        $datos = array($id_compra, $id_producto, $cantidad, $precio , $subtotal);
        $data = $this->guardar($sql, $datos);
        if($data == 1){
            $res = "ok";
        }
        else{
            $res = "error";
        }
        return $res;
    }
    public function vaciarDetalle($id_usuario){
        $sql = "DELETE FROM detalles_temp_compras WHERE id_usuario = ?";
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
    public function getEmpresa(){
        $sql = "SELECT * FROM configuracion";
        $data = $this->select($sql);
        return $data;
    }
    public function getProCompra(int $id_compra){
        $sql = "SELECT c.*, d.*, p.id, p.descripcion FROM compras c INNER JOIN detalles_compra d ON c.id = d.id_compra INNER JOIN productos p ON p.id = d.id_producto WHERE c.id = $id_compra";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getHistorial(){
        $sql = "SELECT * FROM compras ORDER BY estado DESC ";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function actualizarStock(string $cantidad, int $id){
        $sql = "UPDATE productos SET cantidad = ? WHERE id = ?";
        $datos = array($cantidad, $id);
        $data = $this->guardar($sql, $datos);
        return $data;
    }
    public function getAnular($id){
        $sql = "UPDATE compras SET estado= ? WHERE id = ?";
        $datos = array(0, $id);
        $data = $this->guardar($sql, $datos);
        if ($data == 1) {
            $res = 'ok';
        }
        else{
            $res = 'error';
        }
        return $res;
    }
    public function VerificarPermiso(int $id_usuario, string $nombre){
        $sql = "SELECT p.id, p.permiso, d.id AS id_detalle, d.id_usuario, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_usuario AND p.permiso = '$nombre'";
        $data = $this->selectAll($sql);
        return $data;
    }
}
?>