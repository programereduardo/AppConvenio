<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class terceros_controller extends CI_controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model('terceros_model');
  }
  //Cargando Vistas
  public function index($nombre_minuscula, $titulo, $accMod, $tip) {
    $next = false;
    $resultado = $this->terceros_model->validar_session();
    if ($resultado === false) {
      header('Location: login');
    } else {
      $this->load->model('sistema/permisos_model');
      $acciones = $this->permisos_model->obtener_acciones();
      $datos = array(
        'acciones' => $acciones
      );
      foreach ($acciones as $data) {
        if ($data['mod_nombre'] == 'Aprendiz' && $data['acc_descripcion'] == "Ver") {
          $next = true;
        }
      }
      $parametros = array(
        'controlador' => 'terceros_controller',
        'titulo' => $titulo,
        'modalName' => 'modalClientes',
        'clase' => 'cli',
        'tipo' => $nombre_minuscula,
        'accMod' => $accMod,
        'tip' => $tip
      );
      if ($next) {
        $this->load->view('shared/header');
        $this->load->view('shared/menu', $datos);
        $this->load->view('Aprendiz_view', $parametros);
        $this->load->view('shared/ubicaciones');
        $this->load->view('shared/footer');
      } else {
        header('Location: inicio');
      }
    }
  }

  public function clientes() {
    $next = false;
    $this->load->model('sistema/permisos_model');
    $acciones = $this->permisos_model->obtener_acciones();
    $datos = array(
      'acciones' => $acciones
    );
    foreach ($acciones as $data) {
      if ($data['mod_nombre'] == "Clientes" && $data['acc_descripcion'] == "Ver") {
        $next = true;
      }
    }
    if ($next === true) {
      $this->index('terceros', 'Clientes', 'Cliente', 'CLI');
    } else {
      header("Location: inicio");
    }
  }

  public function servicios($value='')
  {
    $next = false;
    $this->load->model('sistema/permisos_model');
    $acciones = $this->permisos_model->obtener_acciones();
    $datos = array(
      'acciones' => $acciones
    );
    foreach ($acciones as $data) {
      if ($data['mod_nombre'] == "Servicios" && $data['acc_descripcion'] == "Ver") {
        $next = true;
      }
    }
    if ($next === true) {
      $this->index('servicios', 'Servicios', 'Proveedor de Servicio', 'SER');
    } else {
      header("Location: inicio");
    }
  }

  public function proveedores() {
    $next = false;
    $this->load->model('sistema/permisos_model');
    $acciones = $this->permisos_model->obtener_acciones();
    $datos = array(
      'acciones' => $acciones
    );
    foreach ($acciones as $data) {
      if ($data['mod_nombre'] == "Proveedores" && $data['acc_descripcion'] == "Ver") {
        $next = true;
      }
    }
    if ($next === true) {
      $this->index('proveedores', 'Proveedores', 'Proveedor', 'PRO');
    } else {
      header("Location: inicio");
    }
  }

  public function aprendiz() {
    $next = false;
    $this->load->model('sistema/permisos_model');
    $acciones = $this->permisos_model->obtener_acciones();
    $datos = array(
      'acciones' => $acciones
    );
    foreach ($acciones as $data) {
      if ($data['mod_nombre'] == "Aprendiz" && $data['acc_descripcion'] == "Ver") {
        $next = true;
      }
    }
    if ($next === true) {
      $this->index('aprendiz', 'aprendiz', 'aprendiz', 'APRE');
    } else {
      header("Location: inicio");
    }
  }

  public function guardar_aprendiz(){
    $datos_aprendiz = $this->input->post();

    $success = false;
    $msg = "";
    if (isset($datos_aprendiz['contributivo'])) {
      if ($datos_aprendiz['contributivo'] == "NA") {
        $datos_aprendiz['contributivo'] = "N";
      }
    }
    if (isset($datos_aprendiz['retenedor'])) {
      if ($datos_aprendiz['retenedor'] == "NA") {
        $datos_aprendiz['retenedor'] = "N";
      }
    }
    if ($datos_aprendiz['tipo'] === "1") {
      $realizar = $this->terceros_model->salvar_aprendiz($datos_aprendiz);
    } else {
      $realizar = $this->terceros_model->actualizaraprendiz($datos_aprendiz); 
    }
    if ($realizar !== false) {
      $success = true;
      $msg = $realizar;
    }
    echo json_encode(array(
      'msg' => $msg,
      'success' => $success
    ));
  }

  public function eliminar_aprendiz(){
    $codigo = $this->input->post('codigo');
    $result = $this->terceros_model->inactivar_aprendiz($codigo);
    $success = false;
    $msg = '';
    if ($result !== false) {
      $success = true;
      $msg = $result;
    }
    echo json_encode(array(
      'msg' => $msg,
      'success' => $success
    ));
  }


  public function obtener_aprendiz(){
    $data = $this->input->post('data');
    $datos = $this->terceros_model->obtener_aprendices($data);

    $tip = obtener_codigo_glotipos($data, 'TERTIP');
    $tipo = $tip[0]['tipcodigo'];
    
    $cantidad = contar($tipo);
    if (count($cantidad)>0){
    echo json_encode(array(
      'success' => true,
      'aprendices' => $datos,
      'cantidad'=>$cantidad[0]['contar']
    ));
      
    }else{
      echo json_encode(array(
      'success' => false
    ));
    }
  }

  //UBICACIONES

  public function obtener_ubicacion(){
    $codigo = $this->input->post('codigo');
    $result = $this->terceros_model->obtener_ubicacion($codigo);
    
    $cantidad = count($result);
    $success = false;
    if ($cantidad > 0) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'ubicaciones' => $result
    ));
  }

  public function obtener_tertip(){
    $result = $this->terceros_model->obtener_tertip();
    $cantidad = count($result);
    $success = false;
    if ($cantidad > 0) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'data' => $result
    ));
  }

  public function inactivar_ubicacion(){
    $codigo = $this->input->post();
    $result = $this->terceros_model->inactivar_ubicacion($codigo);
    $success = false;
    $msg = '';
    if ($result !== false) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'msg' => $msg
    ));
  }

  public function guardar_ubicacion(){
    $datos = $this->input->post();
    if ($datos['tipoU'] == '1') {
      $result = $this->terceros_model->guardar_ubicacion($datos);
    } else {
      $result = $this->terceros_model->modificar_ubicacion($datos);
    }
    $msg = '';
    if ($result !== false) {
        $success = true;
      }
      echo json_encode(array(
        'success' => $success,
        'msg' => $msg
      ));
  }

  public function obtener_paises()
  {
    $paises = $this->terceros_model->obtener_paises();
    $success = false;
    if (count($paises) > 0) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'paises' => $paises
    ));
  }

  public function obtener_estados()
  {
    $codigo_pais = $this->input->post('codigo_pais');

    $resultado = $this->terceros_model->obtenter_estados($codigo_pais);
    $success = false;
    if (count($resultado) > 0) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'estados' => $resultado
    ));
  }

  public function obtener_ciudades()
  {
    $codigo_estado = $this->input->post('codigo_estado');
    $resultado = $this->terceros_model->obtener_ciudades($codigo_estado);
    $success = false;
    if (count($resultado) > 0) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'ciudades' => $resultado
    ));
  }

  public function obtener_documentos()
  {
    $resultado = $this->terceros_model->obtener_documentos();
    $success = false;
    if (count($resultado) > 0) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'documentos' => $resultado
    ));
  }

  public function obtener_fichas()
  {
    $resultado = $this->terceros_model->obtener_fichas();
    $success = false;
    if (count($resultado) > 0) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'fichas' => $resultado
    ));
  }

  public function obtener_generos()
  {
    $resultado = $this->terceros_model->obtener_generos();
    $success = false;
    if (count($resultado) > 0) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'generos' => $resultado
    ));
  }

  public function obtener_tiposubi()
  {
    $resultado = $this->terceros_model->obtener_tiposubi();
    $success = false;
    if (count($resultado) > 0) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'ubi' => $resultado
    ));
  }

  public function obtener_barrios()
  {
    $codigo_ciudad = $this->input->post('codigo_ciudad');
    $resultado = $this->terceros_model->obtener_barrios($codigo_ciudad);
    $success = false;
    if (count($resultado) > 0) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'barrios' => $resultado
    ));
  }

  public function guardar_barrio()
  {
    $datos = $this->input->post();
    $resultado = $this->terceros_model->guardar_barrio($datos);
    $success = false;
    if ($resultado !== false) {
      $success = true;
    }
    echo json_encode(array(
      'success' => $success,
      'barrios' => $resultado
    ));
  }

  public function validar_documento()
  {
    $data = $this->input->post('codigo');
    $result = $this->terceros_model->validar_documento($data);
    $success = false;
    $data = 1;
    if (count($result) > 0) {
      $success = true;
      $data = 2;
    }
    echo json_encode(
      array(
        'success' => $success,
        'data' => $data
      )
    );
  }

  public function validar_ubipri()
  {
    $tipo = $this->input->post('tipo');

    $tercero = $this->input->post('tercero');
    $result = $this->terceros_model->validar_terubipri($tipo, $tercero);
    $success = false;
    $data = 1;
    if (count($result) > 0) {
      $success = true;
      $data = 2;
    }
    echo json_encode(
      array(
        'success' => $success,
        'data' => $data
      )
    );
  }
  
  public function reporte_aprendiz()
   {
     $data = $this->input->get('data');
     $datos = $this->terceros_model->obtener_aprendices($data);
     $this->load->library('excel/excel');
     $objPHPExcel = new excel();
     $styleCabecera = new PHPExcel_Style();
     $styleCabecera->applyFromArray(
             array(
                 'fill' => array(
                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                     'color' => array('argb' => 'FF5e74e8')
                 ),
                 'borders' => array(
                     'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                     'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                     'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                     'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                 )
             )
     );

     $styleCuerpo = new PHPExcel_Style();
     $styleCuerpo->applyFromArray(
         array(
             'borders' => array(
                 'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                 'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                 'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                 'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
             )
         )
     );

     $styleCentrar = new PHPExcel_Style();
     $styleCentrar->applyFromArray(
       array(
           'alignment' => array(
               'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
               'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
           )
       )
     );

     $styleBordes = new PHPExcel_Style();
     $styleBordes->applyFromArray(
             array(
                 'borders' => array(
                     'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                     'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                     'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                     'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                 )
             )
     );

     $objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($styleCabecera, "A1:G1");
     $objPHPExcel->setActiveSheetIndex(0)
             ->setCellValue ('A1','ID')
             ->setCellValue ('B1','Tip. Doc')
             ->setCellValue ('C1','Identificación')
             ->setCellValue ('D1','Primer Nombre')
             ->setCellValue ('E1','Segundo Nombre')
             ->setCellValue ('F1','primer Apeliido')
             ->setCellValue ('G1','Segundo Apellido');
     $cedula = "";
     $filaPos = 1;

     $hoja = $objPHPExcel->setActiveSheetIndex(0);
     $row = 2;
     $contador = 1;
     foreach ($datos as $campo) {
       $filaPos++;
         if($cedula != $campo['terdocnum']) {
           if($cedula != "") {
           $arrayCombinacion = array('A','B','C','D','E','F','G');
           foreach ($arrayCombinacion as $columna) {
             $hoja->mergeCells($columna.$filaIni.":".$columna.($filaPos - 1));
             $hoja->setSharedStyle($styleCentrar, $columna.$filaIni.":".$columna.($filaPos - 1));
             $objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($styleCuerpo, $columna.$filaIni.":".$columna.($filaPos - 1));
           }
         }

         $filaIni = $filaPos;
         //Nuevo registro
         $cedula = $campo['terdocnum'];
         $hoja   ->setCellValue ('A'.$filaPos, $contador)
                  ->setCellValue ('B'.$filaPos, $campo["detalle"])
                 ->setCellValue ('C'.$filaPos, $campo["terdocnum"])
                 ->setCellValue ('D'.$filaPos, $campo["ternom1"])
                 
                 ->setCellValue ('E'.$filaPos, $campo["ternom2"])
                 ->setCellValue ('F'.$filaPos, $campo["terape1"])
                 ->setCellValue ('G'.$filaPos, $campo["terape2"]);
                 

       } 
       $objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($styleCuerpo, "A".$row.":"."G".$row);
       $contador++;
       $row++;
     } 

     foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
       $objPHPExcel->setActiveSheetIndex($objPHPExcel->getIndex($worksheet));
       $sheet = $objPHPExcel->getActiveSheet();
       $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
       $cellIterator->setIterateOnlyExistingCells(true);
       /** @var PHPExcel_Cell $cell */
       foreach ($cellIterator as $cell) {
           $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
       }
     }
     $fecha = date('Y-m-d-h-s');
     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
     header('Content-Disposition: attachment;filename="Aprendices'.$fecha.'.xlsx"');
     header('Cache-Control: max-age=0');
     $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
     $objWriter->save('php://output');
   }

   public function obtener_regimenes()
   {
     $data = $this->terceros_model->obtener_regimenes();
     $success = false;
     if (count($data) > 0) {
       $success = true;
     }
     echo json_encode(array(
       'success' => $success,
       'data' => $data
     ));
   }
 

   public function to_mysql()
    {
      $excel = $_FILES['excel']['tmp_name'];
      
      /*var_dump($excel);
      exit();*/
      //$excel = 'C:\xampp\htdocs\AppConvenio\excel_files\Aprendices2018-05-26-04-14.xlsx';
      
      //obtenemos el archivo subido mediante el formulario
      //$file = $_FILES['excel']['name'];
   
      //comprobamos si existe un directorio para subir el excel
      //si no es así, lo creamos
      if(!is_dir("./excel_files/")) 
        mkdir("./excel_files/", 0777);
   
      //comprobamos si el archivo ha subido para poder utilizarlo
      if ($excel !== '' )
      {
   
        //queremos obtener la extensión del archivo
        $trozos = explode(".", $excel);
   
        //solo queremos archivos excel
        
   
        /*var_dump($trozos);
        exit();*/
        /** archivos necesarios */
        $this->load->library('excel/excel');
        $this->load->library('excel/PHPExcel');
   
        //creamos el objeto que debe leer el excel
        $objReader = new PHPExcel_Reader_Excel2007();
        $objPHPExcel = $objReader->load($excel);
    
        //número de filas del archivo excel
        $rows = $objPHPExcel->getActiveSheet()->getHighestRow();   
   
        //obtenemos el nombre de la tabla que el usuario quiere insertar el excel
        $table_name = trim($this->security->xss_clean($this->input->post("table")));  
   
        //obtenemos los nombres que el usuario ha introducido en el campo text del formulario,
        //se supone que deben ser los campos de la tabla de la base de datos.
        $fields_table = explode(",", $this->security->xss_clean($this->input->post("fields")));
   
        //inicializamos sql como un array
        $sql = array();
   
        //array con las letras de la cabecera de un archivo excel
        $letras = array(
          "A","B","C","D","E","F","G",
          "H","I","J","Q","L","M","N",
          "O","P","Q","R","S","T","U",
          "V","W","X","Y","Z"
        );
    
        //recorremos el excel y creamos un array para después insertarlo en la base de datos
        for($i = 2;$i <= $rows; $i++)
        {
          //ahora recorremos los campos del formulario para ir creando el array de forma dinámica
          for($z = 0; $z < count($fields_table); $z++)
          {
            $sql[$i][trim($fields_table[$z])] = $objPHPExcel->getActiveSheet()->getCell($letras[$z].$i)->getCalculatedValue();
          }
        }   
   
        /*echo "<pre>";
        var_dump($sql); exit();
        */
   
        //cargamos el modelo
        $this->load->model("terceros_model"); 
        //insertamos los datos del excel en la base de datos
        $import_excel = $this->terceros_model->excel($table_name,$sql);

        //comprobamos si se ha guardado bien
        if ($import_excel === true)
        {
          echo json_encode(
            array(
              'success'=>true,
            )
          );
        }else{
          echo json_encode(
            array(
              'success'=>false)
          );
        }
   
        //finalmente, eliminamos el archivo pase lo que pase
        //unlink("./excel_files/".$file);
   
      }else{
        echo "Debes subir un archivo";
      }
    }
 }
