<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('contar_compras'))
{
 function contar_compras()
 {
   $ci =& get_instance();

   $sql = "SELECT COUNT(comnumero) as cantidad_compras,
                  SUM(comtotal) AS total_historico,
                  SUM(comdescuento) as descuento_historico,
                  SUM(comiva) as iva_historico
           FROM contabilidad.concompras
           WHERE comestado = 'A'
           ";

   $result = $ci->db->query($sql);
   return $result->result_array();
 }
}
