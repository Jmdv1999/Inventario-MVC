<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Iniciar Sesion || Sistema Administrativo</title>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <!-- Vendors styles-->
      <link rel="stylesheet" href="<?php echo base_url?>/Assets/vendors/simplebar/css/simplebar.css">
      <link rel="stylesheet" href="<?php echo base_url?>/Assets/css/vendors/simplebar.css">
      <!-- Main styles for this application-->
      <link href="<?php echo base_url?>/Assets/css/style.css" rel="stylesheet">
</head>
<body class="">
  <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="card-group d-block d-md-flex row">
              <div class="card col-md-7 p-4 mb-0">
                <div class="card-body">
                  <h1>Acceder</h1>
                  <p class="text-medium-emphasis">Ingrese usuario y contraseña</p>
                  <form id="frmLogin">
                    <div class="input-group mb-3">
                      <span class="input-group-text">
                        <i class="fas fa-user"></i>
                      </span>
                      <input type="text" class="form-control form-control-lg" id="user" name="user" placeholder="Usuario" autocomplete="off">
                    </div>
                    <div class="input-group mb-4">
                      <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                      </span>
                      <input type="password" class="form-control form-control-lg" id="pass" name="pass" placeholder="Contraseña" autocomplete="off">
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <button type="button" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0" type="submit" onclick="frmLogin(event)">Acceder</button>
                      </div>
                    </div>
                    <div class="alert alert-danger d-none mt-3" role="alert" id="alerta">
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>const base_url = "<?php echo base_url;?>";</script>
    <!-- CoreUI and necessary plugins-->
    <script src="<?php echo base_url?>/Assets/vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" integrity="sha512-6PM0qYu5KExuNcKt5bURAoT6KCThUmHRewN3zUFNaoI6Di7XJPTMoT6K0nsagZKk2OB4L7E3q1uQKHNHd4stIQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?php echo base_url?>/Assets/vendors/simplebar/js/simplebar.min.js"></script>
    <script src="<?php echo base_url;?>Assets/js/login.js"></script>
</body>

</html>