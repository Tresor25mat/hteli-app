<?php
session_start();
require_once('connexion.php');
$id_ecole = htmlentities($_GET['ecole']);
$classe = htmlentities($_GET['classe']);
$annee = htmlentities($_GET['annee']);
$sel_classe=$pdo->query("SELECT * FROM classe WHERE ID_Classe=".$classe);
$classes=$sel_classe->fetch();
$sel_annee=$pdo->query("SELECT * FROM annee WHERE ID_Annee=".$annee);
$annees=$sel_annee->fetch();
if(isset($_GET['frais']) && $_GET['frais']!=''){
	$req_frais=$pdo->query("SELECT frais.*, type_frais.*, taux_change.* FROM frais INNER JOIN type_frais ON frais.ID_Type_Frais=type_frais.ID_Type_Frais INNER JOIN paiement ON frais.ID_Frais=paiement.ID_Frais INNER JOIN taux_change ON frais.ID_Taux=taux_change.ID_Taux INNER JOIN inscription ON paiement.ID_Inscription=inscription.ID_Inscription WHERE inscription.ID_Classe=".$classe." AND inscription.ID_Annee=".$annee." AND frais.ID_Type_Frais=".$_GET['frais']." GROUP BY frais.ID_Frais ORDER BY type_frais.Libelle_Type_Frais");
}else{
	$req_frais=$pdo->query("SELECT frais.*, type_frais.*, taux_change.* FROM frais INNER JOIN type_frais ON frais.ID_Type_Frais=type_frais.ID_Type_Frais INNER JOIN paiement ON frais.ID_Frais=paiement.ID_Frais INNER JOIN taux_change ON frais.ID_Taux=taux_change.ID_Taux INNER JOIN inscription ON paiement.ID_Inscription=inscription.ID_Inscription WHERE inscription.ID_Classe=".$classe." AND inscription.ID_Annee=".$annee." GROUP BY frais.ID_Frais ORDER BY type_frais.Libelle_Type_Frais");
}
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
$ecole=$pdo->query("SELECT * FROM etablissement WHERE ID_Etablissement=".$id_ecole);
$ecoles=$ecole->fetch();
$sheet->setCellValue('A1', $ecoles['Design_Etablissement']);
$sheet->setCellValue('A3', "SITUATION DE PAIEMENT PAR CLASSE");
$sheet->setCellValue('A5', "Classe");
$sheet->setCellValue('C5', stripslashes($classes['Design_Classe']));
$sheet->setCellValue('A6', "Année scolaire");
$sheet->setCellValue('C6', stripslashes($annees['Libelle_Annee']));
// $sheet->setCellValue('A7', "Libellé frais");
// $sheet->setCellValue('C7', stripslashes($type_frais['Libelle_Type_Frais']));
$sheet->mergeCells('A3:F3');
$sheet->mergeCells('A5:B5');
$sheet->mergeCells('A6:B6');
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

