<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class barrios_controller extends CI_controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model('barrios_model');
  }
  //Cargando Vistas
  public function index() {
    $resultado = $this->barrios_model->validar_session();
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
        if ($data['mod_nombre'] == "Barrios" && $data['acc_descripcion'] == "Ver") {
          $next = true;
        }
      }
      if ($next === true) {
        $this->load->view('shared/header');
        $this->load->view('shared/menu', $datos);
        $this->load->view('Barrios_view');
        $this->load->view('shared/footer');
      } else {
        header("Location: inicio");
      }
    }
  }

  public function obtener_barrios()
  {
    $result = $this->barrios_model->obtener_barrios();
    $success = false;
    if (count($result) > 0) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'data' => $result
    ));
  }
  public function guardar_barrio()
  {
    $data = $this->input->post();
    $success = false;
    if ($data['tipo'] == '1') {
      $result = $this->barrios_model->guardar_barrio($data);
    } else {
      $result = $this->barrios_model->actualizar_barrio($data);
    }
    if ($result === true) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success
    ));
  }

  public function inactivar_barrio()
  {
    $data = $this->input->post('codigo_barrio');
    $result = $this->barrios_model->inactivar_barrio($data);
    $success = false;
    if ($result == true) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success
    ));
  }
}
