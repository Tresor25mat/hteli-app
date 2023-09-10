<?php
session_start();
// $_SESSION['last_activity'] = time();
require_once ("connexion.php");
require_once("PHPExcel/PHPExcel/IOFactory.php");
$Classeur = htmlentities($_POST['classeur']);
$Feuille = htmlentities($_POST['feuille']);
$Ecole=htmlentities($_POST['Ecole']);
//Chargement du fichier Excel
$objPHPExcel = PHPExcel_IOFactory::load($Classeur);
$sheet = $objPHPExcel->getSheetByName($Feuille);
// $sheet = $objPHPExcel->getActiveSheet();
	$I=3;
	$Nbr=0;
	$Doublon=0;
	$Classe=htmlentities($_POST['classe']);
	$Annee=htmlentities($_POST['annee']);
    $Categorie=$pdo->query("SELECT * FROM categorie_eleve WHERE ID_Etablissement=".$Ecole." AND Active=1");
    $Categories=$Categorie->fetch();
	if($sheet->getCell('A1')->getValue()=='' || $sheet->getCell('E2')->getValue()==''){
		echo "2";
	}else{
		while ($sheet->getCell('B'.$I)->getValue()!=''){
			$Nom=Securite::bdd($sheet->getCell('B'.$I)->getValue());
			$Pnom=Securite::bdd($sheet->getCell('C'.$I)->getValue());
			$Prenom=Securite::bdd($sheet->getCell('D'.$I)->getValue());
			$Sexe=Securite::bdd($sheet->getCell('E'.$I)->getValue());
			$val1=rand();
		    $val2=rand();
		    $chaine=sha1($val1.$val2);
	        $rech=$pdo->query("SELECT * FROM eleve INNER JOIN inscription ON eleve.ID_Eleve=inscription.ID_Eleve WHERE UPPER(eleve.Prenom_Eleve)='".strtoupper($Prenom)."' AND UPPER(eleve.Nom_Eleve)='".strtoupper($Nom)."' AND UPPER(eleve.Pnom_Eleve)='".strtoupper($Pnom)."' AND eleve.Sexe='".$Sexe."' AND inscription.ID_Classe=".$Classe." AND inscription.ID_Annee=".$Annee);
	        if($rechs=$rech->fetch()){
	            $Doublon++;
	        }else{
	            $insert_eleve=$pdo->query("INSERT INTO eleve(ID_Eleve, ID_Etablissement, Prenom_Eleve, Nom_Eleve, Pnom_Eleve, Sexe, ID_Utilisateur) VALUES ('".$chaine."',".$_SESSION['user_eteelo_app']['ID_Etablissement'].",'".$Prenom."','".$Nom."','".$Pnom."','".$Sexe."',".$_SESSION['user_eteelo_app']['ID_Utilisateur'].")");
	            $insert_inscription=$pdo->query("INSERT INTO inscription(ID_Inscription, ID_Eleve, ID_Classe, ID_Annee, ID_Cat_Eleve, ID_Utilisateur) VALUES ('".$chaine."', '".$chaine."', ".$Classe.", ".$Annee.", ".$Categories['ID_Categorie'].", ".$_SESSION['user_eteelo_app']['ID_Utilisateur'].")");
	            $Nbr++;
	        }
	        $I++;
		}
        echo "1,".$Nbr.",".$Doublon;
	}
?>