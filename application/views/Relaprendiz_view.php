<title>Relación de Aprendices</title>  
<link rel="stylesheet" href="<?php echo base_url(); ?>css/ocultar_codigo.css">
<div class="col-xs-12 col-sm-12 col-md-10" id="panelHome" name="cuerpo">
  <div class="panel panel-success">
    <div class="panel-heading">
      <h3 class="panel-title">Relación de Aprendices</h3>
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
        <div class="content" autoCal="true" formulaCal="height-180" style="height: 50000px; overflow: auto;">

          <div class="table-responsive">
          <table class="table table-hover"  id="datos">
            <thead>
              <tr class="info">
                <th style="width: 90px">Acciones</th>
                <th id="codigo">Codigo</th>
                <th style="width: 250px;">Aprendiz</th>
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
                    <div class="col-xs-12">
                       <label for="fichas">Ficha :<span class="required"> *</span> <span class="icon icon-notification" style="font-size: 18px;" onmouseover="mostrarAyuda('Ingrese el nombre o el número de ficha.')"></span></label>
                       <select name="fichaid" id="fichaid" class="form-control">
                         
                       </select>
                    </div>
                    
                  </div><br>
                  <div class="content" autoCal="true" formulaCal="height-220" style=" overflow-x: auto; overflow-y: auto;height: 397px;">
                      <div class="table-responsive" style="height: 481px">
                      <table class="table table-hover"  id="datos1">
                        <thead>
                          <tr class="success">
                            <th id="codigo">Codigo</th>
                            <th>Nombres</th>
                            <th style="width: 120px">Acciones</th>
                          </tr>
                        </thead>
                        <tbody name="listado_aprendices">

                        </tbody>
                      </table>
                      </div>
                    </div> 
            </form>
          </div>
          <div class="input-group" id="busqueda" name="busqueda" style="padding-right: 15px; padding-left: 15px">
                <input id="searchTerm1" onkeyup="doSearchapr()" type="text" class="form-control" placeholder="Busqueda rapida....">
                <span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
          </div>
          <div class="modal-footer">
            <center>
              <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" name="btn-warning">Cancelar</button>
              <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary" id="btnSavingDocumentos" name="btnSavingDocumentos"  >Finalizar y Cerrar</button>
            </center>
          </div>
        </div>
      </div>
    </div>
  <!-- Fin Modal Documentos -->

  
   

    <script type="text/javascript">
        $.getScript('<?php echo base_url(); ?>js/relaprendiz.js');
    </script>
