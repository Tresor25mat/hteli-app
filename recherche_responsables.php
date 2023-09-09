<?php 
    session_start();
	require_once('connexion.php');
	$ID_Responsable=$_POST['ID_Responsable'];
    $req_agent=$pdo->query("SELECT * FROM responsable WHERE ID_Responsable='".$ID_Responsable."'");
    $req_profession=$pdo->query("SELECT * FROM profession INNER JOIN responsable ON profession.ID_Profession=responsable.ID_Profession WHERE responsable.ID_Responsable='".$ID_Responsable."'");
    $professions=$req_profession->fetch();
    $tab_gamme=array();
while($resulcon=$req_agent->fetch()){
	$tab_gamme[]=array(
				   'Nom'=>stripslashes($resulcon['Nom_Responsable']),
				   'Pnom'=>stripslashes($resulcon['Pnom_Responsable']),
				   'Prenom'=>stripslashes($resulcon['Prenom_Responsable']),
				   'Tel'=>stripslashes($resulcon['Tel']),
				   'Sexe'=>stripslashes($resulcon['Sexe']),
				   'ID_Profession'=>$professions['ID_Profession'],
				   'Design'=>stripslashes($professions['Design_Profession'])
				);

}

echo json_encode($tab_gamme);
	
?>