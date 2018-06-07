<?php
/**
 *
 */
class reportes_inasistencias_model extends CI_Model
{

  function __construct()
  {
    parent:: __construct();
    $db['default']['schema'] = 'GLOBAL';
  }

  public function validar_session(){
    $verificar = $this->session->userdata("logueado");
    if ($verificar === true) {
      return true;
    } else {
      return false;
    }
  }

  public function llenar_fichas()
  {
    $this->db->select('*');
    $this->db->from('glofichas');
    $this->db->where('ficactivo','S');
    $query = $this->db->get();
    $resultado = $query->result_array();
    return $resultado;
  }

  public function obtener_consulta($ficha,$desde,$hasta,$dias)
  {
    
    
    $this->db->distinct();
    $this->db->select('count(*) as total');
    $this->db->select('gloterceros.*');
    $this->db->select('glorelAprendices.*');
    $this->db->from('gloasistencias');
    $this->db->join('gloterceros','gloterceros.tercodigo = gloasistencias.asiaprendiz');
    $this->db->join('glorelAprendices','glorelAprendices.relaprAprendiz = gloasistencias.asiaprendiz');
    $this->db->where('asidetalle',2);
    $this->db->where('relaprficha',$ficha);
    $this->db->where('asifecha>=',$desde);
    $this->db->where('asifecha<=',$hasta);
    //$this->db->where('total>=',0);
    //$this->db->where('total<=',$dias);
    $this->db->group_by('asiaprendiz');  
    $this->db->group_by('tercodigo');
    $this->db->group_by('relaprcodigo'); 


    $query = $this->db->get();
    $resultado = $query->result_array();


    return $resultado;
  }
}

 ?>
