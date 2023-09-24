<?php 
    session_start();
	require_once('connexion.php');
    $Eleve=htmlentities($_POST['ID_Eleve']);
    $Annee=htmlentities($_POST['Annee']);
    $Frais=htmlentities($_POST['Frais']);
    $req_eleve=$pdo->query("SELECT * FROM eleve INNER JOIN inscription ON eleve.ID_Eleve=inscription.ID_Eleve INNER JOIN classe ON inscription.ID_Classe=classe.ID_Classe WHERE eleve.ID_Eleve='".$Eleve."' AND inscription.ID_Annee=".$Annee);
    $tab_gamme=array();
    $Montant_paye=0;
    $Montant_reste=0;
	if($eleves=$req_eleve->fetch()){
        $Rech_frai=$pdo->query("SELECT * FROM frais INNER JOIN classe_frais ON frais.ID_Frais=classe_frais.ID_Frais WHERE frais.ID_Type_Frais=".$Frais." AND frais.ID_Annee=".$Annee." AND classe_frais.ID_Option=".$eleves['ID_Option']." AND classe_frais.ID_Cat_Eleve=".$eleves['ID_Cat_Eleve']);
        if($Rech_frais=$Rech_frai->fetch()){
            if(isset($_POST['Paiement']) && $_POST['Paiement']!=""){
                $paiement=$pdo->query("SELECT * FROM paiement INNER JOIN paiement_frais ON paiement.ID_Paiement=paiement_frais.ID_Paiement WHERE paiement.ID_Paiement!='".$_POST['Paiement']."' AND paiement.ID_Inscription='".$eleves['ID_Inscription']."' AND paiement_frais.ID_Frais=".$Rech_frais['ID_Frais']." AND paiement.Confirm_Paiement=1");
            }else{
                $paiement=$pdo->query("SELECT * FROM paiement INNER JOIN paiement_frais ON paiement.ID_Paiement=paiement_frais.ID_Paiement WHERE paiement.ID_Inscription='".$eleves['ID_Inscription']."' AND paiement_frais.ID_Frais=".$Rech_frais['ID_Frais']." AND paiement.Confirm_Paiement=1");
            }
            while($paiements=$paiement->fetch()){
                if($paiements['ID_Taux']==$Rech_frais['ID_Taux']){
                    $Montant_paye+=$paiements['Montant_Paie'];
                }else{
                    if($paiements['ID_Taux']==1){
                        $Montant_paye+=($paiements['Montant_Paie']/$paiements['Taux']);
                    }else{
                        $Montant_paye+=($paiements['Montant_Paie']*$paiements['Taux']);
                    }
                }
            }
        }
        $Montant_reste=$Rech_frais['Montant_Frais']-$Montant_paye;
        $tab_gamme[]=array(
            'Montant_paye'=>number_format($Montant_paye, 2, ',', ''),
            'Montant_reste'=>number_format($Montant_reste, 2, ',', '')
        );
	}
	echo json_encode($tab_gamme);
?>