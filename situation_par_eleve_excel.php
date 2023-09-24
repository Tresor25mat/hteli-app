<?php
session_start();
require_once('connexion.php');
$id_ecole = htmlentities($_GET['ecole']);
$classe = htmlentities($_GET['classe']);
$annee = htmlentities($_GET['annee']);
$eleve = htmlentities($_GET['eleve']);
$sel_classe=$pdo->query("SELECT * FROM classe WHERE ID_Classe=".$classe);
$classes=$sel_classe->fetch();
$sel_annee=$pdo->query("SELECT * FROM annee WHERE ID_Annee=".$annee);
$annees=$sel_annee->fetch();
$sel_eleve=$pdo->query("SELECT * FROM eleve INNER JOIN inscription ON eleve.ID_Eleve=inscription.ID_Eleve WHERE inscription.ID_Inscription='".$eleve."'");
$rs_eleve=$sel_eleve->fetch();
$req_frais=$pdo->query("SELECT frais.*, type_frais.*, taux_change.* FROM frais INNER JOIN type_frais ON frais.ID_Type_Frais=type_frais.ID_Type_Frais INNER JOIN paiement_frais ON frais.ID_Frais=paiement_frais.ID_Frais INNER JOIN paiement ON paiement_frais.ID_Paiement=paiement.ID_Paiement INNER JOIN taux_change ON frais.ID_Taux=taux_change.ID_Taux WHERE paiement.ID_Inscription='".$eleve."' GROUP BY frais.ID_Frais ORDER BY type_frais.Libelle_Type_Frais");
$app_info=$pdo->query("SELECT * FROM app_infos");
$app_infos=$app_info->fetch();
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
$ecole=$pdo->query("SELECT * FROM etablissement WHERE ID_Etablissement=".$id_ecole);
$ecoles=$ecole->fetch();
$sheet->setCellValue('A1', $ecoles['Design_Etablissement']);
$sheet->setCellValue('A3', "SITUATION DE PAIEMENT PAR ELEVE");
$sheet->setCellValue('A5', "Classe");
$sheet->setCellValue('C5', stripslashes($classes['Design_Classe']));
$sheet->setCellValue('A6', "Année scolaire");
$sheet->setCellValue('C6', stripslashes($annees['Libelle_Annee']));
$sheet->setCellValue('A7', "Matricule");
$sheet->setCellValue('C7', stripslashes($rs_eleve['Matricule']));
$sheet->setCellValue('A8', "Noms de l'élève");
$sheet->setCellValue('C8', stripslashes($rs_eleve['Nom_Eleve'].' '.$rs_eleve['Pnom_Eleve'].' '.$rs_eleve['Prenom_Eleve']));
$sheet->mergeCells('A3:F3');
$sheet->mergeCells('A5:B5');
$sheet->mergeCells('A6:B6');
$sheet->mergeCells('A7:B7');
$sheet->mergeCells('A8:B8');
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
        'alignment'=>array(
            'horizontal'=>\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
        )
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

