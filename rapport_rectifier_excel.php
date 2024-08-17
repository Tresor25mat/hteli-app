<?php
session_start();
$_SESSION['last_activity'] = time();
require_once('connexion.php');
$query="SELECT * FROM table_rapport_rectifier INNER JOIN table_rectifier_make ON table_rapport_rectifier.ID_Rectifier_Make=table_rectifier_make.ID_Rectifier_Make INNER JOIN table_rectifier_model ON table_rapport_rectifier.ID_Rectifier_Model=table_rectifier_model.ID_Rectifier_Model INNER JOIN table_make_batterie ON table_rapport_rectifier.ID_Make_Batterie=table_make_batterie.ID_Make_Batterie INNER JOIN site ON table_rapport_rectifier.ID_Site=site.ID_Site INNER JOIN province ON site.ID_Prov=province.ID_Prov WHERE table_rapport_rectifier.ID_Rapport!=0";
if(isset($_GET['User']) && $_GET['User']!=''){
    $query.=" AND table_rapport_rectifier.ID_Utilisateur=".$_GET['User'];
}
if(isset($_GET['siteId']) && $_GET['siteId']!=''){
    $query.=" AND UCASE(site.Site_ID) LIKE '%".strtoupper($_GET['siteId'])."%'";
}
if(isset($_GET['dateRapport']) && $_GET['dateRapport']!=''){
    $query.=" AND table_rapport_rectifier.Date_Rapport='".date('Y-m-d', strtotime($_GET['dateRapport']))."'";
}
$query.=" ORDER BY table_rapport_rectifier.Date_Rapport";
$selection=$pdo->query($query);

//include the file that loads the PhpSpreadsheet classes
require 'spreadsheet/vendor/autoload.php';

//include the classes needed to create and write .xlsx file
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//object of the Spreadsheet class to create the excel data
$spreadsheet = new Spreadsheet();
$sheet=$spreadsheet->getActiveSheet();

// $styleA3 = $sheet->getStyle('A3:I3');
// $styleFont = $styleA3->getFont();
// $styleFont->setBold(true);
// $styleFont->setSize(12);
$ecole=$pdo->query("SELECT * FROM etablissement");
$ecoles=$ecole->fetch();
$sheet->setCellValue('A1', $ecoles['Design_Etablissement']);
$sheet->setCellValue('A3', "RECTIFIER AND STORAGE BATTERY MAINTENANCE LIST");
$sheet->mergeCells('A3:I3');
// $sheet->mergeCells('A5:I5');
// $sheet->mergeCells('A6:B6');
$sheet->mergeCells('A1:C1');
$styleA1=array(
        'font'=>array(
            'bold'=>true,
            'size'=>15
            // 'name'=>Arial
            // 'color'=>array('rgb'=>'FFFFFF')
        ),
        // 'fill'=>array(
        //     'type'=>\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        //     'color'=>array('rgb'=>'004489')
        // ),
        'alignment'=>array(
            'horizontal'=>\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        )
    );
 $styleA2=array(
        'font'=>array(
            'italic'=>true,
            'bold'=>true
        ),
        'alignment'=>array(
            'horizontal'=>\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
        )
    );
 $styleA3=array(
        'font'=>array(
            'bold'=>true,
            'size'=>10
            // 'name'=>Arial
            // 'color'=>array('rgb'=>'FFFFFF')
        ),
        // 'fill'=>array(
        //     'type'=>\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        //     'color'=>array('rgb'=>'C8DCFF')
        // ),
    );
  $styleA4=array(
        'font'=>array(
            // 'bold'=>true,
            'size'=>10
            // 'name'=>Arial
            // 'color'=>array('rgb'=>'FFFFFF')
        ),
        // 'fill'=>array(
        //     'type'=>\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        //     'color'=>array('rgb'=>'C8DCFF')
        // ),
    );
 $styleA5=array(
        'font'=>array(
            'bold'=>true,
            'size'=>10
            // 'name'=>Arial
            // 'color'=>array('rgb'=>'FFFFFF')
        ),
        'fill'=>array(
            'type'=>\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'color'=>array('rgb'=>'C8DCFF')
        ),
        'alignment'=>array(
            'horizontal'=>\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
        )
    );
