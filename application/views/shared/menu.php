<!-- Area del menu lateral-->
<?php $rol_user = $this->session->userdata('rol'); ?>
<?php //var_dump($rol_user);
//exit(); ?>
<?php //var_dump($rol_user); ?>
<?php $username = $this->session->userdata('usuario'); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/menu.css">
<div class="col-xs-12 col-sm-12 col-md-2 lateral" id="menu_principal">
    <div class="list-group">
        <a class="list-group-item active" data-toggle="collapse" data-target="#collapse">
          Modulos <span class="arrow-down"></span>
        </a>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <?php if ($this->session->userdata('rol') === 'Administrador' || $this->session->userdata('rol') === 'Funcionario'): ?>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingSixteen">
              <h4 class="panel-title">
                <h5 role="button" data-toggle="collapse" data-parent="#accordion"| href="#collapseSixteen" aria-expanded="true" aria-controls="collapseSixteen">
                  <strong><span class=""></span></span>Home</strong>
                </h5>
              </h4>
            </div>
            <div id="collapseSixteen" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSixteen">
              <div class="panel-body">
                <a class="list-group-item submenu"  href="inicio"><span class=""></span>Home</a>
              </div>
            </div>
          </div>
        <?php endif; ?> 
          <?php foreach ($acciones as $data): ?>

          <!-- Inicio Aprendiz -->
         <?php if ($this->session->userdata('rol')==='Aprendiz'): ?>
            <?php if ($data['mod_nombre'] == 'Aprendiz' && $data['acc_descripcion'] == 'Ver') {?>
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="headincreatorgaprendiz">
                <h4 class="panel-title">
                  <h5 role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseaprendizcreator" aria-expanded="true" aria-controls="collapseaprendizcreator">
                    <strong><span class=""></span>Datos Personales</strong>
                  </h5>
                </h4>
              </div>
              <div id="collapseaprendizcreator" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headincreatorgaprendiz">
                <div class="panel-body">
                  <a class="list-group-item submenu"  href="datos_personales"><span class=""></span>Ingresar</a>
                </div>
              </div>
            </div>

            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="password">
                <h4 class="panel-title">
                  <h5 role="button" data-toggle="collapse" data-parent="#accordion" href="#cambiarpass" aria-expanded="true" aria-controls="cambiarpass">
                    <strong><span class=""></span>Cambiar contraseña</strong>
                  </h5>
                </h4>
              </div>
              <div id="cambiarpass" class="panel-collapse collapse" role="tabpanel" aria-labelledby="password">
                <div class="panel-body">
                  <a class="list-group-item submenu"  href="redirect"><span class=""></span>Cambiar</a>
                </div>
              </div>
            </div>
          <?php } ?> 
         <?php endif; ?> 
          <!-- Fin Aprendiz -->

          <!-- Inicio asistencias -->
          <?php if ($rol_user=== 'Instructor' || $rol_user=== 'Administrador' || $rol_user=== 'Funcionario'): ?>
          <?php if ($data['mod_nombre'] == 'Asistencias' && $data['acc_descripcion'] == 'Ver') {?>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingasistencias">
              <h4 class="panel-title">
                <h5 role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseasistencias" aria-expanded="true" aria-controls="collapseasistencias">
                  <strong><span class=""></span>Inasistencias</strong>
                </h5>
              </h4>
            </div>
            <div id="collapseasistencias" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingasistencias">
              <div class="panel-body">
                <a class="list-group-item submenu"  href="asistencias"><span class=""></span>Control</a>
              </div>
            </div>
          </div>
        <?php } ?>
      
          <!-- Fin asistencias -->


          <!-- Inicio aprendices -->
         
          <?php if ($data['mod_nombre'] == 'Aprendiz' && $data['acc_descripcion'] == 'Ver') {?>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingaprendiz">
              <h4 class="panel-title">
                <h5 role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseaprendiz" aria-expanded="true" aria-controls="collapseaprendiz">
                  <strong><span class=""></span>Aprendices</strong>
                </h5>
              </h4>
            </div>
            <div id="collapseaprendiz" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingaprendiz">
              <div class="panel-body">
                <a class="list-group-item submenu"  href="aprendiz"><span class=""></span>Ingresar</a>
              </div>
            </div>
          </div>
        <?php } ?>
      <?php endif; ?>
          <!-- Fin aprendices -->



          <!-- Inicio mantenimientos -->
          <?php if ($data['mod_nombre'] == 'Mantenimientos' && $data['acc_descripcion'] == 'Ver'): ?>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingSix">
              <h4 class="panel-title">
                <h5 role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                  <strong><span class=""></span>Mantenimientos</strong>
                </h5>
              </h4>
            </div>
            <div id="collapseSix" class="panel-collapse collapse" role="tabpane1" aria-labelledby="headingSix">
              <div class="panel-body">
                <?php foreach ($acciones as $accMan): ?>
                  <?php if ($accMan['mod_nombre'] == 'Fichas' && $accMan['acc_descripcion'] == 'Ver'): ?>
                    <a class="list-group-item submenu" href="Fichas"><span class=""></span>Fichas</a>
                  <?php endif; ?>
                  <?php if ($accMan['mod_nombre'] == 'Instructores' && $accMan['acc_descripcion'] == 'Ver'): ?>
                    <a class="list-group-item submenu" href="Instructores"><span class=""></span>Instructores</a>
                  <?php endif; ?>

                  <?php if ($accMan['mod_nombre'] == 'Documentos' && $accMan['acc_descripcion'] == 'Ver'): ?>
                    <a class="list-group-item submenu" href="tipo_documentos"><span class=""></span>Tipo de documentos</a>
                  <?php endif; ?>

                  <?php if ($accMan['mod_nombre'] == 'Ubicaciones' && $accMan['acc_descripcion'] == 'Ver'): ?>
                    <a class="list-group-item submenu" href="tipo_ubicaciones"><span class=""></span>Tipo de ubicaciones</a>
                  <?php endif; ?>



                  <?php if ($accMan['mod_nombre'] == 'rel_ins' && $accMan['acc_descripcion'] == 'Ver'): ?>
                    <a class="list-group-item submenu" href="relacion-Instructores"><span class=""></span>Relación de Instructores</a>
                  <?php endif; ?>


                  <?php if ($accMan['mod_nombre'] == 'relacion-aprendiz' && $accMan['acc_descripcion'] == 'Ver'): ?>
                    <a class="list-group-item submenu" href="relacion-aprendiz"><span class=""></span>Relación de Aprendices</a>
                  <?php endif; ?>


                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <?php endif; ?>
          <!-- Fin mantenimientos -->



          <!-- inicio Sistema -->
          <?php if ($data['mod_nombre'] == "Sistema" && $data['acc_descripcion'] == "Ver"): ?>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingNine">
              <h4 class="panel-title">
                <h5 role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseNine" aria-expanded="true" aria-controls="collapseNine">
                  <strong><span class=""></span>Sistema</strong>
                </h5>
              </h4>
            </div>
            <div id="collapseNine" class="panel-collapse collapse" role="tabpane1" aria-labelledby="headingNine">
              <div class="panel-body">

                <?php foreach ($acciones as $accSis): ?>

                  <?php if ($accSis['mod_nombre'] == 'Usuarios' && $accSis['acc_descripcion'] == 'Ver'): ?>
                    <a class="list-group-item submenu" href="usuarios"><span class=""></span>Usuarios</a>
                  <?php endif; ?>

                  <?php if ($accSis['mod_nombre'] == 'Roles' && $accSis['acc_descripcion'] == 'Ver'): ?>
                    <a class="list-group-item submenu" href="roles"><span class=""></span>Roles</a>
                  <?php endif; ?>

                  <?php if ($accSis['mod_nombre'] == 'Permisos' && $accSis['acc_descripcion'] == 'Ver'): ?>
                    <a class="list-group-item submenu" href="actividades"><span class=""></span>Permisos</a>
                  <?php endif; ?>

                <?php endforeach; ?>
              </div>
            </div>
          </div>
        <?php endif; ?>
          <!-- Fin Sistema -->
          <!-- inicio Reportes -->
          <?php if ($data['mod_nombre'] == "Reportes" && $data['acc_descripcion'] == "Ver"): ?>
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTen">
              <h4 class="panel-title">
                <h5 role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTen" aria-expanded="true" aria-controls="collapseTen">
                  <strong><span class=""></span>Reportes</strong>
                </h5>
              </h4>
            </div>
            <div id="collapseTen" class="panel-collapse collapse" role="tabpane1" aria-labelledby="headingTen">
              <div class="panel-body">

                <?php foreach ($acciones as $accReportes): ?>

                  <?php if ($accReportes['mod_nombre'] == 'Reporte inasistencias' && $accReportes['acc_descripcion'] == 'Ver'): ?>
                    <a class="list-group-item submenu" href="reportes-inasistencias"><span class=""></span>Reporte de Inasistencias</a>
                  <?php endif; ?>

                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <?php endif; ?>
          <!-- Fin Reportes -->

        <?php endforeach; ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    acciones = $.parseJSON('<?php echo json_encode($acciones); ?>')
    user_rol = $.parseJSON('<?php echo json_encode($rol_user); ?>')
    username = $.parseJSON('<?php echo json_encode($username); ?>')
</script>
