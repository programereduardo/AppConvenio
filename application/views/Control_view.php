<title>Control <?php echo $titulo; ?></title>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/ocultar_codigo.css">
<div class="col-xs-12 col-sm-12 col-md-10" id="panelHome" name="cuerpo">
  <div class="panel panel-success">
    <div class="panel-heading">
      <h3 class="panel-title">Control <?php echo $titulo; ?></h3>
    </div>
    <div style="clear: both"></div>
    <div id="estudiantes" class="tab-pane fade in active">
      <div class="panel-body" autoCal="true" formulacal="height-100">
        <div class="row">
          <form id="formControl" name="formControl">
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
        <div class="content" autoCal="true" formulaCal="height-180" style="height: 500px; overflow: auto;">
          <table class="table table-hover"  id="datos">
            <thead>
              <tr class="info">
                <th style="width: 90px">Acciones</th>
                <th id="codigo">Codigo</th>
                <th style="width: 100px;">Identificación</th>
                <th style="width: 200px;">Nombre</th>
                <th>Articulo</th>
                <th>Fecha Proceso</th>
                <th>Existencia Actual</th>
                <th>Pedidos</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody name="listar_datos">
              <!-- Contenido de la tabla es cargado por medio de jQuery -->
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Inicio Modal Registro Documentos -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" name="modalDocumentos" data-backdrop="static" data-keyboard="true">
      <div class="modal-dialog" id="cuerpo" role="document">
        <div class="modal-content" id="newCliente">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span name="btn-warning" aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><center>Registrar <?php echo $nombre; ?></h4>
          </div>
          <div class="modal-body">
            <form name="formSaveFamily" id="formSaveFamily">
              <input type="hidden" name="tipo_tercero" value="<?php echo $codigo; ?>">
              <input type="hidden" name="clave_tipo_tercero" value="<?php echo $clave; ?>">
              <input type="hidden" name="tipo" value="1">
              <input type="hidden" name="codigo_control">
              <hr id="hr" name="hr">
              <div class="form-group">
                  <div class="row">
                    <?php
                      $msg = 'Ingrese el nombre o el número de documento del cliente';
                      $disabledCli = '';
                      $disabledVen = '';
                    ?>
                    <?php if ($nombre == "Cliente"): ?>
                      <?php
                        $disabledVen = 'disabled';
                      ?>
                      <div class="col-xs-12" id="cli">
                        <label for="cliente"><?php echo $nombre; ?> :<span class="required"> *</span></label>
                          <span class="icon icon-notification" style="font-size: 18px;" onmouseover="mostrarAyuda('<?php echo $msg; ?>')"></span>
                          <input <?php echo $disabledCli; ?> type="text" id="cliente" maxlength="30" class="form-control" name="cliente" placeholder="Cliente">
                          <input type="hidden" name="cliente-id" id="cliente-id">
                      </div>
                    <?php endif; ?>
                    <?php if ($nombre == "Vendedor"): ?>
                      <?php
                        $msg = 'Ingrese el nombre o el número de documento del vendedor';
                        $disabledCli = 'disabled';
                      ?>
                      <div class="col-xs-12" id="ven">
                        <label for="vendedor"><?php echo $nombre; ?> :<span class="required"> *</span></label>
                        <span class="icon icon-notification" style="font-size: 18px;" onmouseover="mostrarAyuda('<?php echo $msg; ?>')"></span>
                        <input <?php echo $disabledVen; ?> type="text" id="vendedor" maxlength="30" class="form-control" name="vendedor" placeholder="Vendedor">
                        <input type="hidden" id="vendedor-id" name=vendedor-id>
                      </div>
                    <?php endif; ?>
                  </div> <br>
                  <div class="row">
                    <div class="col-xs-12" id="pro">
                      <label for="producto">Producto :<span class="required"> *</span></label>
                      <select class="form-control" id="producto" name="producto" placeholder="Producto">
                        <option value="0">Seleccione</option>
                      </select>
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-xs-6">
                      <label for="existencia_actual">Existencia Actual :<span class="required"> *</span></label>
                      <input type="number" id="existencia_actual" maxlength="30" class="form-control" name="existencia_actual" placeholder="Existencia actual">
                    </div>
                    <div class="col-xs-6">
                      <label for="pedidos">Pedidos :<span class="required"> *</span></label>
                      <input type="number" id="pedidos" maxlength="30" class="form-control" name="pedidos" placeholder="Pedidos">
                    </div>
                  </div></br>
                  <div class="row">
                    <div class="col-xs-12">
                      <label for="fecha">Fecha :<span class="required"> *</span></label>
                      <input type="text" id="fecha" maxlength="30" class="form-control" name="fecha" placeholder="Fecha">
                    </div>
                  </div></br>
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
        $.getScript('<?php echo base_url(); ?>js/control.js');
        modulo = $.parseJSON('<?php echo json_encode($modulo); ?>')
        nombre = $.parseJSON('<?php echo json_encode($nombre); ?>')
    </script>
