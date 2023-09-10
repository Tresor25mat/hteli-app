<?php 
    session_start();
	require_once('connexion.php');
    $Eleve=htmlentities($_POST['ID_Eleve']);
    $req_agent=$pdo->query("SELECT * FROM eleve WHERE ID_Eleve='".$Eleve."'");
    $tab_gamme=array();
	if($resulcon=$req_agent->fetch()){
        $Inscription=$pdo->query("SELECT * FROM inscription WHERE ID_Eleve='".$Eleve."'");
        $Inscriptions=$Inscription->fetch();
        $provenance=$pdo->query("SELECT * FROM ecole_provenance WHERE ID_Ecole_Provenance=".$resulcon['ID_Ecole_Provenance']);
        $provenances=$provenance->fetch();
        $tab_gamme[]=array(
            'Matricule'=>stripslashes($resulcon['Matricule']),
            'Prenom'=>stripslashes($resulcon['Prenom_Eleve']),
            'Nom'=>stripslashes($resulcon['Nom_Eleve']),
            'Pnom'=>stripslashes($resulcon['Pnom_Eleve']),
            'Sexe'=>stripslashes($resulcon['Sexe']),
            'Adresse'=>stripslashes($resulcon['Adresse']),
            'Commune'=>stripslashes($resulcon['ID_Commune']),
            'Lieu'=>stripslashes($resulcon['ID_Lieu_Naiss']),
            'Date_Naissance'=>date('d/m/Y', strtotime($resulcon['Date_Naissance'])),
            'Date_N'=>date('Y-m-d', strtotime($resulcon['Date_Naissance'])),
            'Categorie'=>stripslashes($Inscriptions['ID_Cat_Eleve']),
            'Provenance'=>stripslashes($provenances['Design_Ecole_Provenance']),
            'ID_Provenance'=>stripslashes($provenances['ID_Ecole_Provenance']),
            'Photo'=>stripslashes($resulcon['Photo'])
        );
	}
	echo json_encode($tab_gamme);
?>