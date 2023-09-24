<?php
session_start();
require_once('connexion.php');
require('rotation.php');
$rs_paiement_cdf="SELECT eleve.*, paiement.*, paiement_frais.*, annee.*, classe.*, type_frais.* FROM eleve INNER JOIN inscription ON eleve.ID_Eleve=inscription.ID_Eleve INNER JOIN paiement ON inscription.ID_Inscription=paiement.ID_Inscription INNER JOIN paiement_frais ON paiement.ID_Paiement=paiement_frais.ID_Paiement INNER JOIN frais ON paiement_frais.ID_Frais=frais.ID_Frais INNER JOIN classe ON inscription.ID_Classe=classe.ID_Classe INNER JOIN annee ON inscription.ID_Annee=annee.ID_Annee INNER JOIN table_option ON classe.ID_Option=table_option.ID_Option INNER JOIN section ON table_option.ID_Section=section.ID_Section INNER JOIN type_frais ON frais.ID_Type_Frais=type_frais.ID_Type_Frais WHERE section.ID_Etablissement=".$_GET['Ecole']." AND paiement_frais.ID_Taux=1 AND paiement.Confirm_Paiement=1";
if(isset($_GET['frais']) && !empty($_GET['frais'])){
	$rs_paiement_cdf .=" AND type_frais.ID_Type_Frais=".$_GET['frais'];
}
if(isset($_GET['datedeb']) && !empty($_GET['datedeb']) && isset($_GET['datefin']) && !empty($_GET['datefin'])){
	$rs_paiement_cdf .=" AND paiement.Date_Paiement >='".date('Y-m-d', strtotime($_GET['datedeb']))."' AND paiement.Date_Paiement <='".date('Y-m-d', strtotime($_GET['datefin']))."'";
}else{
    if(isset($_GET['datedeb']) && !empty($_GET['datedeb'])){
    	$rs_paiement_cdf .=" AND paiement.Date_Paiement >='".date('Y-m-d', strtotime($_GET['datedeb']))."'";
    }
}
$rs_paiement_cdf .=" ORDER BY paiement.Date_Paiement, eleve.Nom_Eleve";
$req_eleve_cdf=$pdo->query($rs_paiement_cdf);

$rs_paiement_usd="SELECT eleve.*, paiement.*, paiement_frais.*, annee.*, classe.*, type_frais.* FROM eleve INNER JOIN inscription ON eleve.ID_Eleve=inscription.ID_Eleve INNER JOIN paiement ON inscription.ID_Inscription=paiement.ID_Inscription INNER JOIN paiement_frais ON paiement.ID_Paiement=paiement_frais.ID_Paiement INNER JOIN frais ON paiement_frais.ID_Frais=frais.ID_Frais INNER JOIN classe ON inscription.ID_Classe=classe.ID_Classe INNER JOIN annee ON inscription.ID_Annee=annee.ID_Annee INNER JOIN table_option ON classe.ID_Option=table_option.ID_Option INNER JOIN section ON table_option.ID_Section=section.ID_Section INNER JOIN type_frais ON frais.ID_Type_Frais=type_frais.ID_Type_Frais WHERE section.ID_Etablissement=".$_GET['Ecole']." AND paiement_frais.ID_Taux=2 AND paiement.Confirm_Paiement=1";
if(isset($_GET['frais']) && !empty($_GET['frais'])){
	$rs_paiement_usd .=" AND type_frais.ID_Type_Frais=".$_GET['frais'];
}
if(isset($_GET['datedeb']) && !empty($_GET['datedeb']) && isset($_GET['datefin']) && !empty($_GET['datefin'])){
	$rs_paiement_usd .=" AND paiement.Date_Paiement >='".date('Y-m-d', strtotime($_GET['datedeb']))."' AND paiement.Date_Paiement <='".date('Y-m-d', strtotime($_GET['datefin']))."'";
}else{
    if(isset($_GET['datedeb']) && !empty($_GET['datedeb'])){
    	$rs_paiement_usd .=" AND paiement.Date_Paiement >='".date('Y-m-d', strtotime($_GET['datedeb']))."'";
    }
}
$rs_paiement_usd .=" ORDER BY paiement.Date_Paiement, eleve.Nom_Eleve";
$req_eleve_usd=$pdo->query($rs_paiement_usd);
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

$pdf->SetSubject(utf8_decode($app_infos['Design_App']." : SITUATION JOURNALIERE"));
$pdf->SetTitle(utf8_decode($app_infos['Design_App']." : SITUATION JOURNALIERE"));

