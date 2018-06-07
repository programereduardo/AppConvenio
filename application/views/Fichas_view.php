<title>Fichas</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/ocultar_codigo.css">
<div class="col-xs-12 col-sm-12 col-md-10" id="panelHome" name="cuerpo">
  <div class="panel panel-success">
    <div class="panel-heading">
      <h3 class="panel-title">Fichas</h3>
    </div>
    <div style="clear: both"></div>
    <div id="estudiantes" class="tab-pane fade in active">
      <div class="panel-body" autoCal="true" formulacal="height-100">
        <div class="row">
          <form id="formFichas" name="formFichas">
                <div class="form-group col-xs-12 col-sm-4 col-md-2" id="registrar" name="registrar">
                  <button type="button" class="btn btn-default btn-sm btn-primary" name="btnSaveFichas" title="Registrar Ficha">
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
          <table class="table table-hover"  id="datos">
            <thead>
              <tr>
                <th style="width: 90px">Acciones</th>
                <th id="codigo">Codigo</th>
                <th style="width: 100px;">Clave</th>
                <th style="width: 200px;">Abreviatura</th>
                <th>Detalle</th>
              </tr>
            </thead>
            <tbody name="listar_fichas">
              <!-- Contenido de la tabla es cargado por medio de jQuery -->
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Inicio Modal Registro Fcihas -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" name="modalFichas" data-backdrop="static" data-keyboard="true">
      <div class="modal-dialog" id="cuerpo" role="document">
        <div class="modal-content" id="newFicha">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span name="btn-warning" aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><center>Registrar Ficha</h4>
          </div>
          <div class="modal-body">
            <form name="formSaveFamily" id="formSaveFamily">
              <hr id="hr" name="hr">
              <div class="form-group">
                  <div class="row">
                    <div class="col-xs-0">
                      <input type="hidden" id="codigo_ficha" name="codigo_ficha">
                      <input type="hidden" value="1" name="tipo">
                    </div>
                    <div class="col-xs-4">
                      <label for="clave">Clave :<span class="required"> *</span>  <span class="icon icon-notification" style="font-size: 18px;" onmouseover="mostrarAyudaClave()"></span></label>
                      <input type="text" id="clave" maxlength="11" onkeyup="aMayusculas(this.value,this.id)" class="form-control" name="clave" required="" placeholder="Numero de Ficha">
                    </div>
                    
                  </div>
                  <div class="row">
                    <div class="col-xs-9">
                      <label for="abreviatura">Abreviatura :<span class="required"> *  </span><span class="icon icon-notification" style="font-size: 18px;" onmouseover="mostrarAyudaAbreviatura()"></span></label>
                      <input type="text" id="abreviatura" maxlength="30" class="form-control" name="abreviatura" placeholder="Abreviatura">
                    </div>
                    
                  </div>
                  <div class="row">
                    <div class="col-xs-9">
                      <label for="detalle">Descripción / Nombre :<span class="required"> *  </span><span class="icon icon-notification" style="font-size: 18px;" onmouseover="mostrarAyudaDetalle()"></span></label>
                      <input type="text" id="detalle" maxlength="100" class="form-control" name="detalle" placeholder="Descripción / Nombre">
                    </div>
                    
                  </div></br>
                </div>
              </form>
            </div>
          <div class="modal-footer">
            <center>
              <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" name="btn-warning">Cancelar</button>
              <button type="button" class="btn btn-primary" id="btnSavingFichas" name="btnSavingFichas"  >Registrar</button>
            </center>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Fin Modal Documentos -->


    <script type="text/javascript">
        $.getScript('<?php echo base_url(); ?>js/fichas.js');
    </script>
