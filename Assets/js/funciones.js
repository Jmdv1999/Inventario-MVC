/*Tablas*/
let tblUsuarios, tblClientes, tblCategorias, tblCajas, tblProductos, tblArqueoCajas, tblHistorial, tblHistorialVentas;
document.addEventListener("DOMContentLoaded", function () {
  tblUsuarios = $("#tblUsuarios").DataTable({
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    ajax: {
      url: base_url + "Usuarios/listar",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
      },
      {
        data: "usuario",
      },
      {
        data: "nombre",
      },
      {
        data: "estado",
      },
      {
        data: "caja",
      },
      {
        data: "acciones",
      },
    ],
  });
  tblClientes = $("#tblClientes").DataTable({
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    ajax: {
      url: base_url + "Clientes/listar",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
      },
      {
        data: "cedula",
      },
      {
        data: "nombre",
      },
      {
        data: "telefono",
      },
      {
        data: "direccion",
      },
      {
        data: "estado",
      },
      {
        data: "acciones",
      },
    ],
  });
  tblCategorias = $("#tblCategorias").DataTable({
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    ajax: {
      url: base_url + "Categorias/listar",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
      },
      {
        data: "nombre",
      },
      {
        data: "estado",
      },
      {
        data: "acciones",
      },
    ],
  });
  tblCajas = $("#tblCajas").DataTable({
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    ajax: {
      url: base_url + "Cajas/listar",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
      },
      {
        data: "caja",
      },
      {
        data: "estado",
      },
      {
        data: "acciones",
      },
    ],
  });
  tblProductos = $("#tblProductos").DataTable({
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    ajax: {
      url: base_url + "Productos/listar",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
      },
      {
        data: "imagen",
      },
      {
        data: "codigo",
      },
      {
        data: "descripcion",
      },
      {
        data: "precio_compra",
      },
      {
        data: "precio_venta",
      },
      {
        data: "cantidad",
      },
      {
        data: "nombrecategoria",
      },
      {
        data: "estado",
      },
      {
        data: "acciones",
      },
    ],
  });
  tblHistorial = $("#tblHistorial").DataTable({
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    ajax: {
      url: base_url + "Compras/ListarHistorial",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
      },
      {
        data: "total",
      },
      {
        data: "estado",
      },
      {
        data: "fecha",
      },
      {
        data: "acciones",
      },
    ],
  });
  tblHistorialVentas = $("#tblHistorialVentas").DataTable({
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    ajax: {
      url: base_url + "Ventas/ListarHistorial",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
      },
      {
        data: "total",
      },
      {
        data: "nombre",
      },
      {
        data: "estado",
      },
      {
        data: "fecha",
      },
      {
        data: "acciones",
      },
    ],
  });
  tblArqueoCajas = $('#tblArqueoCajas').DataTable({
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    ajax: {
      url: base_url + "Cajas/ListarArqueos",
      dataSrc: "",
    },
    columns: [
      {
        data: "id",
      },
      {
        data: "id_usuario",
      },
      {
        data: "monto_inicial",
      },
      {
        data: "monto_final",
      },
      {
        data: "fecha_apertura",
      },
      {
        data: "fecha_cierre",
      },
      {
        data: "total_ventas",
      },
      {
        data: "monto_total",
      },
      {
        data: "estado",
      },
    ],
  });
});
/*usuarios*/
function registrarPermisos(e){
  e.preventDefault()
  const url = base_url + "Usuarios/RegistrarPermisos";
  frm = document.getElementById('frmPermisos')
  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(new FormData(frm));
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      if(res != ''){
        Alertas(res.msg, res.icono);
      }
      else{
        Alertas('Error no identificado', 'error');
      }
    }
  };
}
function frmResetPass(e) {
  e.preventDefault();
  const actual = document.getElementById("pass_actual").value;
  const nueva = document.getElementById("pass_nueva").value;
  const confirmar = document.getElementById("pass_confirmar").value;
  if (actual == "" || nueva == "" || confirmar == "") {
    Alertas("todos los campos son obligatorios", "warning");
  } else {
    if (nueva != confirmar) {
      Alertas("Las contraseñas no coinciden", "warning");
    } else {
      const url = base_url + "Usuarios/ReiniciarPass";
      const frm = document.getElementById("frmResetPass");
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(new FormData(frm));
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          $("#Modalpass").modal("hide");
          frm.reset();
          Alertas(res.msg, res.icono);
        }
      };
    }
  }
}
function frmUsuarios(e) {
  e.preventDefault();
  const usuario = document.getElementById("usuario");
  const nombre = document.getElementById("nombre");
  const caja = document.getElementById("caja");
  if (usuario.value == "" || nombre.value == "" || caja.value == "") {
    Alertas("Todos los campos son obligatorios", "warning");
  } else {
    const url = base_url + "Usuarios/Registrar";
    const frm = document.getElementById("frmUsuariosReg");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        $("#modal-form").modal("hide");
        Alertas(res.msg, res.icono);
        tblUsuarios.ajax.reload();
      }
    };
  }
}
function Arreglar() {
  document.getElementById("id").value = "";
  document.getElementById("frmUsuariosReg").reset();
  document.getElementById("titulo").innerHTML = "Agregar Usuario";
  document.getElementById("claves").classList.remove("d-none");
  $("#modal-form").modal("show");
}
function btnEditarUser(id) {
  const url = base_url + "Usuarios/Editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("titulo").innerHTML = "Editar Usuario";
      document.getElementById("id").value = res.id;
      document.getElementById("usuario").value = res.usuario;
      document.getElementById("nombre").value = res.nombre;
      document.getElementById("caja").value = res.id_caja;
      document.getElementById("claves").classList.add("d-none");
      $("#modal-form").modal("show");
    }
  };
}
function btnEliminarUser(id) {
  Swal.fire({
    title: "¿Está seguro?",
    text: "El usuario no se eliminara de forma permanente",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Desactivar",
    cancelButtonText: "No, Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Usuarios/Eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          Alertas(res.msg, res.icono);
          tblUsuarios.ajax.reload();
        }
      };
    }
  });
}
function btnActivarUser(id) {
  Swal.fire({
    title: "¿Está seguro?",
    text: "El usuario será activado",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Activar",
    cancelButtonText: "No, Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Usuarios/Activar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          tblUsuarios.ajax.reload();
          Alertas(res.msg, res.icono);
        }
      };
    }
  });
}

