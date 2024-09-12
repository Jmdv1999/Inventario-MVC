<?php
class VentasModel extends Query{
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
    public function listarClientes(){
        $sql = "SELECT * FROM clientes";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getProductos(int $id){
        $sql = "SELECT * FROM productos WHERE id = '$id'";
        $data = $this->select($sql);
        return $data;
    }
    public function consultarDetalle(int $id_producto, int $id_usuario){
        $sql = "SELECT * FROM detalles_temp_ventas WHERE id_producto = $id_producto AND id_usuario = $id_usuario";
        $data = $this->select($sql);
        return $data;
    }
    public function registrarDetalle(int $id_producto, int $id_usuario, string $precio, string $cantidad, string $subtotal){
        $sql = "INSERT INTO detalles_temp_ventas(id_producto, id_usuario, precio, cantidad, subtotal) VALUES (?,?,?,?,?)";
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
    public function actualizarDetalle(string $precio, string $cantidad, string $subtotal, int $id_producto, int $id_usuario){
        $sql = "UPDATE detalles_temp_ventas SET precio = ?, cantidad = ?, subtotal = ? WHERE id_producto = ? AND id_usuario = ?";
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
    public function getDetalle(int $id){
        $sql = "SELECT d.*, p.id AS id_producto, p.descripcion FROM detalles_temp_ventas d INNER JOIN productos p ON d.id_producto = p.id WHERE d.id_usuario = $id";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function calcularVenta(int $id_usuario){
        $sql = "SELECT id_usuario, SUM(subtotal) AS total FROM detalles_temp_ventas WHERE id_usuario = $id_usuario GROUP BY id_usuario";
        $data = $this->select($sql);
        return $data;
    }
    public function borrarVenta(int $id){
        $sql = "DELETE FROM detalles_temp_ventas WhERE id = ?";
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
    public function registrarVenta(int $id_usuario, string $total, int $cliente){
        $sql = "INSERT INTO ventas(id_usuario, total, cliente, fecha, hora) VALUES (?, ?, ?, ?, ?)";
        $datos = array($id_usuario, $total, $cliente, date('Y-m-d'), date('H:i:s'));
        $data = $this->guardar($sql, $datos);
        if($data == 1){
            $res = "ok";
        }
        else{
            $res = "error";
        }
        return $res;
    }
    public function idVenta(){
        $sql = "SELECT MAX(id) AS id FROM ventas";
        $data = $this->select($sql);
        return $data;
    }
    public function registrarDetalleVenta(int $id_venta, int $id_producto, string $cantidad, string $descuento, string $precio, string $subtotal){
        $sql = "INSERT INTO detalles_venta(id_venta, id_producto, cantidad, descuento, precio, subtotal) VALUES (?,?,?,?,?,?)";
        $datos = array($id_venta, $id_producto, $cantidad, $descuento, $precio , $subtotal);
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
        $sql = "DELETE FROM detalles_temp_ventas WHERE id_usuario = ?";
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
    public function getProVenta(int $id_venta){
        $sql = "SELECT v.*, d.*, p.id, p.descripcion, c.id AS id_cliente, c.nombre AS nombre_cliente, c.cedula FROM ventas v INNER JOIN detalles_venta d ON v.id = d.id_venta INNER JOIN productos p ON p.id = d.id_producto INNER JOIN clientes c ON c.id = v.cliente WHERE v.id = $id_venta";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getHistorial(){
        $sql = "SELECT v.*, c.id AS id_cliente, c.nombre FROM ventas v INNER JOIN clientes c ON v.cliente = c.id";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function actualizarDescuento(string $descuento,string $subtotal ,int $id){
        $sql = "UPDATE detalles_temp_ventas SET descuento = ?, subtotal = ? WHERE id = ?";
        $datos = array($descuento, $subtotal, $id);
        $data = $this->guardar($sql, $datos);
        if($data == 1){
            $res = "ok";
        }
        else{
            $res = "error";
        }
        return $res;

    }
    public function verificarDescuento($id){
        $sql = "SELECT * FROM detalles_temp_ventas WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }
    public function actualizarStock(int $id, string $cantidad){
        $sql = "UPDATE productos SET cantidad = ? WHERE id = ?";
        $datos = array($cantidad, $id);
        $data = $this->guardar($sql, $datos);
        return $data;
    }
    public function getAnular($id){
        $sql = "UPDATE ventas SET estado= ? WHERE id = ?";
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
    public function verificarCaja(int $id_usuario)
    {
        $sql = "SELECT * FROM cierre_caja WHERE id_usuario = $id_usuario AND estado = 1";
        $data = $this->select($sql);
        return $data;
    }
    public function VerificarPermiso(int $id_usuario, string $nombre){
        $sql = "SELECT p.id, p.permiso, d.id AS id_detalle, d.id_usuario, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_usuario AND p.permiso = '$nombre'";
        $data = $this->selectAll($sql);
        return $data;
    }
}
?>