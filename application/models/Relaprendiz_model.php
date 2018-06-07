<?php  
  defined('BASEPATH') OR exit('No direct script access allowed');

  class relaprendiz_model extends CI_model
  {
    public function __construct()
    {
      parent::__construct();
      $db['default']['schema'] = 'GLOBAL';
      date_default_timezone_set("America/Bogota");
    }


    public function validar_session(){
      $verificar = $this->session->userdata("logueado");
      if ($verificar == TRUE) {
        return true;
      } else {
        return false;
      }
    }
 

        public function obtener_aprendices()
    {
      $data = obtener_codigo_glotipos('APRE', 'TERTIP');
      $this->db->select('glorelAprendices.*');
      $this->db->select('tercodigo');
      $this->db->select('terdocnum');
      $this->db->select('ternom1');
      $this->db->select('ternom2');
      $this->db->select('terape1');
      $this->db->select('terape2');
      $this->db->select('ternombre');
      $this->db->from('gloterceros');
      $this->db->join('glorelAprendices','glorelAprendices.relaprAprendiz = gloterceros.tercodigo');
      $this->db->where('teractivo', 'S');
      $this->db->where('relaprestado', 'N');
      $this->db->where('tertipo', $data[0]['tipcodigo']);
      $datos = $this->db->get();
      $rersultado = $datos->result_array();
      #var_dump($datos);
      #exit();
      return $rersultado;
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
      $fecha_creacion = date('Y-m-d', time());
      
      $this->db->set('relaprficha',$datos['fichaid']);
      $this->db->set('relaprusuariocrea',$this->session->userdata('usuario'));
      $this->db->set('relaprfechacrea',$fecha_creacion);
      $this->db->set('relaprestado','S');
      $this->db->where('relaprAprendiz',$datos['aprendiz']);
      $this->db->update('glorelAprendices');

      return true;
    }

    

    public function actualizar_relacion($datos)
    {
      $this->db->set('relaprAprendiz', $datos['aprendizid']);
      $this->db->set('relaprficha', $datos['fichaid']);
      $this->db->set('relaprobservacion', $datos['observacion']);
      $this->db->where('relaprestado','S');
      $this->db->where('relaprcodigo',$datos['codigo_documento']);
      $this->db->update('glorelAprendices');
      return true;
    }

    public function obtener_relaciones()
    {
      $this->db->select('relaprcodigo');
      $this->db->select('relaprAprendiz');
      $this->db->select('relaprficha');
      $this->db->select('relaprobservacion');
      $this->db->select('relaprestado');
      $this->db->select('t.ternom1');
      $this->db->select('t.ternom2');
      $this->db->select('t.terape1');
      $this->db->select('t.terape2');
      $this->db->select('f.ficdetalle as ficha');
      $this->db->from('glorelAprendices');
      $this->db->join('gloterceros as t', 'glorelAprendices.relaprAprendiz = t.tercodigo');
      $this->db->join('glofichas as f', 'glorelAprendices.relaprficha = f.ficcodigo');
      $this->db->where('relaprestado', 'S');
      $this->db->order_by('relaprcodigo','DESC');
      $query = $this->db->get();
      return $query->result_array();

    }


    public function inactivar_relacion($data)
    {
      $this->db->set('relaprestado', 'N');
      $this->db->set('relaprficha', '0');
      $this->db->set('relaprusuarioanula', $this->session->userdata('usuario'));
      $this->db->set('relaprfechaanula', date('Y-m-d'));
      $this->db->where('relaprcodigo', $data);
      $this->db->update('glorelAprendices');
      return true;
    }

    public function validar_aprendices($aprendiz, $ficha)
    {
      $success = true;
      $type = 'success';
      $msg = 'Acción realizada con éxito.';
      $this->db->select('*');
      $this->db->from('glorelAprendices');
      $this->db->where('relaprAprendiz', $aprendiz);

      $this->db->where('relaprficha', $ficha);
      $this->db->where('relaprestado', 'S');
      $dt1 = $this->db->get();
      $data1 = $dt1->result_array();      
      if (count($data1) > 0) {
        foreach ($data1 as $dt) {
          if ($dt['relaprestado'] == 'S') {
            $success = false;
            $msg = 'El aprendiz Ya se Encuentra Relacionado con la Ficha.';
            $type = 'danger';
          }
        }
      }else{

        $this->db->select('*');
      $this->db->from('glorelAprendices');
      $this->db->where('relaprAprendiz', $aprendiz);
      $this->db->where('relaprestado', 'S');
      $dt1 = $this->db->get();
      $data2 = $dt1->result_array();      
      if (count($data2) > 0) {
        foreach ($data2 as $dt) {
          if ($dt['relaprestado'] == 'S') {
            $success = false;
            $msg = 'El aprendiz Ya se Encuentra Relacionado con una Ficha.';
            $type = 'danger';
          }
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

    public function validar_aprendices2($aprendiz, $ficha)
    {
      $success = true;
      $type = 'success';
      $msg = 'Acción realizada con éxito.';
      $this->db->select('*');
      $this->db->from('glorelAprendices');
      $this->db->where('relaprAprendiz', $aprendiz);
      
      $this->db->where('relaprficha', $ficha);
      $this->db->where('relaprestado', 'S');
      $dt1 = $this->db->get();
      $data1 = $dt1->result_array();      
      if (count($data1) > 0) {
        foreach ($data1 as $dt) {
          if ($dt['relaprestado'] == 'S') {
            $success = false;
            $msg = 'El aprendiz Ya se Encuentra Relacionado con la Ficha.';
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
