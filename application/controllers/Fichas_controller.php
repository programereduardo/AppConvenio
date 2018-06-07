<?php 
/**
* 
*/
class Fichas_controller extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Fichas_model');
	}

	//Cargando Vistas
  public function index() {
    $resultado = $this->Fichas_model->validar_session();
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
        if ($data['mod_nombre'] == "Mantenimientos" && $data['acc_descripcion'] == "Ver") {
          $next = true;
        }
      }
      if ($next === true) {
        $this->load->view('shared/header');
        $this->load->view('shared/menu', $datos);
        $this->load->view('Fichas_view');
        $this->load->view('shared/footer');
      } else {
        header("Location: inicio");
      }
    }
  }

    public function guardar_ficha()
    {
	  	$datos = $this->input->post();

	  	if ($datos['tipo']==='1')
	  	 {

	  		$ejecutar = $this->Fichas_model->guardar_ficha($datos);
	  	 }else{
	  	 	$ejecutar = $this->Fichas_model->actualizar_ficha($datos);
	  	 }
	  	 $success = false;
	  	 if ($ejecutar=== true)
	  	 {
	  	 	$success=true;
	  	 }
	  	 echo json_encode(array(
			'success'=>$success	
	  	 ));
	}

	public function obtener_fichas()
	{
		$result = $this->Fichas_model->obtener_fichas();
		$success = false;
		$cant = count($result);

		if ($cant>0)
		{
			$success = true;
		}

		echo json_encode(array(
			'success'=>$success,
			'fichas'=>$result
		));
	}

	public function inactivar_ficha()
	{
		$codigo_ficha = $this->input->post('codigo_ficha');
		$result = $this->Fichas_model->inactivar_ficha($codigo_ficha);
		$success = false;

		if ($result===true)
		{
			$success = true;
		}

		echo json_encode(array(
			'success'=>$success
		));
	}



}
?>