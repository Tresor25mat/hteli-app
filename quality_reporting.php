<?php
session_start();
require_once('connexion.php');
$app_info=$pdo->query("SELECT * FROM app_infos");
$app_infos=$app_info->fetch();
$ID_Rapport=$_GET['Rapport'];
$req_rapport=$pdo->query("SELECT * FROM table_rapport_quality INNER JOIN site ON table_rapport_quality.ID_Site=site.ID_Site INNER JOIN province ON site.ID_Prov=province.ID_Prov WHERE table_rapport_quality.ID_Rapport=".$ID_Rapport);
$rapports=$req_rapport->fetch();
$fme=$pdo->query("SELECT * FROM agent WHERE ID_Agent=".$rapports['ID_Agent']);
$fmes=$fme->fetch();
$photo = $pdo->query("SELECT * FROM table_photo_quality WHERE ID_Rapport=".$rapports['ID_Rapport']);

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
    $this->cell(0,3,'Date: '.date('d/m/Y'),0,0,'R');
    $this->cell(0,10,'Page '.$this->PageNo().' / {nb}       ',0,0,'R');
    
  
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

$pdf->AddPage('L','A4');

$pdf->SetSubject(utf8_decode($app_infos['Design_App']." : QUALITY REPORTING STANDARDS"));
$pdf->SetTitle(utf8_decode($app_infos['Design_App']." : QUALITY REPORTING STANDARDS"));
$pdf->Image('images/entete.png','22','20','252','34','PNG');

$pdf->Ln(44);
$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(252, 213, 180);
$pdf->Cell(12,6,utf8_decode(""),0,0,'C');
$pdf->Cell(65,6,utf8_decode("Project Reference :"),1,0,'C',1);
$pdf->Cell(187,6,utf8_decode("PREVENTIVE MAINTENANCE"),1,1,'C',1);
$pdf->SetFillColor(191, 191, 191);
$pdf->Cell(12,6,utf8_decode(""),0,0,'C');
$pdf->Cell(65,6,utf8_decode("Site Name"),1,0,'C',1);
$pdf->Cell(61,6,utf8_decode("Site ID :"),1,0,'C',1);
$pdf->Cell(69,6,utf8_decode("Field Eng. Name"),1,0,'C',1);
$pdf->Cell(57,6,utf8_decode("Date"),1,1,'C',1);
$pdf->Cell(12,6,utf8_decode(""),0,0,'C');
$pdf->Cell(65,6,utf8_decode(strtoupper($rapports['Site_Name'])),1,0,'C');
$pdf->Cell(61,6,utf8_decode($rapports['Site_ID']),1,0,'C');
$pdf->Cell(69,6,utf8_decode(strtoupper($fmes['Nom_Agent'])),1,0,'C');
$pdf->Cell(57,6,date('d/m/Y', strtotime($rapports['Date_Rapport'])),1,0,'C');
$Nbr=0;
$aig=0;
$L1=22;
$C1=73;
$Nombre_Photo=$pdo->query("SELECT COUNT(*) AS Nbr FROM table_photo_quality WHERE ID_Rapport=".$rapports['ID_Rapport']);
$Nombre_Photos=$Nombre_Photo->fetch();
while ($photos=$photo->fetch()) {$Nbr++;
    $pdf->SetFillColor(91,155,213);
    $pdf->SetTextColor(0,0,255);
    $pdf->SetXY($L1,$C1);
    $pdf->SetFont('Arial','',10);
    $pdf->MultiCell(125,6,utf8_decode($photos['Legend_Photo']),1,'L');
    $pdf->SetTextColor(255,255,255);
    $pdf->SetXY($L1,$C1+6);
    $pdf->MultiCell(125,77,utf8_decode($photos['Legend_Photo']),1,'C',1);
    $pdf->Image('images/rapports/'.$photos['Photo'],$L1+2,$C1+8,'121','73','');
    if($aig==0){
        $L1=149;
        $aig=1;
    }else{
        $L1=22;
        $C1=$C1+84;
        $aig=0;
    }
    if(($Nbr==2 && $Nombre_Photos['Nbr']>2) || ($Nbr==6 && $Nombre_Photos['Nbr']>6) || ($Nbr==10 && $Nombre_Photos['Nbr']>10) || ($Nbr==14 && $Nombre_Photos['Nbr']>14) || ($Nbr==18 && $Nombre_Photos['Nbr']>18)){
        $pdf->AddPage('L','A4');
        $L1=22;
        $C1=20;
    }
}
$pdf->Output();
?>