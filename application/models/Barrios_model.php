<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class barrios_model extends CI_model
  {
    public function __construct()
    {
      parent::__construct();
      $db['default']['schema'] = 'GLOBAL';
    }


    public function validar_session(){
      $verificar = $this->session->userdata("logueado");
      if ($verificar == TRUE) {
        return true;
      } else {
        return false;
      }
    }

    public function obtener_barrios()
    {
      $this->db->select('globarrios.*');
      $this->db->select('glomunicipios.munnombre');
      $this->db->from('globarrios');
      $this->db->where('barestado', 'S');
      $this->db->join('glomunicipios', 'globarrios.barmunicipio = glomunicipios.muncodigo');
      $this->db->order_by('barnombre', 'ASC');
      $result = $this->db->get();
      return $result->result_array();
    }

    public function actualizar_barrio($data)
    {
      $this->db->set('barnombre', $data['nombre']);
      $this->db->where('barcodigo', $data['codigo_barrio']);
      $this->db->update('globarrios');
      return true;
    }

    public function inactivar_barrio($data)
    {
      $this->db->set('barestado', 'N');
      $this->db->where('barcodigo', $data);
      $this->db->update('globarrios');
      return true;
    }
  }
