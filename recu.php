<?php
session_start();
require_once('connexion.php');
require('fpdf/WriteTag.php');
require_once('libs/phpqrcode/qrlib.php');
require_once('NumberToString.php');
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

		// Courier gras 15
		$this->SetFont('Courier','BI',10);
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
		
		// $this->SetFont('Courier','BI','8');
		// $this->setY(-13);
		
		// $this->SetFont('Courier','I','8');
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



$pdf=new PDF_WriteTag();

$pdf->AddPage('P','A4',0);

$pdf->SetSubject(utf8_decode($app_infos['Design_App']." : REÇU"));
$pdf->SetTitle(utf8_decode($app_infos['Design_App']." : REÇU"));

$pdf->SetStyle("p","courier","B",11,"0,0,0",0);
$pdf->SetStyle("h1","arial","BU",16,"0,0,0",0);
$pdf->SetStyle("a","times","BU",9,"0,0,255");
$pdf->SetStyle("pers","times","N",0,"255,0,0");
$pdf->SetStyle("place","arial","U",0,"153,0,0");
$pdf->SetStyle("vb","arial","B",0,"0,0,0");
$pdf->SetStyle("vm","arial","BI",0,"0,0,0");

$ecole=$pdo->query("SELECT * FROM etablissement WHERE ID_Etablissement=".$Ecole);
$ecoles=$ecole->fetch();
$pdf->SetFont('Courier','B',13);
$pdf->Cell(50,7,utf8_decode($ecoles['Design_Etablissement']),0,1,'L');
$txt=utf8_decode('<p>'.$ecoles['Description_Etablissement'].'</p>');
$pdf->WriteTag(65,4,$txt,0,"L",0,0);
$pdf->Ln();
$pdf->SetFont('Courier','BU',17);
if($eleves['Confirm_Paiement']==2){
	$pdf->Cell(190,10,utf8_decode("PRO FORMA"),0,0,'C');
}else{
	$pdf->Cell(190,10,utf8_decode("REÇU N° ".$eleves['Num_Recu']),0,0,'C');
	$tempDir = 'images/temp'; 
	$filename = "RECU_".$eleves['Num_Recu'];
	$codeContents = $eleves['Num_Recu']; 
	QRcode::png($codeContents, $tempDir.''.$filename.'.png', QR_ECLEVEL_L, 5);
	$pdf->Image('images/temp'. @$filename.'.png','166','10','35','35','PNG');
	$pdf->SetXY(169,13);
	$pdf->MultiCell(29,29,utf8_decode(""),1,'L');
}

$pdf->Ln(3);
$pdf->SetFont('Courier','B',12);
// Couleur de fond
$pdf->SetFillColor(200,220,255);
// Titre
$pdf->SetFont('Courier','B','11');
$pdf->Cell(37 ,6,'Matricule     :',1,0,'L');
$pdf->SetFont('Courier','','11');
$pdf->Cell(73 ,6,utf8_decode($eleves['Matricule']),1,0,'L');

$pdf->SetFont('Courier','B','11');
$pdf->Cell(37 ,6,utf8_decode('Date paiement :'),1,0,'L');
$pdf->SetFont('Courier','','11');
$pdf->Cell(41 ,6,date('d/m/Y', strtotime($eleves['Date_Paiement'])),1,1,'L');

$pdf->SetFont('Courier','B','11');
$pdf->Cell(37 ,6,'Noms          :',1,0,'L');
$pdf->SetFont('Courier','','11');
$pdf->Cell(73 ,6,utf8_decode(stripslashes($eleves['Nom_Eleve'])).' '.utf8_decode(stripslashes($eleves['Pnom_Eleve'])).' '.utf8_decode(stripslashes($eleves['Prenom_Eleve'])),1,0,'L');

$pdf->SetFont('Courier','B','11');
$pdf->Cell(37 ,6,utf8_decode('Heure         :'),1,0,'L');
$pdf->SetFont('Courier','','11');
$pdf->Cell(41 ,6,date('H:i:s', strtotime($eleves['Heure_paiement'])),1,1,'L');

$pdf->SetFont('Courier','B','11');
$pdf->Cell(37 ,6,'Classe        :',1,0,'L');
$pdf->SetFont('Courier','','11');
$pdf->Cell(73 ,6,utf8_decode(stripslashes($eleves['Design_Classe'])),1,0,'L');

