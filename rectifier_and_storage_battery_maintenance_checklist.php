<?php
session_start();
require_once('connexion.php');
$app_info=$pdo->query("SELECT * FROM app_infos");
$app_infos=$app_info->fetch();
$ID_Rapport=$_GET['Rapport'];
$req_rapport=$pdo->query("SELECT * FROM table_rapport_rectifier INNER JOIN table_rectifier_make ON table_rapport_rectifier.ID_Rectifier_Make=table_rectifier_make.ID_Rectifier_Make INNER JOIN table_rectifier_model ON table_rapport_rectifier.ID_Rectifier_Model=table_rectifier_model.ID_Rectifier_Model INNER JOIN table_make_batterie ON table_rapport_rectifier.ID_Make_Batterie=table_make_batterie.ID_Make_Batterie INNER JOIN site ON table_rapport_rectifier.ID_Site=site.ID_Site INNER JOIN province ON site.ID_Prov=province.ID_Prov INNER JOIN utilisateur ON table_rapport_rectifier.ID_Utilisateur=utilisateur.ID_Utilisateur WHERE table_rapport_rectifier.ID_Rapport=".$ID_Rapport);
$rapports=$req_rapport->fetch();
$client=$pdo->query("SELECT * FROM client WHERE ID_Cient=".$rapports['ID_Cient']);
$clients=$client->fetch();
$text=$pdo->query("SELECT * FROM questionnaire_rectifier WHERE ID_Rapport=".$rapports['ID_Rapport']);


require('rotation.php');
class PDF extends PDF_Rotate
{
  function Header()
  {

    // $this->Image('images/filigranne.png','100','45','120','100','PNG');
  }

  function RotatedText($x, $y, $txt, $angle)
  {
    //Text rotated around its origin
    $this->Rotate($angle,$x,$y);
    $this->Text($x,$y,$txt);
    $this->Rotate(0);
  }


  function Footer(){
    
    $this->SetFont('Arial','BI','8');
    $this->setY(-13);
    $this->SetFont('Arial','I','8');
    // $this->cell(0,3,'Date: '.date('d/m/Y'),0,0,'R');
    // $this->cell(0,10,'Page '.$this->PageNo().' / {nb}       ',0,0,'R');
    
  
  }

  function CorpsChapitre($fichier)
  {
    // Lecture du fichier texte
    $txt = file_get_contents($fichier);
    // Times 12
    $this->SetFont('Times','',12);
    // Sortie du texte justifié
    $this->MultiCell(0,5,$txt);
    // Saut de ligne
    $this->Ln();
    // Mention en italique
    $this->SetFont('','I');
    $this->Cell(0,5,"(fin de l'extrait)");
  }

  function AjouterChapitre($num, $titre)
  {
    // $this->AddPage();
    $this->TitreChapitre($num,$titre);
    // $this->CorpsChapitre($fichier);
  }

  function RotatedImage($file,$x,$y,$w,$h,$angle)
  {
        //Image rotated around its upper-left corner
        $this->Rotate($angle,$x,$y);
        $this->Image($file,$x,$y,$w,$h);
        $this->Rotate(0);
  }

}

$pdf=new PDF();

$pdf-> AliasNbPages();
$pdf->SetAutoPageBreak(false);
$pdf->AddPage('P','A4',0);
$pdf->SetMargins(0, 0, 0, 0);

$pdf->SetSubject(utf8_decode($app_infos['Design_App']." : RECTIFIER AND STORAGE BATTERY MAINTENANCE CHECKLIST"));
$pdf->SetTitle(utf8_decode($app_infos['Design_App']." : RECTIFIER AND STORAGE BATTERY MAINTENANCE CHECKLIST"));
$pdf->Image('images/PM04-1.jpg','0','0','210','295','');
$pdf->Image('images/client/'.$clients['Logo'],'1','6','63','20','');

