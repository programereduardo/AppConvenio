<title>Usuarios</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/ocultar_codigo.css">
<div class="col-xs-12 col-sm-12 col-md-10" id="panelHome" name="cuerpo">
  <div class="panel panel-success">
    <div class="panel-heading">
      <h3 class="panel-title">Usuarios</h3>
    </div>
    <div style="clear: both"></div>
    <div id="estudiantes" class="tab-pane fade in active">
      <div class="panel-body" autoCal="true" formulacal="height-100">
        <div class="row">
          <form id="formDocumentos" name="formDocumentos">
                <div class="form-group col-xs-12 col-sm-4 col-md-2" id="registrar" name="registrar">
                  <button type="button" class="btn btn-default btn-sm btn-primary" name="btnSaveDocumentos" title="Registrar cliente">
                  <span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Registrar
                  </button>
                </div>
                <div class="input-group" id="busqueda" name="busqueda" style="padding-right: 15px; padding-left: 15px">
                <input id="searchTerm" onkeyup="doSearch()" type="text" class="form-control" placeholder="Busqueda rapida....">
                <span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
              </div>
          </form>
        </div>
        <br/>
        <?php
          $id = "";
          if ($this->session->userdata('rol') !== "Administrador") {
            $id = "codigo";
          }
        ?>
        <div class="content" autoCal="true" formulaCal="height-180" style="height: 500px; overflow: auto;">
          <table class="table table-hover"  id="datos">
            <thead>
              <tr class="info">
                <th id="<?php echo $id; ?>" style="width: 90px">Acciones</th>
                <th id="codigo">Codigo</th>
                <th style="width: 300px;">Nombres</th>
                <th style="width: 300px;">Usuario</th>
                <th style="width: 200px">Rol</th>
                <th>Estado</th>
                <th>Pin</th>
              </tr>
            </thead>
            <tbody name="listado_usuarios">
              <!-- Contenido de la tabla es cargado por medio de jQuery -->
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Inicio Modal Registro Documentos -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" name="modalUsuarios" data-backdrop="static" data-keyboard="true">
      <div class="modal-dialog" id="cuerpo" role="document">
        <div class="modal-content" id="newCliente">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span name="btn-warning" aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><center>Registrar Usuario</h4>
          </div>
          <div class="modal-body">
            <form name="formUsuario" id="formUsuario">
              <hr id="hr" name="hr">
              <div class="form-group">
                  <div class="row">
                    <div class="col-xs-0">
                      <input type="hidden" value="1" name="tipo">
                      <input type="hidden" name="codigo_user">
                    </div>
                    <div class="col-xs-12">
                      <label for="usuario">Usuario :<span class="required"> *</span></label>
                      <input type="text" id="usuario" minlength="4" class="form-control" name="usuario" placeholder="Usuario">
                    </div>
                  </div><br>
                  <div class="row" id="status">
                    <div class="col-xs-12">
                      <label for="estado">Estado :<span class="required"> *</span></label>
                      <select class="form-control" id="estado" name="estado">
                        <option value="">Seleccione</option>
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                      </select>
                    </div>
                  </div></br>
                  <!--
                  <div class="row" id="actual">
                    <div class="col-xs-9">
                      <label for="password">Contraseña Actual :<span class="required"> *</span></label>
                      <input type="password" id="password" class="form-control" name="password" placeholder="Contraseña Actual">
                    </div>
                  </div><br>
                  -->
                  <div class="row">
                    <div class="col-xs-9">
                      <label for="new_password">Nueva Contraseña :<span class="required"> *</span></label>
                      <input type="password" id="new_password" class="form-control" name="new_password" placeholder="Nueva Contraseña">
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-xs-9">
                      <label for="confirmacion">Confirme Nueva Contraseña :<span class="required"> *</span></label>
                      <input type="password" id="confirmacion" class="form-control" name="confirmacion" placeholder="Confirme Nueva Contraseña">
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-xs-12">
                      <label for="rol">Rol :<span class="required"> *</span></label>
                      <select class="form-control" id="rol" name="rol">
                        <option value="0">Seleccione</option>
                      </select>
                    </div>
                  </div></br>
                </div>
              </form>
            </div>
          <div class="modal-footer">
            <center>
              <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" name="btn-warning">Cancelar</button>
              <button type="button" class="btn btn-primary" id="btnSavingUsuario" name="btnSavingUsuario"  >Registrar</button>
            </center>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  <!-- Fin Modal Documentos -->


    <script type="text/javascript">
        $.getScript('<?php echo base_url(); ?>js/sistema/usuarios.js');
    </script>
