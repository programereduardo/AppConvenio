<?php 
	/**
	* 
	*/
	class apredatpersonales_model extends CI_Model
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

	    public function tipo_documento()
	    {
	    	$this->db->select('*');
	    	$this->db->from('glotipos');
	    	$this->db->where('tipgrupo','TERDOC');
	    	$query = $this->db->get();
	    	$resultado = $query->result_array();
	    	return $resultado;
	    }

	    public function datos_personales()
	    {
	    	$this->db->select('gloterceros.*');
	    	$this->db->select('gloterdatospersonales.*');
	    	$this->db->select('gloterubicaciones.*');
	    	$this->db->from('gloterceros');
	    	$this->db->where('tercodigo',$this->session->userdata('tercero'));
	    	$this->db->join('gloterdatospersonales','gloterdatospersonales.terdatcodigo = gloterceros.tercodigo');
	    	$this->db->join('gloterubicaciones','gloterubicaciones.terubitercero = gloterceros.tercodigo');
	    	$query = $this->db->get();
	    	$respuesta = $query->result_array();

	    	return $respuesta;
	    	
	    }

	    public function actualizar_datos($data)
	    {	
	    	$this->db->set('tercodigo',$data['tip_doc']);
	    	$this->db->set('terdocnum',$data['identificación']);
	    	$this->db->set('ternom1',$data['p_nombre']);
	    	$this->db->set('ternom2',$data['s_nombre']);
	    	$this->db->set('terclave','APRE');
	    	$this->db->where('tercodigo',$this->session->userdata('tercero'));
	    	$this->db->update('gloterceros');

	    }

	    public function sexo()
	    {
	    	$this->db->select('*');
	    	$this->db->from('glotipos');
	    	$this->db->where('tipgrupo','TERGEN');
	    	$query = $this->db->get();
	    	$resultado = $query->result_array();
	    	return $resultado;
	    }

	    public function estado_civil()
	    {
	    	$this->db->select('*');
	    	$this->db->from('glotipos');
	    	$this->db->where('tipgrupo','TERCIV');
	    	$query = $this->db->get();
	    	$resultado = $query->result_array();
	    	return $resultado;
	    }


	    public function pais_nacimiento()
	    {
	    	$this->db->select('*');
	    	$this->db->from('glopaises');
	    	$query = $this->db->get();
	    	$resultado = $query->result_array();
	    	return $resultado;
	    }

	    public function dep_nacimiento($pais)
	    {
	    	$this->db->select('*');
	    	$this->db->from('glodepartamentos');
	    	$this->db->where('deppais',$pais);
	    	$query = $this->db->get();
	    	$resultado = $query->result_array();
	    	return $resultado;
	    }

	    public function municipio_nacimiento($departamento)
	    {
	    	$this->db->select('*');
	    	$this->db->from('glomunicipios');
	    	$this->db->where('mundepartamento',$departamento);
	    	$query = $this->db->get();
	    	$resultado = $query->result_array();
	    	return $resultado;
	    }

	    public function dep_residencia($pais)
	    {
	    	$this->db->select('*');
	    	$this->db->from('glodepartamentos');
	    	$this->db->where('deppais',$pais);
	    	$query = $this->db->get();
	    	$resultado = $query->result_array();
	    	return $resultado;
	    }

	    public function municipio_residencia($departamento)
	    {
	    	$this->db->select('*');
	    	$this->db->from('glomunicipios');
	    	$this->db->where('mundepartamento',$departamento);
	    	$query = $this->db->get();
	    	$resultado = $query->result_array();
	    	return $resultado;
	    }

	    public function barrio($municipio)
	    {
	    	$this->db->select('*');
	    	$this->db->from('globarrios');
	    	$this->db->where('barmunicipio',$municipio);
	    	$query = $this->db->get();
	    	$resultado = $query->result_array();
	    	return $resultado;	
	    }

	    

	    
	}
 ?>