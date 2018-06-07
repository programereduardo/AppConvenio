var ctx = $('#chart')
var obtener_terceros = function() {
  $.ajax({
    async: false,
    url: 'home_controller/obtener_terceros',
    success: function(response){
      var respuesta = $.parseJSON(response)
      item = respuesta.data;

      cantidad = [];
      label = [];
      for (var i = 0; i < item.length; i++) {
        cantidad[i] = item[i]['cant']
      }
      for (var i = 0; i < item.length; i++) {
        label[i] = item[i]['data']
      }

      config = {
        type: 'pie',
            data: {
                labels: [label],
                datasets: [{
                    label: '# of Votes',
                    data: [cantidad],
                    backgroundColor: [
                      window.chartColors.red,
                      window.chartColors.blue
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
              legend: {
                labels:{
                  fontSize: 17,
                },
                //position: 'bottom'
              },
              title: {
                display: true,
                text: 'Título del gráfico',
                fontSize: 24,
                fontStyle: 'bold'
              },
              responsive: true,
            }
      };
      function chart_chart() {
        var c = new Chart(ctx, config)
      }
      chart_chart()
    }
  })
  //var chart1 = chartHelper.createChart("chart1", "Bar", item, config);
}
//obtener_terceros()

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

var validar_articulos = function() {
  var componente = $('[name=listado_notificaciones]');
  //waitingDialog.show('Cargando, por favor espere...', {dialogSize: 'm', progressType: ''});
  var modelFila = '<tr>'+
      '        <td>{0}</td>'+
      '        <td>{1}</td>'+
      '        <td>{2}</td>'+
      '        <td>{3}</td>'+
      '        <td>{4}</td>'+
      //'        <td>{4} ( {2} )</td>'+
      '    </tr>';
  $.ajax({
    url: 'home_controller/validar_articulos',
    type: 'POST',
    success: function(response) {
      var respuesta = $.parseJSON(response)
      if (respuesta.success === true) {
        data = respuesta.data;
        if (data.length > 0) {
          $('[name=modalNotificaciones]').modal();
        }
        for (var i = 0; i < data.length; i++) {
          componente.append(modelFila.format(
            data[i]['artreferencia'], //0
            data[i]['artnombre'],//1
            data[i]['artexistencias'],//2
            data[i]['artstock'],//3
            data[i]['artdescripcion']//4
          ));
        }
      }
    //  waitingDialog.hide();
    }
  })
}
validar_articulos()

$('[name="desde"]').daterangepicker({
  singleDatePicker: true,
  showDropdowns: true,
  locale: {
    format: 'YYYY-MM-DD'
  },
  singleDatePicker: true
});

$('[name="hasta"]').daterangepicker({
  singleDatePicker: true,
  showDropdowns: true,
  locale: {
    format: 'YYYY-MM-DD'
  },
  singleDatePicker: true
});

var limpiar = function(){
  $('[name=vendedor]').val("")
  $('[name=vendedor-id]').val("")
  $('[name=desde]').val("")
  $('[name=hasta]').val("")
}
limpiar()

$(function() {
  $.ajax({
    url: 'facturacion_controller/obtener_vendedores',
    success: function(response){
      var respuesta = $.parseJSON(response);
      var data = respuesta.data
      $("#vendedor").autocomplete({
        lookup: data,
        onSelect: function(event) {
          $("#vendedor").val(event.value);
          $("#vendedor-id").val(event.id);
        }
      });
    }
  })
});

function validar_vendedor(){
  vendedor = $('[name=vendedor]').val()
  if (vendedor == "") {
    $('[name=vendedor-id]').val("")
  }
}
