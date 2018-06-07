
//inicio de metodo para mostrar la fecha actual
 var mostrar_fecha = function ()
 {
   var d = new Date();
var strDate = d.getFullYear() + "/" + (d.getMonth()+1) + "/" + d.getDate();
   $('#Fecha_view').html('Fecha : '+strDate);
   $('#Fecha_view').css('font-weight', 'bold')
   $('#Fecha_view').css('margin-left', '900px')

 } 
//fin del metodo
mostrar_fecha();

$('[name=fecha]').daterangepicker({
  singleDatePicker: true,
  showDropdowns: true,
  locale: {
    format: 'YYYY-MM-DD'
  },
  singleDatePicker: true
});

$('#btnguardar').on('click',function()
{
  guardar();

  
  
})


$('#btncancelar').on('click',function()
{
  window.location= './inicio';
})
 
  
 
 //ejecutar metodo -> llenar_tabla ()

 $('#ficha').on('change',function()
 {
 	llenar_tabla();
 })

 //fin de ejecucion

var guardar = function()
{
   
    
  var form = $('[name=formlist_ins]');
  //var fd = form.serializeArray();
 var fd = new FormData(document.getElementById("formlist_ins"));
    //alert(confirmacion);

        $.ajax({
          url : 'asistencias_controller/guardar',
          type : 'POST',
          data: fd,
          processData: false, // tell jQuery not to process the data
          contentType: false, // tell jQuery not to set contentType
          success : function(response)
          {
            var respuesta = $.parseJSON(response);
            if (respuesta.success === true)
            {
              $.notify({
                message : 'Guardado Exitosamente.'
              },{
                type : 'success',
                delay : 100,
                placement : {
                  align : 'center'
                },
                z_index : 9999,
                onClosed: function(){
                  llenar_tabla();
                  //waitingDialog.hide();
              }
              });
              
            }else{
              $.notify({
                message : 'Se produjo un error inesperado, intentelo más tarde. Si no funciona pongase en contacto con el Departamento de Sistemas (ERROR: asiguar192).'
              },{
                type : 'success',
                delay : 3000,
                placement : {
                  align : 'center'
                },
                z_index : 9999
              })
            }
            llenar_tabla();
          }   

        })
  

}


 //metodo para llenar la tabla segun se seleccione en la lista

 var llenar_tabla = function ()
 {
  var lista = $('#ficha').val();

  var fecha = $('#fecha').val();



 	var componenteListarasistencias = $('[name=lista_asistencias]');
var obtener_asistencias = function(){
  waitingDialog.show('Cargando, por favor espere...', {dialogSize: 'm', progressType: ''});
  var modelFila = '<tr>'+
      '        <td id="codigo">{0}</td>'+
      '         <th scope="row">'+
      '<label class="btn btn-success active"><input type="checkbox"  class="custom-control-input" name="asistenciacheck[]" value="{5}" codigo="{0}" aprendiz="{5}">'+
      '<span class="glyphicon glyphicon-ok"></span>'+
      '        <td>{2}</td>'+
      '        <td>{3}</td>'+
      '        </th>'+
      '    </tr>';

      $.ajax({
        url: 'asistencias_controller/obtener_asistencias',
        type : 'POST',
        data : {
        	lista : lista,
          fecha : fecha
        },
        success: function(response){
          var respuesta = $.parseJSON(response);
          componenteListarasistencias.empty();
          if (respuesta.success === true) {
            var datos = respuesta.data;

            for (var i = 0; i < datos.length; i++) {

                $.ajax({
                  url : 'asistencias_controller/buscar_fallas',
                  type : 'POST',
                  data : {
                    aprendiz: datos[i]['relaprAprendiz']
                  },

                })

              componenteListarasistencias.append(modelFila.format(
                datos[i]['relaprcodigo'], //0
                datos[i]['terdocnum'], //1
                datos[i]['ternom1']+' '+datos[i]['ternom2']+' '+datos[i]['terape1']+' '+datos[i]['terape2'], //2
                datos[i]['relaprinasistencias'], //3
                datos[i]['relaprobservacion'], //4
                datos[i]['relaprAprendiz'],//5
                datos[i]['relaprficha'],//6
              ));
            }
            //$('[name=asistenciacheck]').on('click', guardar);
            $('[name=btnNoAsistio]').on('click', noasistio_relacion);
            $('[name=btnHistorial]').on('click',historial_relacion);
          }
          waitingDialog.hide();
        }
      })
}
obtener_asistencias();


 }

 //fin del metodo

 //metodo para mostrar el historial del aprendiz

 var historial_relacion = function()
 {
  $(".has-error").removeClass("has-error");
   $('[name=modalDocumentos]').modal();
   $('[name=modalDocumentos]').find('[name=codigo_aprendiz]').val($(this).attr('aprendiz'));
   var combo = $('#consulta');
  var consulta = $('#consulta').val();
    var codigo_aprendiz = $('#codigo_aprendiz').val();



  $.ajax({
    url : 'asistencias_controller/buscar_nombre',
    type : 'POST',
    data : {
      aprendiz : codigo_aprendiz
    },
    success : function(response)
    {
      var respuesta = $.parseJSON(response);
      if (respuesta.success === true)
      {
        $('[name=modalDocumentos').find('[name=nombre_aprendiz]').val(respuesta.data);
      }
    }
  })

  //llenar el combobox
   combo.empty();
   combo.append('<option value="0">Sin Información</option>');
   combo.append('<option value="2">Inasistencias</option>');
   combo.append('<option value="1">Asistencias</option>');


    mostrar_consulta();

   $('#consulta').on('change',function(){
    mostrar_consulta();
   })


 }

 //fin del metodo

