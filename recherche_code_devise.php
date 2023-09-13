<?php
    require_once ("connexion.php");
    $Devise=$_POST['Devise'];
    $rech=$pdo->query("SELECT * FROM taux_change WHERE ID_Taux=".$Devise);
    $rechs=$rech->fetch();
    echo $rechs['Devise'];
?>