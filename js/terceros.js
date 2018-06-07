var parametro = $('[name=parametro]').val()
var titulo = "Aprendiz";
accMod = $('[name=accMod]').val()
var aux = parametro+'_controller';
var controller = aux.replace(/\s/g,"")
var controlador = controller

function aMayusculas(obj,id){
  obj = obj.toUpperCase();
  document.getElementById(id).value = obj;
}



function ocultar_asoc() {
  if (controlador == 'Terceros_controller') {
    $('#asoc').css('display', 'none')
    $('td#asoc').css('display', 'none')
  }
}

var data = '';
$('#registrar').on('click', function(){
  obtener_fichas();
  var invalidCreate = true;
  for (var i = 0; i < acciones.length; i++) {
    if (acciones[i]['mod_nombre'] == 'Aprendiz') {

      if (acciones[i]['acc_descripcion'] == 'Crear') {
        invalidCreate = false;
      }
    }
  }
  if (invalidCreate === true) {    
    $.notify({
      message: 'Error! Usted no posee permisos para ejecutar esta acción.'
    },{
      type: 'danger',
      delay: 1000,
      placement: {
        align: 'center'
      },
      z_index: 1000
    })
  } else {
    limpiar_formulario()
    $('[name=modalAprendiz]').find(".has-error").removeClass("has-error");
    $('[name=modalAprendiz]').find('[name=pais]').removeAttr('disabled')
    $('[name=modalAprendiz]').find('[name=estado]').removeAttr('disabled')
    $('[name=modalAprendiz]').find('[name=ciudad]').removeAttr('disabled')
    $('[name=modalAprendiz]').find('[name=barrio]').removeAttr('disabled')
    obtener_documentos(data)
    obtener_tertip(data)
    obtener_regimenes($('[name=modalAprendiz]'), false)
    $('[name=correo]').val("No aplica")
    $('[name=modalAprendiz]').modal();
    $('[name=modalAprendiz]').find('[name=pais]').attr('disabled', 'disabled')
    $('[name=modalAprendiz]').find('[name=estado]').attr('disabled', 'disabled')
    $('[name=modalAprendiz]').find('[name=ciudad]').attr('disabled', 'disabled')
    $('[name=modalAprendiz]').find('[name=genero]').attr('disabled', 'disabled')
    $('[name=modalAprendiz]').find('[name=fecha]').attr('disabled', 'disabled')
    $('[name=modalAprendiz]').find('[name=contributivo]').attr('disabled', 'disabled')
    $('[name=modalAprendiz]').find('[name=retenedor]').attr('disabled', 'disabled')
    $('#correo').css('display', 'block')
    $('#pais').css('display', 'block')
    $('#ciudad').css('display', 'block')
    $('#estado').css('display', 'block')
    $('#fecha_nacimiento').css('display', 'block')
    $('#estado').css('display', 'block')
    $('[name=modalAprendiz]').find('[name=regimen]').attr('disabled', 'disabled')
    //$('#reg_ter').css('display', 'none')
    if (controlador == 'proveedores_controller') {
      $('[name=modalAprendiz]').find('[name=retenedor]').removeAttr('disabled')
      $('[name=modalAprendiz]').find('[name=contributivo]').removeAttr('disabled')
      $('[name=modalAprendiz]').find('#pais').css('display', 'none')
      $('[name=modalAprendiz]').find('#estado').css('display', 'none')
      $('[name=modalAprendiz]').find('#ciudad').css('display', 'none')
      $('[name=modalAprendiz]').find('#genero').css('display', 'none')
      $('[name=modalAprendiz]').find('#fecha_nacimiento').css('display', 'none')
      $('[name=modalAprendiz]').find('#h4').css('display', 'none')
      $('[name=modalAprendiz]').find('[name=regimen]').removeAttr('disabled')
      $('#reg_ter').css('display', 'block')
    }
    if (controlador == 'servicios_controller') {
      $('[name=modalAprendiz]').find('[name=retenedor]').removeAttr('disabled')
      $('[name=modalAprendiz]').find('[name=contributivo]').removeAttr('disabled')
      $('[name=modalAprendiz]').find('#pais').css('display', 'none')
      $('[name=modalAprendiz]').find('#estado').css('display', 'none')
      $('[name=modalAprendiz]').find('#ciudad').css('display', 'none')
      $('[name=modalAprendiz]').find('#genero').css('display', 'none')
      $('[name=modalAprendiz]').find('#fecha_nacimiento').css('display', 'none')
      $('[name=modalAprendiz]').find('#h4').css('display', 'none')
      $('[name=modalAprendiz]').find('[name=regimen]').removeAttr('disabled')
      $('#reg_ter').css('display', 'block')
    }
    if (controlador == 'aprendiz_controller') {
      $('[name=modalAprendiz]').find('[name=contributivo]').attr('disabled', 'disabled')
      $('[name=modalAprendiz]').find('[name=retenedor]').attr('disabled', 'disabled')
      $('[name=modalAprendiz]').find('#contributivo').css('display', 'none')
      $('[name=modalAprendiz]').find('#retenedor').css('display', 'none')
      $('[name=modalAprendiz]').find('[name=pais]').removeAttr('disabled')
      $('[name=modalAprendiz]').find('[name=estado]').removeAttr('disabled')
      $('[name=modalAprendiz]').find('[name=ciudad]').removeAttr('disabled')
      $('[name=modalAprendiz]').find('[name=barrio]').removeAttr('disabled')
      $('[name=modalAprendiz]').find('[name=fecha]').removeAttr('disabled')
      $('[name=modalAprendiz]').find('[name=genero]').removeAttr('disabled')
    }
  }
})
//Fin llamado al modal ingreso cliente

