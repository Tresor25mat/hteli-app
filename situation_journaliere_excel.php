<?php
session_start();
require_once('connexion.php');
$rs_paiement_cdf="SELECT eleve.*, paiement.*, paiement_frais.*, annee.*, classe.*, type_frais.* FROM eleve INNER JOIN inscription ON eleve.ID_Eleve=inscription.ID_Eleve INNER JOIN paiement ON inscription.ID_Inscription=paiement.ID_Inscription INNER JOIN paiement_frais ON paiement.ID_Paiement=paiement_frais.ID_Paiement INNER JOIN frais ON paiement_frais.ID_Frais=frais.ID_Frais INNER JOIN classe ON inscription.ID_Classe=classe.ID_Classe INNER JOIN annee ON inscription.ID_Annee=annee.ID_Annee INNER JOIN table_option ON classe.ID_Option=table_option.ID_Option INNER JOIN section ON table_option.ID_Section=section.ID_Section INNER JOIN type_frais ON frais.ID_Type_Frais=type_frais.ID_Type_Frais WHERE section.ID_Etablissement=".$_GET['Ecole']." AND paiement_frais.ID_Taux=1 AND paiement.Confirm_Paiement=1";
if(isset($_GET['frais']) && !empty($_GET['frais'])){
	$rs_paiement_cdf .=" AND type_frais.ID_Type_Frais=".$_GET['frais'];
}
if(isset($_GET['datedeb']) && !empty($_GET['datedeb']) && isset($_GET['datefin']) && !empty($_GET['datefin'])){
	$rs_paiement_cdf .=" AND paiement.Date_Paiement >='".date('Y-m-d', strtotime($_GET['datedeb']))."' AND paiement.Date_Paiement <='".date('Y-m-d', strtotime($_GET['datefin']))."'";
}else{
    if(isset($_GET['datedeb']) && !empty($_GET['datedeb'])){
    	$rs_paiement_cdf .=" AND paiement.Date_Paiement >='".date('Y-m-d', strtotime($_GET['datedeb']))."'";
    }
}
$rs_paiement_cdf .=" ORDER BY paiement.Date_Paiement, eleve.Nom_Eleve";
$req_eleve_cdf=$pdo->query($rs_paiement_cdf);

