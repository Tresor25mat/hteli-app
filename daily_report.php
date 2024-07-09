<?php
session_start();
require_once('connexion.php');
$app_info=$pdo->query("SELECT * FROM app_infos");
$app_infos=$app_info->fetch();
$ID_Rapport=$_GET['Rapport'];
$req_rapport=$pdo->query("SELECT * FROM table_rapport_journalier INNER JOIN site ON table_rapport_journalier.ID_Site=site.ID_Site INNER JOIN province ON site.ID_Prov=province.ID_Prov WHERE table_rapport_journalier.ID_Rapport=".$ID_Rapport);
$rapports=$req_rapport->fetch();
$fme=$pdo->query("SELECT * FROM agent WHERE ID_Agent=".$rapports['ID_Agent']);
$fmes=$fme->fetch();
$titre=$pdo->query("SELECT * FROM table_titre_rapport INNER JOIN table_sous_titre ON table_titre_rapport.ID_Sous_Titre=table_sous_titre.ID_Sous_Titre WHERE table_titre_rapport.ID_Rapport=".$rapports['ID_Rapport']);
$nombre_titre=$pdo->query("SELECT COUNT(*) AS Nbr FROM table_titre_rapport INNER JOIN table_sous_titre ON table_titre_rapport.ID_Sous_Titre=table_sous_titre.ID_Sous_Titre WHERE table_titre_rapport.ID_Rapport=".$rapports['ID_Rapport']);
$nombre_titres=$nombre_titre->fetch();

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

$pdf->AddPage('P','A4',0);

$pdf->SetSubject(utf8_decode($app_infos['Design_App']." : DAILY PM - PROGRESS REPORT"));
$pdf->SetTitle(utf8_decode($app_infos['Design_App']." : DAILY PM - PROGRESS REPORT"));
// $pdf->Image('images/logo_congo.png','6','9','40','30','PNG');