//metodo para llenar la tabla con la consulta requerida
var mostrar_consulta = function()
{

    var consulta = $('#consulta').val();
    var aprendiz = $('#codigo_aprendiz').val();




  var componenteListarasistencias = $('[name=listado_consulta]');
var listado_consulta = function(){
  waitingDialog.show('Cargando, por favor espere...', {dialogSize: 'm', progressType: ''});
  var modelFila = '<tr>'+
      '         <th scope="row">'+
      '            <span name="btnAsistio" id="editar_familia"'+
      '              codigo="{0}" aprendiz="{5}"  fecha="{1}" tipo=2'+
      '              class="text-info" style="width: 32px; padding-left: 0px; padding-right: 0px;" title="Asistio" role="button">'+
      '                <span class="glyphicon glyphicon-ok-circle" style="font-size: 18px;"/></span>'+
      '            <span name="btnNoAsistio" codigo="{0}" aprendiz="{5}" fecha="{1}" tipo=2 title="No Asistio" '+
      '               class="text-danger" style="width: 32px; padding-left: 0px; padding-right: 0px;" role="button">'+
      '                <span class="glyphicon glyphicon-remove-circle" style="font-size: 18px;"/></span>'+
      '            <span name="eliminar" codigo="{0}" aprendiz="{5}" fecha="{1}" tipo=2 title="eliminar" '+
      '               class="text-danger" style="width: 32px; padding-left: 0px; padding-right: 0px;" role="button">'+
      '                <span class="glyphicon glyphicon-trash" style="font-size: 18px;"/></span>'+
      '        <td id="codigo">{0}</td>'+
      '        <td>{1}</td>'+
      '        </th>'+
      '    </tr>';

      $.ajax({
        url: 'asistencias_controller/obtener_consulta',
        type : 'POST',
        data : {
          consulta : consulta,
          aprendiz : aprendiz
        },
        success: function(response){
          var respuesta = $.parseJSON(response);
          componenteListarasistencias.empty();
          if (respuesta.success === true) {
            var datos = respuesta.data;
            $('#total').html('Total : ' +respuesta.total)
            $('#total').css('font-weight', 'bold')
            for (var i = 0; i < datos.length; i++) {

              componenteListarasistencias.append(modelFila.format(
                datos[i]['asicodigo'], //0
                datos[i]['asifecha'], //1
                datos[i]['terdocnum'], //3
                datos[i]['ternom1']+' '+datos[i]['ternom2']+' '+datos[i]['terape1']+' '+datos[i]['terape2'], //2
                datos[i]['relaprobservacion'], //4
                datos[i]['asiaprendiz'],//5

              ));
            }
            $('[name=btnAsistio]').on('click', asistio_relacion);
            $('[name=btnNoAsistio]').on('click', noasistio_relacion);
            $('[name=btnHistorial]').on('click',historial_relacion);
            $('[name=eliminar]').on('click',eliminar_historial);
          }
          waitingDialog.hide();
        }
      })
}
listado_consulta();




}
//fin del metodo



  //metodo para eliminar historial de asistencia

  var eliminar_historial = function()
  {
    var codigo = $(this).attr('codigo');

    $.ajax({
      url : 'asistencias_controller/eliminar_historial',
      type : 'POST',
      data : {
        codigo : codigo
      },
      success : function(response)
      {
        var respuesta = $.parseJSON(response);

        if (respuesta.success === true)
        {
          $.notify({
            message : 'Acción Realizada Exitosamente.'
          },{
            type : 'success',
            delay : 3000,
            placement : {
              align : 'center'
            },
            z_index : 9999
          });
        }
      }
    })
        mostrar_consulta();
  }

  //fin del metodo

 //metodo para ingresar la asistencia

 var asistio_relacion = function()
 {
    var tipo = $(this).attr('tipo');
    if (tipo === '2')
    {

      var fecha = $(this).attr('fecha');
    }else{

      var fecha = 0;
    }

    var aprendiz = $(this).attr('aprendiz');
    waitingDialog.show('Guardando los cambios, por favor espere...', {dialogSize: 'm', progressType: ''});
    $.ajax({
    url : 'asistencias_controller/asistio_relacion',
    type : 'POST',
    data : {
      aprendiz : aprendiz,
      tipo : tipo,
      fecha : fecha
    },
    success : function(response){

      var respuesta = $.parseJSON(response);

      if (respuesta.success === true)
      {
        $.notify({
          message : 'Guardado Exitosamente',
        },{
          type : 'success',
          delay : 3000,
          placement : {
            align : 'center'
          },
          z_index : 9999
        });

      }
    }
  });
      llenar_tabla();
      if (tipo==='2')
      {
        mostrar_consulta();
      }
 }

 //fin del metodo



