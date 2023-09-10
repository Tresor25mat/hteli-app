<?php
session_start();
require_once('connexion.php');
require('rotation.php');
$app_info=$pdo->query("SELECT * FROM app_infos");
$app_infos=$app_info->fetch();
$ID = htmlentities($_GET['ID']);
$req_eleve=$pdo->query("SELECT * FROM eleve  WHERE ID_Eleve='".$ID."'");
$eleves=$req_eleve->fetch();
$req_eleve2=$pdo->query("SELECT lieu.*, commune.* FROM eleve INNER JOIN lieu ON eleve.ID_Lieu_Naiss=lieu.ID_Lieu INNER JOIN commune ON eleve.ID_Commune=commune.ID_Commune WHERE eleve.ID_Eleve='".$ID."'");
$eleves2=$req_eleve2->fetch();
$provenance=$pdo->query("SELECT * FROM ecole_provenance INNER JOIN eleve ON eleve.ID_Ecole_Provenance=ecole_provenance.ID_Ecole_Provenance WHERE eleve.ID_Eleve='".$ID."'");
$provenances=$provenance->fetch();
$req_responsable=$pdo->query("SELECT responsable.*, eleve_responsable.*, degre.* FROM responsable INNER JOIN eleve_responsable ON responsable.ID_Responsable=eleve_responsable.ID_Responsable INNER JOIN degre ON eleve_responsable.ID_Degre=degre.ID_Degre WHERE eleve_responsable.ID_Eleve='".$ID."'");
if($eleves['ID_Commune_Orig']!=''){
	$origine=$pdo->query("SELECT commune.*, ville.*, province.* FROM commune INNER JOIN ville ON commune.ID_Ville=ville.ID_Ville INNER JOIN province ON ville.ID_Prov=province.ID_Prov WHERE commune.ID_Commune=".$eleves['ID_Commune_Orig']);
	$origines=$origine->fetch();
}

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

