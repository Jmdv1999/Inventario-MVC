<?php
class ConfiguracionModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getEmpresa()
    {
        $sql = "SELECT * FROM configuracion";
        $data = $this->select($sql);
        return $data;
    }
    public function getDatos(string $table)
    {
        $sql = "SELECT COUNT(*) AS total FROM $table";
        $data = $this->select($sql);
        return $data;
    }
    public function  getVentas()
    {
        $sql = "SELECT COUNT(*) AS totalventas FROM ventas WHERE fecha > CURDATE()";
        $data = $this->select($sql);
        return $data;
    }
    public function guardarEmpresa(int $id, string $rif, string $nombre, string $telefono, string $correo, string $direccion, string $mensaje)
    {
        $this->id = $id;
        $this->rif = $rif;
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->correo = $correo;
        $this->direccion = $direccion;
        $this->mensaje = $mensaje;
        $sql = "UPDATE configuracion SET rif = ?,nombre = ?,telefono = ?,correo = ?,direccion = ?, mensaje = ? WHERE id = ?";
        $datos = array($this->rif, $this->nombre, $this->telefono, $this->correo, $this->direccion, $this->mensaje, $this->id);
        $data = $this->guardar($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
    public function getstockMinimo()
    {
        $sql = "SELECT * FROM productos WHERE cantidad < 5 ORDER BY cantidad DESC LIMIT 10";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getMasVendidos()
    {
        $sql = "SELECT d.id_producto, d.cantidad, p.id, p.descripcion, SUM(d.cantidad) AS total FROM detalles_venta d INNER JOIN productos p ON p.id = d.id_producto GROUP BY d.id_producto ORDER BY d.cantidad DESC LIMIT 10";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function VerificarPermiso(int $id_usuario, string $nombre)
    {
        $sql = "SELECT p.id, p.permiso, d.id AS id_detalle, d.id_usuario, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_usuario AND p.permiso = '$nombre'";
        $data = $this->selectAll($sql);
        return $data;
    }
}
