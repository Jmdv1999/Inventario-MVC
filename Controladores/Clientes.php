<?php
class Clientes extends Controlador
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
        $verificar = $this->modelo->VerificarPermiso($id_usuario, 'clientes');
        if (!empty($verificar)) {
            $this->vista->getView($this, "index");
        } else {
            header('location: ' . base_url . 'Errores/permisos');
        }
    }
    public function listar()
    {
        $data = $this->modelo->getClientes();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge text-bg-success">Activo</span>';
                $data[$i]['acciones'] =
                    '<div>
                                                <button type="button" class="btn btn-secondary btn-sm btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" data-container="body" data-animation="true" onclick="btnEditarClientes(' . $data[$i]['id'] . ');"><i class="fa-solid fa-pen-to-square"></i></button> 
                                                <button ttype="button" class="btn btn-danger btn-sm btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Desactivar" data-container="body" data-animation="true" onclick="btnEliminarClientes(' . $data[$i]['id'] . ');"><i class="fa-solid fa-trash"></i></button>
                                            </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge text-bg-danger text-white">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                                                <button type="button" class="btn btn-success btn-sm btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Activar" data-container="body" data-animation="true" onclick="btnActivarClientes(' . $data[$i]['id'] . ');"><i class="fa-solid fa-play"></i></button>
                                            </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function Registrar()
    {
        $cedula = $_POST['cedula'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $id = $_POST['id'];
        if (empty($cedula) || empty($nombre)) {
            $msg = array('msg' => 'Nombre y Cedula son obligatorios', 'icono' => 'warning');
        } else {
            if ($id == "") {
                $data = $this->modelo->RegistrarCliente($cedula, $nombre, $telefono, $direccion);
                if ($data == "ok") {
                    $msg = array('msg' => 'Cliente registrado con exito', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'La cedula ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al agregar cliente', 'icono' => 'error');
                }
            } else {
                $data = $this->modelo->ModificarCliente($cedula, $nombre, $telefono, $direccion, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Cliente modificado con exito', 'icono' => 'success');
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
        $data = $this->modelo->EditarUser($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function Eliminar(int $id)
    {
        $data = $this->modelo->AccionCliente(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Cliente desactivado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al desactivar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function Activar(int $id)
    {
        $data = $this->modelo->AccionCliente(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Cliente activado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al activar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function Salir()
    {
        session_destroy();
        header("location: " . base_url);
    }
}
