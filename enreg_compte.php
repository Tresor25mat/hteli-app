<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $Categorie=htmlentities($_POST['categorie']);
    $Numero=htmlentities($_POST['numero_compte']);
    $Design=Securite::bdd($_POST['design']);
    $Ecole=htmlentities($_POST['ID_Etablissement']);
    $Nature=htmlentities($_POST['nature']);
    $aig=0;
    $sel_categorie=$pdo->query("SELECT * FROM categorie_compte WHERE ID_Categorie=".$Categorie);
    $sel_categories=$sel_categorie->fetch();
    $sel=$pdo->query("SELECT * FROM compte INNER JOIN categorie_compte ON compte.ID_Categorie=categorie_compte.ID_Categorie");
    while ($sels=$sel->fetch()) {
        if(($sels['Cod_Categorie'].$sels['Cod_Compte'])==($sel_categories['Cod_Categorie'].$Numero) && ($sels['ID_Etablissement']==$Ecole)){
            $aig=1;
        }
    }
    if($aig==0){
        if($Token==$_SESSION['user_eteelo_app']['token']){
            $rs=$pdo->prepare("INSERT INTO compte(ID_Etablissement, ID_Nature, Cod_Compte, ID_Categorie, Design_Compte, ID_Utilisateur) VALUES (?,?,?,?,?,?)");
            $params=array($Ecole, $Nature, $Numero, $Categorie, $Design, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
            $rs->execute($params);
            if($Nature==8){
                $max=$pdo->query("SELECT MAX(ID_Compte) AS ID_Compte FROM compte");
                $maxid=$max->fetch();
                $compte=$maxid['ID_Compte'];
                $insert=$pdo->query("INSERT INTO type_frais (Libelle_Type_Frais, ID_Etablissement, ID_Compte, ID_Utilisateur) VALUES ('".$Design."', ".$Ecole.", ".$compte.", 1)");
            }
            echo "1";
        }
    }else{
        echo "2";
    }
?>