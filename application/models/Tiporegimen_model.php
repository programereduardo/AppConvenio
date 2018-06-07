<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class tiporegimen_model extends CI_model
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

    public function salvar_regimen($datos)
    {
      $clave = strtoupper($datos['clave']);
      $datos_insertar = array(
        'tipclave' => $clave,
        'tipdetalle' => $datos['detalle'],
        'tipabreviatura' => $datos['abreviatura'],
        'tipgrupo' => 'TERREG'
      );
      $this->db->insert('glotipos', $datos_insertar);
      return true;
    }

    public function actualizar_regimen($datos)
    {
      $codigo = (int) $datos['codigo_regimen'];
      $this->db->set('tipclave', $datos['clave']);
      $this->db->set('tipabreviatura', $datos['abreviatura']);
      $this->db->set('tipdetalle', $datos['detalle']);
      $this->db->where('tipcodigo', $codigo);
      $this->db->update('glotipos');
      return true;
    }

    public function obtener_regimen()
    {
      $this->db->select('tipcodigo');
      $this->db->select('tipclave');
      $this->db->select('tipabreviatura');
      $this->db->select('tipdetalle');
      $this->db->where('tipactivo', 'S');
      $this->db->where('tipgrupo', 'TERREG');
      $this->db->from('glotipos');
      $this->db->order_by('tipclave', 'ASC');
      $query = $this->db->get();
      $result = $query->result_array();
      return $result;
    }

    public function inactivar_regimen($codigo_regimen)
    {
      $desactivar = 'N';
      $this->db->set('tipactivo', $desactivar);
      $this->db->where('tipcodigo', $codigo_regimen);
      $this->db->update('glotipos');
      return true;
    }
  }
