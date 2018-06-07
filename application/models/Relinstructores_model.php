<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class relinstructores_model extends CI_model
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


        public function obtener_instructores()
    {
      $data = obtener_codigo_glotipos('INS', 'TERTIP');
      $this->db->select('tercodigo');
      $this->db->select('terdocnum');
      $this->db->select('ternom1');
      $this->db->select('ternom2');
      $this->db->select('terape1');
      $this->db->select('terape2');
      $this->db->select('ternombre');
      $this->db->from('gloterceros');
      $this->db->where('teractivo', 'S');
      $this->db->where('tertipo', $data[0]['tipcodigo']);
      $datos = $this->db->get();
      return $datos->result_array();
    }

    public function obtener_fichas()
    {
      
      $this->db->select('ficcodigo');
      $this->db->select('ficclave');
      $this->db->select('ficabreviatura');
      $this->db->select('ficdetalle');
      $this->db->select('ficactivo');
      $this->db->from('glofichas');
      $this->db->where('ficactivo', 'S');
      $datos = $this->db->get();
      return $datos->result_array();
    }

    public function salvar_relacion($datos)
    {
      $datos_insertar = array(
        'relinsInstructor' => $datos['instructorid'],
        'relinsficha' => $datos['fichaid'],
        'relinsobservacion' => $datos['observacion'],
        'relinsusuariocrea' => $this->session->userdata('usuario'),
        'relinsfechacrea' => date('Y-m-d'),
        'relinsestado' => 'S'
      );
      $this->db->insert('glorelInstructores', $datos_insertar);
      return true;
    }

    

    public function actualizar_relacion($datos)
    {
      $this->db->set('relinsInstructor', $datos['instructorid']);
      $this->db->set('relinsficha', $datos['fichaid']);
      $this->db->set('relinsobservacion', $datos['observacion']);
      $this->db->where('relinsestado','S');
      $this->db->where('relinscodigo',$datos['codigo_documento']);
      $this->db->update('glorelInstructores');
      return true;
    }

    public function obtener_relaciones()
    {
      $this->db->select('relinscodigo');
      $this->db->select('relinsInstructor');
      $this->db->select('relinsficha');
      $this->db->select('relinsobservacion');
      $this->db->select('relinsestado');
      $this->db->select('t.ternom1');
      $this->db->select('t.ternom2');
      $this->db->select('t.terape1');
      $this->db->select('t.terape2');
      $this->db->select('f.ficdetalle as ficha');
      $this->db->from('glorelInstructores');
      $this->db->join('gloterceros as t', 'glorelInstructores.relinsInstructor = t.tercodigo');
      $this->db->join('glofichas as f', 'glorelInstructores.relinsficha = f.ficcodigo');
      $this->db->where('relinsestado', 'S');
      $this->db->order_by('relinscodigo','DESC');
      $query = $this->db->get();
      return $query->result_array();

    }

    public function obtener_relcli()
    {
      $this->db->select('relclicodigo');
      $this->db->select('relclicliente');
      $this->db->select('relclivendedor');
      $this->db->select('relcliobservacion');
      $this->db->select('relcliestado');
      $this->db->select('t.ternombre');
      $this->db->select('v.ternombre as vendedor');
      $this->db->from('glorelcli_vendedores');
      $this->db->join('gloterceros as t', 'glorelcli_vendedores.relclicliente = t.tercodigo');
      $this->db->join('gloterceros as v', 'glorelcli_vendedores.relclivendedor = v.tercodigo');
      $this->db->where('relcliestado', 'S');
      $query = $this->db->get();
      return $query->result_array();
    }

    public function inactivar_relacion($data)
    {
      $this->db->set('relinsestado', 'N');
      $this->db->set('relinsusuarioanula', $this->session->userdata('usuario'));
      $this->db->set('relinsfechaanula', date('Y-m-d'));
      $this->db->where('relinscodigo', $data);
      $this->db->update('glorelInstructores');
      return true;
    }

    public function validar_instructores($instructor, $ficha)
    {
      $success = true;
      $type = 'success';
      $msg = 'Acción realizada con éxito.';
      $this->db->select('*');
      $this->db->from('glorelInstructores');
      $this->db->where('relinsInstructor', $instructor);
      $this->db->where('relinsficha', $ficha);
      $this->db->where('relinsestado', 'S');
      $dt1 = $this->db->get();
      $data1 = $dt1->result_array();      
      if (count($data1) > 0) {
        foreach ($data1 as $dt) {
          if ($dt['relinsestado'] == 'S') {
            $success = false;
            $msg = 'El Instructor Ya se Encuentra Relacionado con la Ficha.';
            $type = 'danger';
          }
        }
      } 
      $retorno = array(
        'msg' => $msg,
        'type' => $type,
        'success' => $success
      );
      return $retorno;
    }

  }
