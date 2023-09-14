<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $Design_Tranche=Securite::bdd($_POST['Design_Tranche']);
    $Ecole=htmlentities($_POST['Ecole']);
    $Type_frais=htmlentities($_POST['Type_frais']);
    $Devise=htmlentities($_POST['Devise']);
    $Montant=htmlentities($_POST['Montant']);
    $Montant_Tranche=htmlentities($_POST['Montant_Tranche']);
    $annee=$pdo->query("SELECT * FROM annee WHERE Encours=1");
    $annees=$annee->fetch();
    $Id_Frais=htmlentities($_POST['Frais']);;
    $sel=$pdo->query("SELECT SUM(Montant_Tranche) AS Montant_Tranche FROM tranche_frais WHERE ID_Frais=".$Id_Frais);
    $sels=$sel->fetch();
    $rech_tranche=$pdo->query("SELECT * FROM tranche_frais WHERE ID_Frais=".$Id_Frais." AND UCASE(Design_Tranche_Frais)='".strtoupper($Design_Tranche)."'");
    if($rech_tranches=$rech_tranche->fetch()){
        echo '2';
    }else{
        $sel=$pdo->query("SELECT SUM(Montant_Tranche) AS Montant_Tranche FROM tranche_frais WHERE ID_Frais=".$Id_Frais);
        $sels=$sel->fetch();
        if((intval($sels['Montant_Tranche'])+intval($Montant_Tranche))>intval($Montant)){
            echo "3";
        }else{
            if($Token==$_SESSION['user_eteelo_app']['token']){
                $update_frais=$pdo->query("UPDATE frais SET ID_Type_Frais=".$Type_frais.", ID_Annee=".$annees['ID_Annee'].", ID_Taux=".$Devise.", Montant_Frais=".$Montant." WHERE ID_Frais=".$Id_Frais);
                $rs=$pdo->prepare("INSERT INTO tranche_frais(ID_Frais, Design_Tranche_Frais, Montant_Tranche, ID_Utilisateur) VALUES (?,?,?,?)");
                $params=array($Id_Frais, $Design_Tranche, $Montant_Tranche, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
                $rs->execute($params);
                echo "1";
            }
        }
    }
?>