$('#btnexcel').on('click',function()
{
  $('[name=modalinportar]').modal();
})

$('#btnimportarexcel').on('click',function()
{
  
 $.ajax(
 {
  url : 'terceros_controller/to_mysql',
  success : function(response)
  {
    var respuesta = $.parseJSON(response);
    if (respuesta.success === true)
    {
      obtener_aprendiz();
    }
  }
 })
})



$('#excel').on('click', function(){
  var clave = $('[name=modalAprendiz]').find('[name=tip]').val();
  window.open('terceros_controller/reporte_aprendiz?data='+clave)
})

function mostrarAyudaFecha(){
  $.notify({
      message: 'El valor por defecto es no aplica'
  }, {
      type: 'info',
      delay: 3000,
      placement: {
          align: 'center'
      },
      z_index: 99999,
  })
}

function change_name() {
  var tipoTer = $('[name=tipo_tercero]').val()
  if (tipoTer == '2') {
    $('#nombre1').attr('name', 'nombre1')
    $('#apellido1').attr('name', 'apellido1')
    $('#nombre').attr('name', 'nom')
  }
  if (tipoTer == '1') {
    $('#nombre1').attr('name', 'nom')
    $('#apellido1').attr('name', 'ape')
    $('#nombre').attr('name', 'nombre')
  }
  if (tipoTer !== '1' && tipoTer !== '2') {
    $('#nombre1').attr('name', 'nombre1')
    $('#apellido1').attr('name', 'apellido1')
    $('#nombre').attr('name', 'nombre')
  }
}

//Default function
function tipoTercero() {
  var tipoTer = $('[name=tipo_tercero]').val()
  if (tipoTer == "0") {
    $('[name=modalAprendiz]').find('[name=estado]').attr('disabled', 'disabled')
    $('[name=modalAprendiz]').find('[name=ciudad]').attr('disabled', 'disabled')
    $('[name=modalAprendiz]').find('[name=genero]').attr('disabled', 'disabled')
    $('[name=modalAprendiz]').find('[name=fecha]').attr('disabled', 'disabled')
    $('[name=modalAprendiz]').find('[name=pais]').attr('disabled', 'disabled')
    $('[name=modalAprendiz]').find('[name=contributivo]').attr('disabled', 'disabled')
    $('[name=modalAprendiz]').find('[name=retenedor]').attr('disabled', 'disabled')
    $('[name=modalAprendiz]').find('[name=regimen]').attr('disabled', 'disabled')
  }
  if (tipoTer == "2") {
    $('#quitar1').html('*')
    $('#quitar2').html('*')
    controlador = 'terceros_controller'
    $('[name=modalAprendiz]').find('[name=contributivo]').attr('disabled', 'disabled')
    $('[name=modalAprendiz]').find('[name=contributivo]').val('N')
    $('[name=modalAprendiz]').find('[name=retenedor]').attr('disabled', 'disabled')
    $('[name=modalAprendiz]').find('[name=retenedor]').val('N')
    $('[name=modalAprendiz]').find('[name=regimen]').attr('disabled', 'disabled')
    $('[name=modalAprendiz]').find('[name=regimen]').val('')
    $('[name=modalAprendiz]').find('[name=pais]').removeAttr('disabled')
    $('[name=modalAprendiz]').find('[name=estado]').removeAttr('disabled')
    $('[name=modalAprendiz]').find('[name=ciudad]').removeAttr('disabled')
    $('[name=modalAprendiz]').find('[name=genero]').removeAttr('disabled')
    $('[name=modalAprendiz]').find('[name=fecha]').removeAttr('disabled')
  }
  if (tipoTer == "1") {
    $('#quitar1').html('')
    $('#quitar2').html('')
    controlador = 'terceros_controller' //Si alguna vaina el error es aqui "empresas_controller"
    $('[name=modalAprendiz]').find('[name=estado]').attr('disabled', 'disabled')
    $('[name=modalAprendiz]').find('[name=ciudad]').attr('disabled', 'disabled')
    $('[name=modalAprendiz]').find('[name=genero]').attr('disabled', 'disabled')
    $('[name=modalAprendiz]').find('[name=fecha]').attr('disabled', 'disabled')
    $('[name=modalAprendiz]').find('[name=pais]').attr('disabled', 'disabled')
    $('[name=modalAprendiz]').find('[name=contributivo]').removeAttr('disabled')
    $('[name=modalAprendiz]').find('[name=retenedor]').removeAttr('disabled')
    $('[name=modalAprendiz]').find('[name=regimen]').Attr('disabled','disabled')
  }
  if (tipoTer == "29") {
    $('[name=modalAprendiz]').find('[name=estado]').removeAttr('disabled')
    $('[name=modalAprendiz]').find('[name=ciudad]').removeAttr('disabled')
    $('[name=modalAprendiz]').find('[name=genero]').removeAttr('disabled')
    $('[name=modalAprendiz]').find('[name=fecha]').removeAttr('disabled')
    $('[name=modalAprendiz]').find('[name=pais]').removeAttr('disabled')
    $('[name=modalAprendiz]').find('[name=regimen]').attr('disabled', 'disabled')
  }
  change_name();
  obtener_paises($('[name=modalAprendiz]'), data)
  obtener_generos(data)
  obtener_documentos(data)
}

