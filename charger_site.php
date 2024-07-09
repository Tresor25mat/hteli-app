<?php 
    session_start();
    require_once('connexion.php');
    if(isset($_POST['ID'])){
        $ID = $_POST['ID'];
        $liste_site = $pdo->query('SELECT * FROM utilisateur_site WHERE ID_Utilisateur='.$ID.' ORDER BY ID_Site');
        $list=array();
        while($liste_sites = $liste_site->fetch()){
            $list[]=$liste_sites['ID_Site'];
        }
        echo json_encode($list);
    }
?>