$sheet->getStyle('A3')->applyFromArray($styleA1);
$sheet->getStyle('A1')->applyFromArray($styleA2);
$sheet->getStyle('A5')->applyFromArray($styleA3);
$sheet->getStyle('A6')->applyFromArray($styleA3);
$sheet->getStyle('A7')->applyFromArray($styleA3);
$sheet->getStyle('A8')->applyFromArray($styleA3);
$sheet->getStyle('C5')->applyFromArray($styleA4);
$sheet->getStyle('C6')->applyFromArray($styleA4);
$sheet->getStyle('C7')->applyFromArray($styleA4);
$sheet->getStyle('C8')->applyFromArray($styleA4);
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
$t=10;
$NbrF=0;
while($frais=$req_frais->fetch()){
	$req_eleve=$pdo->query("SELECT paiement.*, paiement_frais.*, taux_change.*, type_frais.*, recu.* FROM paiement INNER JOIN inscription ON inscription.ID_Inscription=paiement.ID_Inscription INNER JOIN paiement_frais ON paiement.ID_Paiement=paiement_frais.ID_Paiement INNER JOIN frais ON paiement_frais.ID_Frais=frais.ID_Frais INNER JOIN classe ON inscription.ID_Classe=classe.ID_Classe INNER JOIN annee ON inscription.ID_Annee=annee.ID_Annee INNER JOIN table_option ON classe.ID_Option=table_option.ID_Option INNER JOIN section ON table_option.ID_Section=section.ID_Section INNER JOIN taux_change ON frais.ID_Taux=taux_change.ID_Taux INNER JOIN type_frais ON frais.ID_Type_Frais=type_frais.ID_Type_Frais INNER JOIN recu ON paiement.ID_Paiement=recu.ID_Paiement WHERE section.ID_Etablissement=".$id_ecole." AND inscription.ID_Classe=".$classe." AND inscription.ID_Annee=".$annee." AND inscription.ID_Inscription='".$eleve."' AND frais.ID_Frais=".$frais['ID_Frais']." AND paiement.Confirm_Paiement=1 GROUP BY paiement.ID_Paiement ORDER BY paiement.Date_Paiement");
    $NbrF++;
    $sheet->setCellValue('A'.$t, $NbrF.". ".stripslashes($frais['Libelle_Type_Frais']));
    $sheet->mergeCells('A'.$t.':E'.$t);
    $sheet->getStyle('A'.$t)->applyFromArray($styleA5);
    $t=$t+2;
    $sheet->SetCellValue('A'.$t, "N°")->SetCellValue('B'.$t, "Date paiement")->SetCellValue('C'.$t, "Numéro reçu")->SetCellValue('D'.$t, "Montant payé ".$frais['Devise'])->SetCellValue('E'.$t, "Reste ".$frais['Devise']);
    $cell_st =[
     'font' =>['bold' => true, 'size' => 10], 'alignment' =>['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER], 'borders'=>['allborders' =>['style'=> \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM]]
    ];
    $sheet->getStyle('A'.$t.':E'.$t)->applyFromArray($cell_st);
    $Nbr=0;
    $mont=0;
    while($eleves=$req_eleve->fetch()){ 
        $rs_paiement=$pdo->query("SELECT * FROM paiement INNER JOIN paiement_frais ON paiement.ID_Paiement=paiement_frais.ID_Paiement WHERE paiement.ID_Paiement='".$eleves['ID_Paiement']."' AND paiement_frais.ID_Frais=".$frais['ID_Frais']);
        $Montant_Paie=0;
        while ($rs_paiements=$rs_paiement->fetch()) {
            if($frais['ID_Taux']==$rs_paiements['ID_Taux']){
                $Montant_Paie=$Montant_Paie+$rs_paiements['Montant_Paie'];
            }else{
			 	if($frais['ID_Taux']==1){
					$Montant_Paie=$Montant_Paie+($rs_paiements['Montant_Paie']*$rs_paiements['Taux']);
			 	}else{
					$Montant_Paie=$Montant_Paie+($rs_paiements['Montant_Paie']/$rs_paiements['Taux']);
			 	}
            }
        }
        $mont=$mont+$Montant_Paie;
        $t++;
        $Nbr++;
        $sheet->SetCellValue('A'.$t, sprintf('%02d', $Nbr))->SetCellValue('B'.$t, date('d/m/Y', strtotime($eleves['Date_Paiement'])))->SetCellValue('C'.$t, stripslashes($eleves['Num_Recu']))->SetCellValue('D'.$t, $Montant_Paie)->SetCellValue('E'.$t, $frais['Montant_Frais']-$mont);
    }
    $t++;
    $sheet->SetCellValue('A'.$t, 'Total')->SetCellValue('D'.$t, '=SUM(D'.($t-$Nbr).':D'.($t-1).')')->SetCellValue('E'.$t, $frais['Montant_Frais']-$mont);
    $Nbr++;
    $sheet->getStyle('A'.$t.':E'.$t)->applyFromArray($style);
    $sheet->mergeCells('A'.$t.':C'.$t);
    $sheet->getStyle('A'.($t-$Nbr).':C'.$t)->applyFromArray($centrer);
    $sheet->getStyle('A'.($t-$Nbr).':A'.$t)->applyFromArray($stingformat);
    $sheet->getStyle('A'.($t-$Nbr).':E'.$t)->applyFromArray($bordures);
    $sheet->getStyle('D'.($t-$Nbr).':E'.$t)->getNumberFormat()->applyFromArray($styleNumber);
    $t=$t+2;
}

$sheet->getColumnDimension('A')->setWidth(5);
$sheet->getColumnDimension('B')->setWidth(20);
$sheet->getColumnDimension('C')->setWidth(20);
$sheet->getColumnDimension('D')->setWidth(20);
$sheet->getColumnDimension('E')->setWidth(20);
// $sheet->getColumnDimension('F')->setWidth(13);
// $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
$sheet->setTitle("SITUATION_PAR_ELEVE"); //set a title for Worksheet
//make object of the Xlsx class to save the excel file
/*$writer = new Xlsx($spreadsheet);
$fxls ='conducteur_candidat.xlsx';
$writer->load($fxls); */

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
    header('Content-Disposition: attachment;filename="Situation_par_eleve_'.date('d').'_'.date('m').'_'.date('Y').'_'.date('H').'_'.date('i').'_'.date('s').'.xlsx"'); 
    header('Cache-Control: max-age=0'); 
    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); 
    $writer->save('php://output');


?>
