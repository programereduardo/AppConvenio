<title>Home</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/chart.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/estilo_modal.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/googlemaps.css">
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAX6Mrr8JkSBQx-bBptN1EpY76hHN1f-Zc&callback=initializate_map" async defer>
</script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&;amp;language=es"></script>-->

<div class="col-xs-12 col-sm-12 col-md-10" id="panelHome" name="cuerpo" style="margin-left: 110px;">
  <div class="panel panel-success">
    <div class="panel-heading">
      <h3 class="panel-title">Home</h3>
    </div>
    <div style="clear: both"></div> 
    <div>
      <br> 
      <div class="row" style="margin-left: 25px;">
          <?php if($this->session->userdata('rol')==='Instructor'): ?>
            <div class="col-xs-3">
        
          <a href="asistencias"><img style="width: 93px;" src="<?php echo base_url(); ?>assets/img/list.png"></a><br>
          <label>Inasistencias</label>
        </div>
          <?php endif; ?>
          <?php if ($this->session->userdata('rol')==='Aprendiz' ): ?>

            <div class="col-xs-3" >
              <a href="datos_personales" style="margin-left: 34px;"><img style="width: 93px;" src="<?php echo base_url(); ?>assets/img/ingreapre.PNG"></a><br>
              <label style="margin-left: 20px;margin-top: 7px;">Datos Personales</label>
            </div>

            <div class="col-xs-3" >
              <a href="redirect" style="margin-left: 34px;"><img style="width: 93px;" src="<?php echo base_url(); ?>assets/img/users.PNG"></a><br>
              <label style="margin-left: 20px;margin-top: 7px;">Cambiar Contraseña</label>
            </div>

          <?php endif;?>
        <div class="col-xs-3">
        <?php if ($this->session->userdata('rol')==='Administrador' || $this->session->userdata('rol')==='Funcionario' ): ?>
          <a href="asistencias"><img style="width: 93px;" src="<?php echo base_url(); ?>assets/img/list.png"></a><br>
          <label>Inasistencias</label>
        </div>
            <div class="col-xs-3">
              <a href="aprendiz" style="margin-left: 34px;"><img style="width: 93px;" src="<?php echo base_url(); ?>assets/img/ingreapre.PNG"></a><br>
              <label>Ingreso de Aprendices</label>
            </div>


            <div class="col-xs-3">
              <a href="Fichas" style="margin-left: 19px;"><img style="width: 93px;" src="<?php echo base_url(); ?>assets/img/fichas.svg"></a><br>
              <label style="margin-left: 45px;">Fichas</label>
            </div>

            <div class="col-xs-3">
              <a href="Instructores" style="margin-left: 25px;"><img style="width: 93px;" src="<?php echo base_url(); ?>assets/img/profesores.png"></a><br>
              <label style="margin-left: 40px;">Instructores</label>
            </div>
          </div>
          <br>
          <br>
          <br>
          <br>
          <br>
          <div class="row" style="margin-left: 25px;">
            <div class="col-xs-3">
              <a href="relacion-Instructores"><img style="width: 101px;height: 108px;" src="<?php echo base_url(); ?>assets/img/relacionprofe.jpg"></a><br>
              <label>Relación Instructores</label>
            </div>
            <div class="col-xs-3">
              <a href="relacion-aprendiz"><img style="width: 123px;" src="<?php echo base_url(); ?>assets/img/relapre.jpg"></a><br>
              <label>Relación Aprendices</label>
            </div>
            <div class="col-xs-3" style="margin-left: 21px;">
              <a href="usuarios"><img style="width: 106px;" src="<?php echo base_url(); ?>assets/img/users.png"></a><br>
              <label style="margin-left: 18px;"> Usuarios</label>
            </div>
            <div class="col-xs-2">
              <a href="reportes-inasistencias"><img style="width: 106px;" src="<?php echo base_url(); ?>assets/img/diagram.png"></a><br>
              <label style="margin-left: 25px;">Reportes</label>
            </div>
          </div>
          <br>
          <br>
          <br>
          <br>
        <?php endif; ?>
    </div>
  </div>
</div> 
    <script type="text/javascript">
        //$.getScript('<?php echo base_url(); ?>js/home.js');
        //$.getScript('<?php echo base_url(); ?>js/shared/googlemaps.js');
        //$.getScript('<?php echo base_url(); ?>assets/js/Chart/Chart.js');
    </script>