//Fin default function

$('#btnBarrio').on('click', function(){
  obtener_paises($('[name=modalBarrio]'), data)
  $('[name=modalBarrio]').modal();
})

$('[name=btnGuardarBarrio]').on('click', function(){
  guardar_barrio()
})

//Obtener documentos
function obtener_documentos(data) {
  var combo=$('[name=tipo_documento]');
  $.ajax({
      url: "terceros_controller/obtener_documentos",
      success: function(response) {
          var respuesta = $.parseJSON(response);
          if (respuesta.success === true) {
            combo.empty();
            combo.append('<option value="">Seleccione</option>')
            for (var i = 0; i < respuesta.documentos.length; i++) {
              var item = respuesta.documentos[i];
              combo.append('<option value="'+item["tipcodigo"]+'">'+item["tipdetalle"]+'</option>');
            }
            if (data.length > 0) {
              combo.val(data)
            }
          }
      }
  });
}
//Fin obtener documentos

//Obtener fichas
function obtener_fichas(data) {
  var combo=$('[name=ficha]');
  $.ajax({
      url: "terceros_controller/obtener_fichas",
      success: function(response) {
          var respuesta = $.parseJSON(response);
          if (respuesta.success === true) {
            combo.empty();
            combo.append('<option value="">Seleccione</option>')
            for (var i = 0; i < respuesta.fichas.length; i++) {
              var item = respuesta.fichas[i];
              combo.append('<option value="'+item["ficcodigo"]+'">'+item["ficclave"]+' - '+item["ficdetalle"]+'</option>');
            }
            if (respuesta.fichas.length > 0) {
              combo.val(data)
            }
          }
      }
  });
}
//Fin obtener fichas

//Obtener documentos
function obtener_tertip(data) {
  var combo = $('[name=tipo_tercero]');
  $.ajax({
    async: false,
      url: "Terceros_controller/obtener_tertip",
      success: function(response) {
          var respuesta = $.parseJSON(response);
          if (respuesta.success === true) {
            combo.empty();
            combo.append('<option value="">Seleccione</option>')
            if (controlador == 'terceros_controller') {
              combo.append('<option value="2">Persona Natural</option>')
              combo.append('<option value="1">Persona Juridica</option>')
            }
            if (controlador == 'proveedores_controller') {
              combo.empty()
              combo.append('<option value="3">Proveedor</option>')
            }
            if (controlador == 'vendedores_controller') {
              combo.empty()
              combo.append('<option value="4">Vendedor</option>')
            }
            if (controlador == 'servicios_controller') {
              combo.empty();
              combo.append('<option value="5">Proveedor de Servicio</opction>')
            }
            /*for (var i = 0; i < respuesta.data.length; i++) {
              var item = respuesta.data[i];
              combo.append('<option value="'+item["tipcodigo"]+'">'+item["tipdetalle"]+'</option>');
            }*/
            if (data.length > 0) {
              combo.val(data)
            }
          }
      }
  });
}
//Fin obtener documentos

//Obtener genero
function obtener_generos(data) {
  var combo=$('[name=genero]');
  $.ajax({
      url: "terceros_controller/obtener_generos",
      success: function(response) {
          var respuesta = $.parseJSON(response);
          if (respuesta.success === true) {
            combo.empty();
            combo.append('<option value="">Seleccione</option>')
            for (var i = 0; i < respuesta.generos.length; i++) {
              var item = respuesta.generos[i];
              combo.append('<option value="'+item["tipcodigo"]+'">'+item["tipdetalle"]+'</option>');
            }
            if (data.length > 0) {
              combo.val(data)
            }
          }
      }
  });
}
//Fin obtener genero
obtener_generos(data)


