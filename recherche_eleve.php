<?php 
    session_start();
	require_once('connexion.php');
    $Ecole=htmlentities($_POST['Ecole']);
	$query="SELECT * FROM eleve INNER JOIN inscription ON eleve.ID_Eleve=inscription.ID_Eleve WHERE eleve.ID_Eleve!=''";
	if(isset($_POST['Annee']) && $_POST['Annee']!=''){
		$query.=" AND inscription.ID_Annee=".$_POST['Annee'];
	}
	if(isset($_POST['Classe']) && $_POST['Classe']!=''){
		$query.=" AND inscription.ID_Classe=".$_POST['Classe'];
	}
	if(isset($_POST['Ecole']) && $_POST['Ecole']!=''){
		$query.=" AND eleve.ID_Etablissement=".$_POST['Ecole'];
		$req_agent=$pdo->query("SELECT * FROM eleve WHERE ID_Etablissement=".$Ecole." ORDER BY Nom_Eleve");
	}
	$query.=" ORDER BY eleve.Nom_Eleve";
	$req_agent=$pdo->query($query);
    $tab_gamme=array();
	while($resulcon=$req_agent->fetch()){
		if($resulcon['Matricule']!=''){
			$tab_gamme[]=array(
				'ID_Eleve'=>$resulcon['ID_Eleve'],
				'ID_Inscription'=>$resulcon['ID_Inscription'],
				'Nom'=>stripslashes($resulcon['Nom_Eleve']).' '.stripslashes($resulcon['Pnom_Eleve']).' '.stripslashes($resulcon['Prenom_Eleve']).' ('.stripslashes($resulcon['Matricule']).')'
			);
		}else{
			$tab_gamme[]=array(
				'ID_Eleve'=>$resulcon['ID_Eleve'],
				'ID_Inscription'=>$resulcon['ID_Inscription'],
				'Nom'=>stripslashes($resulcon['Nom_Eleve']).' '.stripslashes($resulcon['Pnom_Eleve']).' '.stripslashes($resulcon['Prenom_Eleve'])
			);
		}
	}
	echo json_encode($tab_gamme);
?>