<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token_key'];
    $ID_Rapport=htmlentities($_POST['ID_Rapport']);
    for($i=1; $i<=30; $i++) {
        $Test_result=Securite::bdd($_POST['test_result_'.$i]);
        $Pass_Fail=htmlentities($_POST['pass_fail_'.$i]);
        $Remark=Securite::bdd($_POST['remark_'.$i]);
        if($Token==$_SESSION['user_eteelo_app']['token']){
            $rs=$pdo->prepare("INSERT INTO questionnaire_janitorial (ID_Rapport, Indice, Test_Results, Pass, Remarks) VALUES (?,?,?,?,?)");
            $params=array($ID_Rapport, $i, $Test_result, $Pass_Fail, $Remark);
            $rs->execute($params);
        }
    }
    $Description=Securite::bdd($_POST['description']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $update=$pdo->query("UPDATE table_rapport_janitorial SET Description='".$Description."' WHERE ID_Rapport=".$ID_Rapport);
        echo "1";
    }
?>