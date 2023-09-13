<?php
session_start();
require_once('connexion.php');
require('rotation.php');
$Paiement=$_GET['Paiement'];
$Ecole=htmlentities($_GET['Ecole']);
$req_eleve=$pdo->query("SELECT eleve.*, paiement.*, annee.*, classe.*, recu.*, utilisateur.*, paiement.Date_Enreg AS Heure_paiement FROM eleve INNER JOIN inscription ON eleve.ID_Eleve=inscription.ID_Eleve INNER JOIN paiement ON inscription.ID_Inscription=paiement.ID_Inscription INNER JOIN classe ON inscription.ID_Classe=classe.ID_Classe INNER JOIN annee ON inscription.ID_Annee=annee.ID_Annee INNER JOIN table_option ON classe.ID_Option=table_option.ID_Option INNER JOIN section ON table_option.ID_Section=section.ID_Section INNER JOIN recu ON paiement.ID_Paiement=recu.ID_Paiement INNER JOIN utilisateur ON paiement.ID_Utilisateur=utilisateur.ID_Utilisateur WHERE paiement.ID_Paiement='".$Paiement."'");
$eleves=$req_eleve->fetch();
$app_info=$pdo->query("SELECT * FROM app_infos");
$app_infos=$app_info->fetch();
$devise=$pdo->query("SELECT * FROM taux_change WHERE ID_Taux=".$eleves['ID_Taux']);
$devises=$devise->fetch();
$req_frais=$pdo->query("SELECT * from frais INNER JOIN type_frais on frais.ID_Type_Frais=type_frais.ID_Type_Frais WHERE frais.ID_Frais=".$eleves['ID_Frais']);
class PDF extends PDF_Rotate
{
	function Header()
	{
	$this->SetFont('times','B',100);
	$this->SetTextColor(255,192,203);
	$this->RotatedText(60,95,'RECU',20);
		global $titre;

		// Arial gras 15
		$this->SetFont('Arial','BI',10);
		// Calcul de la largeur du titre et positionnement

		$this->Ln();
	}

	function RotatedText($x, $y, $txt, $angle)
	{
		//Text rotated around its origin
		$this->Rotate($angle,$x,$y);
		$this->Text($x,$y,$txt);
		$this->Rotate(0);
	}


