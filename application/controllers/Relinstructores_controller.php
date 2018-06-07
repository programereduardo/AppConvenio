<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relinstructores_controller extends CI_controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Relinstructores_model');
  }
  //Cargando Vistas 
  public function index() {
    $resultado = $this->Relinstructores_model->validar_session();
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
        if ($data['mod_nombre'] == "rel_ins" && $data['acc_descripcion'] == "Ver") {
          $next = true;
        }
      }
      if ($next === true) {
        $this->load->view('shared/header');
        $this->load->view('shared/menu', $datos);
        $this->load->view('Relinstructores_view');
        $this->load->view('shared/footer');
      } else {
        header("Location: inicio");
      }
    }
  }



  public function obtener_instructores()
  {
    $instructores = $this->Relinstructores_model->obtener_instructores();
    $i = 0;
    $success = false;
    if (count($instructores) > 0) {
      while ($i <= count($instructores) - 1) {
        $data[$i]['value'] = $instructores[$i]['ternom1'].' '.$instructores[$i]['ternom2'].' '.$instructores[$i]['terape1'].' '.$instructores[$i]['terape2'];
        $data[$i]['id'] = $instructores[$i]['tercodigo'];
        $i++;
      }
      $a = 0;
      while ($a <= count($instructores) - 1) {
        $data[$i]['value'] = $instructores[$a]['terdocnum'];
        $data[$i]['id'] = $instructores[$a]['tercodigo'];
        $i++;
        $a++;
      }
      $success = true;
    }
    if (!isset($data)) {
      $success = false;
      $data = '';
    }
    echo json_encode(array(
      'success' => $success,
      'data' => $data
    ));
  }

  public function obtener_fichas()
  {
    $fichas = $this->Relinstructores_model->obtener_fichas();
    $i = 0;
    $success = false;
    if (count($fichas) > 0) {
      while ($i <= count($fichas) - 1) {
        $data[$i]['value'] = $fichas[$i]['ficdetalle'];
        $data[$i]['id'] = $fichas[$i]['ficcodigo'];
        $i++;
      }
      $a = 0;
      while ($a <= count($fichas) - 1) {
        $data[$i]['value'] = $fichas[$a]['ficclave'].' '.$fichas[$a]['ficabreviatura'];
        $data[$i]['id'] = $fichas[$a]['ficcodigo'];
        $i++;
        $a++;
      }
      
      $success = true;
    }
    if (!isset($data)) {
      $success = false;
      $data = '';
    }
    echo json_encode(array(
      'success' => $success,
      'data' => $data
    ));
  }

  public function guardar_relacion()
  {
    $datos = $this->input->post();
    $msg = '';
    $type = '';
    $realizar = false;
    $success = false;
    if ($datos['tipo'] === '1') {
      $resp = $this->Relinstructores_model->validar_instructores($datos['instructorid'], $datos['fichaid']);
      if ($resp['success']) {
        $realizar = $this->Relinstructores_model->salvar_relacion($datos);
      }
      $msg = $resp['msg'];
      $type = $resp['type'];
    } else {
      $resp = $this->Relinstructores_model->validar_instructores($datos['instructorid'], $datos['fichaid']);
      if ($resp['success']) {
        $realizar = $this->Relinstructores_model->actualizar_relacion($datos);
      }
      $msg = $resp['msg'];
      $type = $resp['type'];
    }
    if ($realizar !== false) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'msg' => $msg,
      'type' => $type
    ));
  }

  public function obtener_relaciones()
  {
    $datos = $this->Relinstructores_model->obtener_relaciones();
    for ($i=0; $i < count($datos); $i++) {
      /*if ($datos[$i]['tertipogrupo'] == "2") {
        $datos[$i]['ternombre'] = $datos[$i]['ternom1'].' '.$datos[$i]['ternom2'].' '.$datos[$i]['terape1'].' '.$datos[$i]['terape2'];
      }*/
      if ($datos[$i]['relinsobservacion'] == '') {
        $datos[$i]['relinsobservacion'] = 'Información no suministrada.';
      } else {
        $datos[$i]['relinsestado'] = 'Inactivo';
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
    $result = $this->Relinstructores_model->inactivar_relacion($codigo);
    $success = false;
    if ($result !== false) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success
    ));
  }

}
