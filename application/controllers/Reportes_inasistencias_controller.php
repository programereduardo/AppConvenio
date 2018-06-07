<?php
/**
 *
 */
class reportes_inasistencias_controller extends CI_Controller
{

  function __construct()
  {
    parent :: __construct();
    $this->load->model('reportes_inasistencias_model');
  }

  public function index()
  {
    $resultado = $this->reportes_inasistencias_model->validar_session();
    if ($resultado === false) {
      header('Location: login');
    } else {
      $this->load->model('sistema/permisos_model');
      $acciones = $this->permisos_model->obtener_acciones();
      $datos = array(
        'acciones' => $acciones
      );
      $next = false;
      foreach ($acciones as $data) {
        if ($data['mod_nombre'] == "Reporte inasistencias" && $data['acc_descripcion'] == "Ver") {
          $next = true;
        }
      }
      if ($next === true) {
        $this->load->view('shared/header');
        $this->load->view('shared/menu', $datos);
        $this->load->view('reportes-inasistencias_view');
        $this->load->view('shared/footer');
      } else {
        header("Location: inicio");
      }
    }
  }

  public function llenar_fichas()
  {
    $respuesta = $this->reportes_inasistencias_model->llenar_fichas();
    $conteo = count($respuesta);

    if ($conteo>0)
    {
      echo json_encode(array(
        'success'=>true,
        'data'=>$respuesta
      ));
    }
      
  }

  public function obtener_consulta()
  {
    $ficha = $this->input->post('ficha');
    $desde = $this->input->post('desde');
    $hasta = $this->input->post('hasta');

    $dias = $this->input->post('dias');

    $respuesta = $this->reportes_inasistencias_model->obtener_consulta($ficha,$desde,$hasta,$dias);

    $conteo = count($respuesta);
    if ($conteo>0)
    {
      echo json_encode(array(
        'success'=>true,
        'data'=>$respuesta
      ));
    }else{
      echo json_encode(array(
        'success'=>true,
        'data'=>''
      ));
    }

  }

  public function reporte_inasistencia()
  {

     $ficha = $this->input->post('data');
     $desde = $this->input->post('desde');
     $hasta = $this->input->post('hasta');
     $dias = $this->input->post('dias');
     var_dump($ficha);
     $datos = $this->reportes_inasistencias_model->obtener_consulta($ficha,$desde,$hasta,$dias);
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

     $objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($styleCabecera, "A1:M1");
     $objPHPExcel->setActiveSheetIndex(0)
             ->setCellValue ('A1','ID')
             ->setCellValue ('B1','Tip. Doc')
             ->setCellValue ('C1','Identificación')
             ->setCellValue ('D1','Nombre')
             ->setCellValue ('E1','Tipo')
             ->setCellValue ('F1','Dirección')
             ->setCellValue ('G1','Correo')
             ->setCellValue ('H1','Telefono')
             ->setCellValue ('I1','Celular')
             ->setCellValue ('J1','Barrio')
             ->setCellValue ('K1','Ciudad')
             ->setCellValue ('L1','Departamento')
             ->setCellValue ('M1','País');

     $cedula = "";
     $filaPos = 1;

     $hoja = $objPHPExcel->setActiveSheetIndex(0);
     $row = 2;
     $contador = 1;
     foreach ($datos as $campo) {
       $filaPos++;
         if($cedula != $campo['terdocnum']) {
           if($cedula != "") {
           $arrayCombinacion = array('A','B','C','D','E','F','G','H', 'I');
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
                 
                 ->setCellValue ('D'.$filaPos, $campo["ternom1"]. ' ' .$campo["ternom2"].' '.$campo["terape1"].' '.$campo["terape2"])
                 ->setCellValue ('E'.$filaPos, $campo["clave"]);
                 

         $hoja   ->setCellValue ('F'.$filaPos, $campo["direccion"])
                 ->setCellValue ('G'.$filaPos, $campo["correo"])
                 ->setCellValue ('H'.$filaPos, $campo["telefono"])
                 ->setCellValue ('I'.$filaPos, $campo["celular"])
                 ->setCellValue ('J'.$filaPos, $campo["barrio"])
                 ->setCellValue ('K'.$filaPos, $campo["municipio"])
                 ->setCellValue ('L'.$filaPos, $campo["dpto"])
                 ->setCellValue ('M'.$filaPos, $campo["pais"]);

       } 
       $objPHPExcel->setActiveSheetIndex(0)->setSharedStyle($styleCuerpo, "A".$row.":"."M".$row);
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
    
}

 ?>
 