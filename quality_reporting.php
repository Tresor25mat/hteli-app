<?php
session_start();
require_once('connexion.php');
$app_info=$pdo->query("SELECT * FROM app_infos");
$app_infos=$app_info->fetch();
$ID_Rapport=$_GET['Rapport'];
$req_rapport=$pdo->query("SELECT * FROM table_rapport_quality INNER JOIN site ON table_rapport_quality.ID_Site=site.ID_Site INNER JOIN province ON site.ID_Prov=province.ID_Prov INNER JOIN table_project ON table_rapport_quality.ID_Project=table_project.ID_Project INNER JOIN agent ON table_rapport_quality.ID_Agent=agent.ID_Agent WHERE table_rapport_quality.ID_Rapport=".$ID_Rapport);
$rapports=$req_rapport->fetch();
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

$pdf->AddPage('P','A4');

$pdf->SetSubject(utf8_decode($app_infos['Design_App']." : QUALITY REPORTING STANDARDS"));
$pdf->SetTitle(utf8_decode($app_infos['Design_App']." : QUALITY REPORTING STANDARDS"));
$pdf->Image('images/logo_hteli.png','149','25','50','23','PNG');
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(20,20);
$pdf->MultiCell(170,8,utf8_decode("QUALITY REPORTING STANDARDS"),1,'C');
//----------------------------------------------------------------------
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(20,28);
$pdf->MultiCell(20,6,utf8_decode("Number"),1,'L');
$pdf->SetFont('Arial','',8);
$pdf->SetXY(40,28);
$pdf->SetTextColor(200,35,32);
$pdf->SetFillColor(252,255,1);
$pdf->MultiCell(59,6,utf8_decode("HT-DRC-SHEQ-QRS HTL-MS/PR-".$rapports['Numero']),1,'C',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(99,28);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(22,6,utf8_decode("Issue date"),1,'L');
$pdf->SetFont('Arial','',8);
$pdf->SetXY(121,28);
$pdf->SetTextColor(200,35,32);
$pdf->MultiCell(23,6,utf8_decode("18/04/2022"),1,'C');
$pdf->SetXY(144,28);
$pdf->MultiCell(46,18,utf8_decode(""),1,'C');
//----------------------------------------------------------------------
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(20,34);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,6,utf8_decode("Compiled By"),1,'L');
$pdf->SetFont('Arial','',8);
$pdf->SetXY(40,34);
$pdf->SetTextColor(200,35,32);
$pdf->MultiCell(59,6,utf8_decode("Eddie Khonde"),1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(99,34);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(22,6,utf8_decode("Revision "),1,'L');
$pdf->SetFont('Arial','',8);
$pdf->SetXY(121,34);
$pdf->SetTextColor(200,35,32);
$pdf->MultiCell(23,6,utf8_decode("3"),1,'C');
//----------------------------------------------------------------------
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(20,40);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,6,utf8_decode("Revised"),1,'L');
$pdf->SetFont('Arial','',8);
$pdf->SetXY(40,40);
$pdf->SetTextColor(200,35,32);
$pdf->MultiCell(59,6,utf8_decode("Adriel Lessenge"),1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(99,40);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(22,6,utf8_decode("Revision Date"),1,'L');
$pdf->SetFont('Arial','',8);
$pdf->SetXY(121,40);
$pdf->SetTextColor(200,35,32);
$pdf->MultiCell(23,6,utf8_decode("18/04/2022"),1,'C');
//----------------------------------------------------------------------
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(20,46);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(20,6,utf8_decode("Approved"),1,'L');
$pdf->SetFont('Arial','',8);
$pdf->SetXY(40,46);
$pdf->SetTextColor(200,35,32);
$pdf->MultiCell(59,6,utf8_decode("Christian Mayamba"),1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(99,46);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(22,6,utf8_decode("Authorised"),1,'L');
$pdf->SetFont('Arial','',8);
$pdf->SetXY(121,46);
$pdf->SetTextColor(200,35,32);
$pdf->MultiCell(23,6,utf8_decode("Sampie Marais"),1,'C');
//----------------------------------------------------------------------
$pdf->SetFont('Arial','',8);
$pdf->SetXY(20,46);
$pdf->SetTextColor(0,0,255);
$pdf->SetFillColor(252,255,1);
$pdf->MultiCell(170,6,utf8_decode("Access cod : am-20240513-00000007"),1,'C',1);
$pdf->SetTextColor(0,0,0);
//----------------------------------------------------------------------
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(252, 213, 180);
$pdf->SetXY(20,52);
$pdf->MultiCell(45,6,utf8_decode("Project Reference :"),1,'C',1);
$pdf->SetXY(65,52);
$pdf->MultiCell(125,6,utf8_decode(strtoupper($rapports['Design_Project'])),1,'C',1);
$pdf->SetFillColor(191, 191, 191);
$pdf->SetXY(20,58);
$pdf->MultiCell(45,6,utf8_decode("Site Name"),1,'C',1);
$pdf->SetXY(65,58);
$pdf->MultiCell(40,6,utf8_decode("Site ID :"),1,'C',1);
$pdf->SetXY(105,58);
$pdf->MultiCell(50,6,utf8_decode("Field Eng. Name"),1,'C',1);
$pdf->SetXY(155,58);
$pdf->MultiCell(35,6,utf8_decode("Date"),1,'C',1);
$pdf->SetXY(20,64);
$pdf->MultiCell(45,6,utf8_decode(strtoupper($rapports['Site_Name'])),1,'C');
$pdf->SetXY(65,64);
$pdf->MultiCell(40,6,utf8_decode($rapports['Site_ID']),1,'C');
$pdf->SetXY(105,64);
$pdf->MultiCell(50,6,utf8_decode(strtoupper($rapports['Nom_Agent'])),1,'C');
$pdf->SetXY(155,64);
$pdf->MultiCell(35,6,date('d/m/Y', strtotime($rapports['Date_Rapport'])),1,'C');

$Nbr=0;
$aig=0;
$L1=20;
$C1=70;
$Nombre_Photo=$pdo->query("SELECT COUNT(*) AS Nbr FROM table_photo_quality WHERE ID_Rapport=".$rapports['ID_Rapport']);
$Nombre_Photos=$Nombre_Photo->fetch();
while ($photos=$photo->fetch()) {$Nbr++;
    $pdf->SetFillColor(91,155,213);
    $pdf->SetTextColor(0,0,255);
    $pdf->SetXY($L1,$C1);
    $pdf->SetFont('Arial','',7);
    $pdf->MultiCell(85,6,utf8_decode($photos['Legend_Photo']),1,'L');
    $pdf->SetTextColor(255,255,255);
    $pdf->SetXY($L1,$C1+6);
    $pdf->MultiCell(85,77,utf8_decode($photos['Legend_Photo']),1,'C',1);
    $pdf->Image('images/rapports/'.$photos['Photo'],$L1+2,$C1+8,'81','73','');
    if($aig==0){
        $L1=105;
        $aig=1;
    }else{
        $L1=20;
        $C1=$C1+83;
        $aig=0;
    }
    if(($Nbr==4 && $Nombre_Photos['Nbr']>4) || ($Nbr==10 && $Nombre_Photos['Nbr']>10) || ($Nbr==16 && $Nombre_Photos['Nbr']>16) || ($Nbr==22 && $Nombre_Photos['Nbr']>22) || ($Nbr==28 && $Nombre_Photos['Nbr']>28)){
        $pdf->AddPage('P','A4');
        $L1=20;
        $C1=20;
    }
}
$pdf->Output();
?>