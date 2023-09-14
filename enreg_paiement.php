<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $Ecole=htmlentities($_POST['ID_Etablissement']);
    $Eleve=htmlentities($_POST['ID_Eleve']);
    $Frais=htmlentities($_POST['frais']);
    $Annee=htmlentities($_POST['annee']);
    $Devise=htmlentities($_POST['devise']);
    $Montant=htmlentities($_POST['montant_paiement']);
    $Mode_Paiement=htmlentities($_POST['mode_paiement']);
    $Compte_caisse=htmlentities($_POST['compte_caisse']);
    $Compte_banque=htmlentities($_POST['compte_banque']);
    $DateP=date('Y-m-d', strtotime(htmlentities($_POST['datepaie'])));
    $val1=rand();
    $val2=rand();
    $chaine=sha1($val1.$val2);
    $rec=$pdo->query("SELECT MAX(ID_Recu) AS ID_Recu FROM recu");
    $recu=$rec->fetch();
    $req_eleve=$pdo->query("SELECT * FROM eleve INNER JOIN inscription ON eleve.ID_Eleve=inscription.ID_Eleve INNER JOIN classe ON inscription.ID_Classe=classe.ID_Classe WHERE eleve.ID_Eleve='".$Eleve."' AND inscription.ID_Annee=".$Annee);
    $eleves=$req_eleve->fetch();
    $Rech_frai=$pdo->query("SELECT * FROM frais INNER JOIN classe_frais ON frais.ID_Frais=classe_frais.ID_Frais INNER JOIN type_frais ON frais.ID_Type_Frais=type_frais.ID_Type_Frais WHERE frais.ID_Type_Frais=".$Frais." AND frais.ID_Annee=".$Annee." AND classe_frais.ID_Option=".$eleves['ID_Option']." AND classe_frais.ID_Cat_Eleve=".$eleves['ID_Cat_Eleve']);
    $Rech_frais=$Rech_frai->fetch();
    $taux=$pdo->query("SELECT * FROM taux_change INNER JOIN table_taux ON taux_change.ID_Taux=table_taux.ID_Taux WHERE table_taux.ID_Etablissement=".$Ecole." AND table_taux.ID_Taux=1");
    $taux_change=$taux->fetch();
    $journal=$pdo->query("SELECT * FROM table_journal WHERE Active=1 AND ID_Etablissement=".$Ecole);
    $journals=$journal->fetch();
    $Libelle=stripslashes(strtoupper("PAIEMENT FRAIS ".$eleves['Nom_Eleve'].' '.$eleves['Pnom_Eleve'].' '.$eleves['Prenom_Eleve']));
    $Montant_paye=0;
    $Montant_paie=0;
    if($recu['ID_Recu']==NULL){
        $nombre=sprintf('%06d', 1).date('s');
    }else{
        $nombre=sprintf('%06d', $recu['ID_Recu']+1).date('s');
    }
    $paiement=$pdo->query("SELECT * FROM paiement WHERE ID_Inscription='".$eleves['ID_Inscription']."' AND ID_Frais=".$Rech_frais['ID_Frais']." AND Confirm_Paiement=1");
    while($paiements=$paiement->fetch()){
        if($paiements['ID_Taux']==$Rech_frais['ID_Taux']){
            $Montant_paye=$Montant_paye+$paiements['Montant_Paie'];
        }else{
            if($paiements['ID_Taux']==1){
                $Montant_paye=$Montant_paye+($paiements['Montant_Paie']/$paiements['Taux']);
            }else{
                $Montant_paye=$Montant_paye+($paiements['Montant_Paie']*$paiements['Taux']);
            }
        }
    }
    if($Devise!=$Rech_frais['ID_Taux']){
        if($Devise==1){
            $Montant_paie=$Montant/$taux_change['Montant'];
        }else{
            $Montant_paie=$Montant*$taux_change['Montant'];
        }
    }else{
        $Montant_paie=$Montant;
    }
    if(intval($Montant_paye+$Montant_paie)>intval($Rech_frais['Montant_Frais'])){
        echo '2';
    }else{
        if($Token==$_SESSION['user_eteelo_app']['token']){
            if($Mode_Paiement==1){
                $insert_operation=$pdo->query("INSERT INTO operation (ID_Etablissement, ID_Annee, ID_Taux, ID_Journal, Libelle, Num_Piece, Date_Operation, Taux, ID_Utilisateur) VALUES (".$Ecole.", ".$Annee.", ".$Devise.", ".$journals['ID_Journal'].",'".$Libelle."','".$nombre."','".$DateP."',".$taux_change['Montant'].",1)");
                $operation=$pdo->query("SELECT MAX(ID_Operation) AS ID_Operation FROM operation");
                $operations=$operation->fetch();
                $insert_operation_debit=$pdo->query("INSERT INTO operation_compte (ID_Operation, ID_Compte, ID_Type_Operation, Montant) VALUES (".$operations['ID_Operation'].",".$Rech_frais['ID_Compte_D'].",2,".$Montant.")");
                $insert_operation_credit=$pdo->query("INSERT INTO operation_compte (ID_Operation, ID_Compte, ID_Type_Operation, Montant) VALUES (".$operations['ID_Operation'].",".$Compte_caisse.",1,".$Montant.")");
                $res=$pdo->prepare("INSERT INTO paiement(ID_Paiement, ID_Inscription, ID_Frais, ID_Operation, ID_Taux, Mode_Paiement, Taux, Montant_Paie, Date_Paiement, ID_Utilisateur) VALUES (?,?,?,?,?,?,?,?,?,?)");
                $param=array($chaine, $eleves['ID_Inscription'], $Rech_frais['ID_Frais'], $operations['ID_Operation'], $Devise, $Mode_Paiement, $taux_change['Montant'], $Montant, $DateP, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
                $res->execute($param);
                $rec=$pdo->query("INSERT INTO recu(Num_Recu, ID_Paiement, ID_Utilisateur) VALUES ('".$nombre."', '".$chaine."', ".$_SESSION['user_eteelo_app']['ID_Utilisateur'].")");
            }else if($Mode_Paiement==2){
                $insert_operation=$pdo->query("INSERT INTO operation (ID_Etablissement, ID_Annee, ID_Taux, ID_Journal, Libelle, Num_Piece, Date_Operation, Taux, ID_Utilisateur) VALUES (".$Ecole.", ".$Annee.", ".$Devise.", ".$journals['ID_Journal'].",'".$Libelle."','".$nombre."','".$DateP."',".$taux_change['Montant'].",1)");
                $operation=$pdo->query("SELECT MAX(ID_Operation) AS ID_Operation FROM operation");
                $operations=$operation->fetch();
                $insert_operation_debit=$pdo->query("INSERT INTO operation_compte (ID_Operation, ID_Compte, ID_Type_Operation, Montant) VALUES (".$operations['ID_Operation'].",".$Rech_frais['ID_Compte_D'].",2,".$Montant.")");
                $insert_operation_credit=$pdo->query("INSERT INTO operation_compte (ID_Operation, ID_Compte, ID_Type_Operation, Montant) VALUES (".$operations['ID_Operation'].",".$Compte_banque.",1,".$Montant.")");
                $res=$pdo->prepare("INSERT INTO paiement(ID_Paiement, ID_Inscription, ID_Frais, ID_Operation, ID_Taux, Mode_Paiement, Taux, Montant_Paie, Date_Paiement, ID_Utilisateur) VALUES (?,?,?,?,?,?,?,?,?,?)");
                $param=array($chaine, $eleves['ID_Inscription'], $Rech_frais['ID_Frais'], $operations['ID_Operation'], $Devise, $Mode_Paiement, $taux_change['Montant'], $Montant, $DateP, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
                $res->execute($param);
                $rec=$pdo->query("INSERT INTO recu(Num_Recu, ID_Paiement, ID_Utilisateur) VALUES ('".$nombre."', '".$chaine."', ".$_SESSION['user_eteelo_app']['ID_Utilisateur'].")");
            }else{
                $res=$pdo->prepare("INSERT INTO paiement(ID_Paiement, ID_Inscription, ID_Frais, Confirm_Paiement, ID_Taux, Mode_Paiement, Taux, Montant_Paie, Date_Paiement, ID_Utilisateur) VALUES (?,?,?,?,?,?,?,?,?,?)");
                $param=array($chaine, $eleves['ID_Inscription'], $Rech_frais['ID_Frais'], 2, $Devise, $Mode_Paiement, $taux_change['Montant'], $Montant, $DateP, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
                $res->execute($param);
                $rec=$pdo->query("INSERT INTO recu(Num_Recu, ID_Paiement, ID_Utilisateur) VALUES ('".$nombre."', '".$chaine."', ".$_SESSION['user_eteelo_app']['ID_Utilisateur'].")");
            }
            echo "1,".$chaine;
        }
    }
?>