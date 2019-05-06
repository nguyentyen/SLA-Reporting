<?php
require_once 'PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
require_once 'PHPExcel-1.8/Classes/PHPExcel.php';
$tickets = $con->get_tickets($_GET);
$sort = null;
$sortby = null;
if(array_key_exists('sortby', $_GET) && array_key_exists('sort', $_GET)) {
    if ($_GET['sortby'] !== "" && $_GET['sort'] !== "") {
        $sort = $_GET['sort'];
        $sortby = $_GET['sortby'];
        $sort_tickets = [];
        if ($sort == "SORT_DESC") {
            $sort_tickets = $con->tickets_sort($tickets, $sortby, SORT_DESC);
        } else {
            $sort_tickets = $con->tickets_sort($tickets, $sortby, SORT_ASC);
        }
        $tickets = [];
        foreach($sort_tickets as $key => $value) {
            $tickets[] = $value;
        }
        
    }
}

// echo "<pre>";var_dump($tickets);die;
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()
    ->setCreator("Yen Nguyen")
    ->setLastModifiedBy("Temporaris")
    ->setTitle("SLA Reporting")
    ->setSubject("Template excel")
    ->setDescription("Template excel SLA Reporting")
    ->setKeywords("Template excel");
$objPHPExcel->setActiveSheetIndex(0);
$row_name = [
    "Ticket name",
    "Created by",
    "Created date",
    "Time to respond",
    "Time to resolved",
    "Current state"
];
$key = [
    "ticket_name",
    "creator",
    "created_time",
    "time_to_respond",
    "time_to_resolved",
    "state"
];
$letterarr = range('A', 'Z');
for ($i = 0; $i < count($tickets); $i ++) {
    for ($ii = 0; $ii < count($row_name); $ii ++) {
        $objPHPExcel->getActiveSheet()
            ->getColumnDimension($letterarr[$i])
            ->setWidth(20);
//         echo $letterarr[$ii].($i+1).":". $tickets[$i][$key[$ii]] ."<br>";
        $objPHPExcel->getActiveSheet()->SetCellValue($letterarr[$ii].($i+2), $tickets[$i][$key[$ii]]);
//         $objPHPExcel->getActiveSheet()
//             ->getStyle($letterarr[$ii] . "1")
//             ->getFill()
//             ->applyFromArray(array(
//             'type' => PHPExcel_Style_Fill::FILL_SOLID,
//             'startcolor' => array(
//                 'rgb' => "F28A8C"
//             )
//         ));

    }
}
// die;
$objPHPExcel->getActiveSheet()->SetCellValue('A1', $row_name[0]);
$objPHPExcel->getActiveSheet()->SetCellValue('B1', $row_name[1]);
$objPHPExcel->getActiveSheet()->SetCellValue('C1', $row_name[2]);
$objPHPExcel->getActiveSheet()->SetCellValue('D1', $row_name[3]);
$objPHPExcel->getActiveSheet()->SetCellValue('E1', $row_name[4]);
$objPHPExcel->getActiveSheet()->SetCellValue('F1', $row_name[5]);


$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
header('Content-Type: application/vnd.ms-excel');

$now = DateTime::createFromFormat('U.u', number_format(microtime(true), 6, '.', ''));
$local = $now->setTimeZone(new DateTimeZone('Europe/Berlin'));
$time_local = $local->format("m_d_Y_H_i_s_u");
$filename = "SLA_Reporting_Youtrack_" . $time_local . '.xls';
if (file_exists($filename)) {
    unlink($filename);
}

header('Content-Disposition: attachment;filename=' . $filename);
header('Cache-Control: max-age=0');
$writer->save('php://output');
// $savefile = 'C:\Users\yng\eclipse-workspace\SLA_Reporting\\'.$filename;
// $writer->save($savefile);

echo $writer;

// $objWriter =new PHPExcel_Writer_Excel2007();
// $objWriter->save(str_replace('.php', '.xlsx', 'C:\Users\yng\eclipse-workspace\SLA_Reporting\excel.xlsx'));
// echo 1;