<?php
class Cajas extends Controlador
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
        $verificar = $this->modelo->VerificarPermiso($id_usuario, 'cajas');
        if (!empty($verificar)){
            $this->vista->getView($this, "index");
        }
        else {
            header('location: '.base_url.'Errores/permisos');
        }
    }
    public function Arqueo()
    {
        $this->vista->getView($this, "arqueo");
    }
    public function listar()
    {
        $data = $this->modelo->getCajas('caja');
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge text-bg-success">Activo</span>';
                $data[$i]['acciones'] =
                    '<div>
                                            <button type="button" class="btn btn-secondary btn-sm btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" data-container="body" data-animation="true" onclick="btnEditarCajas(' . $data[$i]['id'] . ');"><i class="fa-solid fa-pen-to-square"></i></button> 
                                            <button ttype="button" class="btn btn-danger text-white btn-sm btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Desactivar" data-container="body" data-animation="true" onclick="btnEliminarCajas(' . $data[$i]['id'] . ');"><i class="fa-solid fa-trash"></i></button>
                                        </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge text-bg-danger text-white">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                                            <button type="button" class="btn btn-success btn-sm btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Activar" data-container="body" data-animation="true" onclick="btnActivarCajas(' . $data[$i]['id'] . ');"><i class="fa-solid fa-play"></i></button>
                                        </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function Registrar()
    {
        $nombre = $_POST['caja'];
        $id = $_POST['id'];
        if (empty($nombre)) {
            $msg = array('msg' => 'Nombre es obligatorio', 'icono' => 'warning');
        } else {
            if ($id == "") {
                $data = $this->modelo->RegistrarCaja($nombre);
                if ($data == "ok") {
                    $msg = array('msg' => 'Caja registrada con exito', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'La caja ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar', 'icono' => 'warning');
                }
            } else {
                $data = $this->modelo->ModificarCaja($nombre, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Caja modificada con exito', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function Editar(int $id)
    {
        $data = $this->modelo->EditarCaja($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function Eliminar(int $id)
    {
        $data = $this->modelo->AccionCaja(0, $id);
        if ($data == 1) {

            $msg = array('msg' => 'Caja desactivada con exito', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'error al desactivar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function Activar(int $id)
    {
        $data = $this->modelo->AccionCaja(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Caja activada con exito', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al activar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function AbrirArqueo()
    {
        $monto_inicial = $_POST['montoinicial'];
        $id = $_POST['id'];
        $fecha_apertura = date('Y-m-d');
        $id_usuario = $_SESSION['id_usuario'];
        if (empty($monto_inicial)) {
            $msg = array('msg' => 'El monto inicial no puede estar en blanco', 'icono' => 'warning');
        } 
        else {
            if ($id == "") {
                $data = $this->modelo->AbrirCaja($id_usuario, $monto_inicial, $fecha_apertura);
                if ($data == "ok") {
                    $msg = array('msg' => 'Apertura realizada con exito', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'La caja ya habia sido aperturada', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al realizar la apertura', 'icono' => 'error');
                }
            }
            else{
                $monto_final = $this->modelo->getVentasCaja($id_usuario);
                $total_ventas = $this->modelo->getTotalVentas($id_usuario);
                $inicial = $this->modelo->getMontoInicial($id_usuario);
                $general = $monto_final['total'] + $inicial['monto_inicial'];
                $data = $this->modelo->CerrarArqueo($monto_final['total'], $fecha_apertura, $total_ventas['total'], $general, $inicial['id']);
                if ($data == "ok") {
                    $msg = array('msg' => 'Caja cerrada con exito', 'icono' => 'success');
                    $this->modelo->ActualizarApertura($id_usuario);
                }
                else {
                    $msg = array('msg' => 'Error al cerrar la caja', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function ListarArqueos()
    {
        $data = $this->modelo->getCajas('cierre_caja');
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge text-bg-success">Abierta</span>';
            } else {
                $data[$i]['estado'] = '<span class="badge text-bg-danger text-white">Cerrada</span>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function Ventas()
    {
        $id = $_SESSION['id_usuario'];
        $data['monto_total'] = $this->modelo->getVentasCaja($id);
        $data['total_ventas'] = $this->modelo->getTotalVentas($id);
        $data['monto_inicial'] = $this->modelo->getMontoInicial($id);
        $data['monto_general'] = $data['monto_total']['total'] + $data['monto_inicial']['monto_inicial'];
        
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function Salir()
    {
        session_destroy();
        header("location: " . base_url);
    }
}
