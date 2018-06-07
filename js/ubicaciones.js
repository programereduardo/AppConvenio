//Inicio mostrar modal registro ubicaciones
$('#registrar').on('click', function(){
  var invalidCreate = true;
  for (var i = 0; i < acciones.length; i++) {
    if (acciones[i]['mod_nombre'] == 'Ubicaciones') {
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
    $(".has-error").removeClass("has-error");
    $('[name=modalUbicaciones]').modal();
    limpiar_ubicacion();
  }
})
//Fin mostrar modal registro ubicaciones

//Inicio funcion guardar ubicacion
var guardarubicacion = function(){
  var btnSavingUbicaciones = $(this);
  var datos_ubicacion = $('[name=formSaveUbicaciones]').serializeArray();
  var error = false;
  var mensajeError = 'Guardado correctamente.';
  for (var i = 0; i < datos_ubicacion.length; i++) {
    var label = datos_ubicacion[i]['name'];
    var valor = datos_ubicacion[i]['value'];
    var compItem = $('[name=' + label + ']');
    $('.has-error').removeClass('has-error');
    switch (label) {
      case 'clave':
        if (valor.trim() == ''){
          mensajeError = 'La clave es necesaria.';
          error = true;
          compItem.focus();
          compItem.parent('div').addClass("has-error");
          i = datos_ubicacion.length + 100;
          break;
        }
        break;
      case 'abreviatura':
        if (valor.trim() == ''){
          mensajeError = 'La abreviatura es necesaria.';
          error = true;
          compItem.focus();
          compItem.parent('div').addClass("has-error");
          i = datos_ubicacion.length + 100;
          break;
        }
        break;
      case 'detalle':
      if (valor.trim() == ''){
        mensajeError = 'El detalle es necesario.';
        error = true;
        compItem.focus();
        compItem.parent('div').addClass("has-error");
        i = datos_ubicacion.length + 100;
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
    var fd = new FormData(document.getElementById('formSaveUbicaciones'));
    $('[name=modalUbicaciones]').modal('hide');
    waitingDialog.show('Guardando los datos, por favor espere...',
    {dialogSize: 'm', progressType:''});
    btnSavingUbicaciones.attr('disabled', 'disabled');
    $.ajax({
      url: 'tipoubicaciones_controller/guardar_tipoubicaciones',
      type: 'POST',
      data: fd,
      processData: false,
      contentType: false
    }).done(function(data){
      waitingDialog.hide();
      btnSavingUbicaciones.removeAttr('disabled');
      $.notify({
        message: mensajeError
      }, {
        type: 'success',
        delay: 1000,
        placement: {
          align: 'center'
        },
        z_index: 99999,
        onClosed: function(){
          obtener_ubicacion()
        }
      })
    })
  }
}
//fin funcion guardar ubicacion
//Llamado a funcion guardar ubicacion.
$('[name=btnSavingUbicaciones]').on('click', guardarubicacion);
//fin llamar funcion guardar ubicacion


//Inicio obtener ubicaciones
var componenteListarUbicaciones = $('[name=listar_ubicaciones]');
var obtener_ubicacion = function(){
  waitingDialog.show('Cargando, por favor espere...', {dialogSize: 'm', progressType: ''});
  var modelFila = '<tr>'+
      '         <th scope="row">'+
      '            <span name="btnEditar" id="editar_ubicacion"'+
      '              codigo_ubicaciones="{0}" clave_ubicacion="{1}" abreviatura_ubicacion="{2}" detalle_ubicacion="{3}"'+
      '              class="text-info" style="width: 32px; padding-left: 0px; padding-right: 0px;" title="Editar" role="button">'+
      '                <span class="icon icon-pencil" style="font-size: 18px;"/></span>'+
      '            <span name="btnEliminar" codigo_ubicaciones="{0}" title="Eliminar" '+
      '               class="text-danger" style="width: 32px; padding-left: 0px; padding-right: 0px;" role="button">'+
      '                <span class="icon icon-bin" style="font-size: 18px;"/></span>'+
      '        </th>'+
      '        <td id="codigo">{0}</td>'+
      '        <td>{1}</td>'+
      '        <td>{2}</td>'+
      '        <td>{3}</td>'+
      '    </tr>';

      $.ajax({
        url: 'tipoubicaciones_controller/obtener_tipoubicaciones',
        success: function(response){
          var respuesta = $.parseJSON(response);
          componenteListarUbicaciones.empty();
          if (respuesta.success === true) {
            var datos = respuesta.tipoubicaciones;
            console.log(datos)
            for (var i = 0; i < datos.length; i++) {
              componenteListarUbicaciones.append(modelFila.format(
                datos[i]['tipcodigo'], //0
                datos[i]['tipclave'], //1
                datos[i]['tipabreviatura'], //2
                datos[i]['tipdetalle'] //3
              ));
            }
            $('[name=btnEliminar]').on('click', eliminar_ubicacion);
            $('[name=btnEditar]').on('click', modificar_ubicacion);
          }
          waitingDialog.hide();
        }
      })
}
//Fin obtener ubicaciones

//Llamado a la funcion obtener ubicaciones
obtener_ubicacion();
//Fin llamado a la funcion obtener ubicaciones

//Inicio mostrar ayuda
//Seccion ayuda clave
function mostrarAyudaClave() {
  $.notify({
    message: 'Ingrese tres caracteres. Esto le ayudara a diferenciar un tipo de ubicacion de otro.'
  }, {
    type: 'info',
    delay: 3000,
    placement: {
      align: 'center'
    },
    z_index: 99999,
  });
}
//Fin seccion ayuda clave

//Seccion ayuda abreviatura
function mostrarAyudaAbreviatura() {
  $.notify({
    message: 'Ingrese una abreviatura de maximo 20 caracteres.'
  }, {
    type: 'info',
    delay: 3000,
    placement: {
      align: 'center'
    },
    z_index: 99999,
  });
}
//Fin seccion ayuda abreviatura

//Seccion ayuda detalle
function mostrarAyudaDetalle() {
  $.notify({
    message: 'Ingrese un detalle de maximo 30 caracteres.'
  }, {
    type: 'info',
    delay: 3000,
    placement: {
      align: 'center'
    },
    z_index: 99999,
  });
}
//Fin seccion ayuda detalle

//Fin mostrar ayuda

//Inicio funcion convertir a mayusculas
function aMayusculas(obj,id){
  obj = obj.toUpperCase();
  document.getElementById(id).value = obj;
}
//Fin funcion convertir a mayusculas

//Inicio funcion buscar
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

//Fin funcion buscar

//Inicio funcion eliminar_ubicacion

var eliminar_ubicacion = function(){
  var invalidDelete = true;
  for (var i = 0; i < acciones.length; i++) {
    if (acciones[i]['mod_nombre'] == 'Ubicaciones') {
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
      z_index: 1000
    })
  } else {
    var codigo_ubicaciones = $(this).attr("codigo_ubicaciones");
    bootbox.confirm({
      title: 'Confirmación',
      message: "¿Está seguro que desea eliminar el registro?",
      buttons: {
        confirm: {
          label: "Si",
          className: "btn-"
        },
        cancel: {
          label: "No",
          className: "btn-danger"
        }
      },
      callback: function(result){
        if (result === true) {
          $.ajax({
            url: 'tipoubicaciones_controller/inactivar_tipoubicaciones',
            type: 'POST',
            data:{
              codigo_ubicaciones: codigo_ubicaciones
            },
            success: function(response){
              var respuesta = $.parseJSON(response);
              if (respuesta.success === true) {
                $.notify({
                  message: 'Eliminado correctamente.'
                },{
                  type: 'success',
                  delay: 1000,
                  placement: {
                    align: 'center'
                  },
                  z_index: 1000,
                  onClosed: function(){
                    obtener_ubicacion()
                  }
                })
              }
            }
          })
        }
      }
    })
  }
}

//Fin funcion eliminar

//Inicio funcion modificar ubicacion

var modificar_ubicacion = function() {
  var invalidChange = true;
  for (var i = 0; i < acciones.length; i++) {
    if (acciones[i]['mod_nombre'] == 'Ubicaciones') {
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
    var codigo_ubicaciones = $(this).attr("codigo_ubicaciones");
    var clave_ubicaciones = $(this).attr("clave_ubicacion");
    var abreviatura_ubicaciones = $(this).attr("abreviatura_ubicacion");
    var detalle_ubicaciones = $(this).attr("detalle_ubicacion");
    $('[name=modalUbicaciones]').modal();
    $('[name=modalUbicaciones]').find('.modal-title').text('Modificar Ubicaciones');
    $('[name=modalUbicaciones]').find('[name=codigo_ubicaciones]').val(codigo_ubicaciones);
    $('[name=modalUbicaciones]').find('[name=clave]').val(clave_ubicaciones);
    $('[name=modalUbicaciones]').find('[name=abreviatura]').val(abreviatura_ubicaciones);
    $('[name=modalUbicaciones]').find('[name=detalle]').val(detalle_ubicaciones);
    $('[name=modalUbicaciones]').find('[name=tipo]').val('2');
  }
}

//Fin funcion modificar ubicacion

//Inicio funcion limpiar ubicacion

var limpiar_ubicacion = function(){
  $('[name=modalUbicaciones]').find('[name=codigo_ubicaciones]').val("");
  $('[name=modalUbicaciones]').find('[name=clave]').val("");
  $('[name=modalUbicaciones]').find('[name=abreviatura]').val("");
  $('[name=modalUbicaciones]').find('[name=detalle]').val("");
  $('[name=modalUbicaciones]').find('[name=tipo]').val('1');
}

//Fin funcion limpiar ubicacion
