<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class tiporegimen_controller extends CI_controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model('tiporegimen_model');
  }
  //Cargando Vistas
  public function index() {
    $resultado = $this->tiporegimen_model->validar_session();
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
        $this->load->view('Tiporegimen_view');
        $this->load->view('shared/footer');
      } else {
        header("Location: inicio");
      }
    }
  }

  public function guardar_regimen()
  {
    $datos = $this->input->post();
    if ($datos['tipo'] === '1') {
      $realizar = $this->tiporegimen_model->salvar_regimen($datos);
    } else {
      $realizar = $this->tiporegimen_model->actualizar_regimen($datos);
    }
    $success = false;
    if ($realizar !== false) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success
    ));
  }

  public function obtener_regimen()
  {
    $result = $this->tiporegimen_model->obtener_regimen();
    $success = false;
    $cantidad = count($result);
    if ($cantidad > 0) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'regimen' => $result
    ));
  }

  public function inactivar_regimen()
  {
    $codigo_regimen = $this->input->post('codigo_regimen');
    $result = $this->tiporegimen_model->inactivar_regimen($codigo_regimen);
    $success = false;
    if ($result !== false) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success
    ));
  }

}