$pdf->Ln(8);
$pdf->SetFont('Arial','BU',14);
$pdf->Cell(190,7,utf8_decode("DAILY PM - PROGRESS REPORT"),0,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->SetXY(22,30);
$pdf->MultiCell(70,13,utf8_decode(""),1,'L');
$pdf->SetXY(25,30);
$pdf->MultiCell(70,7,utf8_decode("Site ID & Name :"),0,'L');
$pdf->SetXY(25,36);
$pdf->MultiCell(70,7,utf8_decode($rapports['Site_ID'].' - '.substr($rapports['Site_Name'], 0, 14)),0,'L');
$pdf->SetXY(92,30);
$pdf->MultiCell(45,13,utf8_decode(""),1,'L');
$pdf->SetXY(95,30);
$pdf->MultiCell(70,7,utf8_decode("Province :"),0,'L');
$pdf->SetXY(95,36);
$pdf->MultiCell(70,7,utf8_decode(strtoupper($rapports['Design_Prov'])),0,'L');
$pdf->SetXY(137,30);
$pdf->MultiCell(50,13,utf8_decode(""),1,'L');
$pdf->SetXY(140,30);
$pdf->MultiCell(70,7,utf8_decode("NOC TICKET :"),0,'L');
$pdf->SetXY(140,36);
$pdf->MultiCell(70,7,utf8_decode(strtoupper($rapports['Noc_Ticket'])),0,'L');

$pdf->SetXY(22,43);
$pdf->MultiCell(70,13,utf8_decode(""),1,'L');
$pdf->SetXY(25,43);
$pdf->MultiCell(70,7,utf8_decode("FME Name :"),0,'L');
$pdf->SetXY(25,49);
$pdf->MultiCell(70,7,utf8_decode($fmes['Nom_Agent']),0,'L');
$pdf->SetXY(92,43);
$pdf->MultiCell(45,13,utf8_decode(""),1,'L');
$pdf->SetXY(95,43);
$pdf->MultiCell(70,7,utf8_decode("Date :"),0,'L');
$pdf->SetXY(95,49);
$pdf->MultiCell(70,7,date('d/m/Y', strtotime($rapports['Date_Rapport'])),0,'L');
$pdf->SetXY(137,43);
$pdf->MultiCell(50,13,utf8_decode(""),1,'L');
$pdf->SetXY(140,43);
$pdf->MultiCell(70,7,utf8_decode("Vendor :"),0,'L');
$pdf->SetXY(140,49);
$pdf->MultiCell(70,7,utf8_decode(strtoupper('H - TELI')),0,'L');

$pdf->SetXY(22,56);
$pdf->MultiCell(70,13,utf8_decode(""),1,'L');
$pdf->SetXY(25,56);
$pdf->MultiCell(70,7,utf8_decode("PM type :"),0,'L');
$pdf->SetXY(25,62);
$pdf->MultiCell(70,7,utf8_decode($rapports['PM_Type']),0,'L');
$pdf->SetXY(92,56);
$pdf->MultiCell(45,13,utf8_decode(""),1,'L');
$pdf->SetXY(95,56);
$pdf->MultiCell(70,7,utf8_decode("Run Hour :"),0,'L');
$pdf->SetXY(95,62);
$pdf->MultiCell(70,7,utf8_decode(strtoupper($rapports['Run_Hour'])),0,'L');
$pdf->SetXY(137,56);
$pdf->MultiCell(50,13,utf8_decode(""),1,'L');
$pdf->SetXY(140,56);
$pdf->MultiCell(70,7,utf8_decode("DC Load :"),0,'L');
$pdf->SetXY(140,62);
$pdf->MultiCell(70,7,utf8_decode($rapports['DC_Load']),0,'L');

$pdf->SetXY(22,69);
$pdf->MultiCell(165,13,utf8_decode(""),1,'L');
$pdf->SetXY(25,69);
$pdf->MultiCell(70,7,utf8_decode("Localisation :"),0,'L');
$pdf->SetXY(25,75);
$pdf->MultiCell(70,7,utf8_decode($rapports['Localisation']),0,'L');
$pdf->SetTextColor(255,255,255);
$pdf->Ln(4);
$pdf->SetFont('Arial','B',14);
$Nbr=0;
$Nbr_titre=0;
$aig=0;
$L1=22;
$C1=82;
while ($titres=$titre->fetch()) {$Nbr_titre++;
    $pdf->SetFillColor(0,0,0);
    $pdf->SetXY(22,$C1);
    $pdf->MultiCell(165,12,utf8_decode($titres['Design_Sous_Titre']),1,'C',1,1);
    $photo=$pdo->query("SELECT * FROM table_photo_rapport WHERE ID_Titre_Rapport=".$titres['ID_Titre_Rapport']);
    $Nombre_Photo=$pdo->query("SELECT COUNT(*) AS Nbr FROM table_photo_rapport WHERE ID_Titre_Rapport=".$titres['ID_Titre_Rapport']);
    $Nombre_Photos=$Nombre_Photo->fetch();
    while ($photos=$photo->fetch()) {$Nbr++;
        $pdf->SetFillColor(91,155,213);
        $pdf->SetXY($L1,$C1+13);
        $pdf->MultiCell(82,90,utf8_decode(""),1,'C',1);
        $pdf->Image('images/rapports/'.$photos['Photo'],$L1+2,$C1+15,'78','86','');
        if($aig==0){
            $L1=105;
            $aig=1;
        }else{
            $L1=22;
            $C1=$C1+91;
            $aig=0;
        }
        if(($Nbr==4 && $Nombre_Photos['Nbr']>4) || ($Nbr==8 && $Nombre_Photos['Nbr']>8) || ($Nbr==12 && $Nombre_Photos['Nbr']>12)){
            $pdf->AddPage('P','A4',0);
            $L1=22;
            $C1=8;
        }
    }
    if($Nbr_titre!=$nombre_titres['Nbr']){
        $pdf->AddPage('P','A4',0);
        $Nbr=0;
        $aig=0;
        $L1=22;
        $C1=22;       
    }
}
if($rapports['Description']!=''){
    $pdf->SetFillColor(0,0,0);
    if($Nbr_titre==1 && $Nbr>=3){
        $pdf->AddPage('P','A4',0);
        $C1=22;       
    }else{
        if($Nbr%2){
            $C1=$C1+104;
        }else{
            $C1=$C1+13;
        }
    }
    $pdf->SetXY(22,$C1);
    $pdf->MultiCell(165,12,utf8_decode("Issue"),1,'C',1,1);
    $C1=$C1+12;
    $pdf->SetXY(22,$C1);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',11);
    $pdf->MultiCell(165,5,utf8_decode(stripslashes($rapports['Description'])),1,'L',0);
}
$pdf->Output();
?>