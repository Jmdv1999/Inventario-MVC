<?php
class Usuarios extends Controlador
{
    public function __construct()
    {
        session_start();

        parent::__construct();
    }
    public function index()
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        $id_usuario = $_SESSION['id_usuario'];
        $verificar = $this->modelo->VerificarPermiso($id_usuario, 'usuarios');
        if (!empty($verificar)) {
            $data['cajas'] = $this->modelo->getCajas();
            $this->vista->getView($this, "index", $data);
        } else {
            header('location: ' . base_url . 'Errores/permisos');
        }
    }
    public function listar()
    {
        $data = $this->modelo->getUsuarios();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                if ($data[$i]['id'] == 1) {
                    $data[$i]['estado'] = '<span class="badge text-bg-primary">Administrador</span>';
                    $data[$i]['acciones'] = '<div><button type="button" class="btn btn-secondary btn-sm btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" data-container="body" data-animation="true" onclick="btnEditarUser(' . $data[$i]['id'] . ');"><i class="fa-solid fa-pen-to-square"></i></button></div>';
                } else {
                    $data[$i]['estado'] = '
                        <span class="badge text-bg-success">Activo</span>';
                    $data[$i]['acciones'] = '<div>
                        <a class="btn btn-primary btn-sm btn-tooltip" href="' . base_url . 'Usuarios/permisos/' . $data[$i]['id'] . '" data-bs-toggle="tooltip" data-bs-placement="top" title="permisos" data-container="body" data-animation="true"><i class="fa-solid fa-key"></i></a>
                                                <button type="button" class="btn btn-secondary btn-sm btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar" data-container="body" data-animation="true" onclick="btnEditarUser(' . $data[$i]['id'] . ');"><i class="fa-solid fa-pen-to-square"></i></button> 
                                                <button ttype="button" class="btn btn-danger text-white btn-sm btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Desactivar" data-container="body" data-animation="true" onclick="btnEliminarUser(' . $data[$i]['id'] . ');"><i class="fa-solid fa-trash"></i></button>
                                            </div>';
                }
            } else {
                $data[$i]['estado'] = '<span class="badge text-bg-danger text-white">Inactivo</span>';
                $data[$i]['acciones'] = '<div>
                                                <button type="button" class="btn btn-success btn-sm btn-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Activar" data-container="body" data-animation="true" onclick="btnActivarUser(' . $data[$i]['id'] . ');"><i class="fa-solid fa-play"></i></button>
                                            </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function Validar()
    {
        if (empty($_POST['user']) || empty($_POST['pass'])) {
            $msg = "Los campos estan vacios";
        } else {
            $usuario = $_POST['user'];
            $pass = $_POST['pass'];
            $hash = hash("SHA256", $pass);
            $data = $this->modelo->getUsuario($usuario, $hash);
            if ($data) {
                $_SESSION['id_usuario'] = $data['id'];
                $_SESSION['usuario'] = $data['usuario'];
                $_SESSION['nombre'] = $data['nombre'];
                $_SESSION['activo'] = true;
                $msg = "ok";
            } else {
                $msg = "Usuario y/o Contraseña Incorrectos";
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function Registrar()
    {
        $usuario = $_POST['usuario'];
        $nombre = $_POST['nombre'];
        $clave = $_POST['clave'];
        $confirmar = $_POST['confirm'];
        $caja = $_POST['caja'];
        $id = $_POST['id'];
        $hash = hash("SHA256", $clave);
        if (empty($usuario) || empty($nombre) || empty($caja)) {
            $msg = array('msg' => 'Todos los campos son obligatorios', 'icono' => 'warning');
        } else {
            if ($id == "") {
                if ($clave != $confirmar) {
                    $msg = array('msg' => 'Las contraseñas no coinciden', 'icono' => 'warning');
                } else {
                    $data = $this->modelo->RegistrarUsuaio($usuario, $nombre, $hash, $caja);
                    if ($data == "ok") {
                        $msg = array('msg' => 'Usuario registrado', 'icono' => 'success');
                    } else if ($data == "existe") {
                        $msg = array('msg' => 'El usuario ya existe', 'icono' => 'error');
                    } else {
                        $msg = array('msg' => 'Error al registrar el usuario"', 'icono' => 'error');
                    }
                }
            } else {
                $data = $this->modelo->ModificarUsuaio($usuario, $nombre, $caja, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Usuario modificado', 'icono' => 'success');
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
        $data = $this->modelo->AccionUser(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Usuario Desactivado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al desactivar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function Activar(int $id)
    {
        $data = $this->modelo->AccionUser(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Usuario activado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'error al Activar el usuario', 'icono' => 'success');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function ReiniciarPass()
    {
        $pass_actual = $_POST['pass_actual'];
        $pass_nueva = $_POST['pass_nueva'];
        $pass_confirmar = $_POST['pass_confirmar'];
        $hash = hash("SHA256", $pass_actual);
        if (empty($pass_actual) || empty($pass_nueva) || empty($pass_confirmar)) {
            $msg = array('msg' => 'los campos son obligatorios', 'icono' => 'warning');
        } else {
            if ($pass_nueva != $pass_confirmar) {
                $msg = array('msg' => 'Las contraseñas no coinciden', 'icono' => 'warning');
            } else {
                $id = $_SESSION['id_usuario'];
                $data = $this->modelo->getPass($hash, $id);
                if (!empty($data)) {
                    $verificar = $this->modelo->modificarPass(hash("SHA256", $pass_nueva), $id);
                    if ($verificar == 1) {
                        $msg = array('msg' => 'Contraseña modificada', 'icono' => 'success');
                    } else {
                        $msg = array('msg' => 'Error al modificar', 'icono' => 'error');
                    }
                } else {
                    $msg = array('msg' => 'Contraseña actual incorrecta', 'icono' => 'error');
                }
                echo json_encode($msg, JSON_UNESCAPED_UNICODE);
                die();
            }
        }
    }
    public function permisos($id)
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        $id_usuario = $_SESSION['id_usuario'];
        $verificar = $this->modelo->VerificarPermiso($id_usuario, 'permisos');
        if (!empty($verificar)) {
            $data['datos'] = $this->modelo->getPermisos();
            $data['id_usuario'] = $id;
            $data['asignados'] = array();
            $permisos = $this->modelo->getDetallePermisos($id);

            foreach ($permisos as $permiso) {
                $data['asignados'][$permiso['id_permiso']] = true;
            }
            $this->vista->getView($this, "permisos", $data);
        } else {
            header('location: ' . base_url . 'Errores/permisos');
        }
    }
    public function RegistrarPermisos()
    {
        $msg = '';
        $id_usuario = $_POST['id_usuario'];
        $eliminar = $this->modelo->eleminarPermisos($id_usuario);
        if ($eliminar == 'ok') {
            foreach ($_POST['permisos'] as $id_permiso) {
                $res = $this->modelo->guardarPermisos($id_usuario, $id_permiso);
            }
            if ($res == 'ok') {
                $msg = array('msg' => 'Permisos asignados', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'Error al asignar los permisos', 'icono' => 'error');
            }
        } else {
            $msg = array('msg' => 'Error al eliminar los permisos anteriores', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    }
    public function Salir()
    {
        session_destroy();
        header("location: " . base_url);
    }
}
