<?php 
    session_start();
	require_once('connexion.php');
    $req_agent=$pdo->query("SELECT * FROM agent ORDER BY Nom_Agent");
    $tab_agent=array();
    while($agents=$req_agent->fetch()){
        $tab_agent[]=array(
            'ID_Agent'=>$agents['ID_Agent'],
            'Nom'=>stripslashes(strtoupper($agents['Nom_Agent']))
        );
    }
    echo json_encode($tab_agent);
?>