<?php
session_start();
$_SESSION['last_activity'] = time();
require_once('connexion.php');
require('rotation.php');
$query="SELECT * FROM table_rapport_mensuel_tour INNER JOIN site ON table_rapport_mensuel_tour.ID_Site=site.ID_Site INNER JOIN province ON site.ID_Prov=province.ID_Prov INNER JOIN table_tower_type ON table_rapport_mensuel_tour.ID_Tower_Type=table_tower_type.ID_Tower_Type WHERE table_rapport_mensuel_tour.ID_Rapport!=0";
if(isset($_GET['User']) && $_GET['User']!=''){
    $query.=" AND table_rapport_mensuel_tour.ID_Utilisateur=".$_GET['User'];
}
if(isset($_GET['siteId']) && $_GET['siteId']!=''){
    $query.=" AND UCASE(site.Site_ID) LIKE '%".strtoupper($_GET['siteId'])."%'";
}
if(isset($_GET['dateRapport']) && $_GET['dateRapport']!=''){
    $query.=" AND table_rapport_mensuel_tour.Date_Rapport='".date('Y-m-d', strtotime($_GET['dateRapport']))."'";
}
$query.=" ORDER BY table_rapport_mensuel_tour.Date_Rapport";
$selection=$pdo->query($query);
$app_info=$pdo->query("SELECT * FROM app_infos");
$app_infos=$app_info->fetch();

class PDF extends PDF_Rotate
{
	function Header()
	{
	$this->SetFont('times','B',120);
	$this->SetTextColor(255,192,203);
	// $this->RotatedText(100,150,'SIPAIE',40);
		global $titre;

		// Arial gras 15
		$this->SetFont('Arial','BI',10);
		// Calcul de la largeur du titre et positionnement

		$this->Ln(10);
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

$pdf->AddPage('L','A4',0);

$pdf->SetSubject(utf8_decode($app_infos['Design_App']." : MONTHLY TOWER INSPECTION LIST"));
$pdf->SetTitle(utf8_decode($app_infos['Design_App']." : MONTHLY TOWER INSPECTION LIST"));

$pdf->Ln(-10);
$ecole=$pdo->query("SELECT * FROM etablissement");
$ecoles=$ecole->fetch();
$pdf->Cell(20,15,utf8_decode($ecoles['Design_Etablissement']),0,0,'L');
$pdf->Ln(20);
$pdf->SetFont('Arial','BU',17);
$pdf->Cell(290,10,utf8_decode("MONTHLY TOWER INSPECTION LIST"),0,0,'C');
$pdf->Ln(20);
$pdf->SetFont('Arial','B',10);
// Couleur de fond
$pdf->SetFillColor(200,220,255);
// Titre
if(isset($_GET['dateRapport']) && !empty($_GET['dateRapport'])){
	$pdf->Cell(0,6,utf8_decode("EN DATE DU  ".date('d/m/Y', strtotime($_GET['dateRapport']))),0,1,'L',true);
}
$pdf->Ln(2);
$pdf->SetFont('Arial','B','10');
$pdf->Cell(10 ,6,utf8_decode("N°"),1,0,'C');
$pdf->Cell(50 ,6,utf8_decode("Site ID & Name"),1,0,'C');
$pdf->Cell(45 ,6,utf8_decode("Province"),1,0,'C');
$pdf->Cell(50 ,6,utf8_decode("Tower Type"),1,0,'C');
$pdf->Cell(32 ,6,utf8_decode("Date"),1,0,'C');
$pdf->Cell(30 ,6,utf8_decode("Time In"),1,0,'C');
$pdf->Cell(30 ,6,utf8_decode("Time Out"),1,0,'C');
$pdf->Cell(30 ,6,utf8_decode("Tower Ht"),1,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','','10');
$Nbr=0;
while($selections=$selection->fetch()){
    $Nbr++;
    $pdf->Cell(10 ,6,sprintf('%02d', $Nbr),1,0,'C');
    $pdf->Cell(50 ,6,utf8_decode(strtoupper(stripslashes($selections['Site_ID'].' - '.substr($selections['Site_Name'], 0, 10)))),1,0,'L');
    $pdf->Cell(45 ,6,utf8_decode(strtoupper(stripslashes($selections['Design_Prov']))),1,0,'L');
    $pdf->Cell(50 ,6,utf8_decode(strtoupper(stripslashes($selections['Design_Tower_Type']))),1,0,'L');
    $pdf->Cell(32 ,6,date('d/m/Y', strtotime($selections['Date_Rapport'])),1,0,'C');
    $pdf->Cell(30 ,6,date('H:i', strtotime($selections['Time_In'])),1,0,'C');
    $pdf->Cell(30 ,6,date('H:i', strtotime($selections['Time_Out'])),1,0,'C');
    $pdf->Cell(30 ,6,utf8_decode(strtoupper(stripslashes($selections['Tower_Ht'].' Meters'))),1,0,'C');
	$pdf->Ln();
}
$pdf->Output();
?>