//Obtener paises
var obtener_paises = function(componente, pais, dpto, ciudad, barrio){
  var select = $('#pais');
  var name = select.attr('name');
  var combo = componente.find('[name="pais"]');
  $.ajax({
      url: "terceros_controller/obtener_paises",
      success: function(response) {
        var respuesta = $.parseJSON(response);
        if (respuesta.success === true) {
          combo.empty();
          combo.append('<option value="">Seleccione</option>')
          var cantidad = respuesta.paises.length
          item = respuesta.paises[cantidad-1]
          combo.append('<option value="'+item["paicodigo"]+'">'+item["painombre"]+'</option>');
          for (var i = 0; i < cantidad-1; i++) {
            var item = respuesta.paises[i];
            combo.append('<option value="'+item["paicodigo"]+'">'+item["painombre"]+'</option>');
          }
          if (respuesta.paises.length > 0) {
            combo.val(pais)
            obtener_estados(componente, dpto, ciudad, barrio)
          }
        }
      }
  });
}
//Fin obtener paises
obtener_paises($('[name=modalAprendiz]'), data)
//Obtener estados
function obtener_estados(componente, dpto, ciudad, barrio) {
  var combo = componente.find('[name=estado]');
  var codigo_pais = componente.find('[name=pais]').val();
  var codigop = $('#paisU').val()
  var codigop2 = $('#paisB').val()
  if (codigop !== '') {
    codigo_pais = codigop
  }
  if (codigop2 !== '') {
    codigo_pais = codigop2
  }
  $.ajax({
    url: "terceros_controller/obtener_estados",
    type: 'POST',
    data: {
      codigo_pais: codigo_pais
    },
    success: function(response) {
      var respuesta = $.parseJSON(response);
      if (respuesta.success === true) {
        combo.empty();
        combo.append('<option value="">Seleccione</option>')
        var cantidad = respuesta.estados.length
        item = respuesta.estados[cantidad-1]
        combo.append('<option value="'+item["depcodigo"]+'">'+item["depnombre"]+'</option>');
        for (var i = 0; i < cantidad-1; i++) {
          var item = respuesta.estados[i];
          combo.append('<option value="'+item["depcodigo"]+'">'+item["depnombre"]+'</option>');
        }
        
      }
    }
  });
}
//Obtener estados

//obtener ciudades
function obtener_ciudades(componente, ciudad, barrio){
  var combo = $('[name=ciudad]');
  var codigo_estado = componente.find('[name=estado]').val();
  var codigoe = $('#estadoU').val()
  if (codigoe !== '') {
    codigo_estado = codigoe
  }
  var codigoe2 = $('#estadoB').val()
  if (codigoe2 !== '') {
    codigo_estado = codigoe2
  }
  $.ajax({
    url: "terceros_controller/obtener_ciudades",
    type: 'POST',
    data: {
      codigo_estado: codigo_estado
    },
    success: function(response) {
      var respuesta = $.parseJSON(response);
      if (respuesta.success === true) {
        combo.empty();
        combo.append('<option value="">Seleccione</option>')
        var cantidad = respuesta.ciudades.length
        item = respuesta.ciudades[cantidad-1]
        combo.append('<option value="'+item["muncodigo"]+'">'+item["munnombre"]+'</option>');
        for (var i = 0; i < cantidad-1; i++) {
          var item = respuesta.ciudades[i];
          combo.append('<option value="'+item["muncodigo"]+'">'+item["munnombre"]+'</option>');
        }
        if (ciudad.length > 0) {
          combo.val(ciudad)
          obtener_barrios(barrio)
        }
      }
    }
  });
}
//fin obtener ciudades

//Funcion limpiar formulario
var limpiar_formulario = function(){
  $('[name=modalAprendiz]').modal()
  $('[name=modalAprendiz]').find('.modal-title').text("Registrar "+titulo);
  $('[name=modalAprendiz]').find('[name=tipo]').val("1");
  $('[name=modalAprendiz]').find('[name=codigo_cliente]').val("");
  $('[name=modalAprendiz]').find('#nombre1').val("");
  $('[name=modalAprendiz]').find('#nombre2').val("");
  $('[name=modalAprendiz]').find('#apellido1').val("");
  $('[name=modalAprendiz]').find('#apellido2').val("");
  $('[name=modalAprendiz]').find('[name=numero_documento]').val("");
  $('[name=modalAprendiz]').find('[name=tipo_documento]').val("");
  $('[name=modalAprendiz]').find('[name=pais]').val("");
  $('[name=modalAprendiz]').find('[name=estado]').val("");
  $('[name=modalAprendiz]').find('[name=ciudad]').val("");
  $('[name=modalAprendiz]').find('[name=fecha]').val("");
  $('[name=modalAprendiz]').find('[name=genero]').val("");
  $('[name=modalAprendiz]').find('[name=correo]').val("");
  $('[name=modalAprendiz]').find('[name=regimen]').val("");
  $('[name=modalAprendiz]').find('[name=nombre]').val("");
  $('[name=modalAprendiz]').find('[name=retenedor]').val("NA");
  $('[name=modalAprendiz]').find('[name=contributivo]').val("NA");
  $('[name=modalAprendiz]').find('[name=digito_verificacion]').val("");
  $('[name=modalAprendiz]').find('#correo').css('display', 'block')
  $('[name=modalAprendiz]').find('#pais').css('display', 'block')
  $('[name=modalAprendiz]').find('#ciudad').css('display', 'block')
  $('[name=modalAprendiz]').find('#fecha_nacimiento').css('display', 'block')
}


//Fin funcion limpiar formulario

