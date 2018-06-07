//metodo para exportar de la base de datos a un arcicho excel

  $('#btnexcel').on('click', function(){
  
  var ficha = $('#ficha').val();
  var desde = $('#desde').val();
  var hasta = $('#hasta').val();
  var dias = $('#dias').val();



  window.open(
    $.ajax(
      {
        url : 'Reportes_inasistencias_controller/reporte_inasistencia',
        type : 'POST',
        data : {
          ficha :ficha,
         desde : desde,
         hasta : hasta,
         dias :dias
        }
      }
    )
    );
})

//fin del metodo

//metodo para validar que el nmero de dias sea mayor que 0
$('#dias').on('keyup',function()
{
var compItem = $('[name=dias]');
var validar_campo = function()
{
  var campo = $('#dias').val();
  if (campo<1)
  {
    $.notify({
      message : 'El numero de Inasistencias tiene que ser mayor a 0.'
    },{
      type : 'danger',
      delay : 3000,
      placement : {
        align : 'center'
      },
      Z_index: 9999
    });
    compItem.focus();
          compItem.parent('div').addClass("has-error");
           $('#btnconsulta').css('display', 'none')
           $('#btnpdf').css('display', 'none')
           $('#btnexcel').css('display', 'none')
  }
  if (campo>0)
  {
      $(".has-error").removeClass("has-error");
      compItem.focus();
      compItem.parent('div').addClass("has-success");
      $('#btnconsulta').css('display', 'inline-block');
      $('#btnpdf').css('display', 'inline-block')
      $('#btnexcel').css('display', 'inline-block')   


  }
}
validar_campo();
  
})
//fin del metodo

/*$('#ficha').on('change',function(){
  obtener_consulta();
})*/

//inicio de metodo para ejecutar la consulta de reportes de inasistencias

  $('[name=btnconsulta]').on('click',function()
  {

    obtener_consulta();

  })

//fin del metodo






//metodo para ejecutar la consulta y mostrarla en una tabla

  var obtener_consulta = function()
  {
    var componenteListado = $('[name=lista_consultas]');
    var ficha = $('#ficha').val();
    var desde = $('#desde').val(); 
    var hasta = $('#hasta').val();
    var dias = $('#dias').val();
    
    waitingDialog.show('Cargando los cambios, por favor espere...', {dialogSize: 'm', progressType: ''});
    var modelFila = '<tr>'+
        '        <td id="codigo">{0}</td>'+
        '        <td>{1}</td>'+
        '        <td>{2}</td>'+
        '        <td>{3}</td>'+
        '    </tr>';
        $.ajax({ 
          url : 'Reportes_inasistencias_controller/obtener_consulta',
          type : 'POST',
          data : {
            ficha : ficha,
            desde : desde,
            hasta : hasta,
            dias : dias
          },
          success : function(response)
          {
            var respuesta = $.parseJSON(response);
            if (respuesta.success === true)
            {
              var datos = respuesta.data;
              componenteListado.empty();
              for (var i = 0; i < respuesta.data.length; i++) {

               if(datos[i]["total"] < dias)
               {
                  var porcentaje = datos[i]["total"]/100;
                  componenteListado.append(modelFila.format(
                    datos[i]["asicodigo"],//0
                    datos[i]["ternom1"]+' '+datos[i]["ternom2"]+' '+datos[i]["terape1"]+' '+datos[i]["terape2"],//1
                    datos[i]["total"],//2
                    porcentaje,//3
                    
                  ));
               }
              }
              
            }
          waitingDialog.hide();
          }
        })
  }

//fin del metodo


//Funcion calcular fecha desde
$('[name="desde"]').daterangepicker({
  singleDatePicker: true,
  showDropdowns: true,
  locale: {
    format: 'YYYY-MM-DD'
  },
  singleDatePicker: true
});
//Fin fecha desde


//Funcion calcular fecha hasta
$('[name="hasta"]').daterangepicker({
  singleDatePicker: true,
  showDropdowns: true,
  locale: {
    format: 'YYYY-MM-DD'
  },
  singleDatePicker: true
});
//Fin fecha hasta




// inicio de metodo para mostrar todas las fichas en el multiselectable
var llenar_fichas = function(){
  var combo = $('#ficha');

  $.ajax({
    url : 'Reportes_inasistencias_controller/llenar_fichas',
    success : function(response)
    {
      var respuesta = $.parseJSON(response);
      if (respuesta.success === true)
      {
        
        combo.empty();
              
          for (var i = 0; i < respuesta.data.length; i++) {
            var item = respuesta.data[i];
              combo.append('<option value="'+item["ficcodigo"]+'">'+item["ficclave"]+' '+item["ficdetalle"]+'</option>');
          }

      }
    }
  })
}
llenar_fichas();
//fin del metodo

