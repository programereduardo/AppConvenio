<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css"></link>
    <link id="ico" href="<?php echo base_url(); ?>assets/img/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
    <link href="<?php echo base_url('css/bootstrap-responsive.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('css/font-awesome.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/login.css')?>" rel="stylesheet">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <!-- <link href="<?php echo base_url('css/bootstrap.min.css')?>" rel="stylesheet"> -->
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.1.0.min.js'); ?>" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script src=" <?php echo base_url('assets/js/bootstrap-notify.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.geolocation.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.geolocation.js"></script>
    <meta charset="utf-8">
    <title>LOGIN</title>
  </head>
  <div class="main">
    <div class="container">
      <center>
        <div class="middle">
          <div id="login">
            <div id="mostrarError" class=""></div>
            <div class="form">
              <fieldset class="clearfix">
                <p ><span class="fa fa-user"></span><input type="text" id="usuario" placeholder="Usuario" required></p> <!-- JS because of IE support; better: placeholder="Username" -->
                <p><span class="fa fa-lock"></span><input type="password" id="password" placeholder="Contraseña" required></p> <!-- JS because of IE support; better: placeholder="Password" -->
                <div>
                  <span style="width:48%; text-align:left;  display: inline-block;"><a class="small-text" href="#">¿Contraseña olvidada?  </a></span>
                  <span style="width:50%; text-align:right;  display: inline-block;"><input id="submit" type="submit" value="Entrar"></span>
                </div>
              </fieldset>
              <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
          </div> <!-- end login -->
          <div class="logo">
            <div class="clearfix">
              <!--<img id="logo_login" src=" <?php echo base_url('assets/img/logo.png') ?> ">-->
            </div>
          </div>
        </div>
      </center>
    </div>
  </div>

  <!-- Modal validar pin -->
  <div class="modal fade" id="modalPin" tabindex="-1" role="dialog" name="modalPin" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog" id="" role="document">
      <div class="modal-content" id="newCliente">
        <div class="modal-header">
          <h4 class="modal-title"><center>Ingrese el Pin</center></h4>
        </div>
        <div class="modal-body">
          <form name="formPin" id="formPin">
            <input type="hidden" name="user">
            <input type="hidden" name="rol">
            <hr id="hr" name="hr">
            <div class="form-group">
              <center>
                <div class="row">
                  <div class="col-xs-12" id="pin">
                    <center>
                      <label for="">Pin :<span class="required"> *</span></label>
                      <input class="form-control" maxlength="4" type="text" onkeyup="this.value=solo_numeros(this.value)" name="pin" placeholder="Pin">
                    </center>
                  </div>
                </div>
              </center>
              </div>
            </div>
          </form>
            <br>
            <br>
            <div class="modal-footer">
              <center>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" name="btnCancelPin">Cancelar</button>
                <button type="button" class="btn btn-primary" name="btnValidarPin">Entrar</button>
              </center>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Fin modal validar pin -->
  <div>
    <script src=" <?php echo base_url('js/login.js') ?>"></script>
  </div>
  </font>
  </center>
  </div>
  </div>