//Inicio funcion eliminar cliente
var accionEliminar = function(){
  var invalidDelete = true;
  for (var i = 0; i < acciones.length; i++) {
    if (acciones[i]['mod_nombre'] == titulo) {
      if (acciones[i]['acc_descripcion'] == 'Eliminar') {
        invalidDelete = false;
      }
    }
  }
  if (invalidDelete === true) {
    $.notify({
      message: 'Error! Usted no posee permisos para ejecutar esta acción.'
    },{
      type: 'danger',
      delay: 1000,
      placement: {
        align: 'center'
      },
      z_index: 99999
    })
  } else {
    var codigo=$(this).attr("codigo");
    bootbox.confirm({
      title: "Confirmación",
      message: "¿Está seguro que desea eliminar el registro?",
      buttons: {
        confirm: {
          label: 'Si',
          className: 'btn-'
        },
        cancel: {
          label: 'No',
          className: 'btn-danger'
        }
      },
      callback: function (result) {
        if(result===true){
          $.ajax({
            url: "Terceros_controller/eliminar_aprendiz",
            type:"POST",
            data: {
              codigo: codigo
            },
            success: function(response) {
              var respuesta = $.parseJSON(response);
              if (respuesta.success === true) {
                $.notify({
                  message: "Eliminado correctamente."
                },{
                  type: 'success',
                  delay: 1000,
                  placement: {
                    align: 'center'
                  },
                  z_index: 1000,
                  onClosed: function(){
                    obtener_aprendiz();
                  }
                });
              }
            }
          });
        }
      }
    });
  }
}
//Fin funcion eliminar cliente

//Inicio funcion modificar cliente
var accionModificar = function(){
  var invalidChange = true;
  for (var i = 0; i < acciones.length; i++) {
    if (acciones[i]['mod_nombre'] == titulo) {
      if (acciones[i]['acc_descripcion'] == 'Modificar') {
        invalidChange = false;
      }
    }
  }
  if (invalidChange === true) {
    $.notify({
      message: 'Error! Usted no posee permisos para ejecutar esta acción.'
    },{
      type: 'danger',
      delay: 1000,
      placement: {
        align: 'center'
      },
      z_index: 1000
    })
  } else {
    var codigo = $(this).attr('codigo');
    var nombre1 = $(this).attr("nombre1");
    var nombre2 = $(this).attr("nombre2");
    var apellido1 = $(this).attr("apellido1");
    var apellido2 = $(this).attr("apellido2");
    var numero_documento = $(this).attr("numero_documento");
    var tipo_documento = $(this).attr("tipo_documento");
    var pais = $(this).attr("pais");
    var estado = $(this).attr("estado");
    var ciudad = $(this).attr("ciudad");
    var fecha = $(this).attr("fecha");
    var genero = $(this).attr("genero");
    var correo = $(this).attr("correo");
    var nombre = $(this).attr("nombre");
    var contributivo = $(this).attr("contributivo");
    var retenedor = $(this).attr("retenedor");
    var tipo_tercero = $(this).attr("ter_tip");
  
   obtener_documentos(tipo_documento)
    obtener_generos(genero)
    obtener_tertip(tipo_tercero)
    obtener_regimenes($('[name=modalAprendiz]'), regimen)
    $('[name=modalAprendiz]').modal()
    $('[name=modalAprendiz]').find('.modal-title').text("Modificar datos del "+accMod);
    var btnGuardar=$('[name=modalAprendiz]').find('[name=btnGuardar]');
    $('[name=modalAprendiz]').find('[name=codigo_cliente]').val(codigo);
    $('[name=modalAprendiz]').find('[name=tipo]').val('2');
    $('[name=modalAprendiz]').find('[name=nombre]').val(nombre);
    $('[name=modalAprendiz]').find('#nombre1').val(nombre1);
    $('[name=modalAprendiz]').find('#nombre2').val(nombre2);
    $('[name=modalAprendiz]').find('#apellido1').val(apellido1);
    $('[name=modalAprendiz]').find('#apellido2').val(apellido2);
    $('[name=modalAprendiz]').find('[name=numero_documento]').val(numero_documento);
    $('[name=modalAprendiz]').find('[name=tipo_documento]').val(tipo_documento);
    $('[name=modalAprendiz]').find('#contributivo').css('display', 'none')
    $('[name=modalAprendiz]').find('#retenedor').css('display', 'none')
    $('[name=modalAprendiz]').find('[name=pais]').val(pais);
    $('[name=modalAprendiz]').find('[name=estado]').val(estado);
    $('[name=modalAprendiz]').find('[name=ciudad]').val(ciudad);
    $('[name=modalAprendiz]').find('[name=fecha]').val(fecha);
    $('[name=modalAprendiz]').find('[name=genero]').val(genero);
    $('[name=modalAprendiz]').find('[name=correo]').val('correo');
    //$('#correo').css('display', 'none')
    $('#pais').css('display', 'none')
    $('#ciudad').css('display', 'none')
    $('#estado').css('display', 'none')
    $('#fecha_nacimiento').css('display', 'none')
    $('#estado').css('display', 'none')
 }
}
//Fin funcion modificar cliente

var componenteListado = $('[name=listado_aprendices]');


$('[name=listar]').on('click', function(){
  obtener_aprendiz();
 })

//Funcion calcular fecha nacimiento
$('[name="fecha"]').daterangepicker({
  singleDatePicker: true,
  showDropdowns: true,
  locale: {
    format: 'YYYY-MM-DD'
  },
  singleDatePicker: true
});
//Fin fecha nacimineto

