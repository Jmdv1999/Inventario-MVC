<?php
class CajasModel extends Query{
    private $id, $nombre, $estado;
    public function __construct(){
        parent::__construct();
    }
    public function getCajas(string $tabla){
        $sql = "SELECT * FROM $tabla";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function RegistrarCaja(string $nombre){
        $this->nombre = $nombre;
        $verificar = "SELECT * FROM caja WHERE caja = '$this->nombre'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO caja(caja) VALUES (?)";
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
    public function ModificarCaja(string $nombre, int $id){
        $this->nombre = $nombre;
        $this->id = $id;
        $sql = "UPDATE caja SET caja = ? WHERE id = ?";
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
    public function EditarCaja(int $id){
        $sql = "SELECT * FROM caja WHERE id = $id";
        $data = $this->select($sql); 
        return $data;
    }
    public function AccionCaja(int $estado, int $id){
        $this->estado = $estado;
        $this->id = $id;
        $sql = "UPDATE caja SET estado = ? WHERE id = ?";
        $datos = array($this->estado, $this->id);
        $data = $this->guardar($sql, $datos);
        return $data;
    }
    public function AbrirCaja(int $id_usuario, string $monto_inicial, string $fecha_apertura){
        $this->$monto_inicial = $monto_inicial;
        $this->$fecha_apertura = $fecha_apertura;
        $verificar = "SELECT * FROM cierre_caja WHERE id_usuario = '$id_usuario' AND estado = '1'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO cierre_caja (id_usuario, monto_inicial, fecha_apertura) VALUES (?, ?, ?)";
            $datos = array($id_usuario, $monto_inicial, $fecha_apertura);
            $data = $this->guardar($sql, $datos);
            if($data == 1){
                $res = "ok";
            }
            else{
                $res = "error";
            }
        }
        else{
            $res = "existe";
        }
        return $res;  
    }
    public function getVentasCaja(int $id_usuario){
        $sql = "SELECT total, SUM(total) AS total FROM ventas WHERE id_usuario = $id_usuario AND estado = 1 AND apertura = 1";
        $data = $this->select($sql);
        return $data;
    }
    public function getTotalVentas(int $id_usuario){
        $sql = "SELECT COUNT(total) AS total FROM ventas WHERE id_usuario = $id_usuario AND estado = 1 AND apertura = 1";
        $data = $this->select($sql);
        return $data;
    }
    public function getMontoInicial(int $id_usuario){
        $sql = "SELECT id, monto_inicial FROM cierre_caja WHERE id_usuario = $id_usuario AND estado = 1";
        $data = $this->select($sql);
        return $data;
    }
    public function CerrarArqueo(string $monto_final, string $fecha_apertura, string $total_ventas, string $general,int $id)
    {
        $sql = "UPDATE cierre_caja SET monto_final = ?, fecha_cierre = ?, total_ventas = ?, monto_total = ?, estado = ? WHERE id = ?";   
        $datos = array($monto_final, $fecha_apertura, $total_ventas, $general, 0, $id);
        $data = $this->guardar($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        }
        else {
            $res = "error";
        }
        return $res;
    }
    public function ActualizarApertura($id_usuario){
        $sql = "UPDATE ventas SET apertura = ? WHERE id_usuario = ?";   
        $datos = array(0, $id_usuario);
        $this->guardar($sql, $datos);
    }
    public function VerificarPermiso(int $id_usuario, string $nombre){
        $sql = "SELECT p.id, p.permiso, d.id AS id_detalle, d.id_usuario, d.id_permiso FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_usuario AND p.permiso = '$nombre'";
        $data = $this->selectAll($sql);
        return $data;
    }
}
?>