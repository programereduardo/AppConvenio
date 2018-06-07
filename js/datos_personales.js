//metodo para mostrar los datos del aprendiz

var informacion = function()
{
	$.ajax(
	{
		url : 'apredatpersonales_controller/datos_personales',
		success : function (response)
		{
			var respuesta = $.parseJSON(response);

			if (respuesta.success === true)
			{
				var tip_doc = respuesta.data[0]['tertipdoc'];
				var identificación = respuesta.data[0]['terdocnum'];
				var p_nombre = respuesta.data[0]['ternom1'];
				var s_nombre = respuesta.data[0]['ternom2'];
				var p_apellido = respuesta.data[0]['terape1'];
				var s_apellido = respuesta.data[0]['terape2'];
				var genero = respuesta.data[0]['terdattipsex'];
				var estado_civil = respuesta.data[0]['terdattipciv'];
				var fecha_nac = respuesta.data[0]['terdatfecnac'];
				var pai_nac = respuesta.data[0]['terdattipnac'];
				var mun_nac = respuesta.data[0]['terdatciunac'];
				var departamento = respuesta.data[0][''];

				$('[name=tipo_doc]').val(tip_doc);
				$('[name=num_id]').val(identificación);
				$('[name=p_nombre]').val(p_nombre);
				$('[name=s_nombre]').val(s_nombre);
				$('[name=p_apellido]').val(p_apellido);
				$('[name=s_apellido]').val(s_apellido);
				$('[name=genero]').val(genero);
				$('[name=estado_civil]').val(estado_civil);
				$('[name=fecha_nac]').val(fecha_nac);
				$('[name=pai_nac]').val(pai_nac);
				$('[name=mun_nac]').val(mun_nac);
				$('[name=departamento]').val(departamento);







			}
		}
	})
}
informacion();
//fin del metodo





//metodo para ejecutar funciones cuando ejecuten el boton guardar

$('#btnGuardardatos').on('click',function()
{

	validar_campos();
})

//fin del metodo

//metodo para controlar que los campos requeridos no queden vacios	

var validar_campos = function()
{
	var formulario = $('#formulariodatpesonales').serializeArray();

	var error = false;
	var mensajerror;
	for (var i = 0; i < formulario.length; i++) {
		var label = formulario[i]['name'];
		var valor = formulario[i]['value'];
		var componente = $('[name='+label+']');

		switch (label)
		{
			case 'tipo_doc' :
			if (valor.trim()=== '0')
			{
				
				mensajerror = 'Selecciones tipo de identificación.';
				error = true;
				componente.focus();
				componente.parent('div').addClass("has-error");
				i = formulario.length + 1;
				break;
			}else{
				$(".has-error").removeClass("has-error");
				
			}
			break;
			case 'num_id' :
			if (valor.trim()=== '')
			{
				
				mensajerror = 'Ingrese número de identificación.';
				error = true;
				componente.focus();
				componente.parent('div').addClass("has-error");
				i = formulario.length + 1;
				break;
			}else{
				$(".has-error").removeClass("has-error");
				
			}
			break;
			case 'p_nombre' :
			if (valor.trim()=== '')
			{
				
				mensajerror = 'El primer nombre es necesario.';
				error = true;
				componente.focus();
				componente.parent('div').addClass("has-error");
				i = formulario.length + 1;
				break;
			}else{
				$(".has-error").removeClass("has-error");
			}
			break;
			case 'p_apellido' :
			if (valor.trim()=== '')
			{
				
				mensajerror = 'El primer apellido es necesario.';
				error = true;
				componente.focus();
				componente.parent('div').addClass("has-error");
				i = formulario.length + 1;
				break;
			}else{
				$(".has-error").removeClass("has-error");
			}
			break;
			case 'genero':
			if (valor.trim() === '0')
			{
				mensajerror = 'Seleccione sexo.';
				error = true;
				componente.focus();
				componente.parent('div').addClass('has-error');
				i = formulario.length + 1;
				break;
			}
			break;

			case 'est_civil':
			if (valor.trim()==='0')
			{
				mensajerror = 'Selecciones estado Civil.';
				error = true;
				componente.focus();
				componente.parent('div').addClass('has-error');
				i = formulario.length + 1;
				break;
			}
			break;

			case 'fec_nac':
			if (valor.trim()==='')
			{
				mensajerror = 'Ingrese fecha de nacimiento.';
				error = true;
				componente.focus();
				componente.parent('div').addClass('has-error');
				i = formulario.length + 1;
				break;
			}
			break;

			case 'pai_nac':
			if (valor.trim()==='')
			{
				mensajerror = 'Ingrese Pais de nacimiento.';
				error = true;
				componente.focus();
				componente.parent('div').addClass('has-error');
				i = formulario.length + 1;
				break;
			}
			break;
		}

	}

	if (error===true)
	{
		$.notify(
		{
			message : mensajerror
		},{
			type : 'danger',
			delay : 100,
			placement : {
				align : 'center'
			},
			z_index : 9999
		});
	}else{
		var tip_doc  = $('[name=tipo_doc]').val();
		var identificación = $('[name=num_id]').val();
		var p_nombre = $('[name=p_nombre]').val();
		var s_nombre = $('[name=s_nombre]').val();
		var p_apellido = $('[name=p_apellido]').val();
		var s_apellido = $('[name=s_apellido]').val();

		$.ajax(
		{
			url : 'apredatpersonales_controller/actualizar_datos',
			type : 'POST',
			data : {
				tip_doc:tip_doc,
				identificación:identificación,
				p_nombre:p_nombre,
				s_nombre:s_nombre,
				p_apellido:p_apellido,
				s_apellido:s_apellido
			}, 
			success : function(response)
			{
				var respuesta = $.parseJSON(response);
				if (respuesta.success === true)
				{
					$.notify(
					{
						message : 'Guardado Exitosamente.'
					},{
						type : 'danger',
						delay : 1000,
						placement : {
							align : 'center'
						},
						z_index : 9999
					});
				}
			}
		});
	}
}