function validar_documento() {
  var data = $('[name=modalAprendiz]').find('[name=numero_documento]').val()
  retorno = '';
  $.ajax({
    async: false,
    url: "terceros_controller/validar_documento",
    type: 'POST',
    data: {
      codigo: data
    },
    success: function(response) {
      var respuesta = $.parseJSON(response);
      var item = respuesta.data
      if (item === 2) {
        retorno = false
      } else {
        retorno = true
      }
    }
  })
  return (retorno)
}
formAgregaraprendiz
//Inicio funcion guardar aprendiz
var guardaraprendiz = function(){
  var btnGuardar = $(this);
  var datos_aprendiz = $('[name=formAgregaraprendiz]').serializeArray();
  var error = false;
  var mensajeError;
  for (var i = 0; i < datos_aprendiz.length; i++) {
    var label = datos_aprendiz[i]["name"];
    var valor = datos_aprendiz[i]["value"];
    var compItem = $('[name=' + label + ']');
    $(".has-error").removeClass("has-error");
    switch (label) {
      case 'fichas':
        if (valor.trim() == "") {
          mensajeError = 'Seleccione La Ficha.';
          error = true;
          compItem.focus();
          compItem.parent('div').addClass("has-error");
          i = datos_aprendiz.length + 1;
          break;
        }
        break;
      case 'nombre1':
        if (valor.trim() == "") {
          mensajeError = 'Su primer nombre es necesario.';
          error = true;
          compItem.focus();
          compItem.parent('div').addClass("has-error");
          i = datos_aprendiz.length + 1;
          break;
        }
        break;
      /*case 'nombre2':
        if (valor.trim() == "") {
          mensajeError = 'Su segundo nombre es necesario.';
          error = true;
          compItem.focus();
          compItem.parent('div').addClass("has-error");
          i = datos_aprendiz.length + 1;
          break;
        }
        break;*/
      case 'apellido1':
        if (valor.trim() == "") {
          mensajeError = 'Su primer apellido es necesario.';
          error = true;
          compItem.focus();
          compItem.parent('div').addClass("has-error");
          i = datos_aprendiz.length + 1;
          break;
        }
        break;
      /*case 'apellido2':
        if (valor.trim() == "") {
          mensajeError = 'Su segundo apellido es necesario.';
          error = true;
          compItem.focus();
          compItem.parent('div').addClass("has-error");
          i = datos_aprendiz.length + 1;
          break;
        }
        break;*/
      case 'numero_documento':
        var numero = valor.trim()
        if (valor.trim() == "") {
          mensajeError = 'Su numero de documento es necesario.';
          error = true;
          compItem.focus();
          compItem.parent('div').addClass("has-error");
          i = datos_aprendiz.length + 1;
          break;
        }
        break;
      case 'tipo_documento':
        if (valor.trim() == "") {
          mensajeError = 'Su tipo de documento es necesario.';
          error = true;
          compItem.focus();
          compItem.parent('div').addClass("has-error");
          i = datos_aprendiz.length + 1;
          break;
        }
      break;
      case 'pais':
        if (valor.trim() == "") {
          mensajeError = 'Su pais de nacimiento es necesario.';
          error = true;
          compItem.focus();
          compItem.parent('div').addClass("has-error");
          i = datos_aprendiz.length + 1;
          break;
        }
        break;
    case 'estado':
      if (valor.trim() == "") {
        mensajeError = 'Su estado de nacimiento es necesario.';
        error = true;
        compItem.focus();
        compItem.parent('div').addClass("has-error");
        i = datos_aprendiz.length + 1;
        break;
      }
      break;
      case 'ciudad':
        if (valor.trim() == "") {
          mensajeError = 'Su ciudad de nacimiento es necesaria.';
          error = true;
          compItem.focus();
          compItem.parent('div').addClass("has-error");
          i = datos_aprendiz.length + 1;
          break;
        }
        break;
      case 'genero':
        if (valor.trim() == "") {
          mensajeError = 'Su genero es necesario.';
          error = true;
          compItem.focus();
          compItem.parent('div').addClass("has-error");
          i = datos_aprendiz.length + 1;
          break;
        }
        break;
      case 'nombre':
          if (valor.trim() == "") {
            mensajeError = 'El nombre del establecimiento o razón social es necesario.';
            error = true;
            compItem.focus();
            compItem.parent('div').addClass("has-error");
            i = datos_aprendiz.length + 1;
            break;
          }
        break;
      case 'digito_verificacion':
        if (valor.trim() == "") {
          mensajeError = 'El digito de verificación es necesario.';
          error = true;
          compItem.focus();
          compItem.parent('div').addClass("has-error");
          i = datos_aprendiz.length + 1;
          break;
        }
      break;
      case 'correo':
        if (valor.trim() == "") {
          mensajeError = 'El correo es necesario.';
          error = true;
          compItem.focus();
          compItem.parent('div').addClass("has-error");
          i = datos_aprendiz.length + 1;
          break;
        }
        break;
      
        
    }
  }
  if (error === true) {
    $.notify({
        message: mensajeError
    }, {
        type: 'danger',
        delay: 3000,
        placement: {
            align: 'center'
        },
        z_index: 99999,
    });
    return;
  } else {
      var val = $('[name=modalAprendiz]').find('[name=tipo]').val()
    if (val == '1') {
      var estado = validar_documento();
      if (estado === false) {
        $.notify({
          message: 'El número de documento que intenta registrar ya se encuentra registrado.'
        }, {
          type: 'danger',
          delay: 3000,
          placement: {
            align: 'center'
          },
          z_index: 99999,
        });
      } else {
        $('#nombre1').attr('name', 'nombre1')
        $('#apellido1').attr('name', 'apellido1')
        $('#nombre').attr('name', 'nombre')
        var fd = new FormData(document.getElementById("formAgregaraprendiz"));
        waitingDialog.show('Guardando los cambios, por favor espere...', {dialogSize: 'm', progressType: ''});
        btnGuardar.attr("disabled", "disabled");
        $.ajax({
          url: 'Terceros_controller/guardar_aprendiz',
          type: 'POST',
          data: fd,
          processData: false, // tell jQuery not to process the data
          contentType: false   // tell jQuery not to set contentType
        }).done(function(data) {
          waitingDialog.hide();
          btnGuardar.removeAttr("disabled");
          btnGuardar.text('Guardar');
          $('[name=modalAprendiz]').modal('hide');
          $('#nombre1').attr('name', 'nombre1')
          $('#apellido1').attr('name', 'apellido1')
          $.notify({
            message: "Guardado correctamente."
          }, {
            type: 'success',
            delay: 1000,
            placement: {
              align: 'center'
            },
            z_index: 99999,
            onClosed: function() {
              obtener_aprendiz();
            }
          });
        });
      }
    } else {
      $('#nombre1').attr('name', 'nombre1')
      $('#apellido1').attr('name', 'apellido1')
      $('#nombre').attr('name', 'nombre')
      var fd = new FormData(document.getElementById("formAgregaraprendiz"));
      waitingDialog.show('Guardando los cambios, por favor espere...', {dialogSize: 'm', progressType: ''});
      btnGuardar.attr("disabled", "disabled");
      $.ajax({
        url: 'Terceros_controller/guardar_aprendiz',
        type: 'POST',
        data: fd,
        processData: false, // tell jQuery not to process the data
        contentType: false   // tell jQuery not to set contentType
      }).done(function(data) {
        waitingDialog.hide();
        btnGuardar.removeAttr("disabled");
        btnGuardar.text('Guardar');
        $('[name=modalAprendiz]').modal('hide');
        $('#nombre1').attr('name', 'nombre1')
        $('#apellido1').attr('name', 'apellido1')
        $.notify({
          message: "Guardado correctamente."
        }, {
          type: 'success',
          delay: 1000,
          placement: {
            align: 'center'
          },
          z_index: 99999,
          onClosed: function() {
            obtener_aprendiz();
          }
        });
      });
    }
  }
}
//Fin funcion guardar aprendiz

