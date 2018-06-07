//se ejecutan al iniciar el modal

$('#ejecutar').on('click',function(){
  buscar_instructor();
  buscar_ficha();
  var invalidCreate = true;
  for (var i = 0; i < acciones.length; i++) {
    if (acciones[i]['mod_nombre'] == 'rel_ins') {
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
    $('[name=modalDocumentos]').modal();
    limpiar_documento();
  }

})
//fin del metodo 

//se ejecutan al presionar el boton registrar del modal

$('#btnSavingDocumentos').on('click',function()
{
guardar_relacion();
obtener_relaciones();
})

//fin del metodo


//inicio del metodo para llenar la tabla de relaciones

var componenteListarrelaciones = $('[name=listar_relaciones]');
var obtener_relaciones = function(){
  //waitingDialog.show('Cargando, por favor espere...', {dialogSize: 'm', progressType: ''});
  var modelFila = '<tr>'+
      '         <th scope="row">'+
      '            <span name="btnEditar" id="editar_familia"'+
      '              codigo="{0}" instructor="{1}" fichas="{2}" instructorid="{5}" fichaid="{6}"'+
      '              observacion="{4}"'+
      '              class="text-info" style="width: 32px; padding-left: 0px; padding-right: 0px;" title="Editar" role="button">'+
      '                <span class="icon icon-pencil" style="font-size: 18px;"/></span>'+
      '            <span name="btnEliminar" codigo="{0}" title="Eliminar" '+
      '               class="text-danger" style="width: 32px; padding-left: 0px; padding-right: 0px;" role="button">'+
      '                <span class="icon icon-bin" style="font-size: 18px;"/></span>'+
      '        </th>'+
      '        <td id="codigo">{0}</td>'+
      '        <td>{1}</td>'+
      '        <td>{2}</td>'+
      '        <td>{4}</td>'+
      //'        <td>{3}</td>'+
      '    </tr>';

      $.ajax({
        url: 'Relinstructores_controller/obtener_relaciones',
        success: function(response){
          var respuesta = $.parseJSON(response);
          componenteListarrelaciones.empty();
          if (respuesta.success === true) {
            var datos = respuesta.data;
            
            for (var i = 0; i < datos.length; i++) {
              componenteListarrelaciones.append(modelFila.format(
                datos[i]['relinscodigo'], //0
                datos[i]['ternom1']+' '+datos[i]['ternom2']+' '+datos[i]['terape1']+' '+datos[i]['terape2'], //1
                datos[i]['ficha'], //2
                datos[i]['relinsestado'], //3
                datos[i]['relinsobservacion'], //4
                datos[i]['relinsInstructor'],//5
                datos[i]['relinsficha'],//6
              ));
            }
            $('[name=btnEliminar]').on('click', eliminar_relacion);
            $('[name=btnEditar]').on('click', modificar_relacion);
          }
          waitingDialog.hide();
        }
      })
}
obtener_relaciones();
//fin del metodo 

//inicio de metodo para eliminar relacion

  var eliminar_relacion = function(){
  var invalidDelete = true;
  for (var i = 0; i < acciones.length; i++) {
    if (acciones[i]['mod_nombre'] == 'rel_ins') {
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
    var codigo = $(this).attr("codigo");
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
            url: 'Relinstructores_controller/inactivar_relacion',
            type: 'POST',
            data:{
              codigo: codigo
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
                    obtener_relaciones()
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

//fin de metodo




//inicio de metodo para modificar relacion

  var modificar_relacion = function() {
    buscar_instructor();
  buscar_ficha();
  var invalidChange = true;
  for (var i = 0; i < acciones.length; i++) {
    if (acciones[i]['mod_nombre'] == 'rel_ins') {
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
    var codigo = $(this).attr("codigo");
    var instructor = $(this).attr("instructor");
    var fichas = $(this).attr("fichas");
    var instructorid = $(this).attr("instructorid");
    var fichaid = $(this).attr("fichaid");
    var observacion = $(this).attr("observacion");
    if (observacion == 'Información no suministrada.') {
      observacion = '';
    }
    $('[name=modalDocumentos]').modal();
    $('[name=modalDocumentos]').find('.modal-title').text('Modificar familias');
    $('[name=modalDocumentos]').find('[name=codigo_documento]').val(codigo);
    $('[name=modalDocumentos]').find('[name=instructor]').val(instructor);
    $('[name=modalDocumentos]').find('[name=fichas]').val(fichas);
    $('[name=modalDocumentos]').find('[name=instructorid]').val(instructorid);
    $('[name=modalDocumentos]').find('[name=fichaid]').val(fichaid);
    $('[name=modalDocumentos]').find('[name=observacion]').val(observacion);
    $('[name=modalDocumentos]').find('[name=tipo]').val('2');
  }
}

//fin de metodo







//metodo para buscar en la tabla

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



// fin del metodo




//Inicio funcion guardar relacion
var guardar_relacion = function(){
  var btnSavingDocumentos = $(this);
  var datos_relacion = $('[name=formSaveFamily]').serializeArray();
  var error = false;
  var mensajeError = 'Guardado correctamente.';
  for (var i = 0; i < datos_relacion.length; i++) {
    var label = datos_relacion[i]['name'];
    var valor = datos_relacion[i]['value'];
    var compItem = $('[name=' + label + ']');
    $('.has-error').removeClass('has-error');
    switch (label) {
      case 'instructor':
        if (valor.trim() == ''){
          mensajeError = 'Ingrese el Instructor.';
          error = true;
          compItem.focus();
          compItem.parent('div').addClass("has-error");
          i = datos_relacion.length + 100;
          break;
        }
        break;
      case 'instructorid':
        if (valor.trim() == ''){
          mensajeError = 'Error! El Instructor no se encuentra registrado.';
          error = true;
          compItem.focus();
          compItem.parent('div').addClass("has-error");
          i = datos_relacion.length + 100;
          break;
        }
        break;
      case 'fichas':
      if (valor.trim() == ''){
        mensajeError = 'Ingrese la Ficha.';
        error = true;
        compItem.focus();
        compItem.parent('div').addClass("has-error");
        i = datos_relacion.length + 100;
        break;
      }
      break;
      case 'fichaid':
        if (valor.trim() == ''){
          mensajeError = 'Error! la ficha no se encuentra registrada.';
          error = true;
          compItem.focus();
          compItem.parent('div').addClass("has-error");
          i = datos_relacion.length + 100;
          break;
        }
        break;
    }
  }
  var instructorid = $('[name=modalDocumentos]').find('[name=instructorid]').val()
  var fichaid = $('[name=modalDocumentos]').find('[name=fichaid]').val()
  var instructor = $('[name=modalDocumentos]').find('[name=instructor]').val()
  var fichas = $('[name=modalDocumentos]').find('[name=fichas]').val()
  
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
    //waitingDialog.show('Guardando los datos, por favor espere...',{dialogSize: 'm', progressType:''});
    btnSavingDocumentos.attr('disabled', 'disabled');
    $.ajax({
      url: 'Relinstructores_controller/guardar_relacion',
      type: 'POST',
      data: fd,
      processData: false,
      contentType: false,
    success: function(data){
      var resp = $.parseJSON(data)
      //waitingDialog.hide();
      btnSavingDocumentos.removeAttr('disabled');
      $.notify({
        message: resp.msg
      }, {
        type: resp.type,
        delay: 1000,
        placement: {
          align: 'center'
        },
        z_index: 99999,
        onClosed: function(){
          if (resp.success !== false) {
            $('[name=modalDocumentos]').modal('hide');
            obtener_documentos()
          }
        }
      })
    }
  })
}
}







//funcion para buscar los datos del instructor
  var buscar_instructor = function()
  {
    $.ajax({
    url: 'Relinstructores_controller/obtener_instructores',
    success: function(response){
      var respuesta = $.parseJSON(response);
      var data = respuesta.data
      $('[name=modalDocumentos]').find("#instructor").autocomplete({
        lookup: data,
        onSelect: function(event) {
          $('[name=modalDocumentos]').find("#instructor").val(event.value);
          $('[name=modalDocumentos]').find("#instructorid").val(event.id);
        }
      });
    }
  })
  }

//fin de funcion buscar

//metodo para buscar los de datos de la ficha

  var buscar_ficha = function()
  {
    $.ajax({
    url: 'Relinstructores_controller/obtener_fichas',
    success: function(response){
      var respuesta = $.parseJSON(response);
      var data = respuesta.data
      $('[name=modalDocumentos]').find("#fichas").autocomplete({
        lookup: data,
        onSelect: function(event) {
          $('[name=modalDocumentos]').find("#fichas").val(event.value);
          $('[name=modalDocumentos]').find("#fichaid").val(event.id);
        }
      });
    }
  })
  }

//fin del metodo buyscar ficha







//Inicio mostrar ayuda
function mostrarAyuda(msg) {
  $.notify({
    message: msg
  }, {
    type: 'info',
    delay: 3000,
    placement: {
      align: 'center'
    },
    z_index: 99999,
  });
}
//Fin mostrar ayuda