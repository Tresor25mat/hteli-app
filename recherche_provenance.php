<?php 
    session_start();
	require_once('connexion.php');
    $req_agent=$pdo->query("SELECT * FROM ecole_provenance ORDER BY Design_Ecole_Provenance");
    $tab_gamme=array();
while($resulcon=$req_agent->fetch()){
	$tab_gamme[]=array(
	               'ID_Ecole_Provenance'=>$resulcon['ID_Ecole_Provenance'],
				   'Design'=>stripslashes($resulcon['Design_Ecole_Provenance'])
				);

}

echo json_encode($tab_gamme);
	
?>