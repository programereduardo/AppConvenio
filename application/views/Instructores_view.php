<title>Instructores</title> 
<?php
$titulo='Instructores' ;
  $disabled = '';
  $display = '';
  if ($titulo == 'Instructores') {
    $disabled = 'disabled';
    $display = 'codigo';
  }
?>  
<link rel="stylesheet" href="<?php echo base_url(); ?>css/estilo_modal.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/ocultar_codigo.css">
<link rel="stylesheet" media="screen and (max-width: 1024px)" href="<?php echo base_url(); ?>css/Responsive_table.css">
<div class="col-xs-12 col-sm-12 col-md-10" id="panelHome" name="cuerpo">
  <div class="panel panel-success">
    <div class="panel-heading">
      <h3 class="panel-title">Instructores</h3>
    </div>
    <div style="clear: both"></div>
    <div id="estudiantes" class="tab-pane fade in active">
      <div class="panel-body" autoCal="true" formulacal="height-100">
        <p id="total_terceros"><strong>Total de Instructores: </strong></p><br>
        <div class="row">
          <form class="noprint" id="form_per_aca">
            <input type="hidden" name="parametro" value="Instructores">
            <input type="hidden" name="titulo" value="Instructores">
            <input type="hidden" name="accMod" value="Instructor">
            <div class="form-group col-xs-12 col-sm-4 col-md-2" name="registrar">
              <button type="button" class="btn btn-default btn-sm btn-primary"  id="registrar" name="btnAgregarInstructor" title="Registrar Instructor">
                <span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Registrar
              </button>
              <button type="button" class="btn btn-default btn-sm btn-success" id="excel" name="btnAgregarInstructor" title="Generar reporte">
                <span class="glyphicon glyphicon-save-file"></span>&nbsp;&nbsp;Excel
              </button><br>
            </div>
            <div class="input-group" id="busqueda" name="busqueda" style="padding-right: 15px; padding-left: 15px;">
              <input id="searchTerm" onkeyup="doSearch()" type="text" class="form-control" placeholder="Busqueda rapida....">
              <span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
            </div>
          </form>
        </div>
        <br/>
        <div class="content" autoCal="true" formulaCal="height-220" style="height: 500px; overflow-x: auto; overflow-y: auto;">
          <div class="table-responsive">
          <table class="table table-hover"  id="datos">
            <thead>
              <tr class="success">
                <th style="width: 120px">Acciones</th>
                <th id="codigo">Codigo</th>
                <th>Tip. Doc</th>
                <th>Identificación</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Correo</th>
                <th>Telefono</th>
                <th>Celular</th>
                <th>Barrio</th>
                <th>Ciudad</th>
                <th>Departamento</th>
                <th>País</th>
              </tr>
            </thead>
            <tbody name="listado_Instructores">

            </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal registro Instructors -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" name="modalInstructor" data-backdrop="static" data-keyboard="true">
      <div class="modal-dialog" id="cuerpo" role="document">
        <div class="modal-content" id="newaprendiz">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span name="btn-warning" aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><center>Registrar Instructor</center></h4>
          </div>
          <div class="modal-body">
            <form name="formAgregarInstructor" id="formAgregarInstructor">
              <hr id="hr" name="hr">
              <input type="hidden" name="codigo_Instructor">
              <input type="hidden" name="controlador" value="Instructor_controller">
              <input type="hidden" name="tipo" value="1">
              <input type="hidden" name="tip" value="INS">
              <input type="hidden" name="tipo_tercero" value="2">
              <div class="form-group">
                <div class="row">
                  
                <div class="col-xs-3">
                  <label for="tipo_documento" id="tip_doc_ter">Tipo de identificación :<span class="required"> *</span></label>
                  <select class="form-control" id="tipo_documento" name="tipo_documento" placeholder="Tipo de Identificación">
                    <option value="">Seleccione</option>
                  </select>
                </div>
                <div class="col-xs-4" id="div_num_doc_ter">
                  <label for="numero_documento" id="num_doc_ter">Número de documento :<span class="required"> *</span></label>
                  <input type="text" id="nit" maxlength="50" class="form-control" onkeyup="aMayusculas(this.value,this.id)" name="numero_documento" placeholder="Número de documento">
                </div>
                
              </div><br>
                  <div class="row">
                    <div class="col-xs-3">
                      <label for="nombre1" id="label1">Primer nombre :<span id="quitar1" class="required"> *</span></label>
                      <input type="text" id="nombre1" maxlength="50" class="form-control" name="nombre1" placeholder="Primer Nombre">
                    </div>
                    <div class="col-xs-3">
                        <label for="nombre2">Segundo nombre :<span class=""></span></label>
                        <input type="text" id="nombre2" maxlength="50" class="form-control" name="nombre2" placeholder="Segundo Nombre">
                    </div>
                    <div class="col-xs-3">
                      <label for="apellido1" id="label2">Primer apellido :<span id="quitar2" class="required"> *</span></label>
                      <input type="text" id="apellido1" maxlength="50" class="form-control" name="apellido1" placeholder="Primer Apellido">
                    </div>
                    <div class="col-xs-3">
                      <label for="apellido2">Segundo apellido :</label>
                      <input type="text" id="apellido2" maxlength="50" class="form-control" name="apellido2" placeholder="Segundo Apellido">
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-xs-9" id="<?php echo $display; ?>">
                      <label for="nombre">Nombre del Establecimiento  :<span class="required"> *</span></label>
                      <input type="text" id="nombre" <?php echo $disabled; ?> maxlength="200" class="form-control" name="nombre" placeholder="Nombre del Establecimiento / Razón Social / Nombre de la empresa">
                    </div>
                   
                  </div></br>
                  <br>
                  <div class="row">
                    <div class="col-xs-3" id="contributivo">
                      <label for="contributivo">Contributivo :</label>
                      <select class="form-control" name="contributivo">
                        <option value="NA">Seleccione</option>
                        <option value="S">Si</option>
                        <option value="N">No</option>
                      </select>
                    </div>
                    <div class="col-xs-3" id="retenedor">
                      <label for="retenedor">Retenedor: </label>
                      <select class="form-control" name="retenedor">
                        <option value="NA">Seleccione</option>
                        <option value="S">Si</option>
                        <option value="N">No</option>
                      </select>
                    </div>
                    <div class="col-xs-6" id="correo">
                      <label for="correo">Correo :</label><span class="icon icon-notification" style="font-size: 18px;  padding-left: 20px;" onmouseover="mostrarAyudaFecha()"></span>
                      <input type="text" id="correo" maxlength="70" class="form-control" value="No aplica" name="correo" placeholder="Correo">
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-xs-12">
                      <h4 id="h4">En caso de que sea una persona natural por favor digite la siguiente información</h4>
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-xs-3"  id="pais">
                      <label for="pais" id="pai_nac">País de nacimiento :<span class="required"> *</span></label>
                      <select class="form-control" onchange="obtener_estados()" name="pais" id="paisins">
                        
                      </select>
                    </div>
                    <div class="col-xs-3" id="estado">
                      <label for="" id="est_nac">Estado de nacimiento :<span class="required"> *</span></label>
                      <select class="form-control" name="estado" id="estadoins" onchange="obtener_ciudadesins()" >
                        <option value="">Seleccione</option>
                      </select>
                    </div>
                    <div class="col-xs-3" id="ciudad">
                      <label for="ciudad" id="ciu_nac">Ciudad de nacimiento :<span class="required"> *</span></label>
                      <select class="form-control" name="ciudad">
                        <option value="">Seleccione</option>
                      </select>
                    </div>
                  </div></br>
                  <div class="row">
                    <div class="col-xs-3" id="fecha_nacimiento">
                      <label for="fecha_nacimiento" id="fec_nac">Fecha de nacimiento :</label><span class="icon icon-notification" style="font-size: 18px;  padding-left: 20px;" onmouseover="mostrarAyudaFecha()"></span>
                      <input type="text" class="form-control" name="fecha" placeholder="Fecha nacimiento">
                    </div> 
                    <div class="col-xs-3" id="genero">
                      <label for="genero">Genero :<span class="required"> *</span></label>
                      <select class="form-control" id="genero" name="genero" placeholder="Genero">
                        <option value="">Seleccione</option>
                      </select>
                    </div>
                  </div>
                </form>
              </div>

              <!-- Modal registro clientes --> 


              
   

    <!-- Fin modal registro clientes -->

              <div class="modal-footer">
                <center>
                  <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" name="btn-warning">Cancelar</button>
                  <button type="button" class="btn btn-primary" id="btnGuardar" name="btnGuardar">Registrar</button>
                </center>
              </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin modal registro Instructors -->
  </div>
</div>
<script type="text/javascript">
    $.getScript('<?php echo base_url(); ?>js/Instructores.js');
    $.getScript('<?php echo base_url(); ?>js/responsive_table.js');
    $.getScript('<?php echo base_url(); ?>js/ubicaciones.js');
    $.getScript('<?php echo base_url(); ?>js/ubicacionesIns.js');
</script>