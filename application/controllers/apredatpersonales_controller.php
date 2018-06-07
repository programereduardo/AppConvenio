<?php 
/**
* 
*/
class apredatpersonales_controller extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('apredatpersonales_model');
	}

	public function index()
	{
	    $resultado = $this->apredatpersonales_model->validar_session();
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
	        if ($data['mod_nombre'] == "Aprendiz" && $data['acc_descripcion'] == "Ver") {
	          $next = true;
	        }
	      }
	      if ($next === true) {
	        $this->load->view('shared/header');
	        $this->load->view('shared/menu', $datos);
	        $this->load->view('datospersonales_view');
	        $this->load->view('shared/footer');
	      } else {
	        header("Location: inicio");
	      }
	    }
	}

	public function datos_personales()
	{
		$respuesta = $this->apredatpersonales_model->datos_personales();

		$conteo = count($respuesta);

		if ($conteo>0)
		{
			echo json_encode(
				array(
				'success'=>true,
				'data'=>$respuesta
				)
			);
		}else{
			echo json_encode(
				array(
				'success'=>false
				)
			);
		}
	}

	public function actualizar_datos()
	{
		
		$data = $this->input->post();
		$respuesta = $this->apredatpersonales_model->actualizar_datos($data);
		$conteo = count($respuesta);

		if ($conteo>0)
		{
			echo json_encode(
				array(
				'success'=>true,
				'data'=>$respuesta
				)
			);
		}else{
			echo json_encode(
				array(
				'success'=>false
				)
			);
		}

	}


	public function tipo_documento()
	{
		$respuesta = $this->apredatpersonales_model->tipo_documento();

		$conteo = count($respuesta);

		if ($conteo>0)
		{
			echo json_encode(
				array(
				'success'=>true,
				'data'=>$respuesta
				)
			);
		}else{
			echo json_encode(
				array(
				'success'=>false
				)
			);
		}
	}

	public function sexo()
	{
		$respuesta = $this->apredatpersonales_model->sexo();
		$contar = count($respuesta);
		if ($contar>0)
		{
			echo json_encode(
				array(
					'success'=>true,
					'data'=>$respuesta
				)
			);
		}else{
			echo json_encode(
				array(
					'success'=>false
				)
			);
		}	
	}

	public function estado_civil()
	{
		$respuesta = $this->apredatpersonales_model->estado_civil();

		$contar = count($respuesta);

		if ($contar>0)
		{
			echo json_encode(
				array(
					'success'=>true,
					'data'=>$respuesta
				)
			);
		}else{
			echo json_encode(
				array(
					'success'=>false
				)
			);
		}
	}

	public function pais_nacimiento()
	{
		$respuesta = $this->apredatpersonales_model->pais_nacimiento();
		$contar = count($respuesta);
		if ($contar>0)
		{
			echo json_encode(
				array(
					'success'=>true,
					'data'=>$respuesta
				)
			);
		}else{
			echo json_encode(
				array(
					'success'=>false
				)
			);
		}

	}

	public function dep_nacimiento()
	{
		$pais = $this->input->post('pais');
		
		$respuesta = $this->apredatpersonales_model->dep_nacimiento($pais);
		$contar = count($respuesta);
		if ($contar>0)
		{
			echo json_encode(
				array(
					'success'=>true,
					'data'=>$respuesta
				)
			);
		}else{
			echo json_encode(
				array(
					'success'=>false
				)
			);
		}


	}

	public function municipio_nacimiento()
	{
		$departamento = $this->input->post('departamento');

		$respuesta = $this->apredatpersonales_model->municipio_nacimiento($departamento);
		$contar = count($respuesta);
		if ($contar>0)
		{
			echo json_encode(
				array(
					'success'=>true,
					'data'=>$respuesta
				)
			);
		}else{
			echo json_encode(
				array(
					'success'=>false
				)
			);
		}

	}

	public function dep_residencia()
	{
		$pais = $this->input->post('pais');
		
		$respuesta = $this->apredatpersonales_model->dep_residencia($pais);
		$contar = count($respuesta);
		if ($contar>0)
		{
			echo json_encode(
				array(
					'success'=>true,
					'data'=>$respuesta
				)
			);
		}else{
			echo json_encode(
				array(
					'success'=>false
				)
			);
		}
	}

	public function municipio_residencia()
	{
		$departamento = $this->input->post('departamento');

		$respuesta = $this->apredatpersonales_model->municipio_residencia($departamento);
		$contar = count($respuesta);
		if ($contar>0)
		{
			echo json_encode(
				array(
					'success'=>true,
					'data'=>$respuesta
				)
			);
		}else{
			echo json_encode(
				array(
					'success'=>false
				)
			);
		}

	}

	public function barrio()
	{
		$municipio = $this->input->post('municipio');
		$respuesta = $this->apredatpersonales_model->barrio($municipio);
		$contar = count($respuesta);
		if ($contar>0)
		{
			echo json_encode(
				array(
					'success'=>true,
					'data'=>$respuesta
				)
			);
		}else{
			echo json_encode(
				array(
					'success'=>false
				)
			);
		}

	}  

	

	


}


 ?>