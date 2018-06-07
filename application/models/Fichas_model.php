<?php 
/**
* 
*/
class Fichas_model extends CI_Model
{
	
	public function __construct()
	{
		parent:: __construct();
		$db['default']['schema'] = 'GLOBAL';
	}
	//validacion de session
	public function validar_session(){
      $verificar = $this->session->userdata("logueado");
      if ($verificar == TRUE) {
        return true;
      } else {
        return false;
      }
    }

    public function guardar_ficha($datos)
    {
    	$clave = strtoupper($datos['clave']);
    	$datos_insertar = array(
    		'ficclave'=>$clave,
    		'ficabreviatura'=>$datos['abreviatura'],
    		'ficdetalle'=>$datos['detalle'],
    		'ficactivo'=>'S'
    	);
    	$this->db->insert('glofichas', $datos_insertar);
    	return true;
    }

    public function obtener_fichas()
    {
    	$this->db->select('*');
    	$this->db->from('glofichas');
    	$this->db->where('ficactivo', 'S');
    	$query = $this->db->get();
    	$result = $query->result_array();
    	return $result;
    }

    public function inactivar_ficha($codigo_ficha)
    {
    	$inactivo = 'N';
    	$this->db->set('ficactivo',$inactivo);
    	$this->db->where('ficcodigo',$codigo_ficha);
    	$this->db->update('glofichas');

    	return true;
    }

    public function actualizar_ficha($datos)
    {
    	$this->db->set('ficclave',$datos['clave']);
    	$this->db->set('ficabreviatura',$datos['abreviatura']);
    	$this->db->set('ficdetalle',$datos['detalle']);
    	$this->db->where('ficcodigo',$datos['codigo_ficha']);
    	$this->db->update('glofichas');
    	return true;
    }


}
 ?>