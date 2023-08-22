<?php 
    session_start();
	require_once('connexion.php');
	$Ecole=$_POST['Ecole'];
    $req_enseignant=$pdo->query("SELECT * FROM enseignant WHERE ID_Etablissement=".$Ecole." ORDER BY Nom_Enseignant, Pnom_Enseignant");
    $tab_enseignant=array();
    while($enseignant=$req_enseignant->fetch()){
        $tab_enseignant[]=array(
            'ID_Enseignant'=>$enseignant['ID_Enseignant'],
            'Nom'=>stripslashes($enseignant['Nom_Enseignant']).' '.stripslashes($enseignant['Pnom_Enseignant']).' '.stripslashes($enseignant['Prenom_Enseignant'])
        );
    }
    echo json_encode($tab_enseignant);
?>