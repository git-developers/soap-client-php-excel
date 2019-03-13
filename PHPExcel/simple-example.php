<?php

require_once '../Classes/PHPExcel.php';


$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()
    ->setCreator("Temporaris")
    ->setLastModifiedBy("Temporaris")
    ->setTitle("Template Relev� des heures int�rimaires")
    ->setSubject("Template excel")
    ->setDescription("Template excel permettant la cr�ation d'un ou plusieurs relev�s d'heures")
    ->setKeywords("Template excel");
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->SetCellValue('A1', "Pollo");
$objPHPExcel->getActiveSheet()->SetCellValue('B1', "gato");
$objPHPExcel->getActiveSheet()->SetCellValue('C1', "pERRO");

$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="excel.xls"');
header('Cache-Control: max-age=0');
$writer->save('php://output');