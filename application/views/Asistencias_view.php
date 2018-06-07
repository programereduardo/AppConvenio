<style type="text/css">
  .btn span.glyphicon { 
opacity: 1; 
}
.btn.active span.glyphicon {  
opacity: 0; 
}
</style>


<title>Asistencias</title>
<!--<link rel="stylesheet" href="<?php echo base_url(); ?>css/estilo_modal.css">-->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/ocultar_codigo.css">
<div class="col-xs-12 col-sm-12 col-md-10" id="panelHome" name="cuerpo">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">Asistencias</h3>
      </div>
      <div style="clear: both"></div>
      <div id="estudiantes" class="tab-pane fade in active">
        <div class="panel-body" autoCal="true" formulacal="height-100">
          <form name="formlist_ins" id="formlist_ins" >
          <div class="row">
            <div class="col-xs-2">
              <label for="fecha">Fecha :</label>
              <input type="text" name="fecha" id="fecha" value="" class="form-control">
            </div>
            <div class="col-xs-6">
              <label for="ficha">Seleccione Ficha :</label>
              <select class="form-control" name="ficha" id="ficha">
                <option value="">Seleccionar</option>
              </select>
            </div>
            
   

          </div>
          <br/>

          <div class="table-responsive">

            <table class="table table-hover" id="datos">
              <thead>
                <tr class="info">
                  <th id="codigo">codigo</th>
                  <th style="width: 90px">Acciones</th>
                  <!--<th>N. Documento</th>-->
                  <th>Nombres</th>
                  <th>Inasistencias</th>
                </tr>
              </thead>

              <tbody name="lista_asistencias">
                <div class="btn-group" data-toggle="buttons">
                  

                </div>
 
              </tbody>
            </table>
          </div>
        </form>
          <div align='center'>
            <input type="submit" name="btnguardar" id="btnguardar" value="Guardar" class="btn btn-success" style="width: 100px;">
            <input type="submit" name="btncancelar" id="btncancelar" value="Cancelar" class="btn btn-danger" style="width: 100px;">

          </div>
        </div>
      </div>





   





  </div>
</div>

<script type="text/javascript">
    $.getScript('<?php echo base_url(); ?>js/Asistencias.js');
    $.getScript('<?php echo base_url(); ?>js/responsive_table.js');
</script>
