<div style="float: left;margin-top:-31px">
      <div class="modal-dialog" id="cuerpo" role="document">
        <div class="modal-content" id="newaprendiz" style="width: 1120px;height: 685px;overflow-x: auto; overflow-y: auto;"  >
          <div class="modal-header">
            <h4 class="modal-title"><center>Cambio de Contraseña</center></h4>
          </div>
          <div class="modal-body" > 
            <form id="formulariochangepassword" name="formulariochangepassword">
               
              <div class="form-group">
                <label for="confirm_pass">Ingrese Contraseña Actual : </label><br>
                <input type="password" name="confirm_pass" id="confirm_pass" class="form-control" style="border-top: none;border-left: none;
    width: 192px;border-right: none;">
              </div>
              <div class="form-group">
                <label for="nueva_pass1">Ingrese Nueva Contraseña : </label><br>
                <input type="password" name="nueva_pass1" id="nueva_pass1" class="form-control" style="border-top: none;border-left: none;
    width: 192px;border-right: none;">
              </div>
              <div class="form-group">
                <label for="nueva_pass2">Repita Contraseña Nueva : </label><br>
                <input type="password" name="nueva_pass2" id="nueva_pass2" class="form-control" style="border-top: none;border-left: none;
    width: 192px;border-right: none;"><p id="mensajerror"></p>
              </div>

            </form>
          </div>
          <div class="modal-footer">
            <center>
              <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" name="btn-warning">Cancelar</button>
              <button type="button" class="btn btn-primary" id="guardarpassword" name="guardarpassword">Guardar</button>
            </center>
          </div>
        </div>
      </div>
    </div>


    <script type="text/javascript">
        $.getScript('<?php echo base_url(); ?>js/changepass.js');
    </script>