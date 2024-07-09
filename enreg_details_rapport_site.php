<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token_key'];
    $ID_Rapport=htmlentities($_POST['ID_Rapport']);
    for($i=1; $i<=26; $i++) {
        $Measured_Value=Securite::bdd($_POST['measured_value_'.$i]);
        $Remark=Securite::bdd($_POST['remark_'.$i]);
        if($Token==$_SESSION['user_eteelo_app']['token']){
            $rs=$pdo->prepare("INSERT INTO questionnaire_rapport_site (ID_Rapport, Indice, Measured_Value, Remarks) VALUES (?,?,?,?)");
            $params=array($ID_Rapport, $i, $Measured_Value, $Remark);
            $rs->execute($params);
        }
    }
    $Description=Securite::bdd($_POST['description']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $update=$pdo->query("UPDATE table_rapport_mensuel_site SET Description='".$Description."' WHERE ID_Rapport=".$ID_Rapport);
        echo "1";
    }
?>