var btnGuardar = $('[name=modalAprendiz]').find('[name=btnGuardar]');

btnGuardar.on('click', guardaraprendiz);

var obtener_aprendiz = function(){
  var clave = $('[name=modalAprendiz]').find('[name=tip]').val();
    waitingDialog.show('Cargando, por favor espere...', {dialogSize: 'm', progressType: ''});
    var modelFila = '<tr>'+
        '         <th scope="row">'+
        '            <span name="btnEditar"'+
        '              codigo="{0}" nombre="{5}" nombre1="{4}" nombre2="{6}" apellido1="{7}" apellido2="{8}" numero_documento="{2}" dv="{3}" tipo_documento="{20}"'+
        '              genero="{11}" contributivo="{14}" regimen="{28}" retenedor="{15}" pais="{12}" fecha="{10}" estado="{}" ciudad="{13}" ter_tip="{22}"'+
        '              class="text-info" style="width: 32px; padding-left: 0px; padding-right: 0px;" title="Editar" role="button">'+
        '                <span class="icon icon-pencil" style="font-size: 18px;"/></span>'+
        '            <span name="btnEliminarCli" codigo="{0}" title="Eliminar" '+
        '               class="text-danger" style="width: 32px; padding-left: 0px; padding-right: 0px;" role="button">'+
        '                <span class="icon icon-bin" style="font-size: 18px;"/></span>'+
        '            <span name="btnUbicacion" codigo="{0}" title="Ubicación" '+
        '               class="text-info" style="width: 32px; padding-left: 0px; padding-right: 0px;" role="button">'+
        '                <span class="icon icon-home" style="font-size: 18px;"/></span>'+
        '        </th>'+
        '        <td id="codigo">{0}</td>'+
        '        <td>{1}</td>'+
        '        <td>{2}</td>'+
        '        <td>{4} {6} {7} {8}</td>'+
        '        <td>{17}</td>'+
        '        <td>{18}</td>'+
        '        <td>{19}</td>'+
        '        <td>{27}</td>'+
        '        <td>{23}</td>'+
        '        <td>{24}</td>'+
        '        <td>{25}</td>'+
        '        <td>{26}</td>'+
        '    </tr>';

    $.ajax({
        url: 'terceros_controller/obtener_aprendiz',
        type: 'POST',
        data: {
          data: clave
        },
        success: function(response) {
            var respuesta = $.parseJSON(response);
            var datos = respuesta.aprendices;
            var cant = respuesta.cantidad
            var clave = $('[name=modalAprendiz]').find('[name=tip]').val();
            
            if (cant === "0") {
              $.notify({
                  message: 'No podra generar este excel hasta que no ingrese unos '+titulo
              }, {
                  type: 'info',
                  delay: 3000,
                  placement: {
                      align: 'center'
                  },
                  z_index: 99999,
              })
              $('#excel').attr('disabled', 'disabled')
            }
            $('#total_terceros').html('Total de '+ titulo + ' : ' +cant)
            $('#total_terceros').css('font-weight', 'bold')
            componenteListado.empty();
            if (respuesta.success === true) {
              for (var i = 0; i < datos.length; i++) {
                if (datos[i]["terdatcontributivo"] == 'S') {
                  datos[i]["terdatcontributivo"] = 'Si';
                } else {
                  datos[i]["terdatcontributivo"] = 'No';
                }
                if (datos[i]["terdatretenedor"] == 'S') {
                  datos[i]["terdatretenedor"] = 'Si';
                } else {
                  datos[i]["terdatretenedor"] = 'No';
                }
                if (controlador == 'vendedores_controller') {
                  datos[i]['tertipogrupo'] = '4'
                }
                if (controlador == 'proveedores_controller') {
                  datos[i]['tertipogrupo'] = '3'
                }
                if (controlador == 'servicios_controller') {
                  datos[i]['tertipogrupo'] = '5'
                }
                componenteListado.append(modelFila.format(
                  datos[i]["tercodigo"],//0
                  datos[i]["detalle"],//1
                  datos[i]["terdocnum"],//2
                  datos[i]["terdigver"],//3
                  datos[i]["ternom1"],//4
                  datos[i]["ternombre"],//5
                  datos[i]["ternom2"],//6
                  datos[i]["terape1"],//7
                  datos[i]["terape2"],//8
                  datos[i]["terubivalor"],//9
                  datos[i]["terdatfecnac"],//10
                  datos[i]["terdattipsex"],//11
                  datos[i]["terdattipnac"],//12
                  datos[i]["terdatciunac"],//13
                  datos[i]['terdatcontributivo'],//14
                  datos[i]["terdatretenedor"],//15
                  datos[i]["clave"],//16
                  datos[i]["direccion"],//17
                  datos[i]["correo"],//18
                  datos[i]["telefono"],//19
                  datos[i]["tertipdoc"],//20
                  datos[i]["tertipo"],//21
                  datos[i]['tertipogrupo'], //22
                  datos[i]['barrio'], //23
                  datos[i]['municipio'], //24
                  datos[i]['dpto'], //25
                  datos[i]['pais'], //26
                  datos[i]['celular'], //27
                  datos[i]['regimen'],//28
                ));
              }
              $('[name=btnEditar]').on('click', accionModificar);
              $('[name=btnEliminarCli]').on('click', accionEliminar);
              $('[name=btnUbicacion]').on('click', accionUbicacion);
            }
            waitingDialog.hide();
            ocultar_asoc();
        }
    });
};

