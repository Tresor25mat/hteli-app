<?php
    session_start();
    require_once ("connexion.php");
    $Code=htmlentities($_POST['categorie']);
    $rech=$pdo->query("SELECT * FROM categorie_compte WHERE ID_Categorie=".$Code);
    $rechs=$rech->fetch();
    echo $rechs['Cod_Categorie'];
?>