/*Clientes*/
function frmClientes(e) {
  e.preventDefault();
  const cedula = document.getElementById("cedula");
  const nombre = document.getElementById("nombre");
  if (cedula.value == "" || nombre.value == "") {
    Alertas("Cedula y nombre son obligatorios", "error");
  } else {
    const url = base_url + "Clientes/Registrar";
    const frm = document.getElementById("frmClienteReg");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        Alertas(res.msg, res.icono);
        frm.reset();
        $("#modal-cliente").modal("hide");
      }
    };
  }
}
function ArreglarCliente() {
  document.getElementById("id").value = "";
  document.getElementById("frmClienteReg").reset();
  document.getElementById("titulo").innerHTML = "Agregar Cliente";
  $("#modal-cliente").modal("show");
}
function btnEditarClientes(id) {
  const url = base_url + "Clientes/Editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("titulo").innerHTML = "Editar Cliente";
      document.getElementById("id").value = res.id;
      document.getElementById("cedula").value = res.cedula;
      document.getElementById("nombre").value = res.nombre;
      document.getElementById("telefono").value = res.telefono;
      document.getElementById("direccion").value = res.direccion;
      $("#modal-cliente").modal("show");
    }
  };
}
function btnEliminarClientes(id) {
  Swal.fire({
    title: "¿Está seguro?",
    text: "El cliente no se eliminara de forma permanente",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Desactivar",
    cancelButtonText: "No, Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Clientes/Eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          Alertas(res.msg, res.icono);
          tblClientes.ajax.reload();
        }
      };
    }
  });
}
function btnActivarClientes(id) {
  Swal.fire({
    title: "¿Está seguro?",
    text: "El Cliente será activado",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Activar",
    cancelButtonText: "No, Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Clientes/Activar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          Alertas(res.msg, res.icono);
          tblClientes.ajax.reload();
        }
      };
    }
  });
}
/**Cajas */
function frmCajas(e) {
  e.preventDefault();
  const caja = document.getElementById("caja");
  if (caja.value == "") {
    Alertas("El nombre es obligatorio", "warning");
  } 
  else {
    const url = base_url + "Cajas/Registrar";
    const frm = document.getElementById("frmCajasReg");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        Alertas(res.msg, res.icono);
        frm.reset();
        $("#modal-caja").modal("hide");
        tblCajas.ajax.reload();
      }
    };
  }
}
function ArreglarCajas() {
  document.getElementById("id").value = "";
  document.getElementById("frmCajasReg").reset();
  document.getElementById("titulo").innerHTML = "Agregar Caja";
  $("#modal-caja").modal("show");
}
function btnEditarCajas(id) {
  const url = base_url + "Cajas/Editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("titulo").innerHTML = "Editar Caja";
      document.getElementById("id").value = res.id;
      document.getElementById("caja").value = res.caja;
      $("#modal-caja").modal("show");
    }
  };
}
function btnEliminarCajas(id) {
  Swal.fire({
    title: "¿Está seguro?",
    text: "La caja no se eliminara de forma permanente",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Desactivar",
    cancelButtonText: "No, Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Cajas/Eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          Alertas(res.msg, res.icono);
          tblCajas.ajax.reload();
        }
      };
    }
  });
}
function btnActivarCajas(id) {
  Swal.fire({
    title: "¿Está seguro?",
    text: "La Catja será activado",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Activar",
    cancelButtonText: "No, Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Cajas/Activar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          Alertas(res.msg, res.icono);
          tblCajas.ajax.reload();
        }
      };
    }
  });
}
function ArqueoCaja(e){
  document.getElementById('titulo').innerHTML = 'Apertutra de caja'
  document.getElementById('elementos_cierre').classList.add('d-none')
  document.getElementById('montoinicial').value = '';
  document.getElementById('id').value = '';
  $("#abrir-caja").modal("show");
}
function AbrirArqueo(e){
  e.preventDefault()
  const inicial = document.getElementById('montoinicial').value
  if(inicial == ""){
    Alertas('Ingrese el monto de apertura', 'warning')
  }
  else{
    const url = base_url + "Cajas/AbrirArqueo";
    const frm = document.getElementById("frmAbrirCaja");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        Alertas(res.msg, res.icono)
        $("#abrir-caja").modal("hide");
        tblArqueoCajas.ajax.reload()
        
      }
    };
  }
}
function CerrarCaja(){
  const url = base_url + "Cajas/Ventas";
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById('titulo').innerHTML = 'Cierre de caja';
      document.getElementById('montoinicial').value = res.monto_inicial['monto_inicial']
      document.getElementById('montofinal').value = res.monto_total['total']
      document.getElementById('totalventas').value = res.total_ventas['total']
      document.getElementById('montototal').value = res.monto_general
      document.getElementById('id').value = res.monto_inicial['id']
      document.getElementById('elementos_cierre').classList.remove('d-none')
      $("#abrir-caja").modal("show");
    }
  };
}
/*Categorias*/
function frmCategorias(e) {
  e.preventDefault();
  const nombre = document.getElementById("nombre");
  if (nombre.value == "") {
    Alertas("El nombre es obligatorio", "warning");
  } else {
    const url = base_url + "Categorias/Registrar";
    const frm = document.getElementById("frmCategoriaReg");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        Alertas(res.msg, res.icono);
        frm.reset();
        $("#modal-categoria").modal("hide");
        tblCategorias.ajax.reload();
      }
    };
  }
}
function ArreglarCategoria() {
  document.getElementById("id").value = "";
  document.getElementById("frmCategoriaReg").reset();
  document.getElementById("titulo").innerHTML = "Agregar Categoria";
  $("#modal-categoria").modal("show");
}
function btnEditarCategorias(id) {
  const url = base_url + "Categorias/Editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("titulo").innerHTML = "Editar Categoria";
      document.getElementById("id").value = res.id;
      document.getElementById("nombre").value = res.nombre;
      $("#modal-categoria").modal("show");
    }
  };
}
function btnEliminarCategorias(id) {
  Swal.fire({
    title: "¿Está seguro?",
    text: "La categoriano se eliminara de forma permanente",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Desactivar",
    cancelButtonText: "No, Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Categorias/Eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          Alertas(res.msg, res.icono);
          const res = JSON.parse(this.responseText);
          tblCategorias.ajax.reload();
        }
      };
    }
  });
}
function btnActivarCategorias(id) {
  Swal.fire({
    title: "¿Está seguro?",
    text: "La Categoria será activado",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Activar",
    cancelButtonText: "No, Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Categorias/Activar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          Alertas(res.msg, res.icono);
          tblCategorias.ajax.reload();
        }
      };
    }
  });
}
/*Productos*/
function frmProductos(e) {
  e.preventDefault();
  const descripcion = document.getElementById("descripcion");
  const compra = document.getElementById("compra");
  const venta = document.getElementById("venta");
  if (descripcion.value == "" || compra.value == "" || venta.value == "") {
    Alertas("Descripcion es obligatoria", "warning");
    Alertas("Precio de compra y venta son obligatoris", "warning");
  } else {
    const url = base_url + "Productos/Registrar";
    const frm = document.getElementById("frmProductosReg");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const res = JSON.parse(this.responseText);
        Alertas(res.msg, res.icono);
        frm.reset();
        $("#modal-producto").modal("hide");
        tblProductos.ajax.reload();
      }
    };
  }
}
function ArreglarProductos() {
  document.getElementById("id").value = "";
  document.getElementById("frmProductosReg").reset();
  document.getElementById("titulo").innerHTML = "Agregar Producto";
  $("#modal-producto").modal("show");
  deleteImg();
}
function btnEditarProducto(id) {
  const url = base_url + "Productos/Editar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      document.getElementById("titulo").innerHTML = "Editar Producto";
      document.getElementById("id").value = res.id;
      document.getElementById("codigo").value = res.codigo;
      document.getElementById("descripcion").value = res.descripcion;
      document.getElementById("compra").value = res.precio_compra;
      document.getElementById("venta").value = res.precio_venta;
      document.getElementById("categoria").value = res.id_categoria;
      document.getElementById("previewimg").src =
        base_url + "Assets/img/" + res.foto;
      document.getElementById(
        "icon-cerrar"
      ).innerHTML = `<button class="btn btn-danger" onclick="deleteImg()"><i class="fas fa-times"></i></button>`;
      document.getElementById("icon-image").classList.add("d-none");
      document.getElementById("fotoactual").value = res.foto;
      $("#modal-producto").modal("show");
    }
  };
}
function btnEliminarProducto(id) {
  Swal.fire({
    title: "¿Está seguro?",
    text: "El producto no se eliminara de forma permanente",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Desactivar",
    cancelButtonText: "No, Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Productos/Eliminar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          Alertas(res.msg, res.icono);
          tblProductos.ajax.reload();
        }
      };
    }
  });
}
function btnActivarProducto(id) {
  Swal.fire({
    title: "¿Está seguro?",
    text: "El producto será activado",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Activar",
    cancelButtonText: "No, Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Productos/Activar/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          Alertas(res.msg, res.icono);
          tblProductos.ajax.reload();
        }
      };
    }
  });
}
function preview(e) {
  const url = e.target.files[0];
  const urltmp = URL.createObjectURL(url);
  document.getElementById("previewimg").src = urltmp;
  document.getElementById("icon-image").classList.add("d-none");
  document.getElementById(
    "icon-cerrar"
  ).innerHTML = `<button class="btn btn-danger" onclick="deleteImg()"><i class="fas fa-times"></i></button>`;
}
function deleteImg() {
  document.getElementById("icon-cerrar").innerHTML = "";
  document.getElementById("icon-image").classList.remove("d-none");
  document.getElementById("foto").value = "";
  document.getElementById("previewimg").src = "";
  document.getElementById("fotoactual").value = "";
}
/*Compras y ventas*/
if(document.getElementById("codigo")){
  new Selectr(document.getElementById("codigo"));
}
function buscarCodigo(e) {
  const cod = document.getElementById("codigo").value;
  const url = base_url + "Compras/BuscarCodigo/" + cod;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      if (res) {
        document.getElementById("precio").value = res.precio_compra;
        document.getElementById("id").value = res.id;
        document.getElementById("cantidad").removeAttribute("disabled");
        document.getElementById("cantidad").focus();
      }
    }
  };
}
function buscarCodigoVenta(e) {
  const cod = document.getElementById("codigo").value;
  const url = base_url + "Ventas/BuscarCodigo/" + cod;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      if (res) {
        document.getElementById("precio").value = res.precio_venta;
        document.getElementById("id").value = res.id;
        document.getElementById("cantidad").removeAttribute("disabled");
        document.getElementById("cliente").focus();
      }
    }
  };
}
function calcularPrecio() {
  const cantidad = document.getElementById("cantidad").value;
  const precio = document.getElementById("precio").value;
  document.getElementById("subtotal").value = cantidad * precio;
}
if (document.getElementById("listaVenta")) {
  cargarDetallesVentas();
} 
else if (document.getElementById("listaCompra")) {
  cargarDetalles();
}
function agregar(e) {
  e.preventDefault();
  const cantidad = document.getElementById("cantidad").value;
  const codigo = document.getElementById("codigo").value;
  if (cantidad > 0 && codigo != "") {
    const url = base_url + "Compras/Agregar";
    const frm = document.getElementById("frmCompra");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("cantidad").setAttribute("disabled", "disabled");
        const res = JSON.parse(this.responseText);
        if (res == "ok") {
          Alertas("Agregado", "success");
          frm.reset();
          cargarDetalles();
        } else if (res == "modificado") {
          Alertas("modificado", "info");
          frm.reset();
          cargarDetalles();
        }
      }
    };
  }
}
function cargarDetalles() {
  const url = base_url + "Compras/Listar";
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      let html = "";
      res.detalle.forEach((row) => {
        html += `<tr>
                            <td>${row["id"]}</td>
                            <td>${row["descripcion"]}</td>
                            <td>${row["cantidad"]}</td>
                            <td>${row["precio"]}</td>
                            <td>${row["subtotal"]}</td>
                            <td><button class="btn btn-danger text-white btn-sm" type="button" onclick="borrarDetalle(${row["id"]})"><i class="fas fa-trash"></i></button></td>
                        </tr>`;
      });
      document.getElementById("listaCompra").innerHTML = html;
      document.getElementById("total").value = res.total_pagar.total;
    }
  };
}
function agregarVenta(e) {
  e.preventDefault();
  const cantidad = document.getElementById("cantidad").value;
  const codigo = document.getElementById("codigo").value;
  if (cantidad > 0 && codigo != "") {
    const url = base_url + "Ventas/Agregar";
    const frm = document.getElementById("frmVenta");
    const http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.send(new FormData(frm));
    http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("cantidad").setAttribute("disabled", "disabled");
        const res = JSON.parse(this.responseText);
        Alertas(res.msg, res.icono);
        frm.reset();
        cargarDetallesVentas();
      }
    };
  }
}
function cargarDetallesVentas() {
  const url = base_url + "Ventas/Listar";
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      let html = "";
      res.detalle.forEach((row) => {
        html += `<tr>
                            <td>${row["id"]}</td>
                            <td>${row["descripcion"]}</td>
                            <td>${row["cantidad"]}</td>
                            <td><input type="text" class="form-control" placeholder="descuento" onkeyup='calculardescuento(event, ${row["id"]})'></td>
                            <td>${row["descuento"]}</td>
                            <td>${row["precio"]}</td>
                            <td>${row["subtotal"]}</td>
                            <td><button class="btn btn-danger btn-sm text-white" type="button" onclick="borrarDetalleVenta(${row["id"]})"><i class="fas fa-trash"></i></button></td>
                        </tr>`;
      });
      document.getElementById("listaVenta").innerHTML = html;
      document.getElementById("total").value = res.total_pagar.total;
    }
  };
}
function calculardescuento(e, id) {
  e.preventDefault();
  if (e.which == 13) {
    if (isNaN(e.target.value) || e.target.value == '') {
      Alertas("Ingrese un valor numerico", "warning");
    } 
    else {
      const url =
        base_url + "Ventas/CalcularDescuento/" + id + "/" + e.target.value;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          Alertas(res.msg, res.icono);
          cargarDetallesVentas();
        }
      };
    }
  }
}
function borrarDetalle(id) {
  const url = base_url + "Compras/Borrar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      if (res == "ok") {
        const Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
          background: "#333",
          color: "#fff",
        });
        Toast.fire({
          icon: "success",
          title: "Registro Eliminado",
        });
        cargarDetalles();
      } else {
        const Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
          background: "#333",
          color: "#fff",
        });
        Toast.fire({
          icon: "error",
          title: "Error, no se pudo borrar",
        });
        cargarDetalles();
      }
    }
  };
}
function borrarDetalleVenta(id) {
  const url = base_url + "Ventas/Borrar/" + id;
  const http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.send();
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      Alertas(res.msg, res.icono);
      cargarDetallesVentas();
    }
  };
}
function comprar(e) {
  e.preventDefault();
  Swal.fire({
    title: "¿Estás seguro de realizar la compra?",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Comprar",
    cancelButtonText: "No, Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url + "Compras/RegistrarCompra";
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
            Alertas(res.msg, res.icono)
            cargarDetalles();
        }
      };
    }
  });
}
function vender(e) {
  e.preventDefault();
  Swal.fire({
    title: "¿Estás seguro de realizar la compra?",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Comprar",
    cancelButtonText: "No, Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      frm = document.getElementById("frmVendido");
      const url = base_url + "Ventas/RegistrarVenta";
      const http = new XMLHttpRequest();
      http.open("POST", url, true);
      http.send(new FormData(frm));
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          Alertas(res.msg, res.icono);
          cargarDetallesVentas();
        }
      };
    }
  });
}
function btnAnularCompra(id){
  Swal.fire({
    title: "¿Estás seguro de anular la compra?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, anular",
    cancelButtonText: "No, Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url+"Compras/AnularCompra/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          Alertas(res.msg, res.icono)
          tblHistorial.ajax.reload();
        }
      };
    }
  });
}
function btnAnularVenta(id){
  Swal.fire({
    title: "¿Estás seguro de anular la venta?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, anular",
    cancelButtonText: "No, Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      const url = base_url+"Ventas/AnularVenta/" + id;
      const http = new XMLHttpRequest();
      http.open("GET", url, true);
      http.send();
      http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const res = JSON.parse(this.responseText);
          Alertas(res.msg, res.icono)
          tblHistorialVentas.ajax.reload();
        }
      };
    }
  });
}
/*Configuracion*/
function ModificarEmpresa() {
  const frm = document.getElementById("frmEmpresa");
  const url = "Configuracion/Modificar";
  const http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.send(new FormData(frm));
  http.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const res = JSON.parse(this.responseText);
      Alertas(res.msg, res.icono);
    }
  };
}
/*Alertas*/
function Alertas(mensaje, icono) {
  const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    background: "#333",
    color: "#fff",
  });
  Toast.fire({
    icon: icono,
    title: mensaje,
  });
}
function MostrarModalPass() {
  $("#Modalpass").modal("show");
}