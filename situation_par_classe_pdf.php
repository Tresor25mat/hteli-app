<?php
session_start();
require_once('connexion.php');
require('rotation.php');
$id_ecole = htmlentities($_GET['ecole']);
$classe = htmlentities($_GET['classe']);
$annee = htmlentities($_GET['annee']);
$sel_classe=$pdo->query("SELECT * FROM classe WHERE ID_Classe=".$classe);
$classes=$sel_classe->fetch();
$sel_annee=$pdo->query("SELECT * FROM annee WHERE ID_Annee=".$annee);
$annees=$sel_annee->fetch();
if(isset($_GET['frais']) && $_GET['frais']!=''){
	$req_frais=$pdo->query("SELECT frais.*, type_frais.*, taux_change.* FROM frais INNER JOIN type_frais ON frais.ID_Type_Frais=type_frais.ID_Type_Frais INNER JOIN paiement_frais ON frais.ID_Frais=paiement_frais.ID_Frais INNER JOIN paiement ON paiement_frais.ID_Paiement=paiement.ID_Paiement INNER JOIN taux_change ON frais.ID_Taux=taux_change.ID_Taux INNER JOIN inscription ON paiement.ID_Inscription=inscription.ID_Inscription WHERE inscription.ID_Classe=".$classe." AND inscription.ID_Annee=".$annee." AND frais.ID_Type_Frais=".$_GET['frais']." GROUP BY frais.ID_Frais ORDER BY type_frais.Libelle_Type_Frais");
}else{
	$req_frais=$pdo->query("SELECT frais.*, type_frais.*, taux_change.* FROM frais INNER JOIN type_frais ON frais.ID_Type_Frais=type_frais.ID_Type_Frais INNER JOIN paiement_frais ON frais.ID_Frais=paiement_frais.ID_Frais INNER JOIN paiement ON paiement_frais.ID_Paiement=paiement.ID_Paiement INNER JOIN taux_change ON frais.ID_Taux=taux_change.ID_Taux INNER JOIN inscription ON paiement.ID_Inscription=inscription.ID_Inscription WHERE inscription.ID_Classe=".$classe." AND inscription.ID_Annee=".$annee." GROUP BY frais.ID_Frais ORDER BY type_frais.Libelle_Type_Frais");
}
$app_info=$pdo->query("SELECT * FROM app_infos");
$app_infos=$app_info->fetch();

