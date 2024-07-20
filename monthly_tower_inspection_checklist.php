<?php
session_start();
require_once('connexion.php');
$app_info=$pdo->query("SELECT * FROM app_infos");
$app_infos=$app_info->fetch();
$ID_Rapport=$_GET['Rapport'];
$req_rapport=$pdo->query("SELECT * FROM table_rapport_mensuel_tour INNER JOIN site ON table_rapport_mensuel_tour.ID_Site=site.ID_Site INNER JOIN province ON site.ID_Prov=province.ID_Prov INNER JOIN table_tower_type ON table_rapport_mensuel_tour.ID_Tower_Type=table_tower_type.ID_Tower_Type INNER JOIN utilisateur ON table_rapport_mensuel_tour.ID_Utilisateur=utilisateur.ID_Utilisateur WHERE table_rapport_mensuel_tour.ID_Rapport=".$ID_Rapport);
$rapports=$req_rapport->fetch();
$client=$pdo->query("SELECT * FROM client WHERE ID_Cient=".$rapports['ID_Cient']);
$clients=$client->fetch();
$text=$pdo->query("SELECT * FROM questionnaire_rapport_tour WHERE ID_Rapport=".$rapports['ID_Rapport']);
$texts=$text->fetch();


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

$pdf->AddPage('P','A4',0);

$pdf->SetSubject(utf8_decode($app_infos['Design_App']." : MONTHLY TOWER INSPECTION CHECKLIST"));
$pdf->SetTitle(utf8_decode($app_infos['Design_App']." : MONTHLY TOWER INSPECTION CHECKLIST"));
$pdf->Image('images/background.jpg','0','0','210','295','');
$pdf->Image('images/client/'.$clients['Logo'],'2','7','63','20','');

$pdf->SetFont('Arial','B',10);
$pdf->SetXY(23,49);
$pdf->MultiCell(70,5,utf8_decode($rapports['Site_ID']),0,'L');
$pdf->SetXY(77,49);
$pdf->MultiCell(70,5,utf8_decode(substr($rapports['PM_Ref'], 0, 10)),0,'L');
$pdf->SetXY(127,49);
$pdf->MultiCell(70,5,utf8_decode(substr($rapports['History_Card_Ref'], 0, 6)),0,'L');
$pdf->SetXY(152,49);
$pdf->MultiCell(70,5,date('d/m/Y', strtotime($rapports['Date_Rapport'])),0,'L');
$pdf->SetXY(28,58);
$pdf->MultiCell(70,4,utf8_decode(substr($rapports['Site_Name'], 0, 15)),0,'L');
$pdf->SetXY(78,58);
$pdf->MultiCell(70,4,date('H:i', strtotime($rapports['Time_In'])),0,'L');
$pdf->SetXY(158,58);
$pdf->MultiCell(70,4,date('H:i', strtotime($rapports['Time_Out'])),0,'L');

$pdf->SetXY(30,66);
$pdf->MultiCell(70,5,stripslashes($rapports['Design_Tower_Type']),0,'L');
$pdf->SetXY(80,66);
$pdf->MultiCell(70,5,utf8_decode($rapports['Tower_Ht'].'M'),0,'L');
$pdf->SetXY(169,66);
$pdf->MultiCell(70,5,utf8_decode('H - TELI'),0,'L');

$pdf->SetFont('Arial','',9);

$h=89;

for ($i=1;$i<=10;$i++){
    $pdf->SetXY(100,$h);
    $pdf->MultiCell(70,4,utf8_decode(substr($texts['Test_Results_'.$i], 0, 10)),0,'L');
    if($texts['Etat_'.$i]==1){
        $pdf->Image('images/check.png','123',$h,'4','4','');
    }else if($texts['Etat_'.$i]==2){
        $pdf->Image('images/check.png','135',$h,'4','4','');
    }
    $pdf->SetXY(144,$h);
    $pdf->MultiCell(70,4,utf8_decode($texts['Ncr_If_Any_'.$i]),0,'L');
    if($i==1){
        $h=$h+9;
    }else if($i==5 || $i==4 || $i==8){
        $h=$h+7; 
    }else{
        $h=$h+8;
    }
}
$pdf->SetXY(23,$h);
$pdf->MultiCell(170,5,utf8_decode(stripslashes($rapports['Description'])),0,'L');
$pdf->SetFont('Arial','B',10);
$h=$h+32;
$pdf->SetXY(25,$h);
$pdf->MultiCell(170,5,utf8_decode(stripslashes(': H - TELI')),0,'L');
$pdf->SetXY(124,$h);
$pdf->MultiCell(170,6,utf8_decode(stripslashes($clients['Design_Client'])),0,'L');
$h=$h+9;
$pdf->SetXY(20,$h);
$pdf->MultiCell(170,5,utf8_decode(stripslashes(': '.$rapports['Prenom'].' '.$rapports['Nom'])),0,'L');
$h=$h+17;
$pdf->SetXY(18,$h);
$pdf->MultiCell(170,5,utf8_decode(': '.date('d/m/Y', strtotime($rapports['Date_Rapport']))),0,'L');
$pdf->Output();
?>