<title>Reportes</title> 
<!--<link rel="stylesheet" href="<?php echo base_url(); ?>css/estilo_modal.css">-->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/ocultar_codigo.css">
<div class="col-xs-12 col-sm-12 col-md-10" id="panelHome" name="cuerpo">
  <div class="panel panel-success">
    <div class="panel-heading">
      <h3 class="panel-title">Reportes</h3>
    </div>
    <div style="clear: both"></div>

    <div id="estudiantes" class="tab-pane fade in active">
      <div class="panel-body" autoCal="true" formulacal="height-100">
        <div class="row">

          <div class="col-xs-5">
            <label for="ficha">Seleccione Ficha :</label>
            <select class="form-control" name="ficha" id="ficha">
              <option value="">Seleccionar</option>
            </select>
          </div>
        
          <div class="col-xs-2">
            <label for="desde">Desde :</label>
            <input type="text" name="desde" id="desde" class="form-control" value="2018">
          </div>
          <div class="col-xs-2">
            <label for="hasta">Hasta :</label>
            <input type="text" name="hasta" id="hasta" class="form-control" value="">
          </div>

          <div class="col-xs-2">
            <label for="dias">Hasta :</label>
            <input type="number" name="dias" id="dias" class="form-control" value="10">
          </div>
          

 
          <a  title="Buscar" name="btnconsulta" id="btnconsulta" class="btn btn-default" style="margin-top: 26px;width: 70px;"><span class="glyphicon glyphicon-search"></span></a>

          <a href="pdf" title="PDF [new window]" class="btn btn-danger" name="btnpdf" id="btnpdf" style="margin-top: -11px;margin-left: 16px;margin-bottom: -28px;" target="_blank">PDF</a>

          <button type="button" class="btn btn-default btn-sm btn-success" id="btnexcel" name="btnexcel" title="Generar reporte" style="margin-top: 15px;">
                <span class="glyphicon glyphicon-save-file"></span>&nbsp;&nbsp;Excel
              </button>


        <br/>
        <br><br>
           <div class="content" autoCal="true" formulaCal="height-220" style="height: 500px; overflow-x: auto; overflow-y: auto;margin-left: 15px;margin-right: 17px;">
            <div class="table-responsive">
              <table class="table table-hover" id="datos">

                <thead>
                  <tr class="info">
                    <th id="codigo">codigo</th>
                    <!--<th style="width: 90px">Acciones</th>-->
                    <!--<th>N. Documento</th>-->
                    <th>Nombres</th>
                    <th>Inasistencias</th>
                    <th>% Inasistencias</th>
                  </tr>
                </thead>
 
                <tbody name="lista_consultas">

                </tbody>

              </table>

            </div>
          </div>





      </div>
    </div>
  </div>









</div>

<script type="text/javascript">
    $.getScript('<?php echo base_url(); ?>js/reportes_inasistencias.js');
    $.getScript('<?php echo base_url(); ?>js/responsive_table.js');
</script>