$pdf->SetSubject(utf8_decode($app_infos['Design_App']." : INFORMATIONS DE L'ELEVE"));
$pdf->SetTitle(utf8_decode($app_infos['Design_App']." : INFORMATIONS DE L'ELEVE"));
// $pdf->Cell(22,5,utf8_decode("COMPTA"),0,0,'C');
$ecole=$pdo->query("SELECT * FROM etablissement WHERE ID_Etablissement=".$_SESSION['user_eteelo_app']['ID_Etablissement']);
$ecoles=$ecole->fetch();
$pdf->Cell(42,15,utf8_decode($ecoles['Design_Etablissement']),0,0,'C');
$pdf->Ln(20);
$pdf->SetFont('Arial','BU',17);
$pdf->Cell(190,10,utf8_decode("INFORMATIONS DE L'ELEVE"),0,0,'C');
$pdf->Ln(20);
$pdf->SetFont('Arial','B',12);
// Couleur de fond
$pdf->SetFillColor(200,220,255);
// Titre
if($eleves['Photo']==''){
	if($eleves['Sexe']=='F'){
		$img='images/photo_femme.jpg';
	}else{
		$img='images/photo.jpg';
	}
}else{
	$img='images/eleves/'.$eleves['Photo'];
}
$pdf->Image($img,'150','50','45','52','');
$pdf->SetFont('Arial','B','11');
$pdf->Cell(40 ,5,'Matricule',0,0,'L');
$pdf->SetFont('Arial','','11');
$pdf->Cell(80 ,5,':  '.utf8_decode($eleves['Matricule']),0,1,'L');
$pdf->SetFont('Arial','B','11');
$pdf->Cell(40 ,5,'Nom',0,0,'L');
$pdf->SetFont('Arial','','11');
$pdf->Cell(80 ,5,':  '.utf8_decode(stripslashes($eleves['Nom_Eleve'])),0,1,'L');
$pdf->SetFont('Arial','B','11');
$pdf->Cell(40 ,5,utf8_decode('Post-nom'),0,0,'L');
$pdf->SetFont('Arial','','11');
$pdf->Cell(80 ,5,':  '.utf8_decode(stripslashes($eleves['Pnom_Eleve'])),0,1,'L');
$pdf->SetFont('Arial','B','11');
$pdf->Cell(40 ,5,utf8_decode('Prénom'),0,0,'L');
$pdf->SetFont('Arial','','11');
$pdf->Cell(80 ,5,':  '.utf8_decode(stripslashes($eleves['Prenom_Eleve'])),0,1,'L');
$pdf->SetFont('Arial','B','11');
$pdf->Cell(40 ,5,utf8_decode('Sexe'),0,0,'L');
$pdf->SetFont('Arial','','11');
if($eleves['Sexe']=='M'){
	$pdf->Cell(80 ,5,':  '.utf8_decode('Masculin'),0,1,'L');
}else{
	$pdf->Cell(80 ,5,':  '.utf8_decode('Féminin'),0,1,'L');
}
$pdf->SetFont('Arial','B','11');
$pdf->Cell(40 ,5,utf8_decode('Lieu de naissance'),0,0,'L');
$pdf->SetFont('Arial','','11');
$pdf->Cell(80 ,5,':  '.utf8_decode(stripslashes($eleves2['Design_Lieu'])),0,1,'L');
$pdf->SetFont('Arial','B','11');
$pdf->Cell(40 ,5,utf8_decode('Date de naissance'),0,0,'L');
$pdf->SetFont('Arial','','11');
$pdf->Cell(80 ,5,':  '.date('d/m/Y', strtotime($eleves['Date_Naissance'])),0,1,'L');
$pdf->SetFont('Arial','B','11');
$pdf->Cell(40 ,5,utf8_decode('Adresse'),0,0,'L');
$pdf->SetFont('Arial','','11');
$pdf->Cell(80 ,5,':  '.utf8_decode(stripslashes($eleves['Adresse'])),0,1,'L');
$pdf->SetFont('Arial','B','11');
$pdf->Cell(40 ,5,utf8_decode('Commune'),0,0,'L');
$pdf->SetFont('Arial','','11');
$pdf->Cell(80 ,5,':  '.utf8_decode(stripslashes($eleves2['Design_Commune'])),0,1,'L');
$pdf->SetFont('Arial','B','11');
$pdf->Cell(40 ,5,utf8_decode('Ecole de provenance'),0,0,'L');
$pdf->SetFont('Arial','','11');
$pdf->Cell(80 ,5,':  '.utf8_decode(stripslashes($provenances['Design_Ecole_Provenance'])),0,1,'L');
if($eleves['ID_Commune_Orig']!=''){
	$pdf->SetFont('Arial','B','11');
	$pdf->Cell(40 ,5,utf8_decode("Province d'origine"),0,0,'L');
	$pdf->SetFont('Arial','','11');
	$pdf->Cell(80 ,5,':  '.utf8_decode(stripslashes($origines['Design_Prov'])),0,1,'L');
	$pdf->SetFont('Arial','B','11');
	$pdf->Cell(40 ,5,utf8_decode("Territoire"),0,0,'L');
	$pdf->SetFont('Arial','','11');
	$pdf->Cell(80 ,5,':  '.utf8_decode(stripslashes($origines['Design_Ville'])),0,1,'L');
	$pdf->SetFont('Arial','B','11');
	$pdf->Cell(40 ,5,utf8_decode("Secteur"),0,0,'L');
	$pdf->SetFont('Arial','','11');
	$pdf->Cell(80 ,5,':  '.utf8_decode(stripslashes($origines['Design_Commune'])),0,1,'L');
}

$pdf->Ln(5);
$pdf->SetFont('Arial','B','11');
$pdf->Cell(7 ,5,utf8_decode("N°"),1,0,'C');
$pdf->Cell(60 ,5,utf8_decode("Noms du responsable"),1,0,'C');
$pdf->Cell(21 ,5,utf8_decode("Sexe"),1,0,'C');
$pdf->Cell(32 ,5,utf8_decode("Téléphone"),1,0,'C');
$pdf->Cell(35 ,5,utf8_decode("Lien de parenté"),1,0,'C');
$pdf->Cell(35 ,5,utf8_decode("Profession"),1,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','','11');
$Nbr=0;
while($responsables=$req_responsable->fetch()){
	$profession=$pdo->query("SELECT * FROM profession WHERE ID_Profession=".$responsables['ID_Profession']);
	$professions=$profession->fetch();
	$Nbr++;
	$pdf->Cell(7 ,5,sprintf('%02d', $Nbr),1,0,'C');
	$pdf->Cell(60 ,5,utf8_decode(stripslashes($responsables['Nom_Responsable'].' '.$responsables['Pnom_Responsable'].' '.$responsables['Prenom_Responsable'])),1,0,'L');
	if($responsables['Sexe']=='M'){
		$pdf->Cell(21 ,5,utf8_decode('Masculin'),1,0,'C');
	}else{
		$pdf->Cell(21 ,5,utf8_decode('Féminin'),1,0,'C');
	}
	$pdf->Cell(32 ,5,utf8_decode(stripslashes($responsables['Tel'])),1,0,'L');
	$pdf->Cell(35 ,5,utf8_decode(stripslashes($responsables['Design_Degre'])),1,0,'L');
	$pdf->Cell(35 ,5,utf8_decode(stripslashes($professions['Design_Profession'])),1,0,'L');
	$pdf->Ln();
}
$pdf->Output();
?>