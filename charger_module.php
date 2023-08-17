<?php 
    session_start();
    require_once('connexion.php');
    if(isset($_POST['ID'])){
        $ID = $_POST['ID'];
        $Utilisateur = $pdo->query('SELECT * FROM utilisateur WHERE ID_Utilisateur='.$ID);
        $Utilisateurs = $Utilisateur->fetch();
        $list=array();
        if($Utilisateurs['Inscription']==1){
            $list[]=1;
        }
        if($Utilisateurs['Discipline']==1){
            $list[]=2;
        }
        if($Utilisateurs['Cotes']==1){
            $list[]=3;
        }
        if($Utilisateurs['Compta']==1){
            $list[]=4;
        }
        if($Utilisateurs['Paiement']==1){
            $list[]=5;
        }
        echo json_encode($list);
    }
?>