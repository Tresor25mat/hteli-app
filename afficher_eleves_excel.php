<?php
session_start();
require_once('connexion.php');
$query="SELECT eleve.*, classe.*, annee.*, inscription.*, categorie_eleve.*, inscription.Date_Enreg AS mydate FROM eleve INNER JOIN inscription ON eleve.ID_Eleve=inscription.ID_Eleve INNER JOIN classe ON classe.ID_Classe=inscription.ID_Classe INNER JOIN annee ON annee.ID_Annee=inscription.ID_Annee INNER JOIN table_option ON table_option.ID_Option=classe.ID_Option INNER JOIN section ON section.ID_Section=table_option.ID_Section INNER JOIN categorie_eleve ON inscription.ID_Cat_Eleve=categorie_eleve.ID_Categorie WHERE eleve.ID_Eleve!=''";
if(isset($_GET['Ecole']) && $_GET['Ecole']!=''){
    $query.=" AND section.ID_Etablissement=".$_GET['Ecole'];
}
if(isset($_GET['Annee']) && $_GET['Annee']!=''){
    $query.=" AND annee.ID_Annee =".$_GET['Annee'];
    $sel_annee=$pdo->query("SELECT * FROM annee WHERE ID_Annee=".$_GET['Annee']);
    $annees=$sel_annee->fetch();
}
if(isset($_GET['Classe']) && $_GET['Classe']!=''){
    $query.=" AND inscription.ID_Classe =".$_GET['Classe'];
    $sel_classe=$pdo->query("SELECT * FROM classe WHERE ID_Classe=".$_GET['Classe']);
    $classes=$sel_classe->fetch();
    $sel_titulaire=$pdo->query("SELECT * FROM enseignant WHERE ID_Enseignant='".$classes['ID_Enseignant']."'");
}
$query.=" ORDER BY Nom_Eleve, Pnom_Eleve";
$req_eleve=$pdo->query($query);
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
if(isset($_GET['Ecole']) && $_GET['Ecole']!=''){
    $ecole=$pdo->query("SELECT * FROM etablissement WHERE ID_Etablissement=".$_GET['Ecole']);
    $ecoles=$ecole->fetch();
    $sheet->setCellValue('A1', $ecoles['Design_Etablissement']);
    $sheet->mergeCells('A1:C1');
}
$sheet->setCellValue('A3', "LISTE DES ELEVES");
$sheet->mergeCells('A3:G3');
if(isset($_GET['Classe']) && $_GET['Classe']!=''){
    $sheet->setCellValue('A5', "Classe");
    $sheet->setCellValue('C5', stripslashes($classes['Design_Classe']));
    $sheet->mergeCells('A5:B5');
}
if(isset($_GET['Annee']) && $_GET['Annee']!=''){
    $sheet->setCellValue('A6', "Année scolaire");
    $sheet->setCellValue('C6', stripslashes($annees['Libelle_Annee']));
    $sheet->mergeCells('A6:B6');
}
if(isset($_GET['Classe']) && $_GET['Classe']!='' && $titulaire=$sel_titulaire->fetch()){
    $sheet->setCellValue('A7', "Titulaire");
    $sheet->setCellValue('C7', stripslashes($titulaire['Nom_Enseignant'].' '.$titulaire['Pnom_Enseignant'].' '.$titulaire['Prenom_Enseignant']));
    $sheet->mergeCells('A7:B7');
}

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
$sheet->getStyle('C5')->applyFromArray($styleA4);
$sheet->getStyle('C6')->applyFromArray($styleA4);
$sheet->getStyle('C7')->applyFromArray($styleA4);
$sheet->SetCellValue('A9', "N°")->SetCellValue('B9', "Matricule")->SetCellValue('C9', "Noms")->SetCellValue('F9', "Sexe")->SetCellValue('G9', "Date d'inscription");
$sheet->mergeCells('C9:E9');
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
   
$t=9;
$Nbr=0;
while($eleves=$req_eleve->fetch()){ 
    $t++;
    $Nbr++;
    if($eleves['Sexe']=='M'){
        $sexe='Masculin';
    }else{
        $sexe='Féminin';
    }
    $sheet->SetCellValue('A'.$t, sprintf('%02d', $Nbr))->SetCellValue('B'.$t, stripslashes($eleves['Matricule']))->SetCellValue('C'.$t, stripslashes($eleves['Nom_Eleve'].' '.$eleves['Pnom_Eleve'].' '.$eleves['Prenom_Eleve']))->SetCellValue('F'.$t, $sexe)->SetCellValue('G'.$t, date('d/m/Y', strtotime($eleves['mydate'])));
    $sheet->mergeCells('C'.$t.':E'.$t);
}
$sheet->getStyle('A10:B'.$t)->applyFromArray($centrer);
$sheet->getStyle('A10:A'.$t)->applyFromArray($stingformat);
$sheet->getStyle('F10:G'.$t)->applyFromArray($centrer);
$sheet->getStyle('A10:G'.$t)->applyFromArray($bordures);
  $cell_st =[
 'font' =>['bold' => true, 'size' => 10], 'alignment' =>['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER], 'borders'=>['allborders' =>['style'=> \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM]]
];
$sheet->getStyle('A9:G9')->applyFromArray($cell_st);

$sheet->getColumnDimension('A')->setWidth(5);
$sheet->getColumnDimension('B')->setWidth(9);
$sheet->getColumnDimension('C')->setWidth(17);
$sheet->getColumnDimension('D')->setWidth(17);
$sheet->getColumnDimension('E')->setWidth(17);
$sheet->getColumnDimension('F')->setWidth(9);
$sheet->getColumnDimension('G')->setWidth(15);
// $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
$sheet->setTitle("LISTE_DES_ELEVES"); //set a title for Worksheet
//make object of the Xlsx class to save the excel file
/*$writer = new Xlsx($spreadsheet);
$fxls ='conducteur_candidat.xlsx';
$writer->load($fxls); */

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
    header('Content-Disposition: attachment;filename="Liste_des_eleves_'.date('d').'_'.date('m').'_'.date('Y').'_'.date('H').'_'.date('i').'_'.date('s').'.xlsx"'); 
    header('Cache-Control: max-age=0'); 
    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx'); 
    $writer->save('php://output');


?>
