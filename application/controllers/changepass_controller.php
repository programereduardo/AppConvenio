<?php 
/**
* 
*/
class changepass_controller extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('changepass_model');
	}

	public function index()
	{
		$resultado = $this->changepass_model->validar_session();
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
	        $this->load->view('changepassword_view');
	        $this->load->view('shared/footer');
	      } else {
	        header("Location: inicio");
	      }
	    }
	}

	public function cambiar_password()
	{
		$datos = $this->input->post();

		$respuesta = $this->changepass_model->cambiar_password($datos);
		if ($respuesta===true)
		{
			echo json_encode(
				array(
					'success'=>true
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