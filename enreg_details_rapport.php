<?php
    session_start(); 
    require_once("connexion.php");
    $Token=$_POST['token_key'];
    $ID_Rapport=htmlentities($_POST['ID_Rapport']);
    $Test_result1=Securite::bdd($_POST['test_result1']);
    $Ok_nok1=htmlentities($_POST['ok_nok1']);
    $NCR_if_any1=Securite::bdd($_POST['ncr_if_any1']);
    $Test_result2=Securite::bdd($_POST['test_result2']);
    $Ok_nok2=htmlentities($_POST['ok_nok2']);
    $NCR_if_any2=Securite::bdd($_POST['ncr_if_any2']);
    $Test_result3=Securite::bdd($_POST['test_result3']);
    $Ok_nok3=htmlentities($_POST['ok_nok3']);
    $NCR_if_any3=Securite::bdd($_POST['ncr_if_any3']);
    $Test_result4=Securite::bdd($_POST['test_result4']);
    $Ok_nok4=htmlentities($_POST['ok_nok4']);
    $NCR_if_any4=Securite::bdd($_POST['ncr_if_any4']);
    $Test_result5=Securite::bdd($_POST['test_result5']);
    $Ok_nok5=htmlentities($_POST['ok_nok5']);
    $NCR_if_any5=Securite::bdd($_POST['ncr_if_any5']);
    $Test_result6=Securite::bdd($_POST['test_result6']);
    $Ok_nok6=htmlentities($_POST['ok_nok6']);
    $NCR_if_any6=Securite::bdd($_POST['ncr_if_any6']);
    $Test_result7=Securite::bdd($_POST['test_result7']);
    $Ok_nok7=htmlentities($_POST['ok_nok7']);
    $NCR_if_any7=Securite::bdd($_POST['ncr_if_any7']);
    $Test_result8=Securite::bdd($_POST['test_result8']);
    $Ok_nok8=htmlentities($_POST['ok_nok8']);
    $NCR_if_any8=Securite::bdd($_POST['ncr_if_any8']);
    $Test_result9=Securite::bdd($_POST['test_result9']);
    $Ok_nok9=htmlentities($_POST['ok_nok9']);
    $NCR_if_any9=Securite::bdd($_POST['ncr_if_any9']);
    $Test_result10=Securite::bdd($_POST['test_result10']);
    $Ok_nok10=htmlentities($_POST['ok_nok10']);
    $NCR_if_any10=Securite::bdd($_POST['ncr_if_any10']);
    $Description=Securite::bdd($_POST['description']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("INSERT INTO questionnaire_rapport_tour (ID_Rapport, Test_Results_1, Etat_1, Ncr_If_Any_1, Test_Results_2, Etat_2, Ncr_If_Any_2, Test_Results_3, Etat_3, Ncr_If_Any_3, Test_Results_4, Etat_4, Ncr_If_Any_4, Test_Results_5, Etat_5, Ncr_If_Any_5, Test_Results_6, Etat_6, Ncr_If_Any_6, Test_Results_7, Etat_7, Ncr_If_Any_7, Test_Results_8, Etat_8, Ncr_If_Any_8, Test_Results_9, Etat_9, Ncr_If_Any_9, Test_Results_10, Etat_10, Ncr_If_Any_10) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $params=array($ID_Rapport, $Test_result1, $Ok_nok1, $NCR_if_any1, $Test_result2, $Ok_nok2, $NCR_if_any2, $Test_result3, $Ok_nok3, $NCR_if_any3, $Test_result4, $Ok_nok4, $NCR_if_any4, $Test_result5, $Ok_nok5, $NCR_if_any5, $Test_result6, $Ok_nok6, $NCR_if_any6, $Test_result7, $Ok_nok7, $NCR_if_any7, $Test_result8, $Ok_nok8, $NCR_if_any8, $Test_result9, $Ok_nok9, $NCR_if_any9, $Test_result10, $Ok_nok10, $NCR_if_any10);
        $rs->execute($params);
        $update=$pdo->query("UPDATE table_rapport_mensuel_tour SET Description='".$Description."' WHERE ID_Rapport=".$ID_Rapport);
        echo "1";
    }
?>