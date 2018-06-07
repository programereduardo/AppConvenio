//Inicio mostrar modal registro familias
$('#registrar').on('click', function(){
  
  var invalidCreate = true;
  for (var i = 0; i < acciones.length; i++) {
    if (acciones[i]['mod_nombre'] == 'Documentos') {
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
    $('[name=modalFichas]').modal();
    limpiar_documento();
  }
})
//Fin mostrar modal registro familias

//Inicio funcion guardar familia
var guardarFichas = function(){
  var btnSavingFichas = $(this);
  var datos_fichas = $('[name=formSaveFamily]').serializeArray();
  var error = false;
  var mensajeError = 'Guardado correctamente.';
  for (var i = 0; i < datos_fichas.length; i++) {
    var label = datos_fichas[i]['name'];
    var valor = datos_fichas[i]['value'];
    var compItem = $('[name=' + label + ']');
    $('.has-error').removeClass('has-error');
    switch (label) {
      case 'clave':
        if (valor.trim() == ''){
          mensajeError = 'La clave es necesaria.';
          error = true;
          compItem.focus();
          compItem.parent('div').addClass("has-error");
          i = datos_fichas.length + 100;
          break;
        }
        break;
      case 'abreviatura':
        if (valor.trim() == ''){
          mensajeError = 'La abreviatura es necesaria.';
          error = true;
          compItem.focus();
          compItem.parent('div').addClass("has-error");
          i = datos_fichas.length + 100;
          break;
        }
        break;
      case 'detalle':
      if (valor.trim() == ''){
        mensajeError = 'El detalle es necesario.';
        error = true;
        compItem.focus();
        compItem.parent('div').addClass("has-error");
        i = datos_fichas.length + 100;
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
    var fd = new FormData(document.getElementById('formSaveFamily'));
    $('[name=modalFichas]').modal('hide');
    waitingDialog.show('Guardando los datos, por favor espere...',
    {dialogSize: 'm', progressType:''});
    btnSavingFichas.attr('disabled', 'disabled');
    $.ajax({
      url: 'Fichas_controller/guardar_ficha',
      type: 'POST',
      data: fd,
      processData: false,
      contentType: false
    }).done(function(data){
      waitingDialog.hide();
      btnSavingFichas.removeAttr('disabled');
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
          obtener_fichas()
        }
      })
    })
  }
}
//fin funcion guardar familia
//Llamado a funcion guardar familia.
$('[name=btnSavingFichas]').on('click', guardarFichas);
//fin llamar funcion guardar familia


//Inicio obtener familias
var componenteListarficha = $('[name=listar_fichas]');
var obtener_fichas = function(){
  waitingDialog.show('Cargando, por favor espere...', {dialogSize: 'm', progressType: ''});
  var modelFila = '<tr>'+
      '         <th scope="row">'+
      '            <span name="btnEditar" id="editar_familia"'+
      '              codigo_ficha="{0}" clave_ficha="{1}" abreviatura_ficha="{2}" detalle_ficha="{3}"'+
      '              class="text-info" style="width: 32px; padding-left: 0px; padding-right: 0px;" title="Editar" role="button">'+
      '                <span class="icon icon-pencil" style="font-size: 18px;"/></span>'+
      '            <span name="btnEliminar" codigo_ficha="{0}" title="Eliminar" '+
      '               class="text-danger" style="width: 32px; padding-left: 0px; padding-right: 0px;" role="button">'+
      '                <span class="icon icon-bin" style="font-size: 18px;"/></span>'+
      '        </th>'+
      '        <td id="codigo">{0}</td>'+
      '        <td>{1}</td>'+
      '        <td>{2}</td>'+
      '        <td>{3}</td>'+
      '    </tr>';

      $.ajax({
        url: 'Fichas_controller/obtener_fichas',
        success: function(response){
          var respuesta = $.parseJSON(response);
          componenteListarficha.empty();
          if (respuesta.success === true) {
            var datos = respuesta.fichas;
            for (var i = 0; i < datos.length; i++) {
              componenteListarficha.append(modelFila.format(
                datos[i]['ficcodigo'], //0
                datos[i]['ficclave'], //1
                datos[i]['ficabreviatura'], //2
                datos[i]['ficdetalle'] //3
              ));
            }
            $('[name=btnEliminar]').on('click', eliminar_ficha);
            $('[name=btnEditar]').on('click', modificar_ficha);
          }
          waitingDialog.hide();
        }
      })
}
//Fin obtener familias

//Llamado a la funcion obtener familias
obtener_fichas();
//Fin llamado a la funcion obtener familias

//Inicio mostrar ayuda
//Seccion ayuda clave
function mostrarAyudaClave() {
  $.notify({
    message: 'Ingrese Ingrese Numero de Ficha.'
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
    message: 'Ingrese una abreviatura de maximo 30 caracteres.'
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
    message: 'Ingrese un detalle de maximo 100 caracteres.'
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

//Inicio funcion numerico
function aMayusculas(obj,id){
  var clave = $('#clave').val();
  var compItem = $('[name=clave]');
$('.has-error').removeClass('has-error');
  if (clave==='a' || clave==='.' || clave==='+' || clave==='*' || clave==='/' ) {
    
     mensajeError = 'ERROR La Clave Solo Debe Contener Numeros.';
          error = true;
          compItem.focus();
          compItem.parent('div').addClass("has-error");

    $.notify({
      message: mensajeError
    },{
      type: 'danger',
      delay: 3000,
      placement: {
        align : 'center'
      },
      z_index: 9999
    });        
          
  }
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

//Inicio funcion eliminar_ficha

var eliminar_ficha = function(){
  var invalidDelete = true;
  for (var i = 0; i < acciones.length; i++) {
    if (acciones[i]['mod_nombre'] == 'Fichas') {
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
    var codigo_ficha = $(this).attr("codigo_ficha");
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
            url: 'Fichas_controller/inactivar_ficha',
            type: 'POST',
            data:{
              codigo_ficha: codigo_ficha
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
                    obtener_fichas()
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


//Inicio funcion modificar familia

var modificar_ficha = function() {
  var invalidChange = true;
  for (var i = 0; i < acciones.length; i++) {
    if (acciones[i]['mod_nombre'] == 'Fichas') {
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
    var codigo_ficha = $(this).attr("codigo_ficha");
    var clave_ficha = $(this).attr("clave_ficha");
    var abreviatura_ficha = $(this).attr("abreviatura_ficha");
    var detalle_ficha = $(this).attr("detalle_ficha");
    $('[name=modalFichas]').modal();
    $('[name=modalFichas]').find('.modal-title').text('Modificar ficha');
    $('[name=modalFichas]').find('[name=codigo_ficha]').val(codigo_ficha);
    $('[name=modalFichas]').find('[name=clave]').val(clave_ficha);
    $('[name=modalFichas]').find('[name=abreviatura]').val(abreviatura_ficha);
    $('[name=modalFichas]').find('[name=detalle]').val(detalle_ficha);
    $('[name=modalFichas]').find('[name=tipo]').val('2');
  }
}

//Fin funcion modificar familia

//Inicio funcion limpiar familia

var limpiar_documento = function(){
  $('[name=modalFichas]').find('[name=codigo_ficha]').val("");
  $('[name=modalFichas]').find('[name=clave]').val("");
  $('[name=modalFichas]').find('[name=abreviatura]').val("");
  $('[name=modalFichas]').find('[name=detalle]').val("");
  $('[name=modalFichas]').find('[name=tipo]').val('1');
}

//Fin funcion limpiar familia
