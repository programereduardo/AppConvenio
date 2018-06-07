//se ejecutan al iniciar el modal
 
$('#ejecutar').on('click',function(){
  limpiar_relacion();
  buscar_aprendiz();
  buscar_ficha();
  var invalidCreate = true;
  for (var i = 0; i < acciones.length; i++) {
    if (acciones[i]['mod_nombre'] == 'relacion-aprendiz') {
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
    limpiar_relacion();
  }

})
//fin del metodo  

$('#fichaid').on('change',function()
{
  obtener_aprendiz();
})

var ocultarbtn = function()
{
  $('#btnguardarrel').css('display','none')
}



//metodo para llenar la tabla de listar_aprendices
var obtener_aprendiz = function()
{

  var componenteListado = $('[name=listado_aprendices]');
  var ficha = $('#fichaid').val();
  waitingDialog.show('Cargando, por favor espere...', {dialogSize: 'm', progressType: ''});
    var modelFila = '<tr>'+
        '        <td id="codigo">{0}</td>'+
        '        <td>{1}</td>'+
        '         <th scope="row">'+
        '<a name="btnguardarrel"  style="height: 26px;margin-top: -6px;width: 71px;padding-left: 8px;padding-top: 5px;" id="btnguardarrel" codigo="{0}" class="btn btn-info">Guardar</a>'+
        '        </th>'+
        '    </tr>';

    $.ajax(
    {
      url : 'Relaprendiz_controller/obtener_aprendices',
      
 
      success: function(response){
          var respuesta = $.parseJSON(response);
          componenteListado.empty();
          if (respuesta.success === true) {
            var datos = respuesta.data;

            for (var i = 0; i < datos.length; i++) {

                

              componenteListado.append(modelFila.format(
                datos[i]['tercodigo'], //0
                datos[i]['ternom1']+' '+datos[i]['ternom2']+' '+datos[i]['terape1']+' '+datos[i]['terape2'], //1
                
              ));
            }
            //$('[name=asistenciacheck]').on('click', guardar);
            $('[name=btnguardarrel]').on('click', guardar_relacion);

            
          }
          waitingDialog.hide();
        }

    })
}
  
//fin del metodo


//se ejecutan al presionar el boton registrar del modal

$('#btnSavingDocumentos').on('click',function()
{


obtener_relaciones();

})

//fin del metodo


//inicio del metodo para llenar la tabla de relaciones

var componenteListarrelaciones = $('[name=listar_relaciones]');
var obtener_relaciones = function(){
  //waitingDialog.show('Cargando, por favor espere...', {dialogSize: 'm', progressType: ''});
  var modelFila = '<tr>'+
      '         <th scope="row">'+
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
        url: 'Relaprendiz_controller/obtener_relaciones',
        success: function(response){
          var respuesta = $.parseJSON(response);
          componenteListarrelaciones.empty();
          if (respuesta.success === true) {
            var datos = respuesta.data;
            
            for (var i = 0; i < datos.length; i++) {
              componenteListarrelaciones.append(modelFila.format(
                datos[i]['relaprcodigo'], //0
                datos[i]['ternom1']+' '+datos[i]['ternom2']+' '+datos[i]['terape1']+' '+datos[i]['terape2'], //1
                datos[i]['ficha'], //2
                datos[i]['relaprestado'], //3
                datos[i]['relaprobservacion'], //4
                datos[i]['relaprAprendiz'],//5
                datos[i]['relaprficha'],//6
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
    if (acciones[i]['mod_nombre'] == 'relacion-aprendiz') {
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
            url: 'Relaprendiz_controller/inactivar_relacion',
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
    buscar_aprendiz();
  buscar_ficha();
  var invalidChange = true;
  for (var i = 0; i < acciones.length; i++) {
    if (acciones[i]['mod_nombre'] == 'relacion-aprendiz') {
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
    var aprendiz = $(this).attr("aprendiz");
    var fichas = $(this).attr("fichas");
    var aprendizid = $(this).attr("aprendizid");
    var fichaid = $(this).attr("fichaid");
    var observacion = $(this).attr("observacion");
    if (observacion == 'Información no suministrada.') {
      observacion = '';
    }
    $('[name=modalmodificarDocumentos]').modal();
    $('[name=modalmodificarDocumentos]').find('[name=codigo_documento]').val(codigo);
    $('[name=modalmodificarDocumentos]').find('[name=aprendiz]').val(aprendiz);
    $('[name=modalmodificarDocumentos]').find('[name=fichas]').val(fichas);
    $('[name=modalmodificarDocumentos]').find('[name=aprendizid]').val(aprendizid);
    $('[name=modalmodificarDocumentos]').find('[name=fichaid]').val(fichaid);
    $('[name=modalmodificarDocumentos]').find('[name=observacion]').val(observacion);
    $('[name=modalmodificarDocumentos]').find('[name=tipo]').val('2');
  }
}

//fin de metodo







//metodo para buscar en la tabla de relaciones

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


//metodo para buscar en la tabla de aprendices

function doSearchapr(){
    var tableReg = document.getElementById('datos1');
    var searchText = document.getElementById('searchTerm1').value.toLowerCase();
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
  var fichaid = $('[name=modalDocumentos]').find('[name=fichaid]').val();
  var relaprendiz = $(this).attr('codigo');
  var tipo = $('[name=tipo]').val();
  $.ajax(
  {
    url : 'Relaprendiz_controller/guardar_relacion',
    type : 'POST',
    data : {
      tipo : tipo,
      fichaid : fichaid,
      aprendiz : relaprendiz
    },
    success : function(response)
    {
      var respuesta = $.parseJSON(response);

      if(respuesta.success === true)
      {
        
        waitingDialog.show('Cargando, por favor espere...', {dialogSize: 'm', progressType: ''});
          obtener_aprendiz();
          obtener_relaciones();
        waitingDialog.hide();
        

      }
    }
  })



}



var limpiar_relacion = function()
{
  $('#aprendiz').val('');
  $('#fichas').val('');

}




//funcion para buscar los datos del aprendiz
  var buscar_aprendiz = function()
  {
    $.ajax({
    url: 'Relaprendiz_controller/obtener_aprendices',
    success: function(response){
      var respuesta = $.parseJSON(response);
      var data = respuesta.data
      $('[name=modalDocumentos]').find("#aprendiz").autocomplete({
        lookup: data,
        onSelect: function(event) {
          $('[name=modalDocumentos]').find("#aprendiz").val(event.value);
          $('[name=modalDocumentos]').find("#aprendizid").val(event.id);
        }
      });
    }
  })
  }

//fin de funcion buscar

//metodo para buscar los de datos de la ficha

  var buscar_ficha = function()
  {
    var combo = $('#fichaid');
    $.ajax({
    url: 'Relaprendiz_controller/obtener_fichas',
    success: function(response) {
        var respuesta = $.parseJSON(response);
        if (respuesta.success === true) {
          combo.empty();
          combo.append('<option value="">Seleccione</option>')
          var cantidad = respuesta.data.length
          item = respuesta.data[cantidad-1]
          combo.append('<option value="'+item["ficcodigo"]+'">'+item["ficclave"]+' - '+item["ficdetalle"]+'</option>');
          for (var i = 0; i < cantidad-1; i++) {
            var item = respuesta.data[i];
            combo.append('<option value="'+item["ficcodigo"]+'">'+item["ficclave"]+' - '+item["ficdetalle"]+'</option>');
          }
          
        }
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