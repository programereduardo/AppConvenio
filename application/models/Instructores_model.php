<?php 
	/**
	* 
	*/
	class Instructores_model extends CI_Model
	{
		
		public function __construct()
		{
			parent::__construct();
			//$db['default']['schema'] = 'GLOBAL';
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

    	public function salvar_Instructor($datos_Instructor){
      $tip = obtener_codigo_glotipos($datos_Instructor['tip'], 'TERTIP');
      $cor = obtener_codigo_glotipos('COREMP', 'TERUBI');

      $this->load->model('sistema/permisos_model');
    $getRol = $this->permisos_model->get_rol($tip[0]['tipdetalle']);
    $codigoRol = $getRol[0]['rol_codigo'];



      function generar_password() {
        return substr(md5(uniqid(rand(), true)), 0, 8);
      }
      if ($datos_Instructor['correo'] == "") {
        $datos_Instructor['correo'] = "No aplica";
      }
      //insert to table gloterceros
      $fecha_creacion = date('Y-m-d', time());
      $nombre = $datos_Instructor['nombre1']." ".$datos_Instructor['nombre2']." ".$datos_Instructor['apellido1']." ".$datos_Instructor['apellido2'];
      $data = array(
        'tertipdoc' => $datos_Instructor['tipo_documento'],
        'terdocnum' => $datos_Instructor['numero_documento'],
        'terclave' => $datos_Instructor['tip'],
        'tertipo' => $tip[0]['tipcodigo'],
        'terfeccre' => $fecha_creacion,
        'teractivo' => 'S',
        'ternom1' => $datos_Instructor['nombre1'],
        'ternom2' => $datos_Instructor['nombre2'],
        'terape1' => $datos_Instructor['apellido1'],
        'terape2' => $datos_Instructor['apellido2'],
        'tertipogrupo' => 2
      );
      $this->db->insert('gloterceros', $data);

      $this->db->select('tercodigo');
      $this->db->from('gloterceros');
      $this->db->where('terdocnum', $datos_Instructor['numero_documento']);
      $resp = $this->db->get();
      $valor = $resp->result_array();
      $codigo = $valor[0]['tercodigo'];

      //insert to table ubicaciones
      $ubi = array(
        'terubitercero' => $codigo,
        'terubibarrio' => 1, //$datos_Instructor['barrio'],
        'terubitipo' => $cor[0]['tipcodigo'],
        'terubivalor' => $datos_Instructor['correo'],
        'terubiactivo' => 'S'
      );
      $this->db->insert('gloterubicaciones', $ubi);
 
      //insert to table usuarios of the scheme seguridad
      $password = generar_password();
      $usuarios = array(
        'usu_estado' => 1,
        'usu_usuario' => $datos_Instructor['numero_documento'],
        'usu_password' => md5($password),
        //'usu_nombres' => $datos_Instructor['nombre1']." ".$datos_Instructor['nombre2'],
        //'usu_apellidos' => $datos_Instructor['apellido1']." ".$datos_Instructor['apellido2'],
        'usu_nombres' => "NA",
        'usu_apellidos' => "NA",
        'usu_email' => $datos_Instructor['correo'],
        'usu_tercero' => $codigo
      );
      $this->db->insert('seg_usuarios', $usuarios);

      $this->db->select('usu_codigo');
      $this->db->from('seg_usuarios');
      $this->db->where('usu_tercero', $codigo);
      $getUsuCodigo = $this->db->get();
      $usuCodigo = $getUsuCodigo->result_array();

      $realyUsucodigo = $usuCodigo[0]['usu_codigo'];

      $rolesUsuarios = array(
        'rol_usuarios' => $realyUsucodigo,
        'rol_roles' => $codigoRol
      );
      $this->db->insert('seg_rolesusuarios', $rolesUsuarios);


      //insert to table datospersonales of the scheme GLOBAL
      if ($datos_Instructor['fecha'] == '') {
        $datos_Instructor['fecha'] = '1900-01-01';
      }
      
        $datos_personales = array(
          'terdatcodigo' => $codigo,
          'terdattipsex' => $datos_Instructor['genero'],
          'terdatfecnac' => $datos_Instructor['fecha'],
          'terdattipnac' => $datos_Instructor['pais'],
          'terdatciunac' => $datos_Instructor['ciudad']
        );
        $this->db->insert('gloterdatospersonales', $datos_personales);
      
      


      //enviar email
      if ($datos_Instructor['correo'] !== 'No aplica' && $datos_Instructor['correo'] !== '') {

        //$dato_encabezado = $this->facturacion_model->mis_datos();
        $nombre = $datos_Instructor['nombre1'];
        $usuario = $datos_Instructor['numero_documento'];
        $subject = 'Bienvenido a nuestro portal.';
        $message = "<p>Estimado cliente $nombre,</p>
                    <p>Bienvenido a nuestro portal de usuarios, sus credenciales son los siguientes:</p>
                    <p>Usuario: $usuario</p>
                    <p>Contraseña: $password</p>
                    ";

        // Get full html:
        $body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=' . strtolower(config_item('charset')) . '" />
        <title>' . html_escape($subject) . '</title>
        <style type="text/css">
        body {
          font-family: Arial, Verdana, Helvetica, sans-serif;
          font-size: 16px;
        }
        </style>
        </head>
        <body>
        ' . $message . '
        </body>
        </html>';

        $config['protocol']    = 'smtp';
        $config['smtp_host']    = 'smtp.googlemail.com';
        $config['smtp_crypto'] = 'ssl';
        $config['smtp_port']    = 465;
        $config['smtp_timeout'] = 10;
        $config['smtp_user']    = 'carlos0carr@gmail.com';
        $config['smtp_pass']    = '199897322';
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html'; // or html or text
        $config['validation'] = TRUE; // bool whether to


        $this->load->library("email");
        $this->email->initialize($config);
        $send = $this->email
                     ->from('carlos0carr@gmail.com', 'Test')
                     //->to('carlos0carr@gmail.com')
                     ->to($datos_Instructor['correo'])
                     ->subject($subject)
                     ->message($body)
                     //->attach($ruta.$nombre)
                     ->send();

      }
    }


    public function obtener_Instructores($data){
      $dir = obtener_codigo_glotipos('DIREMP', 'TERUBI');
      $tel = obtener_codigo_glotipos('TELEMP', 'TERUBI');
      $cor = obtener_codigo_glotipos('COREMP', 'TERUBI');
      $cel = obtener_codigo_glotipos('CELEMP', 'TERUBI');
      $tip = obtener_codigo_glotipos($data, 'TERTIP');
      $codigo_dir = $dir[0]['tipcodigo'];
      $codigo_tel = $tel[0]['tipcodigo'];
      $codigo_cor = $cor[0]['tipcodigo'];
      $codigo_cel = $cel[0]['tipcodigo'];
      $tipo = $tip[0]['tipcodigo'];

      //var_dump($this->db->last_query());

      $sql = "SELECT DISTINCT tercodigo, tertipdoc, terfeccre, terdocnum,
              ternombre, ternom1, tertipo, ternom2, terape1, terape2, tertipogrupo,
            	terdatfecnac, terdattipsex, terdattipnac, terdatciunac, g.tipclave AS clave, tipo2.tipclave AS detalle,
            	COALESCE(ud.terubivalor, 'No Aplica') AS direccion,
            	COALESCE(ut.terubivalor, 'No Aplica') AS telefono,
            	COALESCE(ucel.terubivalor, 'No Aplica') AS celular,
              COALESCE(uc.terubivalor, 'No Aplica') AS correo,
              COALESCE(bar.barnombre, 'No Aplica') barrio,
            	COALESCE(m.munnombre, 'No Aplica') municipio,
              COALESCE(dpto.depnombre, 'No Aplica') dpto,
              COALESCE(p.painombre, 'No Aplica') pais
            	FROM  gloterceros AS t
            	JOIN glotipos g ON t.tertipo = g.tipcodigo
            	LEFT JOIN gloterdatospersonales AS dp ON t.tercodigo = dp.terdatcodigo
            	LEFT JOIN glotipos tipo2 ON t.tertipdoc = tipo2.tipcodigo
            	LEFT JOIN gloterubicaciones AS ud ON t.tercodigo = ud.terubitercero AND ud.terubitipo = $codigo_dir AND ud.terubiactivo = 'S'
            	LEFT JOIN gloterubicaciones AS ut ON t.tercodigo = ut.terubitercero AND ut.terubitipo = $codigo_tel AND ut.terubiactivo = 'S'
            	LEFT JOIN gloterubicaciones AS ucel ON t.tercodigo = ucel.terubitercero AND ucel.terubitipo = $codigo_cel AND ucel.terubiactivo = 'S'
            	LEFT JOIN gloterubicaciones AS uc ON t.tercodigo = uc.terubitercero AND uc.terubitipo = $codigo_cor AND uc.terubiactivo = 'S'
            	LEFT JOIN globarrios bar ON ud.terubibarrio = bar.barcodigo
            	LEFT JOIN glomunicipios m ON bar.barmunicipio = m.muncodigo
            	LEFT JOIN glodepartamentos dpto ON m.mundepartamento = dpto.depcodigo
            	LEFT JOIN glopaises p ON dpto.deppais = p.paicodigo
            	WHERE teractivo = 'S'
            	AND tertipo = $tipo
              ORDER BY tercodigo DESC
            	";
 
      $result = $this->db->query($sql); 
      $data = $result->result_array();
      //$datos = array_merge($array1, $array2); Unir dos arrays

      return $data;
    }

    public function actualizarInstructor($datos_Instructor)
    {
      $numedo_documento = strtoupper($datos_Instructor['numero_documento']);
      $tip = obtener_codigo_glotipos($datos_Instructor['tip'], 'TERTIP');
      $this->db->set('tertipdoc', $datos_Instructor['tipo_documento']);
      $this->db->set('terdocnum', $datos_Instructor['numero_documento']);
      
      $this->db->set('tertipo', $tip[0]['tipcodigo']);
      $this->db->set('ternom1', $datos_Instructor['nombre1']);
      $this->db->set('ternom2', $datos_Instructor['nombre2']);
      $this->db->set('terape1', $datos_Instructor['apellido1']);
      $this->db->set('terape2', $datos_Instructor['apellido2']);
      $this->db->set('tertipogrupo', 2);
      $this->db->where('tercodigo', $datos_Instructor['codigo_Instructor']);
      $this->db->update('gloterceros');
      
      $this->db->set('terdattipsex', $datos_Instructor['genero']);
      $this->db->where('terdatcodigo', $datos_Instructor['codigo_Instructor']);
      $this->db->update('gloterdatospersonales');

      return true;
    }

    public function inactivar_Cliente($codigo){
      $desactivar = 'N';
      $this->db->set('teractivo', $desactivar);
      $this->db->where('tercodigo', $codigo);
      $this->db->update('gloterceros');
      $inactivar = 2;
      $this->db->set('usu_estado', $inactivar);
      $this->db->where('usu_codigo', $codigo);
      $this->db->update('seg_usuarios');
      return true;
    }

    //UBICACIONES

    public function obtener_ubicacion($codigo){
      $this->db->select('gloterubicaciones.*');
      $this->db->select('gloterceros.*');
      $this->db->select('glotipos.*');
      $this->db->select('globarrios.*');
      $this->db->select('glopaises.*');
      $this->db->select('glomunicipios.*');
      $this->db->select('glodepartamentos.*');
      $this->db->from('gloterubicaciones');
      $this->db->join('gloterceros','gloterceros.tercodigo = gloterubicaciones.terubitercero');
      $this->db->join('glotipos','glotipos.tipcodigo = gloterubicaciones.terubitipo');
      $this->db->join('globarrios','globarrios.barcodigo = gloterubicaciones.terubibarrio');
      $this->db->join('glomunicipios','glomunicipios.muncodigo = globarrios.barmunicipio');
      $this->db->join('glodepartamentos','glodepartamentos.depcodigo = glomunicipios.mundepartamento');
      $this->db->join('glopaises','glopaises.paicodigo = glodepartamentos.deppais');
      $this->db->where('terubitercero',$codigo);
      $query = $this->db->get();
      $resultado = $query->result_array();
      return $resultado;
    }

    public function inactivar_ubicacion($codigo){
      $desactivar = 'N';
      $this->db->set('terubiactivo', $desactivar);
      $this->db->where('terubitercero', $codigo['codigo_ter']);
      $this->db->where('terubicodigo', $codigo['codigo_ubi']);
      $this->db->update('gloterubicaciones');
      return true;
    }

    public function guardar_ubicacion($datos)
    {
      if (!isset($datos['barrio'])) {
        $datos['barrio'] = '1';
      }

      $datos_ubi = array(
        'terubitercero' => $datos['codigof'],
        'terubibarrio' => $datos['barrio'],
        'terubitipo' => $datos['tipo_ubicacion'],
        'terubivalor' => $datos['descripcion']
      );
      $this->db->insert('gloterubicaciones', $datos_ubi);
      return true;
    }

    public function modificar_ubicacion($datos)
    {
      $this->db->set('terubivalor', $datos['descripcion']);
      if (isset($datos['barrio'])) {
        $this->db->set('terubibarrio', $datos['barrio']);
      }
      $this->db->set('terubitipo', $datos['tipo_ubicacion']);
      $this->db->where('terubicodigo', $datos['codigoU']);
      $this->db->update('gloterubicaciones');
      return true;
    }

    public function obtener_paises()
    {
      $this->db->select('*');
      $this->db->from('glopaises');
      $result = $this->db->get();
      $paises = $result->result_array();
      return $paises;
    }

    public function obtener_tertip()
    {
      $this->db->select('*');
      $this->db->from('glotipos');
      $this->db->where('tipgrupo', 'TERTIP');
      $this->db->where('tipclave', 'CLI');
      $this->db->or_where('tipclave', 'EMP');
      $result = $this->db->get();
      $tip1 = $result->result_array();
      return $tip1;
    }

    public function obtenter_estados($codigo_pais)
    {
      $this->db->select('*');
      $this->db->from('glodepartamentos');
      $this->db->where('deppais', $codigo_pais);
      
      $result = $this->db->get();
      $estados = $result->result_array();
      return $estados;
    }

    public function obtener_ciudades($codigo_estado)
    {
      $this->db->select('*');
      $this->db->from('glomunicipios');
      $this->db->where('mundepartamento', $codigo_estado);
      $result = $this->db->get();
      $ciudades = $result->result_array();
      return $ciudades;
    }

    public function obtener_documentos()
    {
      $this->db->select('*');
      $this->db->from('glotipos');
      $this->db->where('tipgrupo', 'TERDOC');
      $this->db->order_by('tipdetalle', 'ASC');
      $result = $this->db->get();
      $doc = $result->result_array();
      return $doc;
    }

    public function obtener_fichas()
    {
      $this->db->select('*');
      $this->db->from('glofichas');
      $this->db->order_by('ficdetalle', 'ASC');
      $result = $this->db->get(); 
      $doc = $result->result_array();
      return $doc;
    }

    public function obtener_generos()
    {
      $this->db->select('*');
      $this->db->from('glotipos');
      $this->db->where('tipgrupo', 'TERGEN');
      $result = $this->db->get();
      $gen = $result->result_array();
      return $gen;
    }

    public function obtener_tiposubi()
    {
      $this->db->select('*');
      $this->db->from('glotipos');
      $this->db->where('tipgrupo', 'TERUBI');
      $this->db->where('tipactivo', 'S');
      $this->db->order_by('tipdetalle', 'ASC');
      $result = $this->db->get();
      $ubi = $result->result_array();
      return $ubi;
    }

    public function obtener_barrios($codigo_ciudad)
    {
      $this->db->select('*');
      $this->db->from('globarrios');
      $this->db->where('barmunicipio', $codigo_ciudad);
      $this->db->where('barestado', 'S');
      $this->db->order_by('barnombre', 'ASC');
      $result = $this->db->get();
      $barrios = $result->result_array();
      return $barrios;
    }

    public function guardar_barrio($data)
    {
      $datos = array(
        'barnombre' => $data['nombrebarrio'],
        'barmunicipio' => $data['ciudadBa']
      );
      $this->db->insert('globarrios', $datos);
      return true;
    }

    public function validar_documento($data)
    {
      $this->db->select('terdocnum');
      $this->db->from('gloterceros');
      $this->db->where('terdocnum', $data);
      $result = $this->db->get();
      return $result->result_array();
    }

    public function validar_terubipri($tipo, $tercero)
    {
      $dir = obtener_codigo_glotipos('DIRPRI', 'TERUBI');
      $cor = obtener_codigo_glotipos('CORPRI', 'TERUBI');
      $tel = obtener_codigo_glotipos('TELPRI', 'TERUBI');
      $cel = obtener_codigo_glotipos('CELPRI', 'TERUBI');
      $this->db->select('terubitipo');
      $this->db->from('gloterubicaciones');
      $this->db->where('terubitipo', $tipo);
      $this->db->where('terubitercero', $tercero);
      $result = $this->db->get();
      return $result->result_array();
    }

    public function obtener_regimenes()
    {
      $this->db->select('tipcodigo');
      $this->db->select('tipdetalle');
      $this->db->from('glotipos');
      $this->db->where('tipgrupo', 'TERREG');
      $this->db->where('tipactivo', 'S');
      $this->db->order_by('tipdetalle', 'DESC');
      $result = $this->db->get();
      return $result->result_array();
    }

}


    	
	
 ?>