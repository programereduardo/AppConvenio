<?php 
	/**
	* 
	*/
	class Instructores_controller extends CI_Controller
	{
		
		public function __construct()
		{
			parent::__construct();
			$this->load->model('Instructores_model');
		}

		public function index()
		{
		    $resultado = $this->Instructores_model->validar_session();
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
		        if ($data['mod_nombre'] == "Instructores" && $data['acc_descripcion'] == "Ver") {
		          $next = true;
		        }
		      }
		      if ($next === true) {
		        $this->load->view('shared/header');
		        $this->load->view('shared/menu', $datos);
		        $this->load->view('Instructores_view');
		        $this->load->view('shared/footer');
		      } else {
		        header("Location: inicio");
		      }
		    }
  		}


  		public function Instructor() {
    $next = false;
    $this->load->model('sistema/permisos_model');
    $acciones = $this->permisos_model->obtener_acciones();
    $datos = array(
      'acciones' => $acciones
    );
    foreach ($acciones as $data) {
      if ($data['mod_nombre'] == "Instructor" && $data['acc_descripcion'] == "Ver") {
        $next = true;
      }
    }
    if ($next === true) {
      $this->index('Instructor', 'Instructor', 'Instructor', 'INS');
    } else {
      header("Location: inicio");
    }
  }

  public function guardar_Instructor(){
    $datos_Instructor = $this->input->post();
    #var_dump($datos_Instructor);
    #exit();
    $success = false;
    $msg = "";
    if (isset($datos_Instructor['contributivo'])) { 
      if ($datos_Instructor['contributivo'] == "NA") {
        $datos_Instructor['contributivo'] = "N";
      }
    }
    if (isset($datos_Instructor['retenedor'])) {
      if ($datos_Instructor['retenedor'] == "NA") {
        $datos_Instructor['retenedor'] = "N";
      }
    }
    if ($datos_Instructor['tipo'] === "1") {
      $realizar = $this->Instructores_model->salvar_Instructor($datos_Instructor);
    } else {
      $realizar = $this->Instructores_model->actualizarInstructor($datos_Instructor);
    }
    if ($realizar !== false) {
      $success = true;
      $msg = $realizar;
    }
    echo json_encode(array(
      'msg' => $msg,
      'success' => $success
    ));
  }

  public function eliminar_cliente(){
    $codigo = $this->input->post('codigo');
    $result = $this->Instructores_model->inactivar_Cliente($codigo);
    $success = false;
    $msg = '';
    if ($result !== false) {
      $success = true;
      $msg = $result;
    }
    echo json_encode(array(
      'msg' => $msg,
      'success' => $success
    ));
  }


  public function obtener_Instructor(){
    $data = $this->input->post('data');
    $datos = $this->Instructores_model->obtener_Instructores($data);

    $tip = obtener_codigo_glotipos($data, 'TERTIP');
    $tipo = $tip[0]['tipcodigo'];

    $cantidad = contar($tipo);
    
    /*if (count($cantidad) <= 0) {
      $retorno = "0";
    } else {
      $retorno = $cantidad[0]['count'];
    }
    $success = false;
    $cantidad = count($datos);
    if ($cantidad > 0) {
      $success = true;
    }*/
    echo json_encode(array(
      'success' => true,
      'aprendices' => $datos
    ));
  }

  //UBICACIONES

  public function obtener_ubicacion(){
    $codigo = $this->input->post('codigo');
    $result = $this->Instructores_model->obtener_ubicacion($codigo);
    $cantidad = count($result);
    $success = false;
    if ($cantidad > 0) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'ubicaciones' => $result
    ));
  }

  public function obtener_tertip(){
    $result = $this->Instructores_model->obtener_tertip();
    $cantidad = count($result);
    $success = false;
    if ($cantidad > 0) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'data' => $result
    ));
  }

  public function inactivar_ubicacion(){
    $codigo = $this->input->post();
    $result = $this->Instructores_model->inactivar_ubicacion($codigo);
    $success = false;
    $msg = '';
    if ($result !== false) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'msg' => $msg
    ));
  }

  public function guardar_ubicacion(){
    $datos = $this->input->post();
    if ($datos['tipoU'] == '1') {
      $result = $this->Instructores_model->guardar_ubicacion($datos);
    } else {
      $result = $this->Instructores_model->modificar_ubicacion($datos);
    }
    $msg = '';
    if ($result !== false) {
        $success = true;
      }
      echo json_encode(array(
        'success' => $success,
        'msg' => $msg
      ));
  }

  public function obtener_paises()
  {
    $paises = $this->Instructores_model->obtener_paises();
    $success = false;
    if (count($paises) > 0) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'paises' => $paises
    ));
  }

  public function obtener_estadosins()
  {
    $codigo_pais = $this->input->post('pais');
    $resultado = $this->Instructores_model->obtenter_estados($codigo_pais);
   
    $success = false;
    if (count($resultado) > 0) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'estadosins' => $resultado
    ));
  }

  public function obtener_ciudades()
  {
    $estado = $this->input->post('estado');
    $resultado = $this->Instructores_model->obtener_ciudades($estado);
    $success = false;
    if (count($resultado) > 0) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'municipioins' => $resultado
    ));
  }

  public function obtener_documentos()
  {
    $resultado = $this->Instructores_model->obtener_documentos();
    $success = false;
    if (count($resultado) > 0) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'documentos' => $resultado
    ));
  }

  public function obtener_fichas()
  {
    $resultado = $this->Instructores_model->obtener_fichas();
    $success = false;
    if (count($resultado) > 0) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'fichas' => $resultado
    ));
  }

  public function obtener_generos()
  {
    $resultado = $this->Instructores_model->obtener_generos();
    $success = false;
    if (count($resultado) > 0) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'generos' => $resultado
    ));
  }

  public function obtener_tiposubi()
  {
    $resultado = $this->Instructores_model->obtener_tiposubi();
    $success = false;
    if (count($resultado) > 0) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'ubi' => $resultado
    ));
  }

  public function obtener_barrios()
  {
    $codigo_ciudad = $this->input->post('codigo_ciudad');
    $resultado = $this->Instructores_model->obtener_barrios($codigo_ciudad);
    $success = false;
    if (count($resultado) > 0) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'barrios' => $resultado
    ));
  }

  public function guardar_barrio()
  {
    $datos = $this->input->post();
    $resultado = $this->Instructores_model->guardar_barrio($datos);
    $success = false;
    if ($resultado !== false) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'barrios' => $resultado
    ));
  }

  public function validar_documento()
  {
    $data = $this->input->post('codigo');
    $result = $this->Instructores_model->validar_documento($data);
    $success = false;
    $data = 1;
    if (count($result) > 0) {
      $success = true;
      $data = 2;
    }
    echo json_encode(
      array(
        'success' => $success,
        'data' => $data
      )
    );
  }

  public function validar_ubipri()
  {
    $tipo = $this->input->post('tipo');

    $tercero = $this->input->post('tercero');
    $result = $this->Instructores_model->validar_terubipri($tipo, $tercero);
    $success = false;
    $data = 1;
    if (count($result) > 0) {
      $success = true;
      $data = 2;
    }
    echo json_encode(
      array(
        'success' => $success,
        'data' => $data
      )
    );
  }
	}
 ?>