// $styleBordure1=array(
//         'borders'=>array(
//             'allborders'=>array('style'=>\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,'color'=>array('rgb'=>'FF0000'))
//         )
//     );
 if(isset($_GET['dateRapport']) && !empty($_GET['dateRapport'])){
      $sheet->setCellValue('A5', "EN DATE DU ".date('d/m/Y', strtotime($_GET['dateRapport'])));
      $sheet->mergeCells('A5:I5');
      $sheet->getStyle('A5')->applyFromArray($styleA5);
}
$sheet->getStyle('A3')->applyFromArray($styleA1);
$sheet->getStyle('A1')->applyFromArray($styleA2);
// $sheet->getStyle('A6')->applyFromArray($styleA3);
// $sheet->getStyle('C5')->applyFromArray($styleA4);
// $sheet->getStyle('C6')->applyFromArray($styleA4);
    $style=array(
            'font'=>array(
                'bold'=>true,
                'size'=>10
            ));
    $bordures=array(
            'font'=>array(
                'size'=>10
            ),
            'borders'=>array(
                'allborders'=>array('style'=>\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM)
            ));
    $styleNumber=array(
            'code' =>\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1
            // 'alignment'=>array(
            //     'horizontal'=>\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT
            // )
    );
    $stingformat=array(
            'code' =>\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
            // 'alignment'=>array(
            //     'horizontal'=>\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT
            // )
    );
    $centrer=array(
            'alignment'=>array(
                'horizontal'=>\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
            )
    );
    $sheet->SetCellValue('A7', "N°")->SetCellValue('B7', "Site ID & Name")->SetCellValue('C7', "Province")->SetCellValue('D7', "Rectifier make")->SetCellValue('E7', "Rectifier model")->SetCellValue('F7', "Work Order No")->SetCellValue('G7', "Date")->SetCellValue('H7', "Time In")->SetCellValue('I7', "Time Out");
    $cell_st =[
     'font' =>['bold' => true, 'size' => 10], 'alignment' =>['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER], 'borders'=>['allborders' =>['style'=> \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM]]
    ];
    $sheet->getStyle('A7:I7')->applyFromArray($cell_st);
$t=7;
$Nbr=0;
while($selections=$selection->fetch()){ 
    $Nbr++;
    $t++;
    $sheet->SetCellValue('A'.$t, sprintf('%02d', $Nbr))->SetCellValue('B'.$t, strtoupper(stripslashes($selections['Site_ID'].' - '.$selections['Site_Name'])))->SetCellValue('C'.$t, strtoupper(stripslashes($selections['Design_Prov'])))->SetCellValue('D'.$t, strtoupper(stripslashes($selections['Design_Rectifier_Make'])))->SetCellValue('E'.$t, strtoupper(stripslashes($selections['Design_Rectifier_Model'])))->SetCellValue('F'.$t, strtoupper(stripslashes($selections['Num_Work_Order'])))->SetCellValue('G'.$t, date('d/m/Y', strtotime($selections['Date_Rapport'])))->SetCellValue('H'.$t, date('H:i', strtotime($selections['Time_In'])))->SetCellValue('I'.$t, date('H:i', strtotime($selections['Time_Out'])));
}

$sheet->getStyle('A7:A'.$t)->applyFromArray($centrer);
// $sheet->getStyle('D7:D'.$t)->applyFromArray($centrer);
$sheet->getStyle('E7:I'.$t)->applyFromArray($centrer);
$sheet->getStyle('A7:A'.$t)->applyFromArray($stingformat);
$sheet->getStyle('A7:I'.$t)->applyFromArray($bordures);
// $sheet->getStyle('H7:H'.$t)->getNumberFormat()->applyFromArray($styleNumber);

$sheet->getColumnDimension('A')->setWidth(5);
$sheet->getColumnDimension('B')->setWidth(25);
$sheet->getColumnDimension('C')->setWidth(20);
$sheet->getColumnDimension('D')->setWidth(20);
$sheet->getColumnDimension('E')->setWidth(13);
$sheet->getColumnDimension('F')->setWidth(13);
$sheet->getColumnDimension('G')->setWidth(13);
$sheet->getColumnDimension('H')->setWidth(13);
$sheet->getColumnDimension('I')->setWidth(13);
$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
$sheet->setTitle("RECTIFIER AND STORAGE BATTERY"); //set a title for Worksheet
//make object of the Xlsx class to save the excel file
/*$writer = new Xlsx($spreadsheet);
$fxls ='conducteur_candidat.xlsx';
$writer->load($fxls); */

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
    header('Content-Disposition: attachment;filename="Rectifier_And_Storage_Battery_Maintenance_List_'.date('d').'_'.date('m').'_'.date('Y').'_'.date('H').'_'.date('i').'_'.date('s').'.xlsx"'); 
    header('Cache-Control: max-age=0'); 
    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); 
    $writer->save('php://output');


?>
