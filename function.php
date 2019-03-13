<?php

require_once (getcwd() . '/PHPExcel/Classes/PHPExcel.php');

class exportClass {

    private $name;

    public function process($dateTime) {

        try{

            $fechaActualizacion = $dateTime->format('d/m/Y');
            $excelName = $dateTime->format('Y-m-d');

            $client = new \SoapClient("https://test?wsdl", [
                "proxy_host" => "proxy.test.com.pe",
                "proxy_port" => 3128,
                'proxy_login'    => "test",
                'proxy_password' => "test",
                "soap_version" => SOAP_1_2,
                "trace" => true,
                "exceptions" => 1
            ]);

            $response = $client->consultaHistorica([
                "parametro" => [
                    "claveUsuario" => "95320553",
                    "codigoOsinergmin" => "",
                    "fechaActualizacion" => $fechaActualizacion, // "15/02/2019",
                    "loginUsuario" => "3379100",
                ],
            ]);

            if (!is_array($response->consultaHistoricaResponse)) {
                return false;
            }

            /**
             * CREATE EXCEL
             */
            $obj = new PHPExcel();
            $obj->getProperties()
                ->setCreator('Test Creador')
                ->setLastModifiedBy('Test Creador - Modificador')
                ->setTitle('Template Test')
                ->setSubject('Template excel')
                ->setDescription('Rows de embarque asfalto')
                ->setKeywords('embarque, asfalto');
            $obj->setActiveSheetIndex(0);

            $obj->getActiveSheet()->getColumnDimension('A')->setWidth(30);
            $obj->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $obj->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $obj->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $obj->getActiveSheet()->getColumnDimension('E')->setWidth(30);
            $obj->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $obj->getActiveSheet()->getColumnDimension('G')->setWidth(200);
            $obj->getActiveSheet()->getColumnDimension('H')->setWidth(30);
            $obj->getActiveSheet()->getColumnDimension('I')->setWidth(30);
            $obj->getActiveSheet()->getColumnDimension('J')->setWidth(30);
            $obj->getActiveSheet()->getColumnDimension('K')->setWidth(30);
            $obj->getActiveSheet()->getColumnDimension('L')->setWidth(30);
            $obj->getActiveSheet()->getColumnDimension('M')->setWidth(200);

            $obj->getActiveSheet()->getStyle('A1:M1')->getFill()->applyFromArray([
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => [
                    'rgb' => '5B9BD5'
                ]
            ]);

            $obj->getActiveSheet()->getStyle('A1:M1')->applyFromArray([
                'font' => [
                    'bold'  => true,
                    'color' => [
                        'rgb' => 'FFFFFF'
                    ],
                    'size'  => 10,
                    'name'  => 'Verdana'
                ],
                'alignment' => [
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                ]
            ]);

//        $obj->getActiveSheet()
//            ->getStyle('D1:D99999')
//            ->getAlignment()
//            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $obj->getActiveSheet()->SetCellValue('A1', 'bandera');
            $obj->getActiveSheet()->SetCellValue('B1', 'codigoOsinergmin');
            $obj->getActiveSheet()->SetCellValue('C1', 'departamento');
            $obj->getActiveSheet()->SetCellValue('D1', 'codigoProducto');
            $obj->getActiveSheet()->SetCellValue('E1', 'fechaActualizacion');
            $obj->getActiveSheet()->SetCellValue('F1', 'precio');
            $obj->getActiveSheet()->SetCellValue('G1', 'direccion');
            $obj->getActiveSheet()->SetCellValue('H1', 'distrito');
            $obj->getActiveSheet()->SetCellValue('I1', 'latitud');
            $obj->getActiveSheet()->SetCellValue('J1', 'longitud');
            $obj->getActiveSheet()->SetCellValue('K1', 'numeroRegistro');
            $obj->getActiveSheet()->SetCellValue('L1', 'provincia');
            $obj->getActiveSheet()->SetCellValue('M1', 'razonSocial');

            $col = 2;
            foreach($response->consultaHistoricaResponse as $key => $row) {


                if (is_array($row->detallePrecios)) {
                    foreach($row->detallePrecios as $key => $detallePrecios) {
                        $obj->getActiveSheet()->SetCellValue('A' . $col, $row->bandera);
                        $obj->getActiveSheet()->SetCellValue('B' . $col, $row->codigoOsinergmin);
                        $obj->getActiveSheet()->SetCellValue('C' . $col, $row->departamento);
                        $obj->getActiveSheet()->SetCellValue('D' . $col, $detallePrecios->codigoProducto); // repeat
                        $obj->getActiveSheet()->SetCellValue('E' . $col, $detallePrecios->fechaActualizacion); // repeat
                        $obj->getActiveSheet()->SetCellValue('F' . $col, $detallePrecios->precio); // repeat
                        $obj->getActiveSheet()->SetCellValue('G' . $col, $row->direccion);
                        $obj->getActiveSheet()->SetCellValue('H' . $col, $row->distrito);
                        $obj->getActiveSheet()->SetCellValue('I' . $col, $row->latitud);
                        $obj->getActiveSheet()->SetCellValue('J' . $col, $row->longitud);
                        $obj->getActiveSheet()->SetCellValue('K' . $col, $row->numeroRegistro);
                        $obj->getActiveSheet()->SetCellValue('L' . $col, $row->provincia);
                        $obj->getActiveSheet()->SetCellValue('M' . $col, $row->razonSocial);
                        $col++;
                    }
                } else {
                    $obj->getActiveSheet()->SetCellValue('A' . $col, $row->bandera);
                    $obj->getActiveSheet()->SetCellValue('B' . $col, $row->codigoOsinergmin);
                    $obj->getActiveSheet()->SetCellValue('C' . $col, $row->departamento);
                    $obj->getActiveSheet()->SetCellValue('D' . $col, $row->detallePrecios->codigoProducto); // repeat
                    $obj->getActiveSheet()->SetCellValue('E' . $col, $row->detallePrecios->fechaActualizacion); // repeat
                    $obj->getActiveSheet()->SetCellValue('F' . $col, $row->detallePrecios->precio); // repeat
                    $obj->getActiveSheet()->SetCellValue('G' . $col, $row->direccion);
                    $obj->getActiveSheet()->SetCellValue('H' . $col, $row->distrito);
                    $obj->getActiveSheet()->SetCellValue('I' . $col, $row->latitud);
                    $obj->getActiveSheet()->SetCellValue('J' . $col, $row->longitud);
                    $obj->getActiveSheet()->SetCellValue('K' . $col, $row->numeroRegistro);
                    $obj->getActiveSheet()->SetCellValue('L' . $col, $row->provincia);
                    $obj->getActiveSheet()->SetCellValue('M' . $col, $row->razonSocial);
                    $col++;
                }
            }

            $writer = PHPExcel_IOFactory::createWriter($obj, 'Excel5');


            /**
             * DOWNLOAD
             */
            ob_end_clean();
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $excelName . '.xls"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');


        }catch(\SoapFault $e){
            echo "POLLO :: <pre>";
            print_r($e->getMessage());
            exit;
        }
    }
}

?>