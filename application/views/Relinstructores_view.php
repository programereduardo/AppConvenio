<title>Relación de Instructores</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/ocultar_codigo.css">
<div class="col-xs-12 col-sm-12 col-md-10" id="panelHome" name="cuerpo">
  <div class="panel panel-success">
    <div class="panel-heading">
      <h3 class="panel-title">Relación de Instructores</h3>
    </div>
    <div style="clear: both"></div>
    <div id="estudiantes" class="tab-pane fade in active">
      <div class="panel-body" autoCal="true" formulacal="height-100">
        <div class="row">
          <form id="formDocumentos" name="formDocumentos">
                <div class="form-group col-xs-12 col-sm-4 col-md-2" id="registrar" name="registrar">
                  <button type="button" class="btn btn-default btn-sm btn-primary" name="btnSaveDocumentos" id="ejecutar" title="Registrar cliente">
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
        <div class="content" autoCal="true" formulaCal="height-180" style="height: 500px; overflow: auto;">

          <div class="table-responsive">
          <table class="table table-hover"  id="datos">
            <thead>
              <tr class="info">
                <th style="width: 90px">Acciones</th>
                <th id="codigo">Codigo</th>
                <th style="width: 250px;">Instructor</th>
                <th style="width: 250px;">Ficha</th>
                <th>Observación</th>
                <th id="codigo">Estado</th>
              </tr>
            </thead>
            <tbody name="listar_relaciones">
              <!-- Contenido de la tabla es cargado por medio de jQuery -->
            </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Inicio Modal Registro Documentos -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" name="modalDocumentos" data-backdrop="static" data-keyboard="true">
      <div class="modal-dialog" id="cuerpo" role="document">
        <div class="modal-content" id="newCliente">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span name="btn-warning" aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><center>Registrar</h4>
          </div>
          <div class="modal-body">
            <form name="formSaveFamily" id="formSaveFamily">
              <hr id="hr" name="hr">
              <div class="form-group">
                  <div class="row">
                    <div class="col-xs-0">
                      <input type="hidden" id="codigo_documento" name="codigo_documento">
                      <input type="hidden" value="1" name="tipo">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-6">
                      <label for="instructor">Instructor :<span class="required"> *</span> <span class="icon icon-notification" style="font-size: 18px;" onmouseover="mostrarAyuda('Ingrese el nombre o el número de documento del Instructor.')"></span></label>
                      <input type="text" id="instructor" onkeyup="verificar_escritura($('[name=modalDocumentos]').find('[name=instructor]').val(), $('[name=modalDocumentos]').find('[name=instructorid]'))" maxlength="30" class="form-control" name="instructor" placeholder="Instructor">
                      <input type="hidden" id="instructorid" name="instructorid">
                    </div>
                    <div class="col-xs-6">
                       <label for="fichas">Ficha :<span class="required"> *</span> <span class="icon icon-notification" style="font-size: 18px;" onmouseover="mostrarAyuda('Ingrese el nombre o el número de ficha.')"></span></label>
                      <input type="text" id="fichas" onkeyup="verificar_escritura($('[name=modalDocumentos]').find('[name=fichas]').val(), $('[name=modalDocumentos]').find('[name=fichaid]'))" maxlength="30" class="form-control" name="fichas" placeholder="Ficha">
                      <input type="hidden" id="fichaid" name="fichaid">
                    </div>
                  </div></br>
                  <div class="row">
                    <div class="col-xs-12">
                      <label for="clave">Observación :</label>
                      <textarea class="form-control" name="observacion" rows="2" cols="8" placeholder="Observación"></textarea>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          <div class="modal-footer">
            <center>
              <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" name="btn-warning">Cancelar</button>
              <button type="button" class="btn btn-primary" id="btnSavingDocumentos" name="btnSavingDocumentos"  >Registrar</button>
            </center>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Fin Modal Documentos -->


    <script type="text/javascript">
        $.getScript('<?php echo base_url(); ?>js/relinstructores.js');
    </script>