//
function doSearch(){
    var tableReg = document.getElementById('datos');
    var searchText = document.getElementById('searchTerm').value.toLowerCase();
    var cellsOfRow="";
    var found=false;
    var compareWith="";
    // Recorremos todas las filas con contenido de la tabla
    for (var i = 1; i < tableReg.rows.length; i++)
    {
        cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
        found = false;
        // Recorremos todas las celdas
        for (var j = 0; j < cellsOfRow.length && !found; j++)
        {
          compareWith = cellsOfRow[j].innerHTML.toLowerCase();
          // Buscamos el texto en el contenido de la celda
          if (searchText.length == 0 || (compareWith.indexOf(searchText) > -1))
          {
            found = true;
          }
        }
        if(found)
        {
          tableReg.rows[i].style.display = '';
        } else {
          // si no ha encontrado ninguna coincidencia, esconde la
          // fila de la tabla
          tableReg.rows[i].style.display = 'none';
        }
    }
}

obtener_aprendiz();

$('#editar').on('click', function(){
 $(".has-error").removeClass("has-error");
 $('[name=modalAprendiz]').modal();
})


//Obtener regimenes
var obtener_regimenes = function(componente, dt){
  var select = $('#regimen');
  var name = select.attr('name');
  var combo = componente.find('[name="regimen"]');
  $.ajax({
      url: "terceros_controller/obtener_regimenes",
      success: function(response) {
        var respuesta = $.parseJSON(response);
        if (respuesta.success === true) {
          combo.empty();
          combo.append('<option value="">Seleccione</option>')
          var cantidad = respuesta.data.length
          item = respuesta.data[cantidad-1]
          combo.append('<option value="'+item["tipcodigo"]+'">'+item["tipdetalle"]+'</option>');
          for (var i = 0; i < cantidad-1; i++) {
            var item = respuesta.data[i];
            combo.append('<option value="'+item["tipcodigo"]+'">'+item["tipdetalle"]+'</option>');
          }
          if (dt !== false) {
            if (dt.length > 0) {
              combo.val(dt)
            }
          }
        }
      }
  });
}
//Fin obtener regimenes