$pdf->SetFont('Courier','B','11');
$pdf->Cell(37 ,6,utf8_decode('Montant payé  :'),1,0,'L');
$pdf->SetFont('Courier','','11');
$pdf->Cell(41 ,6,number_format($eleves['Montant_Paie'], 2, ',', ' ').' '.$devises['Devise'],1,1,'L');

$pdf->SetFont('Courier','B','11');
$pdf->Cell(37 ,6,utf8_decode('Année scolaire:'),1,0,'L');
$pdf->SetFont('Courier','','11');
$pdf->Cell(73 ,6,utf8_decode(stripslashes($eleves['Libelle_Annee'])),1,0,'L');
$pdf->SetFont('Courier','B','11');
$pdf->Cell(37 ,6,utf8_decode("Taux de change:"),1,0,'L');
$pdf->SetFont('Courier','','11');
$pdf->Cell(41 ,6,number_format($eleves['Taux'], 2, ',', ' '),1,0,'L');
// $pdf->Cell(0,6,utf8_decode("Nom de l'élève :".stripslashes($eleves['Nom_Eleve'])." ".stripslashes($eleves['Pnom_Eleve'])." ".stripslashes($eleves['Prenom_Eleve'])),0,1,'L',true);
$pdf->Ln(7);
$pdf->SetFont('Courier','B','11');
$pdf->Cell(7 ,6,utf8_decode("N°"),1,0,'C');
$pdf->Cell(140 ,6,utf8_decode("Détails frais"),1,0,'C');
// $pdf->Cell(47 ,5,utf8_decode("Tranche"),1,0,'C');
// $pdf->Cell(47 ,5,utf8_decode("Montant"),1,0,'C');
$pdf->Cell(41 ,6,utf8_decode("Montant"),1,0,'C');
$pdf->Ln();
$pdf->SetFont('Courier','','11');
$mont=0;
$Nbr=1;
$frais=$req_frais->fetch();
$pdf->Cell(7 ,6,sprintf('%02d', $Nbr),1,0,'C');
$pdf->Cell(140 ,6,utf8_decode(stripslashes($frais['Libelle_Type_Frais'])),1,0,'L');
$pdf->Cell(41 ,6,utf8_decode(number_format($eleves['Montant_Paie'], 2, ',', ' ').' '.$devises['Devise']),1,0,'R');
$pdf->Ln();
$pdf->SetFont('Courier','B','11');
$pdf->Cell(147 ,6, utf8_decode('Total'),1,0,'R');
$pdf->Cell(41 ,6, number_format($eleves['Montant_Paie'], 2, ',', ' ').' '.$devises['Devise'],1,0,'R');
// $pdf->Cell(47 ,5, utf8_decode(stripslashes($eleves['Devise'])),1,0,'L');
$pdf->Ln(10);
$pdf->SetFont('Courier','BI','11');
$pdf->Cell(50 ,6,utf8_decode('MONTANT EN LETTRES : '),0,0,'L');
$pdf->SetFont('Courier','I','11');
$myclass = new NumberToString();
if($devises['ID_Taux']==1){
	$pdf->Cell(200 ,6, strtoupper('FRANC CONGOLAIS '.$myclass->getString($eleves['Montant_Paie'], '')),0,0,'L');
}else{
	$pdf->Cell(200 ,6, strtoupper('DOLLAR AMERICAIN '.$myclass->getString($eleves['Montant_Paie'], '')),0,0,'L');
}
$pdf->Ln(10);
$pdf->SetFont('Courier','B','11');
$pdf->Cell(28 ,6,utf8_decode('Utilisateur'),0,0,'R');
$pdf->SetFont('Courier','','11');
$pdf->Cell(89 ,6,': '.utf8_decode(stripslashes($eleves['Prenom']).' '.stripslashes($eleves['Nom'])),0,0,'L');

$pdf->SetFont('Courier','B','11');
$pdf->Cell(45 ,6,utf8_decode('Fait à Kinshasa, le '),0,0,'L');
$pdf->SetFont('Courier','','11');
$pdf->Cell(50 ,6,date("d/m/Y"),0,0,'L');
// $pdf->Cell(180 ,5, utf8_decode('Fait à Kinshasa, le ').date("d/m/Y"),0,0,'R');
// $pdf->Ln(7);
// $pdf->Cell(180 ,5, utf8_decode('Utilisateur : ').utf8_decode(stripslashes($eleves['Prenom']).' '.stripslashes($eleves['Nom'])),0,1,'R');
$pdf->Output();
?>