	function Footer(){
		
		// $this->SetFont('Arial','BI','8');
		// $this->setY(-13);
		
		// $this->SetFont('Arial','I','8');
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

$pdf->SetSubject(utf8_decode($app_infos['Design_App']." : REÇU"));
$pdf->SetTitle(utf8_decode($app_infos['Design_App']." : REÇU"));
$ecole=$pdo->query("SELECT * FROM etablissement WHERE ID_Etablissement=".$Ecole);
$ecoles=$ecole->fetch();
$pdf->Cell(42,15,utf8_decode($ecoles['Design_Etablissement']),0,0,'C');
$pdf->Ln(20);
$pdf->SetFont('Arial','BU',17);
if($eleves['Confirm_Paiement']==2){
	$pdf->Cell(190,10,utf8_decode("PRO FORMA"),0,0,'C');
}else{
	$pdf->Cell(190,10,utf8_decode("REÇU N° ".$eleves['Num_Recu']),0,0,'C');
}

$pdf->Ln(20);
$pdf->SetFont('Arial','B',12);
// Couleur de fond
$pdf->SetFillColor(200,220,255);
// Titre
$pdf->SetFont('Arial','B','11');
$pdf->Cell(30 ,5,'Matricule',0,0,'L');
$pdf->SetFont('Arial','','11');
$pdf->Cell(80 ,5,':  '.utf8_decode($eleves['Matricule']),0,0,'L');
$pdf->SetFont('Arial','B','11');

$pdf->Cell(30 ,5,utf8_decode('Montant payé'),0,0,'L');
$pdf->SetFont('Arial','','11');
$pdf->Cell(80 ,5,':  '.number_format($eleves['Montant_Paie'], 2, ',', ' ').' '.$devises['Devise'],0,1,'L');


$pdf->SetFont('Arial','B','11');
$pdf->Cell(30 ,5,'Noms',0,0,'L');
$pdf->SetFont('Arial','','11');
$pdf->Cell(80 ,5,':  '.utf8_decode(stripslashes($eleves['Nom_Eleve'])).' '.utf8_decode(stripslashes($eleves['Pnom_Eleve'])).' '.utf8_decode(stripslashes($eleves['Prenom_Eleve'])),0,0,'L');
$pdf->SetFont('Arial','B','11');
$pdf->Cell(30 ,5,utf8_decode('Date paiement'),0,0,'L');
$pdf->SetFont('Arial','','11');
$pdf->Cell(80 ,5,':  '.date('d/m/Y', strtotime($eleves['Date_Paiement'])),0,1,'L');
$pdf->SetFont('Arial','B','11');
$pdf->Cell(30 ,5,'Classe',0,0,'L');
$pdf->SetFont('Arial','','11');
$pdf->Cell(80 ,5,':  '.utf8_decode(stripslashes($eleves['Design_Classe'])),0,0,'L');
$pdf->SetFont('Arial','B','11');
$pdf->Cell(30 ,5,utf8_decode('Heure'),0,0,'L');
$pdf->SetFont('Arial','','11');
$pdf->Cell(80 ,5,':  '.date('H:i:s', strtotime($eleves['Heure_paiement'])),0,1,'L');

$pdf->SetFont('Arial','B','11');
$pdf->Cell(30 ,5,utf8_decode('Année scolaire'),0,0,'L');
$pdf->SetFont('Arial','','11');
$pdf->Cell(80 ,5,':  '.utf8_decode(stripslashes($eleves['Libelle_Annee'])),0,0,'L');
$pdf->SetFont('Arial','B','11');
$pdf->Cell(30 ,5,utf8_decode("Taux de change"),0,0,'L');
$pdf->SetFont('Arial','','11');
$pdf->Cell(80 ,5,':  '.number_format($eleves['Taux'], 2, ',', ' '),0,0,'L');
// $pdf->Cell(0,6,utf8_decode("Nom de l'élève :".stripslashes($eleves['Nom_Eleve'])." ".stripslashes($eleves['Pnom_Eleve'])." ".stripslashes($eleves['Prenom_Eleve'])),0,1,'L',true);
$pdf->Ln(5);
$pdf->SetFont('Arial','B','11');
$pdf->Cell(7 ,5,utf8_decode("N°"),1,0,'C');
$pdf->Cell(134 ,5,utf8_decode("Libellé"),1,0,'C');
// $pdf->Cell(47 ,5,utf8_decode("Tranche"),1,0,'C');
// $pdf->Cell(47 ,5,utf8_decode("Montant"),1,0,'C');
$pdf->Cell(47 ,5,utf8_decode("Montant"),1,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','','11');
$mont=0;
$Nbr=1;
$frais=$req_frais->fetch();
$pdf->Cell(7 ,5,sprintf('%02d', $Nbr),1,0,'C');
$pdf->Cell(134 ,5,utf8_decode(stripslashes('PAIEMENT '.$frais['Libelle_Type_Frais'])),1,0,'L');
$pdf->Cell(47 ,5,utf8_decode(number_format($eleves['Montant_Paie'], 2, ',', ' ').' '.$devises['Devise']),1,0,'R');
$pdf->Ln();
$pdf->SetFont('Arial','B','11');
$pdf->Cell(141 ,5, utf8_decode('Total'),1,0,'R');
$pdf->Cell(47 ,5, number_format($eleves['Montant_Paie'], 2, ',', ' ').' '.$devises['Devise'],1,0,'R');
// $pdf->Cell(47 ,5, utf8_decode(stripslashes($eleves['Devise'])),1,0,'L');
$pdf->Ln(10);
$pdf->SetFont('Arial','B','11');
$pdf->Cell(150 ,5,utf8_decode('Fait à Kinshasa, le '),0,0,'R');
$pdf->SetFont('Arial','','11');
$pdf->Cell(50 ,5,date("d/m/Y"),0,0,'L');
$pdf->Ln(8);
$pdf->SetFont('Arial','B','11');
$pdf->Cell(146 ,5,utf8_decode('Utilisateur '),0,0,'R');
$pdf->SetFont('Arial','','11');
$pdf->Cell(50 ,5,':  '.utf8_decode(stripslashes($eleves['Prenom']).' '.stripslashes($eleves['Nom'])),0,0,'L');
// $pdf->Cell(180 ,5, utf8_decode('Fait à Kinshasa, le ').date("d/m/Y"),0,0,'R');
// $pdf->Ln(7);
// $pdf->Cell(180 ,5, utf8_decode('Utilisateur : ').utf8_decode(stripslashes($eleves['Prenom']).' '.stripslashes($eleves['Nom'])),0,1,'R');
$pdf->Output();
?>