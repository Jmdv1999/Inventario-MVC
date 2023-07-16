<?php
class Configuracion extends Controlador
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        parent::__construct();
    }
    public function index()
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        $id_usuario = $_SESSION['id_usuario'];
        $verificar = $this->modelo->VerificarPermiso($id_usuario, 'configuracion');
        if (!empty($verificar)) {
            $data = $this->modelo->getEmpresa();
            $this->vista->getView($this, "index", $data);
        } else {
            header('location: ' . base_url . 'Errores/permisos');
        }
    }
    public function home()
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        $data['usuarios'] = $this->modelo->getDatos('usuarios');
        $data['clientes'] = $this->modelo->getDatos('clientes');
        $data['productos'] = $this->modelo->getDatos('productos');
        $data['ventas'] = $this->modelo->getVentas();
        $this->vista->getView($this, "home", $data);
    }
    public function Modificar()
    {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $rif = $_POST['rif'];
        $telefono = $_POST['telefono'];
        $correo = $_POST['correo'];
        $direccion = $_POST['direccion'];
        $mensaje = $_POST['mensaje'];
        $data = $this->modelo->guardarEmpresa($id, $rif, $nombre, $telefono, $correo, $direccion, $mensaje);
        if ($data == "ok") {
            $msg = array('msg' => 'Informacion modificada con exito', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al modificar', 'icono' => 'warning');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    }
    public function ReporteStock()
    {
        $data = $this->modelo->getstockMinimo();
        echo json_encode($data);
        die();
    }
    public function MasVendidos()
    {
        $data = $this->modelo->getMasVendidos();
        echo json_encode($data);
        die();
    }

    public function Salir()
    {
        session_destroy();
        header("location: " . base_url);
    }
}
