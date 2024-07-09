<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connexion");
    }
    require_once('connexion.php');
    $query="SELECT * FROM site INNER JOIN province ON site.ID_Prov=province.ID_Prov WHERE site.ID_Site!=0";
    if(isset($_GET['Province']) && $_GET['Province']!=''){
        $query.=" AND site.ID_Prov=".$_GET['Province'];
    }
    if(isset($_GET['siteName']) && $_GET['siteName']!=''){
        $query.=" AND UCASE(site.Site_Name) LIKE '%".strtoupper($_GET['siteName'])."%'";
    }
    if(isset($_GET['siteId']) && $_GET['siteId']!=''){
        $query.=" AND UCASE(site.Site_ID) LIKE '%".strtoupper($_GET['siteId'])."%'";
    }
    $query.=" ORDER BY site.Site_ID, site.Site_Name";
    $selection = $pdo->query($query);

//include the file that loads the PhpSpreadsheet classes
require 'spreadsheet/vendor/autoload.php';

//include the classes needed to create and write .xlsx file
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//object of the Spreadsheet class to create the excel data
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// $styleA3 = $sheet->getStyle('A3:I3');
// $styleFont = $styleA3->getFont();
// $styleFont->setBold(true);
// $styleFont->setSize(12);
$ecole = $pdo->query("SELECT * FROM etablissement");
$ecoles = $ecole->fetch();
$sheet->setCellValue('A1', $ecoles['Design_Etablissement']);
$sheet->setCellValue('A3', "LISTE DES SITES");
$sheet->mergeCells('A3:D3');
// $sheet->mergeCells('A6:B6');
$sheet->mergeCells('A1:C1');
$styleA1 = array(
    'font' => array(
        'bold' => true,
        'size' => 15
        // 'name'=>Arial
        // 'color'=>array('rgb'=>'FFFFFF')
    ),
    // 'fill'=>array(
    //     'type'=>\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
    //     'color'=>array('rgb'=>'004489')
    // ),
    'alignment' => array(
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
    )
);
$styleA2 = array(
    'font' => array(
        'italic' => true,
        'bold' => true
    ),
    'alignment' => array(
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
    )
);
$styleA3 = array(
    'font' => array(
        'bold' => true,
        'size' => 10
        // 'name'=>Arial
        // 'color'=>array('rgb'=>'FFFFFF')
    ),
    // 'fill'=>array(
    //     'type'=>\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
    //     'color'=>array('rgb'=>'C8DCFF')
    // ),
);
$styleA4 = array(
    'font' => array(
        // 'bold'=>true,
        'size' => 10
        // 'name'=>Arial
        // 'color'=>array('rgb'=>'FFFFFF')
    ),
    // 'fill'=>array(
    //     'type'=>\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
    //     'color'=>array('rgb'=>'C8DCFF')
    // ),
);
$styleA5 = array(
    'font' => array(
        'bold' => true,
        'size' => 10
        // 'name'=>Arial
        // 'color'=>array('rgb'=>'FFFFFF')
    ),
    'fill' => array(
        'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'color' => array('rgb' => 'C8DCFF')
    ),
    'alignment' => array(
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
    )
);
// $styleBordure1=array(
//         'borders'=>array(
//             'allborders'=>array('style'=>\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,'color'=>array('rgb'=>'FF0000'))
//         )
//     );

$sheet->getStyle('A3')->applyFromArray($styleA1);
$sheet->getStyle('A1')->applyFromArray($styleA2);
// $sheet->getStyle('A6')->applyFromArray($styleA3);
// $sheet->getStyle('C5')->applyFromArray($styleA4);
// $sheet->getStyle('C6')->applyFromArray($styleA4);
$style = array(
    'font' => array(
        'bold' => true,
        'size' => 10
    )
);
$bordures = array(
    'font' => array(
        'size' => 10
    ),
    'borders' => array(
        'allborders' => array('style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM)
    )
);
$styleNumber = array(
    'code' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1
    // 'alignment'=>array(
    //     'horizontal'=>\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT
    // )
);
$stingformat = array(
    'code' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
    // 'alignment'=>array(
    //     'horizontal'=>\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT
    // )
);
$centrer = array(
    'alignment' => array(
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
    )
);
$sheet->SetCellValue('A6', "N°")->SetCellValue('B6', "Site ID & Name")->SetCellValue('C6', "Province")->SetCellValue('D6', "FME Name");
$cell_st = [
    'font' => ['bold' => true, 'size' => 10],
    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    'borders' => ['allborders' => ['style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM]]
];
$sheet->getStyle('A6:D6')->applyFromArray($cell_st);
$t = 6;
$Nbr = 0;
while ($selections = $selection->fetch()) {
    $fme=$pdo->query("SELECT * FROM agent WHERE ID_Agent=".$selections['ID_Agent']);
    $fmes=$fme->fetch();
    $Nbr++;
    $t++;
    $sheet->SetCellValue('A' . $t, sprintf('%02d', $Nbr))->SetCellValue('B' . $t, strtoupper(stripslashes($selections['Site_ID'] . ' - ' . $selections['Site_Name'])))->SetCellValue('C' . $t, strtoupper(stripslashes($selections['Design_Prov'])))->SetCellValue('D' . $t, strtoupper(stripslashes($fmes['Nom_Agent'])));
}

$sheet->getStyle('A7:A' . $t)->applyFromArray($centrer);
// $sheet->getStyle('D7:D'.$t)->applyFromArray($centrer);
$sheet->getStyle('E7:I' . $t)->applyFromArray($centrer);
// $sheet->getStyle('A7:A' . $t)->applyFromArray($stingformat);
$sheet->getStyle('A6:D' . $t)->applyFromArray($bordures);
// $sheet->getStyle('H7:H'.$t)->getNumberFormat()->applyFromArray($styleNumber);

$sheet->getColumnDimension('A')->setWidth(5);
$sheet->getColumnDimension('B')->setWidth(35);
$sheet->getColumnDimension('C')->setWidth(20);
$sheet->getColumnDimension('D')->setWidth(20);

// $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
$sheet->setTitle("LISTE DES SITES"); //set a title for Worksheet
//make object of the Xlsx class to save the excel file
/*$writer = new Xlsx($spreadsheet);
$fxls ='conducteur_candidat.xlsx';
$writer->load($fxls); */

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Liste_Sites_' . date('d') . '_' . date('m') . '_' . date('Y') . '_' . date('H') . '_' . date('i') . '_' . date('s') . '.xlsx"');
header('Cache-Control: max-age=0');
$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');


?>