$rs_paiement_usd="SELECT eleve.*, paiement.*, paiement_frais.*, annee.*, classe.*, type_frais.* FROM eleve INNER JOIN inscription ON eleve.ID_Eleve=inscription.ID_Eleve INNER JOIN paiement ON inscription.ID_Inscription=paiement.ID_Inscription INNER JOIN paiement_frais ON paiement.ID_Paiement=paiement_frais.ID_Paiement INNER JOIN frais ON paiement_frais.ID_Frais=frais.ID_Frais INNER JOIN classe ON inscription.ID_Classe=classe.ID_Classe INNER JOIN annee ON inscription.ID_Annee=annee.ID_Annee INNER JOIN table_option ON classe.ID_Option=table_option.ID_Option INNER JOIN section ON table_option.ID_Section=section.ID_Section INNER JOIN type_frais ON frais.ID_Type_Frais=type_frais.ID_Type_Frais WHERE section.ID_Etablissement=".$_GET['Ecole']." AND paiement_frais.ID_Taux=2 AND paiement.Confirm_Paiement=1";
if(isset($_GET['frais']) && !empty($_GET['frais'])){
	$rs_paiement_usd .=" AND type_frais.ID_Type_Frais=".$_GET['frais'];
}
if(isset($_GET['datedeb']) && !empty($_GET['datedeb']) && isset($_GET['datefin']) && !empty($_GET['datefin'])){
	$rs_paiement_usd .=" AND paiement.Date_Paiement >='".date('Y-m-d', strtotime($_GET['datedeb']))."' AND paiement.Date_Paiement <='".date('Y-m-d', strtotime($_GET['datefin']))."'";
}else{
    if(isset($_GET['datedeb']) && !empty($_GET['datedeb'])){
    	$rs_paiement_usd .=" AND paiement.Date_Paiement >='".date('Y-m-d', strtotime($_GET['datedeb']))."'";
    }
}
$rs_paiement_usd .=" ORDER BY paiement.Date_Paiement, eleve.Nom_Eleve";
$req_eleve_usd=$pdo->query($rs_paiement_usd);

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
$ecole=$pdo->query("SELECT * FROM etablissement WHERE ID_Etablissement=".$_GET['Ecole']);
$ecoles=$ecole->fetch();
$sheet->setCellValue('A1', $ecoles['Design_Etablissement']);
$sheet->setCellValue('A3', "SITUATION JOURNALIERE");
$sheet->mergeCells('A3:H3');
$sheet->mergeCells('A5:H5');
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
 if(isset($_GET['datedeb']) && !empty($_GET['datedeb']) && isset($_GET['datefin']) && !empty($_GET['datefin'])){
      $sheet->setCellValue('A5', "PAIEMENTS DU  ".date('d/m/Y', strtotime($_GET['datedeb']))."  AU  ".date('d/m/Y', strtotime($_GET['datefin']))." EN CDF");
      $sheet->getStyle('A5')->applyFromArray($styleA5);
}else{
  if(isset($_GET['datedeb']) && !empty($_GET['datedeb'])){
      $sheet->setCellValue('A5', "PAIEMENTS DU  ".date('d/m/Y', strtotime($_GET['datedeb']))."  AU  ".date('d/m/Y')." EN CDF");
      $sheet->getStyle('A5')->applyFromArray($styleA5);
  }else{
      $sheet->setCellValue('A5', "PAIEMENTS EN CDF");
      $sheet->getStyle('A5')->applyFromArray($styleA5);
  }
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
    $sheet->SetCellValue('A7', "N°")->SetCellValue('B7', "Matricule")->SetCellValue('C7', "Noms")->SetCellValue('D7', "Classe")->SetCellValue('E7', "Année scolaire")->SetCellValue('F7', "Libellé frais")->SetCellValue('G7', "Date paiement")->SetCellValue('H7', "Montant payé CDF");
    $cell_st =[
     'font' =>['bold' => true, 'size' => 10], 'alignment' =>['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER], 'borders'=>['allborders' =>['style'=> \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM]]
    ];
    $sheet->getStyle('A7:H7')->applyFromArray($cell_st);
$t=7;
$Nbr=0;
while($eleves_cdf=$req_eleve_cdf->fetch()){ 
    $frai=$pdo->query("SELECT * FROM frais WHERE ID_Frais=".$eleves_cdf['ID_Frais']);
    $frais=$frai->fetch();
    $Nbr++;
    $t++;
    $mont_dcf=0;
    // if($eleves_cdf['ID_Taux']==$frais['ID_Taux']){
        $mont_dcf=$eleves_cdf['Montant_Paie'];
    // }else{
    //     $mont_dcf=$eleves_cdf['Montant_Paie']*$eleves_cdf['Taux'];
    // }


    $sheet->SetCellValue('A'.$t, sprintf('%02d', $Nbr))->SetCellValue('B'.$t, stripslashes($eleves_cdf['Matricule']))->SetCellValue('C'.$t, stripslashes($eleves_cdf['Nom_Eleve'].' '.$eleves_cdf['Pnom_Eleve'].' '.$eleves_cdf['Prenom_Eleve']))->SetCellValue('D'.$t, stripslashes($eleves_cdf['Design_Classe']))->SetCellValue('E'.$t, stripslashes($eleves_cdf['Libelle_Annee']))->SetCellValue('F'.$t, stripslashes($eleves_cdf['Libelle_Type_Frais']))->SetCellValue('G'.$t, date('d/m/Y', strtotime($eleves_cdf['Date_Paiement'])))->SetCellValue('H'.$t, $mont_dcf);
}
$t++;
$sheet->SetCellValue('A'.$t, 'TOTAL')->SetCellValue('H'.$t, '=SUM(H'.($t-$Nbr).':H'.($t-1).')');
$Nbr++;
$sheet->getStyle('A'.$t.':H'.$t)->applyFromArray($style);
$sheet->mergeCells('A'.$t.':G'.$t);
$sheet->getStyle('A'.($t-$Nbr).':B'.$t)->applyFromArray($centrer);
$sheet->getStyle('E'.($t-$Nbr).':E'.$t)->applyFromArray($centrer);
$sheet->getStyle('G'.($t-$Nbr).':G'.$t)->applyFromArray($centrer);
$sheet->getStyle('A'.($t-$Nbr).':A'.$t)->applyFromArray($stingformat);
$sheet->getStyle('A'.($t-$Nbr).':H'.$t)->applyFromArray($bordures);
$sheet->getStyle('H'.($t-$Nbr).':H'.$t)->getNumberFormat()->applyFromArray($styleNumber);
$t=$t+2;
if(isset($_GET['datedeb']) && !empty($_GET['datedeb']) && isset($_GET['datefin']) && !empty($_GET['datefin'])){
      $sheet->setCellValue('A'.$t, "PAIEMENTS DU  ".date('d/m/Y', strtotime($_GET['datedeb']))."  AU  ".date('d/m/Y', strtotime($_GET['datefin']))." EN USD");
      $sheet->getStyle('A'.$t)->applyFromArray($styleA5);
}else{
  if(isset($_GET['datedeb']) && !empty($_GET['datedeb'])){
      $sheet->setCellValue('A'.$t, "PAIEMENTS DU  ".date('d/m/Y', strtotime($_GET['datedeb']))."  AU  ".date('d/m/Y')." EN USD");
      $sheet->getStyle('A'.$t)->applyFromArray($styleA5);
  }else{
      $sheet->setCellValue('A'.$t, "PAIEMENTS EN USD");
      $sheet->getStyle('A'.$t)->applyFromArray($styleA5);
  }
}
$sheet->mergeCells('A'.$t.':H'.$t);
$t=$t+2;
$sheet->SetCellValue('A'.$t, "N°")->SetCellValue('B'.$t, "Matricule")->SetCellValue('C'.$t, "Noms")->SetCellValue('D'.$t, "Classe")->SetCellValue('E'.$t, "Année scolaire")->SetCellValue('F'.$t, "Libellé frais")->SetCellValue('G'.$t, "Date paiement")->SetCellValue('H'.$t, "Montant payé USD");
$sheet->getStyle('A'.$t.':H'.$t)->applyFromArray($cell_st);
$Nbr_usd=0;
while($eleves_usd=$req_eleve_usd->fetch()){ 
    $frai_usd=$pdo->query("SELECT * FROM frais WHERE ID_Frais=".$eleves_usd['ID_Frais']);
    $frais_usd=$frai_usd->fetch();
    $Nbr_usd++;
    $t++;
    $mont_usd=0;
    // if($eleves_usd['ID_Taux']==$frais_usd['ID_Taux']){
        $mont_usd=$eleves_usd['Montant_Paie'];
    // }else{
    //     $mont_usd=$eleves_usd['Montant_Paie']/$eleves_usd['Taux'];
    // }


    $sheet->SetCellValue('A'.$t, sprintf('%02d', $Nbr_usd))->SetCellValue('B'.$t, stripslashes($eleves_usd['Matricule']))->SetCellValue('C'.$t, stripslashes($eleves_usd['Nom_Eleve'].' '.$eleves_usd['Pnom_Eleve'].' '.$eleves_usd['Prenom_Eleve']))->SetCellValue('D'.$t, stripslashes($eleves_usd['Design_Classe']))->SetCellValue('E'.$t, stripslashes($eleves_usd['Libelle_Annee']))->SetCellValue('F'.$t, stripslashes($eleves_usd['Libelle_Type_Frais']))->SetCellValue('G'.$t, date('d/m/Y', strtotime($eleves_usd['Date_Paiement'])))->SetCellValue('H'.$t, $mont_usd);
}
$t++;
$sheet->SetCellValue('A'.$t, 'TOTAL')->SetCellValue('H'.$t, '=SUM(H'.($t-$Nbr_usd).':H'.($t-1).')');
$Nbr++;
$sheet->getStyle('A'.$t.':H'.$t)->applyFromArray($style);
$sheet->mergeCells('A'.$t.':G'.$t);
$sheet->getStyle('A'.($t-$Nbr_usd).':B'.$t)->applyFromArray($centrer);
$sheet->getStyle('E'.($t-$Nbr_usd).':E'.$t)->applyFromArray($centrer);
$sheet->getStyle('G'.($t-$Nbr_usd).':G'.$t)->applyFromArray($centrer);
$sheet->getStyle('A'.($t-$Nbr_usd).':A'.$t)->applyFromArray($stingformat);
$sheet->getStyle('A'.($t-$Nbr_usd).':H'.$t)->applyFromArray($bordures);
$sheet->getStyle('H'.($t-$Nbr_usd).':H'.$t)->getNumberFormat()->applyFromArray($styleNumber);

$sheet->getColumnDimension('A')->setWidth(5);
$sheet->getColumnDimension('B')->setWidth(15);
$sheet->getColumnDimension('C')->setWidth(28);
$sheet->getColumnDimension('D')->setWidth(17);
$sheet->getColumnDimension('E')->setWidth(13);
$sheet->getColumnDimension('F')->setWidth(17);
$sheet->getColumnDimension('G')->setWidth(15);
$sheet->getColumnDimension('H')->setWidth(22);
$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
$sheet->setTitle("SITUATION_JOURNALIERE"); //set a title for Worksheet
//make object of the Xlsx class to save the excel file
/*$writer = new Xlsx($spreadsheet);
$fxls ='conducteur_candidat.xlsx';
$writer->load($fxls); */

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
    header('Content-Disposition: attachment;filename="Situation_journaliere_'.date('d').'_'.date('m').'_'.date('Y').'_'.date('H').'_'.date('i').'_'.date('s').'.xlsx"'); 
    header('Cache-Control: max-age=0'); 
    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); 
    $writer->save('php://output');


?>
