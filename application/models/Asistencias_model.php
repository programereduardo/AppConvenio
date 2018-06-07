<?php
	/**
	*
	*/
	class Asistencias_model extends CI_Model
	{

		public function __construct()
		{
			parent::__construct();

      date_default_timezone_set("America/Bogota");
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

    	public function llenar_ficha()
    	{

    		$rol = $this->session->userdata("rol");
    		if ($rol === 'Instructor')
    		{

    			$this->db->select('relinscodigo');
    			$this->db->select('relinsInstructor');
    			$this->db->select('relinsficha');
    			$this->db->select('ficcodigo');
    			$this->db->select('ficclave');
    			$this->db->select('ficdetalle');
    			$this->db->from('glorelinstructores');
    			$this->db->join('glofichas', 'glorelinstructores.relinsficha = glofichas.ficcodigo','left');
    			$this->db->where('relinsInstructor', $this->session->userdata('tercero'));
    			$this->db->where('ficactivo','S');
    			$query = $this->db->get();
    			$resultado = $query->result_array();
    			return $resultado;

            }else{
    			$this->db->select('relinscodigo');
    			$this->db->select('relinsInstructor');
    			$this->db->select('relinsficha');
    			$this->db->select('ficcodigo');
    			$this->db->select('ficclave');
    			$this->db->select('ficdetalle');
    			$this->db->from('glorelinstructores');
    			$this->db->join('glofichas', 'glorelinstructores.relinsficha = glofichas.ficcodigo','left');
    			$this->db->where('ficactivo','S');
    			$query = $this->db->get();
    			$resultado = $query->result_array();
    			return $resultado;
    		}
    	}

      public function obtener_consulta($consulta,$aprendiz)
      {

        $this->db->select('gloasistencias.*');
        $this->db->select('gloterceros.*');
        $this->db->from('gloasistencias');
        $this->db->join('gloterceros', 'gloasistencias.asiaprendiz = gloterceros.tercodigo','left');
        $this->db->where('asidetalle',$consulta);
        $this->db->where('asiactivo','S');
        $this->db->where('asiaprendiz',$aprendiz);
        //$this->db->where('asidetalle',0);
        $this->db->where('asiactivo','S');
        $this->db->order_by('asifecha','DESC');
        $query = $this->db->get();
        $resultado = $query->result_array();

        return $resultado;

      }


        public function contarinasistencias($lista)
        {
          $this->db->select('count(relasidetalle)');
          $this->db->from('gloasistencias');
          $this->db->where('relasidetalle',2);

        }

        public function contenido($aprendiz)
        {
          $fecha = date('Y-m-d');

          $this->db->select('*');
          $this->db->from('gloterceros');
          $this->db->where('terclave','APRE');
          $this->db->where('teractivo','S');
          $query = $this->db->get();
          $resultado = $query->result_array();

          foreach ($resultado as $llenar)
          {
            $this->db->select('*');
            $this->db->from('gloasistencias');
            $this->db->where('asifecha',$fecha);
            $this->db->where('asiaprendiz',$llenar['tercodigo']);
            $query = $this->db->get();
            $result = $query->result_array();
            $conteo = count($result);

            if ($conteo===0)
            {

              $datos_contenido = array(
                'asiaprendiz'=>$llenar['tercodigo'],
                'asidetalle'=>1,
                'asifecha'=>$fecha,
                'asiusucrea'=>$this->session->userdata('usuario'),
                  'asiactivo'=>'S'
              );
              $this->db->insert('gloasistencias',$datos_contenido);
            }
          }

        }



        public function obtener_asistencias($lista,$fecha)
        {

              $confirmacion = $this->session->userdata('confirmacion');




              $this->db->select('*');
              $this->db->from('glorelinstructores');
              $this->db->where('relinscodigo',$lista);

              $query = $this->db->get();
              $resultado = $query->result_array();
              $conteo = count($resultado);
              if ($conteo>0){
                $ficha = $resultado[0]['relinsficha'];

                $this->db->select('glorelAprendices.*');
                $this->db->select('gloterceros.*');
                $this->db->select('gloasistencias.*');
                $this->db->from('glorelAprendices');
                $this->db->join('gloterceros', 'glorelAprendices.relaprAprendiz = gloterceros.tercodigo','left');
               $this->db->join('gloasistencias', 'gloasistencias.asiaprendiz = gloterceros.tercodigo','left');
                $this->db->where('relaprficha',$ficha);
                //$this->db->where('asiusucrea',$this->session->userdata('usuario'));
                $this->db->group_by('tercodigo');
                $this->db->order_by('ternom1','ASC');
                $query = $this->db->get();
                $resultado2 = $query->result_array();
                return $resultado2;

              }
        }

        public function eliminar_historial($codigo)
        {
          $this->db->set('asiactivo','N');
          $this->db->where('asicodigo',$codigo);
          $this->db->update('gloasistencias');
          return true;
        }

        public function buscar_nombre($aprendiz)
        {
          $this->db->select('*');
          $this->db->from('gloterceros');
          $this->db->where('tercodigo',$aprendiz);
          $this->db->where('teractivo','S');
          $query = $this->db->get();
          $resultado = $query->result_array();
          return $resultado;
        }

        public function buscar_fallas($apre)
        {
          $this->db->select('count(asidetalle)');
          $this->db->from('gloasistencias');
          $this->db->where('asidetalle',2);
          $this->db->where('asiaprendiz',$apre);
          $respuesta = $this->db->get();
          $res= $respuesta->result_array();

					$this->db->set('relaprinasistencias',$res[0]['count(asidetalle)']);
          $this->db->where('relapraprendiz',$apre);
          $this->db->update('glorelaprendices');

          return true;

        }

        public function asistio_relacion($aprendiz,$fechain,$tipo)
        {
          if ($tipo === '2')
          {
            $fecha = $fechain;
          }else{

          $fecha = date('Y-m-d');
          }

          $this->db->set('asidetalle',1);
          $this->db->where('asiaprendiz',$aprendiz);
          $this->db->where('asifecha',$fecha);
          $this->db->update('gloasistencias');
          return true;


        }

        public function noasistio_relacion($aprendiz,$fechain,$tipo)
          {
            if ($tipo === '2')
            {
              $fecha = $fechain;
            }else{

            $fecha = date('Y-m-d');
            }


            $this->db->set('asidetalle',2);
            $this->db->where('asiaprendiz',$aprendiz);
            $this->db->where('asifecha',$fecha);
            $this->db->update('gloasistencias');
            return true;
          }

          public function guardar($idaprendiz,$fecha)
          {
            
              $asistencia = array(
                'asiaprendiz'=>$idaprendiz,
                'asidetalle'=>2,
                'asifecha'=>$fecha,
                'asiusucrea'=>$this->session->userdata('usuario'),
                'asiactivo'=>'S'
              );

              $this->db->insert('gloasistencias',$asistencia);
              return true;   
          }


          



	}
 ?>