$pdf->Ln(-10);
$ecole=$pdo->query("SELECT * FROM etablissement WHERE ID_Etablissement=".$_GET['Ecole']);
$ecoles=$ecole->fetch();
$pdf->Cell(42,15,utf8_decode($ecoles['Design_Etablissement']),0,0,'C');
$pdf->Ln(20);
$pdf->SetFont('Arial','BU',17);
$pdf->Cell(290,10,utf8_decode("SITUATION JOURNALIERE"),0,0,'C');
$pdf->Ln(20);
$pdf->SetFont('Arial','B',10);
// Couleur de fond
$pdf->SetFillColor(200,220,255);
// Titre
if(isset($_GET['datedeb']) && !empty($_GET['datedeb']) && isset($_GET['datefin']) && !empty($_GET['datefin'])){
	$pdf->Cell(0,6,utf8_decode("PAIEMENTS DU  ".date('d/m/Y', strtotime($_GET['datedeb']))."  AU  ".date('d/m/Y', strtotime($_GET['datefin']))." EN CDF"),0,1,'L',true);
}else{
	if(isset($_GET['datedeb']) && !empty($_GET['datedeb'])){
		$pdf->Cell(0,6,utf8_decode("PAIEMENTS DU  ".date('d/m/Y', strtotime($_GET['datedeb']))."  AU ".date('d/m/Y')." EN CDF"),0,1,'L',true);
	}else{
		$pdf->Cell(0,6,utf8_decode("PAIEMENTS EN CDF"),0,1,'L',true);
	}
}
$pdf->Ln(2);
$pdf->SetFont('Arial','B','10');
$pdf->Cell(10 ,5,utf8_decode("N°"),1,0,'C');
$pdf->Cell(25 ,5,utf8_decode("Matricule"),1,0,'C');
$pdf->Cell(61 ,5,utf8_decode("Noms"),1,0,'C');
$pdf->Cell(40 ,5,utf8_decode("Classe"),1,0,'C');
$pdf->Cell(32 ,5,utf8_decode("Année scolaire"),1,0,'C');
$pdf->Cell(40 ,5,utf8_decode("Libellé frais"),1,0,'C');
$pdf->Cell(27 ,5,utf8_decode("Date paiement"),1,0,'C');
$pdf->Cell(42 ,5,utf8_decode("Montant payé"),1,0,'C');
$Nbr_cdf=0;
$mont_dcf=0;
$pdf->Ln();
$pdf->SetFont('Arial','','10');
while($eleves_cdf=$req_eleve_cdf->fetch()){
	$frai=$pdo->query("SELECT * FROM frais WHERE ID_Frais=".$eleves_cdf['ID_Frais']);
	$frais=$frai->fetch();
	$Nbr_cdf++;
	$pdf->Cell(10 ,5,sprintf('%02d', $Nbr_cdf),1,0,'C');
	$pdf->Cell(25 ,5,utf8_decode(stripslashes($eleves_cdf['Matricule'])),1,0,'C');
	$pdf->Cell(61 ,5,utf8_decode(stripslashes($eleves_cdf['Nom_Eleve'].' '.$eleves_cdf['Pnom_Eleve'].' '.$eleves_cdf['Prenom_Eleve'])),1,0,'L');
	$pdf->Cell(40 ,5,utf8_decode(stripslashes($eleves_cdf['Design_Classe'])),1,0,'L');
	$pdf->Cell(32 ,5,utf8_decode(stripslashes($eleves_cdf['Libelle_Annee'])),1,0,'C');
	$pdf->Cell(40 ,5,utf8_decode(stripslashes($eleves_cdf['Libelle_Type_Frais'])),1,0,'L');
	$pdf->Cell(27 ,5,date('d/m/Y', strtotime($eleves_cdf['Date_Paiement'])),1,0,'C');
	// if($eleves_cdf['ID_Taux']==$frais['ID_Taux']){
		$pdf->Cell(42 ,5,number_format($eleves_cdf['Montant_Paie'], 2, ',', ' ')." CDF",1,0,'R');
		$mont_dcf=$mont_dcf+$eleves_cdf['Montant_Paie'];
	// }else{
	// 	$pdf->Cell(42 ,5,number_format($eleves_cdf['Montant_Paie']*$eleves_cdf['Taux'], 2, ',', ' ')." CDF",1,0,'R');
	// 	$mont_dcf=$mont_dcf+($eleves_cdf['Montant_Paie']*$eleves_cdf['Taux']);
	// }
	$pdf->Ln();
}
$pdf->SetFont('Arial','B','10');
$pdf->Cell(235 ,5, utf8_decode('TOTAL'),1,0,'C');
$pdf->Cell(42 ,5, number_format($mont_dcf, 2, ',', ' ')." CDF",1,0,'R');
$pdf->Ln(10);
if(isset($_GET['datedeb']) && !empty($_GET['datedeb']) && isset($_GET['datefin']) && !empty($_GET['datefin'])){
	$pdf->Cell(0,6,utf8_decode("PAIEMENTS DU  ".date('d/m/Y', strtotime($_GET['datedeb']))."  AU  ".date('d/m/Y', strtotime($_GET['datefin']))." EN USD"),0,1,'L',true);
}else{
	if(isset($_GET['datedeb']) && !empty($_GET['datedeb'])){
		$pdf->Cell(0,6,utf8_decode("PAIEMENTS DU  ".date('d/m/Y', strtotime($_GET['datedeb']))."  AU ".date('d/m/Y')." EN USD"),0,1,'L',true);
	}else{
		$pdf->Cell(0,6,utf8_decode("PAIEMENTS EN USD"),0,1,'L',true);
	}
}
$pdf->Ln(2);
$pdf->SetFont('Arial','B','10');
$pdf->Cell(10 ,5,utf8_decode("N°"),1,0,'C');
$pdf->Cell(25 ,5,utf8_decode("Matricule"),1,0,'C');
$pdf->Cell(61 ,5,utf8_decode("Noms"),1,0,'C');
$pdf->Cell(40 ,5,utf8_decode("Classe"),1,0,'C');
$pdf->Cell(32 ,5,utf8_decode("Année scolaire"),1,0,'C');
$pdf->Cell(40 ,5,utf8_decode("Libellé frais"),1,0,'C');
$pdf->Cell(27 ,5,utf8_decode("Date paiement"),1,0,'C');
$pdf->Cell(42 ,5,utf8_decode("Montant payé"),1,0,'C');
$Nbr_usd=0;
$mont_usd=0;
$pdf->Ln();
$pdf->SetFont('Arial','','10');
while($eleves_usd=$req_eleve_usd->fetch()){
	$frai_usd=$pdo->query("SELECT * FROM frais WHERE ID_Frais=".$eleves_usd['ID_Frais']);
	$frais_usd=$frai_usd->fetch();
	$Nbr_usd++;
	$pdf->Cell(10 ,5,sprintf('%02d', $Nbr_usd),1,0,'C');
	$pdf->Cell(25 ,5,utf8_decode(stripslashes($eleves_usd['Matricule'])),1,0,'C');
	$pdf->Cell(61 ,5,utf8_decode(stripslashes($eleves_usd['Nom_Eleve'].' '.$eleves_usd['Pnom_Eleve'].' '.$eleves_usd['Prenom_Eleve'])),1,0,'L');
	$pdf->Cell(40 ,5,utf8_decode(stripslashes($eleves_usd['Design_Classe'])),1,0,'L');
	$pdf->Cell(32 ,5,utf8_decode(stripslashes($eleves_usd['Libelle_Annee'])),1,0,'C');
	$pdf->Cell(40 ,5,utf8_decode(stripslashes($eleves_usd['Libelle_Type_Frais'])),1,0,'L');
	$pdf->Cell(27 ,5,date('d/m/Y', strtotime($eleves_usd['Date_Paiement'])),1,0,'C');
	// if($eleves_usd['ID_Taux']==$frais_usd['ID_Taux']){
		$pdf->Cell(42 ,5,number_format($eleves_usd['Montant_Paie'], 2, ',', ' ')." USD",1,0,'R');
		$mont_usd=$mont_usd+$eleves_usd['Montant_Paie'];
	// }else{
	// 	$pdf->Cell(42 ,5,number_format($eleves_usd['Montant_Paie']/$eleves_usd['Taux'], 2, ',', ' ')." USD",1,0,'R');
	// 	$mont_usd=$mont_usd+($eleves_usd['Montant_Paie']/$eleves_usd['Taux']);
	// }
	$pdf->Ln();
}
$pdf->SetFont('Arial','B','10');
$pdf->Cell(235 ,5, utf8_decode('TOTAL'),1,0,'C');
$pdf->Cell(42 ,5, number_format($mont_usd, 2, ',', ' ')." USD",1,0,'R');
$pdf->Output();
?>