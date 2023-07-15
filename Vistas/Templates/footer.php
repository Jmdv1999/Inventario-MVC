<footer class="footer">
  <div>
    <a href="#">Sistema Web </a>© 2022 AtlasWeb.
  </div>
  <div class="ms-auto">Desarrollado Por: <a href="https://coreui.io/docs/">José Delgado</a></div>
</footer>
<div class="modal fade" id="Modalpass" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-body p-0">
        <div class="card card-plain">
          <div class="card-header">
            <h6 class="modal-title font-weight-normal" id="titulo">Modificar Contraseña</h6>
          </div>
          <div class="card-body">
            <form id="frmResetPass">
              <div class="row">
                <div class="mb-3">
                  <label for="pass_actual" class="form-label">Contraseña Actual</label>
                  <input type="text" class="form-control" id="pass_actual" name="pass_actual" placeholder="Contraseña actual">
                </div>
                <div class="mb-3">
                  <label for="pass_actual" class="form-label">Contraseña Nueva</label>
                  <input type="text" class="form-control" id="pass_nueva" name="pass_nueva" placeholder="Contraseña nueva">
                </div>
                <div class="mb-3">
                  <label for="pass_actual" class="form-label">Confirmar Nueva Contraseña</label>
                  <input type="text" class="form-control" id="pass_confirmar" name="pass_confirmar" placeholder="Confirmar contraseña nueva">
                </div>
              </div>
            </form>
          </div>
          <div class="card-footer">
            <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" onclick="frmResetPass(event)">Guardar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<script>const base_url = "<?php echo base_url; ?>";</script>

<script src="<?php echo base_url; ?>Assets/js/chart.min.js"></script>
<script src="<?php echo base_url; ?>Assets/js/selectr.min.js"></script>
<!-- CoreUI and necessary plugins-->
<script src="<?php echo base_url; ?>Assets/vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
<script src="<?php echo base_url; ?>Assets/vendors/simplebar/js/simplebar.min.js"></script>
<script src="<?php echo base_url; ?>Assets/vendors/@coreui/utils/js/coreui-utils.js"></script>
<script src="<?php echo base_url; ?>Assets/js/jquery.min.js"></script>
<script src="<?php echo base_url; ?>Assets/DataTables/datatables.min.js"></script>
<!--
  <script src="<?php echo base_url; ?>Assets/vendors/@coreui/chartjs/js/coreui-chartjs.js"></script>
<script src="<?php echo base_url; ?>Assets/vendors/chart.js/js/chart.min.js"></script>
-->

<script src="<?php echo base_url; ?>Assets/js/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" integrity="sha512-6PM0qYu5KExuNcKt5bURAoT6KCThUmHRewN3zUFNaoI6Di7XJPTMoT6K0nsagZKk2OB4L7E3q1uQKHNHd4stIQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?php echo base_url; ?>Assets/js/funciones.js"></script>
<script>
</script>

</body>

</html>