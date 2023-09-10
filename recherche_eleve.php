<?php 
    session_start();
	require_once('connexion.php');
    $Ecole=htmlentities($_POST['Ecole']);
    $req_agent=$pdo->query("SELECT * FROM eleve WHERE ID_Etablissement=".$Ecole." ORDER BY Nom_Eleve");
    $tab_gamme=array();
	while($resulcon=$req_agent->fetch()){
		if($resulcon['Matricule']!=''){
			$tab_gamme[]=array(
				'ID_Eleve'=>$resulcon['ID_Eleve'],
				'Nom'=>stripslashes($resulcon['Nom_Eleve']).' '.stripslashes($resulcon['Pnom_Eleve']).' '.stripslashes($resulcon['Prenom_Eleve']).' ('.stripslashes($resulcon['Matricule']).')'
			);
		}else{
			$tab_gamme[]=array(
				'ID_Eleve'=>$resulcon['ID_Eleve'],
				'Nom'=>stripslashes($resulcon['Nom_Eleve']).' '.stripslashes($resulcon['Pnom_Eleve']).' '.stripslashes($resulcon['Prenom_Eleve'])
			);
		}
	}
	echo json_encode($tab_gamme);
?>