<?php
session_start();
require_once('connexion.php');
$app_info=$pdo->query("SELECT * FROM app_infos");
$app_infos=$app_info->fetch();
$ID_Rapport=$_GET['Rapport'];
$req_rapport=$pdo->query("SELECT * FROM table_rapport_mensuel_site INNER JOIN site ON table_rapport_mensuel_site.ID_Site=site.ID_Site INNER JOIN province ON site.ID_Prov=province.ID_Prov INNER JOIN utilisateur ON table_rapport_mensuel_site.ID_Utilisateur=utilisateur.ID_Utilisateur WHERE table_rapport_mensuel_site.ID_Rapport=".$ID_Rapport);
$rapports=$req_rapport->fetch();
$client=$pdo->query("SELECT * FROM client WHERE ID_Cient=".$rapports['ID_Cient']);
$clients=$client->fetch();
$text=$pdo->query("SELECT * FROM questionnaire_rapport_site WHERE ID_Rapport=".$rapports['ID_Rapport']);


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

$pdf->SetSubject(utf8_decode($app_infos['Design_App']." : MONTHLY  SITE INSPECTIONS CHECKLIST"));
$pdf->SetTitle(utf8_decode($app_infos['Design_App']." : MONTHLY  SITE INSPECTIONS CHECKLIST"));
$pdf->Image('images/PM03-1.jpg','0','0','210','295','');
$pdf->Image('images/client/'.$clients['Logo'],'2','7','63','20','');


$pdf->SetFont('Arial','B',10);
$pdf->SetXY(23,51);
$pdf->MultiCell(70,5,utf8_decode($rapports['Site_ID']),0,'L');
$pdf->SetXY(80,51);
$pdf->MultiCell(70,5,utf8_decode(substr($rapports['Num_Ref'], 0, 10)),0,'L');
$pdf->SetXY(163,51);
$pdf->MultiCell(70,5,date('d/m/Y', strtotime($rapports['Date_Rapport'])),0,'L');
$pdf->SetXY(28,59);
$pdf->MultiCell(70,6,utf8_decode(substr($rapports['Site_Name'], 0, 15)),0,'L');
$pdf->SetXY(80,59);
$pdf->MultiCell(70,6,date('H:i', strtotime($rapports['Time_In'])),0,'L');
$pdf->SetXY(124,59);
$pdf->MultiCell(70,6,date('H:i', strtotime($rapports['Time_Out'])),0,'L');
$pdf->SetXY(180,59);
$pdf->MultiCell(70,6,utf8_decode('H - TELI'),0,'L');

$pdf->SetFont('Arial','',9);

$h=80;
$nbr=1;

while ($texts=$text->fetch()){$nbr++;
    $pdf->SetXY(108,$h);
    $pdf->MultiCell(45,4,utf8_decode($texts['Measured_Value']),0,'C');
    $pdf->SetXY(153,$h);
    $pdf->MultiCell(45,4,utf8_decode($texts['Remarks']),0,'C');
    if($nbr==3){
        $h=$h+6;
    }else if($nbr==4){
        $h=$h+5;
    }else if($nbr==5 || $nbr==12 || $nbr==13 || $nbr==14 || $nbr==16 || $nbr==17 || $nbr==18 || $nbr==19 || $nbr==22 || $nbr==23 || $nbr==25 || $nbr==26){
        $h=$h+9;
    }else if($nbr==6 || $nbr==10){
        $h=$h+11;
    }else if($nbr==7){
        $h=$h+15;
    }else if($nbr==9){
        $h=$h+8;
    }else if($nbr==11){
        $h=$h+18;
    }else if($nbr==24){
        $h=$h+14;
    }else if($nbr==15 || $nbr==20){
        $h=$h+16;
    }else if($nbr==21){
        $h=42;
        $pdf->AddPage('P','A4',0);
        $pdf->Image('images/PM03-2.jpg','0','0','210','295','');
        $pdf->Image('images/client/'.$clients['Logo'],'2','7','63','20','');
    }else{
        $h=$h+7;
    }
}
$h=$h+1;
$pdf->SetXY(25,$h);
$pdf->MultiCell(170,5,utf8_decode(stripslashes($rapports['Description'])),0,'L');
$pdf->SetFont('Arial','B',10);
$h=$h+32;
$pdf->SetXY(25,$h);
$pdf->MultiCell(170,5,utf8_decode(stripslashes(': H - TELI')),0,'L');
$pdf->SetXY(133,$h);
$pdf->MultiCell(170,6,utf8_decode(stripslashes($clients['Design_Client'])),0,'L');
$h=$h+9;
$pdf->SetXY(20,$h);
$pdf->MultiCell(170,5,utf8_decode(stripslashes(': '.$rapports['Prenom'].' '.$rapports['Nom'])),0,'L');
$h=$h+17;
$pdf->SetXY(18,$h);
$pdf->MultiCell(170,5,utf8_decode(': '.date('d/m/Y', strtotime($rapports['Date_Rapport']))),0,'L');
$pdf->Output();
?>