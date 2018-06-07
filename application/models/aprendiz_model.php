<?php 
	/**
	* 
	*/
	class aprendiz_model extends CI_Model
	{
		
		public function __construct()
		{
			parent::__construct();
			$db['default']['schema'] = 'GLOBAL';
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

	    
	}
 ?>