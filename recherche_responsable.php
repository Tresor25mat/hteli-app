<?php 
    session_start();
	require_once('connexion.php');
    $Ecole=$_POST['Ecole'];
    $req_agent=$pdo->query("SELECT * FROM responsable WHERE ID_Etablissement=".$Ecole." ORDER BY Nom_Responsable");
    $tab_gamme=array();
while($resulcon=$req_agent->fetch()){
	$tab_gamme[]=array(
	               'ID_Responsable'=>$resulcon['ID_Responsable'],
				   'Nom'=>stripslashes($resulcon['Nom_Responsable']).' '.stripslashes($resulcon['Pnom_Responsable']).' '.stripslashes($resulcon['Prenom_Responsable']).' ('.stripslashes($resulcon['Tel']).')'
				);

}

echo json_encode($tab_gamme);
	
?>