//fin del metodo




// metodo para llenar el select tipo de documento

var tipo_documento = function()
{

	var select = $('#tipo_doc');
	$.ajax(
	{
		url : 'apredatpersonales_controller/tipo_documento',
		success : function(response)
		{
			var respuesta = $.parseJSON(response);
			if (respuesta.success === true)
			{
				select.empty();
				select.append('<option value="0">Seleccione</option>');
				var cantidad = respuesta.data.length;
				for (var i = 0; i < cantidad; i++)
				{
					var item = respuesta.data[i];
					select.append('<option value"'+item['tipcodigo']+'">'+item['tipdetalle']+'</option>')
				}
			}
		}
	})
}
tipo_documento(); 

//fin del metodo

//metodo para llenar el select sexo

var sexo = function()
{
	var select = $('[name=genero]');
	$.ajax(
	{
		url : 'apredatpersonales_controller/sexo',
		success : function(response)
		{
			var respuesta = $.parseJSON(response);
			if (respuesta.success === true)
			{
				select.empty();
				select.append('<option value="0">Seleccione</option>');
				var cantidad = respuesta.data.length;
				for (var i = 0; i < cantidad; i++) {
					var item = respuesta.data[i];

					select.append('<option value="'+item['tipcodigo']+'">'+item['tipdetalle']+'</option>');
				}

			}
		}
	});
}
sexo();

//fin del metodo

//metodo para llenar el select estado civil

var estado_civil = function()
{
	var select = $('[name=est_civil]');

	$.ajax(
	{
		url : 'apredatpersonales_controller/estado_civil',
		success : function(response)
		{
			var respuesta = $.parseJSON(response);

			if (respuesta.success === true)
			{
				select.empty();
				select.append('<option value="0">Seleccione</option>');

				var cantidad = respuesta.data.length;

				for (var i = 0; i < cantidad; i++) {
					var item = respuesta.data[i];
					select.append('<option value="'+item['tipcodigo']+'">'+item['tipdetalle']+'</option>');
				}
			}
		}
	})
}

estado_civil();

//fin del metodo 

//Funcion calcular fecha nacimiento
$('[name="fec_nac"]').daterangepicker({
  singleDatePicker: true,
  showDropdowns: true,
  locale: {
    format: 'YYYY-MM-DD'
  },
  singleDatePicker: true
});
//Fin fecha nacimineto

//metodo para llenar select pais de nacimiento

var pais_nacimiento = function()
{
	var select = $('[name=pai_nac]');

	$.ajax(
	{
		url : 'apredatpersonales_controller/pais_nacimiento',
		success : function(response)
		{
			var respuesta = $.parseJSON(response);
			if (respuesta.success === true)
			{
				select.empty();
				select.append('<option value="0">Seleccione</option>');

				var cantidad = respuesta.data.length;

				for (var i = 0; i < cantidad; i++) {
					var item = respuesta.data[i];

					select.append('<option value="'+item['paicodigo']+'">'+item['painombre']+'</option>')
				}
			}
		}
	})
}
pais_nacimiento();

