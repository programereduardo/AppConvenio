<!DOCTYPE html>
<html lang="es-CO">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-responsive.css"></link>
    <link id="ico" href="<?php echo base_url(); ?>/assets/img/convenio.png" rel="shortcut icon" type="image/vnd.microsoft.icon" />
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.1.0.min.js'); ?>" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap-datepicker.min.js'); ?>" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery-ui.css">
    <script type="text/javascript">
        $.getScript('<?php echo base_url(); ?>assets/js/shared/Util.js');
        $.getScript('<?php echo base_url(); ?>js/shared/helper.js');
    </script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.growl.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.bootstrap-growl.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootbox.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-notify.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.autocomplete.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.base64.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/daterangepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/loading.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/Chart/Chart.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/Chart/Chart.bundle.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/Chart/utils.js"></script>
    <!-- Version compilada y comprimida del JavaScript de Bootstrap -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css"></link>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/iconmoon.css"></link>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/estilos.css"></link>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/table.css"></link>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/daterangepicker.css"></link>
    <!-- Select2 combobox-->
    <link href="<?php echo base_url(); ?>assets/css/select2.min.css" rel="stylesheet"/>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
    <link href="<?php echo base_url(); ?>assets/css/jquery.growl.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.geolocation.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.geolocation.js"></script>

    <!-- Para cargar los select con busqueda -->
    <!--<link rel="stylesheet" type="text/css" href="assets/css/bootstrap-select.css"> -->
    <!-- Paginador de resultados -->
    <!--<script views/layout/default/js/paginador.js" type="text/javascript"></script>-->
    <!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/blitzer/jquery-ui.css" type="text/css" />-->
</head>

<body>


    <header class="header">
            <div class="jumbotron col-xs-12 col-sm-12 col-md-12" name="cabeceraApp">
                <div align="center"  class="col-xs-12 col-sm-7 col-md-7">
                    <img class="imagenLogo" src=""/>
                    <!-- Dimensiones del logo : 490 x 70 -->
                    <img id="logo_login" style="height: 90px;" title="SyntaxCompany" src=" <?php echo base_url('assets/img/logoconvenio.png') ?> ">
                    <!--<h4>LOGO</h4>-->
                    <img class="imagenLogo" src=""/>
                    <!-- Dimensiones del logo : 490 x 70 -->
                    <img id="logo_login"  style="height: 63px;margin-top: -11px;" title="SyntaxCompany" src=" <?php echo base_url('assets/img/simon1.png') ?> ">
                </div>


                <div align="right"  class="col-xs-12 col-sm-5 col-md-5">
                    <div align="right" class="col-xs-5 col-sm-4 col-md-6">


                        <table style="width: 100%;
                            overflow: hidden;
                            height: 52px;
                            margin-top: 5px;">
                            <tbody><tr>
                                <td style="text-align:right;width: 100%;">
        								<font style="font-size:18px;"></font>
        								<font style="font-size:18px;">¡Bienvenido <strong><?php echo $this->session->userdata('usuario'); ?></strong>!</font><br>
        								<font style="font-size:13px;">
        								</font>
    							</td>
    						</tr>
    					</tbody></table>
    				</div>
    				<div align="left" class="col-xs-7 col-sm-8 col-md-6 hidden-print">
    					<table style="width: 100%;
                            border-left: 0.5px solid #adadad;
                            height: 52px;
                            margin-top: 5px;">
    						<tbody><tr>
    							<td style="padding-left: 5px;text-align:center;width: 30%;">
    								<img style="width: 52px;height: 52px;" src="<?php echo base_url(); ?>/assets/img/default.jpg" class="img-circle">
    							</td>
    							<td style="text-align:left;width: 70%;">
    								<font style="font-size:14px;"><strong> Usuario:</strong> <?php echo $this->session->userdata('usuario'); ?> </font>
                    <br>
                    <font style="font-size:14px;"><strong> Rol:</strong> <?php echo $this->session->userdata('rol'); ?> </font>
                    <br>
                    <strong>
                      <a name="btnCerrarSession" href="cerrarsesion" style="font-size:13px;color: black !important; text-decoration:none;">
                        Cerrar sesión
                      </a>
                    </strong>
    							</td>
    						</tr>
    					</tbody></table>
    				</div>
    			</div>
            </div>
            <div class="separador-r-header col-xs-12 col-sm-12 col-md-12" name="separadorHeader">
                <div class="separador-header"></div>
            </div>
                <div class="modal fade" data-backdrop="static" data-keyboard="true" id="info-modal" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="background: #dff0d8">
                                <h4 class="modal-title" id="myModalLabel" style="color: #468847">Información</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <div id="mensaje-info"></div>
                                </div>
                                <div align="center">
                                    <input id="aceptar-info" type="button" data-dismiss="modal" class="btn btn-info btn-sm" value="Aceptar" />
                                </div>
                            </div>

                        </div>
                    </div><!-- /.modal-content -->
                </div>
        </header>
<script type="text/javascript">
    $('[name=btnCerrarSession]').on('click', function(){
        window.location="<?php echo base_url(); ?>login/logout";
    })
</script>
