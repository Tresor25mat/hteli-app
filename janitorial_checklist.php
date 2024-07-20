<?php
session_start();
require_once('connexion.php');
$app_info=$pdo->query("SELECT * FROM app_infos");
$app_infos=$app_info->fetch();
$ID_Rapport=$_GET['Rapport'];
$req_rapport=$pdo->query("SELECT * FROM table_rapport_janitorial INNER JOIN site ON table_rapport_janitorial.ID_Site=site.ID_Site INNER JOIN province ON site.ID_Prov=province.ID_Prov INNER JOIN type_site ON table_rapport_janitorial.ID_Type=type_site.ID_Type INNER JOIN utilisateur ON table_rapport_janitorial.ID_Utilisateur=utilisateur.ID_Utilisateur WHERE table_rapport_janitorial.ID_Rapport=".$ID_Rapport);
$rapports=$req_rapport->fetch();
$client=$pdo->query("SELECT * FROM client WHERE ID_Cient=".$rapports['ID_Cient']);
$clients=$client->fetch();
$text=$pdo->query("SELECT * FROM questionnaire_janitorial WHERE ID_Rapport=".$rapports['ID_Rapport']);


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

$pdf->SetSubject(utf8_decode($app_infos['Design_App']." : JANITORIALS, FACILITIES AND ALARMS CHECKLIST"));
$pdf->SetTitle(utf8_decode($app_infos['Design_App']." : JANITORIALS, FACILITIES AND ALARMS CHECKLIST"));
$pdf->Image('images/PM02-1.jpg','0','0','210','295','');
$pdf->Image('images/client/'.$clients['Logo'],'10','3','55','17','');

$pdf->SetFont('Arial','B',10);
$pdf->SetXY(21,41);
$pdf->MultiCell(70,5,utf8_decode($rapports['Site_ID']),0,'L');
$pdf->SetXY(82,41);
$pdf->MultiCell(70,5,utf8_decode(substr($rapports['Num_Work_Order'], 0, 10)),0,'L');
$pdf->SetXY(138,41);
$pdf->MultiCell(70,5,date('d/m/Y', strtotime($rapports['Date_Rapport'])),0,'L');
$pdf->SetXY(26,47);
$pdf->MultiCell(70,6,utf8_decode(substr($rapports['Site_Name'], 0, 15)),0,'L');
$pdf->SetXY(71,47);
$pdf->MultiCell(70,6,date('H:i', strtotime($rapports['Time_In'])),0,'L');
$pdf->SetXY(157,47);
$pdf->MultiCell(70,6,utf8_decode('NOC - EI'),0,'L');
$pdf->SetXY(40,55);
$pdf->MultiCell(70,6,utf8_decode($rapports['Design_Type']),0,'L');
$pdf->SetXY(73,55);
$pdf->MultiCell(70,6,date('H:i', strtotime($rapports['Time_Out'])),0,'L');
$pdf->SetXY(156,55);
$pdf->MultiCell(70,6,utf8_decode('H - TELI'),0,'L');

$pdf->SetFont('Arial','',9);

$h=79;
$nbr=1;

while ($texts=$text->fetch()){$nbr++;
    $pdf->SetXY(93,$h);
    $pdf->MultiCell(70,4,utf8_decode(substr($texts['Test_Results'], 0, 15)),0,'L');
    if($texts['Pass']==1){
        $pdf->Image('images/check.png','122',$h,'4','4','');
    }else if($texts['Pass']==2){
      $pdf->SetXY(131,$h);
      $pdf->MultiCell(70,4,utf8_decode('N/A'),0,'L');
    }
    $pdf->SetXY(141,$h);
    $pdf->MultiCell(70,4,utf8_decode($texts['Remarks']),0,'L');
    if($nbr==3 || $nbr==4 || $nbr==5 || $nbr==7 || $nbr==8 || $nbr==9 || $nbr==10 || $nbr==13 || $nbr==14 || $nbr==15 || $nbr==16 || $nbr==17 || $nbr==20 || $nbr==21 || $nbr==22 || $nbr==23 || $nbr==25 || $nbr==26 || $nbr==27 || $nbr==28 || $nbr==29 || $nbr==30){
        $h=$h+8;
    }else if($nbr==11 || $nbr==18){
        $h=$h+7;
    }else if($nbr==6 || $nbr==12 || $nbr==19){
        $h=$h+15;
    }else if($nbr==24){
        $h=53;
        $pdf->AddPage('P','A4',0);
        $pdf->Image('images/PM02-2.jpg','0','0','210','295','');
        $pdf->Image('images/client/'.$clients['Logo'],'10','3','55','17','');
        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY(21,24);
        $pdf->MultiCell(70,5,utf8_decode($rapports['Site_ID']),0,'L');
        $pdf->SetXY(82,24);
        $pdf->MultiCell(70,5,utf8_decode(substr($rapports['Num_Work_Order'], 0, 10)),0,'L');
        $pdf->SetXY(138,24);
        $pdf->MultiCell(70,5,date('d/m/Y', strtotime($rapports['Date_Rapport'])),0,'L');
        $pdf->SetXY(26,30);
        $pdf->MultiCell(70,6,utf8_decode(substr($rapports['Site_Name'], 0, 15)),0,'L');
        $pdf->SetXY(71,30);
        $pdf->MultiCell(70,6,date('H:i', strtotime($rapports['Time_In'])),0,'L');
        $pdf->SetXY(157,30);
        $pdf->MultiCell(70,6,utf8_decode('NOC - EI'),0,'L');
        $pdf->SetXY(40,38);
        $pdf->MultiCell(70,6,utf8_decode($rapports['Design_Type']),0,'L');
        $pdf->SetXY(73,38);
        $pdf->MultiCell(70,6,date('H:i', strtotime($rapports['Time_Out'])),0,'L');
        $pdf->SetXY(156,38);
        $pdf->MultiCell(70,6,utf8_decode('H - TELI'),0,'L');
        $pdf->SetFont('Arial','',9);
    }else{
        $h=$h+10;
    }
}
$h=$h+6;
$pdf->SetXY(10,$h);
$pdf->MultiCell(170,5,utf8_decode(stripslashes($rapports['Description'])),0,'L');
$pdf->SetFont('Arial','B',10);
$h=$h+24;
$pdf->SetXY(23,$h);
$pdf->MultiCell(170,6,utf8_decode(stripslashes(': H - TELI')),0,'L');
$pdf->SetXY(126,$h);
$pdf->MultiCell(170,6,utf8_decode(stripslashes($clients['Design_Client'])),0,'L');
$h=$h+9;
$pdf->SetXY(18,$h);
$pdf->MultiCell(170,5,utf8_decode(stripslashes(': '.$rapports['Prenom'].' '.$rapports['Nom'])),0,'L');
$h=$h+18;
$pdf->SetXY(16,$h);
$pdf->MultiCell(170,5,utf8_decode(': '.date('d/m/Y', strtotime($rapports['Date_Rapport']))),0,'L');
$pdf->Output();
?>