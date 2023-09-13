<?php
session_start();
require_once('connexion.php');
require('rotation.php');
$query="SELECT eleve.*, classe.*, annee.*, inscription.*, categorie_eleve.*, inscription.Date_Enreg AS mydate FROM eleve INNER JOIN inscription ON eleve.ID_Eleve=inscription.ID_Eleve INNER JOIN classe ON classe.ID_Classe=inscription.ID_Classe INNER JOIN annee ON annee.ID_Annee=inscription.ID_Annee INNER JOIN table_option ON table_option.ID_Option=classe.ID_Option INNER JOIN section ON section.ID_Section=table_option.ID_Section INNER JOIN categorie_eleve ON inscription.ID_Cat_Eleve=categorie_eleve.ID_Categorie WHERE eleve.ID_Eleve!=''";
if(isset($_GET['Ecole']) && $_GET['Ecole']!=''){
    $query.=" AND section.ID_Etablissement=".$_GET['Ecole'];
}
if(isset($_GET['Annee']) && $_GET['Annee']!=''){
    $query.=" AND annee.ID_Annee =".$_GET['Annee'];
    $sel_annee=$pdo->query("SELECT * FROM annee WHERE ID_Annee=".$_GET['Annee']);
    $annees=$sel_annee->fetch();
}
if(isset($_GET['Classe']) && $_GET['Classe']!=''){
    $query.=" AND inscription.ID_Classe =".$_GET['Classe'];
    $sel_classe=$pdo->query("SELECT * FROM classe WHERE ID_Classe=".$_GET['Classe']);
    $classes=$sel_classe->fetch();
    $sel_titulaire=$pdo->query("SELECT * FROM enseignant WHERE ID_Enseignant='".$classes['ID_Enseignant']."'");
}
$query.=" ORDER BY Nom_Eleve, Pnom_Eleve";
$req_eleve=$pdo->query($query);
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

$pdf->SetSubject(utf8_decode($app_infos['Design_App']." : LISTE DES ELEVES"));
$pdf->SetTitle(utf8_decode($app_infos['Design_App']." : LISTE DES ELEVES"));

if(isset($_GET['Ecole']) && $_GET['Ecole']!=''){
    $ecole=$pdo->query("SELECT * FROM etablissement WHERE ID_Etablissement=".$_GET['Ecole']);
    $ecoles=$ecole->fetch();
    $pdf->Cell(42,15,utf8_decode($ecoles['Design_Etablissement']),0,0,'C');
}
$pdf->Ln(20);
$pdf->SetFont('Arial','BU',17);
$pdf->Cell(190,10,utf8_decode("LISTE DES ELEVES"),0,0,'C');
$pdf->Ln(20);
$pdf->SetFont('Arial','B',12);
// Couleur de fond
$pdf->SetFillColor(200,220,255);
// Titre

if(isset($_GET['Classe']) && $_GET['Classe']!=''){
    $pdf->SetFont('Arial','B','10');
    $pdf->Cell(40 ,5,utf8_decode('Classe'),0,0,'L');
    $pdf->SetFont('Arial','','10');
    $pdf->Cell(80 ,5,':  '.utf8_decode(stripslashes($classes['Design_Classe'])),0,1,'L');
}
if(isset($_GET['Annee']) && $_GET['Annee']!=''){
    $pdf->SetFont('Arial','B','10');
    $pdf->Cell(40 ,5,utf8_decode('Année scolaire'),0,0,'L');
    $pdf->SetFont('Arial','','10');
    $pdf->Cell(80 ,5,':  '.utf8_decode(stripslashes($annees['Libelle_Annee'])),0,1,'L');
}
if(isset($_GET['Classe']) && $_GET['Classe']!='' && $titulaire=$sel_titulaire->fetch()){
    $pdf->SetFont('Arial','B','10');
    $pdf->Cell(40 ,5,utf8_decode('Titulaire'),0,0,'L');
    $pdf->SetFont('Arial','','10');
    $pdf->Cell(80 ,5,':  '.utf8_decode(stripslashes($titulaire['Nom_Enseignant'].' '.$titulaire['Pnom_Enseignant'].' '.$titulaire['Prenom_Enseignant'])),0,1,'L');
}
$pdf->Ln(5);
$pdf->SetFont('Arial','B','10');
$pdf->Cell(7 ,5,utf8_decode("N°"),1,0,'C');
$pdf->Cell(20 ,5,utf8_decode("Matricule"),1,0,'C');
$pdf->Cell(105 ,5,utf8_decode("Noms"),1,0,'C');
// $pdf->Cell(35 ,5,utf8_decode("Post-nom"),1,0,'C');
// $pdf->Cell(35 ,5,utf8_decode("Prénom"),1,0,'C');
$pdf->Cell(22 ,5,utf8_decode("Sexe"),1,0,'C');
$pdf->Cell(35 ,5,utf8_decode("Date d'inscription"),1,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','','10');
$Nbr=0;
while($eleves=$req_eleve->fetch()){
	$Nbr++;
	$pdf->Cell(7 ,5,sprintf('%02d', $Nbr),1,0,'C');
	$pdf->Cell(20 ,5,utf8_decode(stripslashes($eleves['Matricule'])),1,0,'C');
	$pdf->Cell(105 ,5,utf8_decode(stripslashes($eleves['Nom_Eleve'].' '.$eleves['Pnom_Eleve'].' '.$eleves['Prenom_Eleve'])),1,0,'L');
	// $pdf->Cell(35 ,5,utf8_decode(stripslashes($eleves['Pnom_Eleve'])),1,0,'L');
	// $pdf->Cell(35 ,5,utf8_decode(stripslashes($eleves['Prenom_Eleve'])),1,0,'L');
	if($eleves['Sexe']=='M'){
		$pdf->Cell(22 ,5,utf8_decode('Masculin'),1,0,'C');
	}else{
		$pdf->Cell(22 ,5,utf8_decode('Féminin'),1,0,'C');
	}
	$pdf->Cell(35 ,5,date('d/m/Y', strtotime($eleves['mydate'])),1,0,'C');
	$pdf->Ln();
}
$pdf->Output();
?>