$sheet->getStyle('A3')->applyFromArray($styleA1);
$sheet->getStyle('A1')->applyFromArray($styleA2);
$sheet->getStyle('A5')->applyFromArray($styleA3);
$sheet->getStyle('A6')->applyFromArray($styleA3);
$sheet->getStyle('C5')->applyFromArray($styleA4);
$sheet->getStyle('C6')->applyFromArray($styleA4);
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
    $cell_st =[
     'font' =>['bold' => true, 'size' => 10], 'alignment' =>['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER], 'borders'=>['allborders' =>['style'=> \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM]]
    ];
$t=6;
$NbrF=0;
while($frais=$req_frais->fetch()){
	$devise=$pdo->query("SELECT * FROM taux_change WHERE ID_Taux=".$frais['ID_Taux']);
	$devises=$devise->fetch();
	$req_eleve=$pdo->query("SELECT eleve.*, paiement.*, annee.*, classe.*, taux_change.*, type_frais.*, frais.*, inscription.* FROM eleve INNER JOIN inscription ON eleve.ID_Eleve=inscription.ID_Eleve INNER JOIN paiement ON inscription.ID_Inscription=paiement.ID_Inscription INNER JOIN frais ON paiement.ID_Frais=frais.ID_Frais INNER JOIN classe ON inscription.ID_Classe=classe.ID_Classe INNER JOIN annee ON inscription.ID_Annee=annee.ID_Annee INNER JOIN table_option ON classe.ID_Option=table_option.ID_Option INNER JOIN section ON table_option.ID_Section=section.ID_Section INNER JOIN taux_change ON frais.ID_Taux=taux_change.ID_Taux INNER JOIN type_frais ON frais.ID_Type_Frais=type_frais.ID_Type_Frais WHERE section.ID_Etablissement=".$id_ecole." AND inscription.ID_Classe=".$classe." AND inscription.ID_Annee=".$annee." AND frais.ID_Frais=".$frais['ID_Frais']." AND paiement.Confirm_Paiement=1 AND inscription.Confirm_Inscription=1 GROUP BY inscription.ID_Inscription, frais.ID_Frais ORDER BY eleve.Nom_Eleve");
    $NbrF++;
    $t=$t+2;
    $sheet->SetCellValue('A'.$t, $NbrF.". ".stripslashes($frais['Libelle_Type_Frais']));
    $sheet->getStyle('A'.$t)->applyFromArray($styleA5);
    $sheet->mergeCells('A'.$t.':F'.$t);
    $t=$t+2;
    $sheet->SetCellValue('A'.$t, "N°")->SetCellValue('B'.$t, "Matricule")->SetCellValue('C'.$t, "Noms")->SetCellValue('D'.$t, "Sexe")->SetCellValue('E'.$t, "Montant payé ".$devises['Devise'])->SetCellValue('F'.$t, "Reste ".$devises['Devise']);
    $sheet->getStyle('A'.$t.':F'.$t)->applyFromArray($cell_st);
    $Nbr=0;
    $mont=0;
    $dette=0;
    while($eleves=$req_eleve->fetch()){ 
        $rs_paiement=$pdo->query("SELECT * FROM paiement WHERE ID_Inscription='".$eleves['ID_Inscription']."' AND Confirm_Paiement=1 AND ID_Frais=".$eleves['ID_Frais']);
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
        $Nbr++;
        $t++;
        $mont=0;
        $md=0;
        if($eleves['Sexe']=='M'){
            $sexe = 'Masculin';
        }else{
            $sexe = 'Féminin';
        }
        // if($eleves['Devise']==$devises['Devise']){
            $mont=$Montant_Paie;
            $dette=$dette+($frais['Montant_Frais']-$Montant_Paie);
            $md=$frais['Montant_Frais']-$Montant_Paie;
        // }else{
        //     if($devises['Devise']=='CDF'){
        //         $mont=$rs_paiements['Montant_Paie']*$rs_paiements['Taux'];
        //         $dette=$dette+($montant_frais['Montant_Tranche']-($rs_paiements['Montant_Paie']*$rs_paiements['Taux']));
        //         $md=$montant_frais['Montant_Tranche']-($rs_paiements['Montant_Paie']*$rs_paiements['Taux']);
        //     }else{
        //         $mont=$rs_paiements['Montant_Paie']/$rs_paiements['Taux'];
        //         $dette=$dette+($montant_frais['Montant_Tranche']-($rs_paiements['Montant_Paie']/$rs_paiements['Taux']));
        //         $md=$montant_frais['Montant_Tranche']-($rs_paiements['Montant_Paie']*$rs_paiements['Taux']);
        //     }
        // }
        $sheet->SetCellValue('A'.$t, sprintf('%02d', $Nbr))->SetCellValue('B'.$t, stripslashes($eleves['Matricule']))->SetCellValue('C'.$t, stripslashes($eleves['Nom_Eleve'].' '.$eleves['Pnom_Eleve'].' '.$eleves['Prenom_Eleve']))->SetCellValue('D'.$t, $sexe)->SetCellValue('E'.$t, $mont)->SetCellValue('F'.$t, $md);
    }
    $t++;
    $sheet->SetCellValue('A'.$t, 'TOTAL')->SetCellValue('E'.$t, '=SUM(E'.($t-$Nbr).':E'.($t-1).')')->SetCellValue('F'.$t, $dette);
    $Nbr++;
    $sheet->getStyle('A'.$t.':F'.$t)->applyFromArray($style);
    $sheet->mergeCells('A'.$t.':D'.$t);
    $sheet->getStyle('A'.($t-$Nbr).':B'.$t)->applyFromArray($centrer);
    $sheet->getStyle('D'.($t-$Nbr).':D'.$t)->applyFromArray($centrer);
    $sheet->getStyle('A'.($t-$Nbr).':A'.$t)->applyFromArray($stingformat);
    $sheet->getStyle('A'.($t-$Nbr).':F'.$t)->applyFromArray($bordures);
    $sheet->getStyle('E'.($t-$Nbr).':F'.$t)->getNumberFormat()->applyFromArray($styleNumber);
}

$sheet->getColumnDimension('A')->setWidth(5);
$sheet->getColumnDimension('B')->setWidth(12);
$sheet->getColumnDimension('C')->setWidth(28);
$sheet->getColumnDimension('D')->setWidth(15);
$sheet->getColumnDimension('E')->setWidth(17);
$sheet->getColumnDimension('F')->setWidth(17);
// $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
$sheet->setTitle("SITUATION_PAR_CLASSE"); //set a title for Worksheet
//make object of the Xlsx class to save the excel file
/*$writer = new Xlsx($spreadsheet);
$fxls ='conducteur_candidat.xlsx';
$writer->load($fxls); */

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
    header('Content-Disposition: attachment;filename="Situation_par_classe_'.date('d').'_'.date('m').'_'.date('Y').'_'.date('H').'_'.date('i').'_'.date('s').'.xlsx"'); 
    header('Cache-Control: max-age=0'); 
    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); 
    $writer->save('php://output');

?>
