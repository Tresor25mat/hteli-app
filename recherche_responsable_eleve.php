<?php 
    session_start();
	require_once('connexion.php');
    $Eleve=htmlentities($_POST['ID_Eleve']);
    $req_agent=$pdo->query("SELECT * FROM responsable INNER JOIN eleve_responsable ON responsable.ID_Responsable=eleve_responsable.ID_Responsable WHERE eleve_responsable.ID_Eleve='".$Eleve."'");
    $tab_gamme=array();
	if($resulcon=$req_agent->fetch()){
        $tab_gamme[]=array(
            'Prenom'=>stripslashes($resulcon['Prenom_Responsable']),
            'Nom'=>stripslashes($resulcon['Nom_Responsable']),
            'Pnom'=>stripslashes($resulcon['Pnom_Responsable']),
            'Sexe'=>stripslashes($resulcon['Sexe']),
            'Tel'=>stripslashes($resulcon['Tel']),
            'Lien'=>stripslashes($resulcon['ID_Degre']),
            'Responsable'=>stripslashes($resulcon['ID_Responsable'])
        );
	}
	echo json_encode($tab_gamme);
?>