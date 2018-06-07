<?php 
/**
* 
*/
class changepass_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}


	public function validar_session()
		{
	      $verificar = $this->session->userdata("logueado");
	      if ($verificar == TRUE) {
	        return true;
	      } else {
	        return false;
	      }
	    }


	public function cambiar_password($datos)
    {
    	$this->db->select('*');
    	$this->db->from('seg_usuarios');
    	$this->db->where('usu_tercero',$this->session->userdata('tercero'));
    	$this->db->where('usu_password',md5($datos['confirmarpass']));
    	$query = $this->db->get();
    	$resultado = $query->num_rows();
    	if ($resultado===0)
    	{
    		return false;
    	}else{
    		$this->db->set('usu_password',md5($datos['newpass']));
    		$this->db->where('usu_tercero',$this->session->userdata('tercero'));
    		$this->db->where('usu_password',md5($datos['confirmarpass']));
    		$this->db->update('seg_usuarios');
    		return true;
    	}

    }
}
 ?>