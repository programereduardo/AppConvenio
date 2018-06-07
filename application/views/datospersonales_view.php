<title>Aprendices</title>
<?php
$titulo='Aprendices' ;
  $disabled = '';
  $display = '';
  if ($titulo == 'Aprendices') {
    $disabled = 'disabled';
    $display = 'codigo';
  }
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/estilo_modal.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/ocultar_codigo.css">
<link rel="stylesheet" media="screen and (max-width: 1024px)" href="<?php echo base_url(); ?>css/Responsive_table.css">


    <!-- Modal registro clientes -->
   <div style="float: left;margin-top:-31px">
      <div class="modal-dialog" id="cuerpo" role="document">
        <div class="modal-content" id="newaprendiz" style="width: 1120px;height: 685px;overflow-x: auto; overflow-y: auto;"  >
          <div class="modal-header">
            <h4 class="modal-title"><center>Información Básica</center></h4>
          </div>
          <div class="modal-body" >
            <form id="formulariodatpesonales" name="formulariodatpesonales">
              <div class="row">
                <div class="col-xs-5"  id="tipo_docitem">
                  <label for="tipo_doc">Tipo de Documento :<span class="required"> *</span></label>
                  <select name="tipo_doc" id="tipo_doc" class="form-control">
                    <option>Seleccionar</option>
                  </select>
                </div>

                <div class="col-xs-5" id="num_id">
                  <label for="num_id">Numero de Identificación :<span class="required"> *</span></label>
                  <input type="number" name="num_id" id="num_id" class="form-control">
                </div>



              </div><br>

              <div class="row">
                <div class="col-xs-3" id="p_nombre">
                  <label for="p_nombre">Primer Nombre : <span class="required"> *</span></label>
                  <input type="text" name="p_nombre" class="form-control" onkeyup="aMayusculas(this.value,this.id)">
                </div>

                <div class="col-xs-3">
                  <label for="s_nombre">Segundo Nombre : </label>
                  <input type="text" name="s_nombre" class="form-control">
                </div>

                <div class="col-xs-3">
                  <label for="p_apellido">Primer Apellido : <span class="required"> *</span></label>
                  <input type="text" name="p_apellido" class="form-control">
                </div>

                <div class="col-xs-3">
                  <label for="s_apellido">Segundo Apellido : </label>
                  <input type="text" name="s_apellido" class="form-control">
                </div>
                
              </div><br>

              <hr>
              <h2>Datos Personales</h2>


              <div class="row">
                <div class="col-xs-3">
                  <label for="genero">Sexo : <span class="required"> *</span></label>
                  <select name="genero" class="form-control">
                    <option value="">Seleccionar</option>
                  </select>
                </div>

                <div class="col-xs-3">
                  <label for="est_civil">Estado Civil : <span class="required"> *</span></label>
                  <select name="est_civil" class="form-control">
                    <option value="">Seleccionar</option>
                  </select>
                </div>
              </div><br>

              <div class="row">
                <div class="col-xs-3">
                  <label for="fec_nac">Fecha de Nacimiento : <span class="required"> *</span></label>
                  <input type="text" name="fec_nac" id="fec_nac" class="form-control">
                </div>

                <div class="col-xs-3">
                  <label for="pai_nac">Pais de Nacimiento : <span class="required"> *</span></label>
                  <select name="pai_nac" class="form-control">
                    <option value="">Seleccionar</option>
                  </select>
                </div>

                <div class="col-xs-3">
                  <label for="dep_nac">Departamento de Nacimiento : </label>
                  <select name="dep_nac" class="form-control">
                    <option value="">Seleccionar</option>
                  </select>
                </div>

                <div class="col-xs-3">
                  <label for="mun_nac">Municipio de Nacimiento : </label>
                  <select name="mun_nac" class="form-control">
                    <option value="">Seleccionar</option>
                  </select>
                </div>
              </div><br>
              <hr>

              <h2>Datos de Contacto </h2>

              <div class="row">
                <div class="col-xs-3">
                  <label for="dep_res">Departamento de Residencia : </label>
                  <select name="dep_res" class="form-control">
                    <option value="">Seleccionar</option>
                  </select>
                </div>

                <div class="col-xs-3">
                  <label for="mun_res">Municipio de Residencia : </label>
                  <select name="mun_res" class="form-control">
                    <option >Seleccionar</option>
                  </select>
                </div>

                <div class="col-xs-3">
                  <label for="bar_res">Barrio de Residencia : </label>
                  <select name="bar_res" class="form-control">
                    <option>Seleccionar</option>
                  </select>
                </div>

                <div class="col-xs-3">
                  <label for="direccion">Direccion de Residencia : </label>
                  <input type="text" name="direccion" class="form-control">
                </div>
              </div><br>

              <div class="row">
                <div class="col-xs-3">
                  <label for="telefono">Telefono : </label>
                  <input type="text" name="telefono" class="form-control">
                </div>

                <div class="col-xs-3">
                  <label for="celular">Celular : </label>
                  <input type="text" name="celular" class="form-control">
                </div>

                <div class="col-xs-3">
                  <label for="correo">Correo : </label>
                  <input type="email" name="correo" class="form-control">
                </div>
              </div>




            </form>
          </div>
          <div class="modal-footer">
            <center>
              <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" name="btn-warning">Cancelar</button>
              <button type="button" class="btn btn-primary" id="btnGuardardatos" name="btnGuardardatos">Guardar</button>
            </center>
          </div>
        </div>
      </div>
    </div>
    
<script type="text/javascript">
    $.getScript('<?php echo base_url(); ?>js/datos_personales.js');
    
</script>