class PDF extends PDF_Rotate
{
	function Header()
	{
	$this->SetFont('times','B',120);
	$this->SetTextColor(255,192,203);
	// $this->RotatedText(60,170,'SIPAIE',40);
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

$pdf->SetSubject(utf8_decode($app_infos['Design_App']." : SITUATION DE PAIEMENT PAR CLASSE"));
$pdf->SetTitle(utf8_decode($app_infos['Design_App']." : SITUATION DE PAIEMENT PAR CLASSE"));

$ecole=$pdo->query("SELECT * FROM etablissement WHERE ID_Etablissement=".$id_ecole);
$ecoles=$ecole->fetch();
$pdf->Cell(42,15,utf8_decode($ecoles['Design_Etablissement']),0,0,'C');
$pdf->Ln(20);
$pdf->SetFont('Arial','BU',15);
$pdf->Cell(200,10,utf8_decode("SITUATION DE PAIEMENT PAR CLASSE"),0,0,'C');
$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);
// Couleur de fond
$pdf->SetFillColor(200,220,255);
// Titre
$pdf->SetFont('Arial','B','10');
$pdf->Cell(40 ,5,utf8_decode('Classe'),0,0,'L');
$pdf->SetFont('Arial','','10');
$pdf->Cell(80 ,5,':  '.utf8_decode(stripslashes($classes['Design_Classe'])),0,1,'L');
$pdf->SetFont('Arial','B','10');
$pdf->Cell(40 ,5,utf8_decode('Année scolaire'),0,0,'L');
$pdf->SetFont('Arial','','10');
$pdf->Cell(80 ,5,':  '.utf8_decode(stripslashes($annees['Libelle_Annee'])),0,1,'L');

$NbrF=0;
$pdf->SetFont('Arial','B','10');
while($frais=$req_frais->fetch()){
	$devise=$pdo->query("SELECT * FROM taux_change WHERE ID_Taux=".$frais['ID_Taux']);
	$devises=$devise->fetch();
	$req_eleve=$pdo->query("SELECT eleve.*, paiement.*, paiement_frais.*, annee.*, classe.*, taux_change.*, type_frais.*, frais.*, inscription.* FROM eleve INNER JOIN inscription ON eleve.ID_Eleve=inscription.ID_Eleve INNER JOIN paiement ON inscription.ID_Inscription=paiement.ID_Inscription INNER JOIN paiement_frais ON paiement.ID_Paiement=paiement_frais.ID_Paiement INNER JOIN frais ON paiement_frais.ID_Frais=frais.ID_Frais INNER JOIN classe ON inscription.ID_Classe=classe.ID_Classe INNER JOIN annee ON inscription.ID_Annee=annee.ID_Annee INNER JOIN table_option ON classe.ID_Option=table_option.ID_Option INNER JOIN section ON table_option.ID_Section=section.ID_Section INNER JOIN taux_change ON frais.ID_Taux=taux_change.ID_Taux INNER JOIN type_frais ON frais.ID_Type_Frais=type_frais.ID_Type_Frais WHERE section.ID_Etablissement=".$id_ecole." AND inscription.ID_Classe=".$classe." AND inscription.ID_Annee=".$annee." AND frais.ID_Frais=".$frais['ID_Frais']." AND paiement.Confirm_Paiement=1 AND inscription.Confirm_Inscription=1 GROUP BY inscription.ID_Inscription, frais.ID_Frais ORDER BY eleve.Nom_Eleve");
	$NbrF++;
	$pdf->Ln(5);
	$pdf->SetFillColor(200,220,255);
	$pdf->Cell(0,6,utf8_decode($NbrF.". ".stripslashes($frais['Libelle_Type_Frais'])),0,1,'L',true);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B','10');
	$pdf->Cell(10 ,5,utf8_decode("N°"),1,0,'C');
	$pdf->Cell(25 ,5,utf8_decode("Matricule"),1,0,'C');
	$pdf->Cell(70 ,5,utf8_decode("Noms"),1,0,'C');
	$pdf->Cell(25 ,5,utf8_decode("Sexe"),1,0,'C');
	$pdf->Cell(30 ,5,utf8_decode("Montant payé"),1,0,'C');
	$pdf->Cell(30 ,5,utf8_decode("Reste"),1,0,'C');
	$Nbr=0;
	$mont=0;
	$dette=0;
	$pdf->Ln();
	$pdf->SetFont('Arial','','10');
	while($eleves=$req_eleve->fetch()){
        $rs_paiement=$pdo->query("SELECT * FROM paiement INNER JOIN paiement_frais ON paiement.ID_Paiement=paiement_frais.ID_Paiement WHERE paiement.ID_Inscription='".$eleves['ID_Inscription']."' AND paiement.Confirm_Paiement=1 AND paiement_frais.ID_Frais=".$eleves['ID_Frais']);
        $Montant_Paie=0;
        while ($rs_paiements=$rs_paiement->fetch()) {
            if($frais['ID_Taux']==$rs_paiements['ID_Taux']){
                $Montant_Paie=$Montant_Paie+$rs_paiements['Montant_Paie'];
            }else{
			 	if($frais['ID_Taux']==1){
					$Montant_Paie=$Montant_Paie+($rs_paiements['Montant_Paie']*$rs_paiements['Taux']);
			 	}else{
					$Montant_Paie=$Montant_Paie+($rs_paiements['Montant_Paie']/$rs_paiements['Taux']);
			 	}
            }
        } 
		$Nbr++;
		$pdf->Cell(10 ,5,sprintf('%02d', $Nbr),1,0,'C');
		$pdf->Cell(25 ,5,utf8_decode(stripslashes($eleves['Matricule'])),1,0,'C');
		$pdf->Cell(70 ,5,utf8_decode(stripslashes($eleves['Nom_Eleve'].' '.$eleves['Pnom_Eleve'].' '.$eleves['Prenom_Eleve'])),1,0,'L');
		if($eleves['Sexe']=='M'){
			$pdf->Cell(25 ,5,utf8_decode('Masculin'),1,0,'C');
		}else{
			$pdf->Cell(25 ,5,utf8_decode('Féminin'),1,0,'C');
		}
	    $pdf->Cell(30 ,5,number_format($Montant_Paie, 2, ',', ' ').' '.$devises['Devise'],1,0,'R');
		$pdf->Cell(30 ,5,number_format($frais['Montant_Frais']-$Montant_Paie, 2, ',', ' ').' '.$devises['Devise'],1,0,'R');
		$mont=$mont+$Montant_Paie;
		$dette=$dette+($frais['Montant_Frais']-$Montant_Paie);
		$pdf->Ln();
	}
	$pdf->SetFont('Arial','B','10');
	$pdf->Cell(130 ,5, utf8_decode('TOTAL'),1,0,'C');
	$pdf->Cell(30 ,5, number_format($mont, 2, ',', ' ').' '.$devises['Devise'],1,0,'R');
	$pdf->Cell(30 ,5, number_format($dette, 2, ',', ' ').' '.$devises['Devise'],1,0,'R');
	$pdf->Ln(5);
}
$pdf->Output();
?>