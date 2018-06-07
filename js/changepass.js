

$('#guardarpassword').on('click',function()
{
	var continuar = false;
	//contraseña actual
	var passactual = $('#confirm_pass').val();
	var campouno = $('#confirm_pass');
	var primercampo = $('#nueva_pass1').val();
	var campodos = $('#nueva_pass1');


	if (passactual=== '')
	{
		campouno.focus();
		campouno.parent('div').addClass('has-error');

		$.notify(
		{
			message : 'Ingrese Contraseña Actual.'
		},{
			type : 'danger',
			delay : 100,
			placement : {
				align : 'center'
			},
			z_index : 9999
		});
	}else{
		if (primercampo ==='')
		{
			campodos.focus();
			campodos.parent('div').addClass('has-error');

			$.notify(
			{
				message : 'Ingrese Nueva Contraseña.'
			},{
				type : 'danger',
				delay : 100,
				placement : {
					align : 'center'
				},
				z_index : 9999
			});
		}else{
			var confirmarpass = $('#confirm_pass').val();
			var newpass = $('#nueva_pass1').val();

			$.ajax(
			{
				url : 'changepass_controller/cambiar_password',
				type : 'POST',
				data : {
					confirmarpass:confirmarpass,
					newpass:newpass
				},
				success : function(response)
				{
					var respuesta = $.parseJSON(response);
					if (respuesta.success === true)
					{
						$.notify(
						{
							message : 'Contraseña Cambiada Exitosamente.'
						},{
							type : 'success',
							delay : 100,
							placement : {
								align : 'center'
							},
							z_index : 9999
						});
					}else{
						$.notify(
						{
							message : 'Contraseña Incorrecta, Verifique contraseña actual por favor.'
						},{
							type : 'danger',
							delay : 100,
							placement : {
								align : 'center'
							},
							z_index : 9999
						});
					}
				}

			})

		}
	}

})


$('#confirm_pass').on('keyup',function()
{
	$(".has-error").removeClass("has-error");
	var passactual = $('#confirm_pass').val();
	var campouno = $('#confirm_pass');
	if (passactual!='')
	{
		campouno.focus();
		campouno.parent('div').addClass('has-info');
	}
})

//metodo para validar que los campos de contraseña coincidan

$('#nueva_pass2').on('keyup',function()
{
	var validation = function()
	{
		var primercampo = $('#nueva_pass1').val();
		var segundocampo = $('#nueva_pass2').val();
		var campo = $('#nueva_pass2');
		if (primercampo != segundocampo)
		{	$('#mensajerror').html('CONTRASEÑAS NO COINCIDEN ');
			$('#mensajerror').css('color','red');
			$('#mensajerror').css('margin-left','220px');
			$('#mensajerror').css('margin-top','-30px');
    		
			campo.focus();
			campo.parent('div').addClass('has-error');
			continuar = false;
			$('#guardarpassword').css('display','none');
		}else{
			$(".has-error").removeClass("has-error");
			campo.parent('div').addClass('has-success');
			$('#mensajerror').html('');
			$('#guardarpassword').css('display','inline');
			continuar = true;
		}

	}
	validation();
	
})


//fin del metodo