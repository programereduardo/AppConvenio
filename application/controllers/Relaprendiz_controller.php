<?php  
defined('BASEPATH') OR exit('No direct script access allowed');

class Relaprendiz_controller extends CI_controller { 
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Relaprendiz_model');
  }
  //Cargando Vistas 
  public function index() {
    $resultado = $this->Relaprendiz_model->validar_session();
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
        if ($data['mod_nombre'] == "relacion-aprendiz" && $data['acc_descripcion'] == "Ver") {
          $next = true;
        }
      }
      if ($next === true) {
        $this->load->view('shared/header');
        $this->load->view('shared/menu', $datos);
        $this->load->view('Relaprendiz_view');
        $this->load->view('shared/footer');
      } else {
        header("Location: inicio");
      }
    }
  }



  public function obtener_aprendices()
  {
    $aprendices = $this->Relaprendiz_model->obtener_aprendices();
    

      
      echo json_encode(array(
        'success' => true,
        'data' => $aprendices
      ));

   
     
  } 

  public function obtener_fichas()
  {
    $fichas = $this->Relaprendiz_model->obtener_fichas();
    $verificacion = count($fichas);
    if ($fichas>0)
    {
      
      echo json_encode(array(
        'success' => true,
        'data' => $fichas
      ));
    
    }else{
      echo json_encode
      (
        array
          (
          'success' => false,
          'data' => $fichas
          ) 
      );  
    }
  }

  public function guardar_relacion()
  {
    $datos = $this->input->post();
    
    $msg = '';
    $type = '';
    $realizar = false;
    $success = false;
    if ($datos['tipo'] === '1') {
      
      
      $realizar = $this->Relaprendiz_model->salvar_relacion($datos);
      
    } else {
      
        $realizar = $this->Relaprendiz_model->actualizar_relacion($datos);
      
      
    }
    if ($realizar !== false) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success
    ));
  }

  public function obtener_relaciones()
  {
    $datos = $this->Relaprendiz_model->obtener_relaciones();
    for ($i=0; $i < count($datos); $i++) {
      /*if ($datos[$i]['tertipogrupo'] == "2") {
        $datos[$i]['ternombre'] = $datos[$i]['ternom1'].' '.$datos[$i]['ternom2'].' '.$datos[$i]['terape1'].' '.$datos[$i]['terape2'];
      }*/
      if ($datos[$i]['relaprobservacion'] == '') {
        $datos[$i]['relaprobservacion'] = 'Información no suministrada.';
      } else {
        $datos[$i]['relaprestado'] = 'Inactivo';
      }
    }
    $success = false;
    $cantidad = count($datos);
    if ($cantidad > 0) {
      $success = true;
    }

    echo json_encode(array(
      'success' => $success,
      'data' => $datos
    ));
  }

  public function inactivar_relacion()
  {
    $codigo = $this->input->post('codigo');
    $result = $this->Relaprendiz_model->inactivar_relacion($codigo);
    $success = false;
    if ($result !== false) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success
    ));
  }

}