// fin del metodo

//metodo para llenar el select de departamento de nacimiento

var dep_nacimiento = function()
{
	var pais = $('[name=pai_nac]').val();
	var select = $('[name=dep_nac]');

	$.ajax(
	{
		url : 'apredatpersonales_controller/dep_nacimiento',
		type : 'POST',
		data : {
			pais : pais
		},
		success : function(response)
		{
			var respuesta = $.parseJSON(response);

			if (respuesta.success===true)
			{
				select.empty();
				select.append('<option value="0">Seleccione</option>');

				var cantidad = respuesta.data.length;

				for (var i = 0; i < cantidad; i++) {
					var item = respuesta.data[i];

					select.append('<option value="'+item['depcodigo']+'">'+item['depnombre']+'</option>')
				}
			}
		}
	})
}

$('[name=pai_nac]').on('change',function()
{
	dep_nacimiento();
})

//fin del metodo

//metodo para llenar select municipio de nacimiento

var municipio_nacimiento = function()
{
	var departamento = $('[name=dep_nac]').val();
	var select = $('[name=mun_nac]');

	$.ajax(
	{
		url : 'apredatpersonales_controller/municipio_nacimiento',
		type : 'POST',
		data : {
			departamento : departamento
		},
		success : function(response)
		{
			var respuesta = $.parseJSON(response);

			if (respuesta.success === true)
			{
				select.empty();
				select.append('<option value="0">Seleccione</option>');

				var cantidad = respuesta.data.length;

				for (var i = 0; i < cantidad; i++) {
					var item = respuesta.data[i];

					select.append('<option value="'+item['muncodigo']+'">'+item['munnombre']+'</option>');
				}
			}
		}
	})
}

$('[name=dep_nac]').on('change',function()
{
	municipio_nacimiento();
})

//fin de metodo

//metodo para llenar select departamento de residencia
var dep_residencia = function()
{
	var pais = 49;
	var select = $('[name=dep_res]');

	$.ajax(
	{
		url : 'apredatpersonales_controller/dep_residencia',
		type : 'POST',
		data : {
			pais : pais
		},
		success : function(response)
		{
			var respuesta = $.parseJSON(response);

			if (respuesta.success===true)
			{
				select.empty();
				select.append('<option value="0">Seleccione</option>');

				var cantidad = respuesta.data.length;

				for (var i = 0; i < cantidad; i++) {
					var item = respuesta.data[i];

					select.append('<option value="'+item['depcodigo']+'">'+item['depnombre']+'</option>')
				}
			}
		}
	})
}
	dep_residencia();



	//metodo para llenar select municipio de residencia

var municipio_residencia = function()
{
	var departamento = $('[name=dep_res]').val();
	var select = $('[name=mun_res]');

	$.ajax(
	{
		url : 'apredatpersonales_controller/municipio_residencia',
		type : 'POST',
		data : {
			departamento : departamento
		},
		success : function(response)
		{
			var respuesta = $.parseJSON(response);

			if (respuesta.success === true)
			{
				select.empty();
				select.append('<option value="0">Seleccione</option>');

				var cantidad = respuesta.data.length;

				for (var i = 0; i < cantidad; i++) {
					var item = respuesta.data[i];

					select.append('<option value="'+item['muncodigo']+'">'+item['munnombre']+'</option>');
				}
			}
		}
	})
}

$('[name=dep_res]').on('change',function()
{
	municipio_residencia();
})

//fin de metodo

//metodo para llenar select de barrio 

var barrio = function()
{
	var municipio = $('[name=mun_res]').val();
	var select = $('[name=bar_res]');

	$.ajax(
	{
		url : 'apredatpersonales_controller/barrio',
		type : 'POST',
		data : {
			municipio : municipio
		},
		success : function(response)
		{
			var respuesta = $.parseJSON(response);
			if (respuesta.success === true)
			{
				select.empty();
				select.append('<option value="0">Seleccione</option>');

				var cantidad = respuesta.data.length;
				for (var i = 0; i < cantidad; i++) {
					var item = respuesta.data[i];

					select.append('<option value="'+item['barcodigo']+'">'+item['barnombre']+'</option>');
				}
			}
		}
	})
}
$('[name=mun_res]').on('change',function()
{
	barrio();
})
//fin del metodo



var aMayusculas = function(obj,id){
  obj = obj.toUpperCase();
  document.getElementById(id).value = obj;
}