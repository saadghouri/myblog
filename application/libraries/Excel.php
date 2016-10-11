<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once "PHPExcel/Classes/PHPExcel.php";
class Excel extends PHPExcel
{
	public function __construct() {
        parent::__construct();

    }
    function getExcelSheetArray($filePath){
    	//read file from path
        $objPHPExcel = PHPExcel_IOFactory::load($filePath);
        //get only the Cell Collection
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        //extract to a PHP readable array format
        foreach ($cell_collection as $cell) {
            $column = PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getCell($cell)->getColumn())-1;
            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
            for ($i=0; $i < $column; $i++) { 
                //if there are blank columns
                if(!isset($arr_data[$row][$i]))
                    $arr_data[$row][$i]="";
            }
            /*if($lastColumn!=($column-1))
            {
                
                for ($i=$lastColumn+1; $i <$column ; $i++) { 
                    $arr_data[$row][$i]="";
                }
            }*/
            //$lastColumn=$column;
            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
            $arr_data[$row][$column] = $data_value;
        }
        return $arr_data;
    }
}


?>
