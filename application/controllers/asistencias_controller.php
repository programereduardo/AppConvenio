<?php
	/**
	*
	*/
	class asistencias_controller extends CI_Controller
	{

		public function __construct()
		{
			parent::__construct();
			$this->load->model('Asistencias_model');
		}

		public function index()
		{
		    $resultado = $this->Asistencias_model->validar_session();
		    if ($resultado === false) {
		      header('Location: login');
		    } else {
		      $this->load->model('sistema/permisos_model');
		      $acciones = $this->permisos_model->obtener_acciones();
		      $datos = array(
		        'acciones' => $acciones
		      );
		      $next = false;

		      foreach ($acciones as $data) {
		        if ($data['mod_nombre'] == "Asistencias" && $data['acc_descripcion'] == "Ver") {
		          $next = true;
		        }
		      }

		      if ($next === true) {
		        $this->load->view('shared/header');
		        $this->load->view('shared/menu', $datos);
		        $this->load->view('Asistencias_view');
		        $this->load->view('shared/footer');
		      } else {
		        header("Location: inicio");
		      }
		    }
  		}

  		public function llenar_ficha()
  		{
  			$respuesta = $this->Asistencias_model->llenar_ficha();
  			if ($respuesta>0) {
  			echo json_encode(array(
  				'success'=> true,
  				'data'=>$respuesta
  			));

  			}else{
  				echo json_encode(array(
  				'success'=> false,
  				'msg'=>'Ha ocurrido un error en la Consulta.'
  			));
  			}
		}

		public function obtener_consulta()
		{
			$consulta = $this->input->post('consulta');
			$aprendiz = $this->input->post('aprendiz');

			$respuesta = $this->Asistencias_model->obtener_consulta($consulta,$aprendiz);
			$total = count($respuesta);
			buscar_fallas($apre);
			if ($respuesta>0)
			{
				echo json_encode(array(
					'success'=>true,
					'data'=>$respuesta,
					'total'=>$total
				));
			}
		}


		public function contenido()
		{
			$aprendiz = $this->input->post('aprendiz');
			$resp = $this->Asistencias_model->contenido($aprendiz);
		}

		public function obtener_asistencias()
		{
			$lista = $this->input->post('lista');
			$fecha = $this->input->post('fecha');

			$respuesta = $this->Asistencias_model->obtener_asistencias($lista,$fecha);

			if ($respuesta>0) {

				echo json_encode(array(
  				'success'=> true,
  				'data'=>$respuesta
  			));
			}else{
  				echo json_encode(array(
  				'success'=> false,
  				'msg'=>'Ha ocurrido un error en la Consulta.'
  			));
  			}

		}

		public function buscar_nombre()
		{
			$aprendiz = $this->input->post('aprendiz');

			$respuesta = $this->Asistencias_model->buscar_nombre($aprendiz);

			if ($respuesta>0)
			{
				echo json_encode(array(
					'success'=>true,
					'data'=>$respuesta[0]['ternom1'].' '.$respuesta[0]['ternom2'].' '.$respuesta[0]['terape1'].' '.$respuesta[0]['terape2']));
			}
		}

		public function asistio_relacion()
		{
			$aprendiz = $this->input->post('aprendiz');
			$tipo =	$this->input->post('tipo');
			$fechain = 0;
			if ($tipo === '2')
			{
				$fechain = $this->input->post('fecha');


			}
			$respuesta = $this->Asistencias_model->asistio_relacion($aprendiz,$fechain,$tipo);
			if ($respuesta === true)
			{
				echo json_encode(array(
					'success'=>true
				));
			}
		}


		public function eliminar_historial()
		{
			$codigo = $this->input->post('codigo');

			$respuesta = $this->Asistencias_model->eliminar_historial($codigo);

			if ($respuesta === true)
			{
				echo json_encode(array(
					'success'=>$respuesta
				));
			}
		}


		public function noasistio_relacion()
		{
			$fechain = 0;
			$aprendiz = $this->input->post('aprendiz');
			$tipo = $this->input->post('tipo');
			if ($tipo === '2')
			{
				$fechain = $this->input->post('fecha');

			}
			$respuesta = $this->Asistencias_model->noasistio_relacion($aprendiz,$fechain,$tipo);
			if ($respuesta === true)
			{
				echo json_encode(array(
					'success'=>true
				));
			}
		}

		public function buscar_fallas()
		{
			$apre = $this->input->post('aprendiz');
			$respuesta = $this->Asistencias_model->buscar_fallas($apre);


		}

		public function guardar()
		{	
			$inasistencias = $this->input->post();
			$fecha = $inasistencias['fecha'];
			foreach ($inasistencias['asistenciacheck'] as $key)
			{
				$idaprendiz = $key;
				$respuesta = $this->Asistencias_model->guardar($idaprendiz,$fecha);
				if ($respuesta === true)
				{
					$continuar = true;
				}else{
					$continuar = false;
				}				
			}
			if ($continuar === true)
			{
				echo json_encode(
					array(
						'success'=>$respuesta
					));
			}
		}

	}
 ?>
  