$pdf->SetFont('Arial','B',10);
$pdf->SetXY(24,50);
$pdf->MultiCell(70,5,utf8_decode($rapports['Site_ID']),0,'L');
$pdf->SetXY(94,50);
$pdf->MultiCell(70,5,utf8_decode($rapports['Num_Work_Order']),0,'L');
$pdf->SetXY(158,50);
$pdf->MultiCell(70,5,date('d/m/Y', strtotime($rapports['Date_Rapport'])),0,'L');
$pdf->SetXY(35,59);
$pdf->MultiCell(70,5,utf8_decode($rapports['Design_Rectifier_Make']),0,'L');
$pdf->SetXY(84,59);
$pdf->MultiCell(70,5,utf8_decode($rapports['Num_Serial']),0,'L');
$pdf->SetXY(132,59);
$pdf->MultiCell(70,5,utf8_decode(substr($rapports['History_Card_Ref'], 0, 10)),0,'L');
$pdf->SetXY(165,59);
$pdf->MultiCell(70,5,utf8_decode(substr($rapports['Site_Name'], 0, 15)),0,'L');
$pdf->SetXY(36,67);
$pdf->MultiCell(70,6,utf8_decode($rapports['Design_Rectifier_Model']),0,'L');
$pdf->SetXY(104,67);
$pdf->MultiCell(70,6,utf8_decode($rapports['Rectifier_Capacity'].'W'),0,'L');
$pdf->SetXY(176,67);
$pdf->MultiCell(70,6,utf8_decode('NOC - EI'),0,'L');
$pdf->SetXY(40,73);
$pdf->MultiCell(70,6,utf8_decode($rapports['Design_Make_Batterie']),0,'L');
$pdf->SetXY(97,73);
$pdf->MultiCell(70,6,utf8_decode($rapports['Number_Bat_banks'].'Bank'),0,'L');
$pdf->SetXY(175,73);
$pdf->MultiCell(70,6,utf8_decode('H - TELI'),0,'L');
$pdf->SetXY(38,80);
$pdf->MultiCell(70,5,utf8_decode($rapports['Number_Bat_By_bank']),0,'L');
$pdf->SetXY(82,80);
$pdf->MultiCell(70,5,date('H:i', strtotime($rapports['Time_In'])),0,'L');
$pdf->SetXY(121,80);
$pdf->MultiCell(70,5,date('H:i', strtotime($rapports['Time_Out'])),0,'L');


$pdf->SetFont('Arial','',9);

$h=98;
$nbr=1;

while ($texts=$text->fetch()){$nbr++;
    $pdf->SetXY(106,$h);
    $pdf->MultiCell(70,4,utf8_decode(substr($texts['Test_Results'], 0, 7)),0,'L');
    if($texts['Pass']==1){
        $pdf->Image('images/check.png','125',$h,'4','4','');
    }else if($texts['Pass']==2){
      $pdf->SetXY(137,$h);
      $pdf->MultiCell(70,4,utf8_decode('N/A'),0,'L');
    }
    $pdf->SetXY(149,$h);
    $pdf->MultiCell(70,4,utf8_decode($texts['Remarks']),0,'L');
    if($nbr==3 || $nbr==4 || $nbr==5 || $nbr==6 || $nbr==9 || $nbr==10 || $nbr==11 || $nbr==13 || $nbr==14 || $nbr==17 || $nbr==18){
        $h=$h+8;
    }else if($nbr==8){
        $h=$h+7;
    }else if($nbr==7){
        $h=$h+6;
    }else{
        $h=$h+9;
    }
}
$h=$h+5;
$pdf->SetXY(12,$h);
$pdf->MultiCell(170,5,utf8_decode(stripslashes($rapports['Description'])),0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->AddPage('P','A4',0);
$pdf->Image('images/PM04-2.jpg','0','0','210','295','');
$pdf->Image('images/client/'.$clients['Logo'],'1','6','63','20','');
$h=35;
$pdf->SetXY(26,$h);
$pdf->MultiCell(170,5,utf8_decode(stripslashes(': H - TELI')),0,'L');
$pdf->SetXY(121,$h);
$pdf->MultiCell(170,6,utf8_decode(stripslashes(': '.$clients['Design_Client'])),0,'L');
$h=$h+9;
$pdf->SetXY(21,$h);
$pdf->MultiCell(170,5,utf8_decode(stripslashes(': '.$rapports['Prenom'].' '.$rapports['Nom'])),0,'L');
$pdf->Output();
?>