//metodo para ingresar la inaasistencia

 var noasistio_relacion = function()
 {
    var tipo = $(this).attr('tipo');
    if (tipo === '2')
    {
      var fecha = $(this).attr('fecha');
    }else{
      var fecha = 0;
    }
    var aprendiz = $(this).attr('aprendiz');
    $.ajax({
    url : 'asistencias_controller/noasistio_relacion',
    type : 'POST',
    data : {
      aprendiz : aprendiz,
      tipo : tipo,
      fecha : fecha
    },
    success : function(response){
      var respuesta = $.parseJSON(response);

      if (respuesta.success === true)
      {
        $.notify({
          message : 'Guardado Exitosamente',
        },{
          type : 'success',
          delay : 3000,
          placement : {
            align : 'center'
          },
          z_index : 9999
        });
      }
    }
  });


        llenar_tabla();
 }

 //fin del metodo


 //metodo para llenar la lista desplegable de fichas

 var llenar_fichas = function(data)
 {
 	var combo = $('#ficha');
 	$.ajax({
 		url : 'asistencias_controller/llenar_ficha',
 		success : function(response)
 		{
 			//debugger
 			var respuesta = $.parseJSON(response);
 			if (respuesta.success === true)
 			{

 				combo.empty();
            	combo.append('<option value="123456789">Seleccione</option>');
            	for (var i = 0; i < respuesta.data.length; i++) {
            		var item = respuesta.data[i];
              		combo.append('<option value="'+item["relinscodigo"]+'">'+item["ficclave"]+' '+item["ficdetalle"]+'</option>');
            	}
 			}
 		}
 	})
 }

 //fin del metodo

 llenar_fichas();

 //ingresa la fecha actual de los aprendices

 //fin del metodo
