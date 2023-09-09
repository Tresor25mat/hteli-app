<?php
    session_start();
    require_once ("connexion.php");
	if($_POST['liste']=="province"){
		$province=htmlentities($_POST['province']);
    	$req_sel_com=$pdo->query("SELECT * FROM ville WHERE ID_Prov='".$province."' ORDER BY Design_Ville");
		$comm="";
	    while ($aff_com=$req_sel_com->fetch()){
		  $comm.='<option value="'.$aff_com['ID_Ville'].'">'.$aff_com['Design_Ville'].'</option>';
		}
		
		echo $comm;
	}elseif($_POST['liste']=="ville"){
		$ville=htmlentities($_POST['ville']);
    	$req_sel_com=$pdo->query("SELECT * FROM commune WHERE ID_Ville='".$ville."' ORDER BY Design_Commune");
		$comm="";
	    while ($aff_com=$req_sel_com->fetch()){
		  $comm.='<option value="'.$aff_com['ID_Commune'].'">'.$aff_com['Design_Commune'].'</option>';
		}
		
		echo $comm;
	}else if($_POST['liste']=="ajoutville"){
		$design=htmlentities($_POST['designville']);
		$province=htmlentities($_POST['province']);
	    $req_rech_nat=$pdo->query("SELECT * FROM ville WHERE Design_Ville='".$design."' AND ID_Prov=".$province);
	    if($req_rech_nats=$req_rech_nat->fetch()){
	    	echo "2";
	    }else{
			$req_insert_nat=$pdo->query("INSERT INTO ville (Design_Ville, ID_Prov, ID_Utilisateur) VALUES ('".$design."',".$province.",".$_SESSION['user_eteelo_app']['ID_Utilisateur'].")");
			$req_sel_max_nat=$pdo->query("SELECT MAX(ID_Ville) as MaxID FROM ville");
			$req_sel_max_nats=$req_sel_max_nat->fetch();
		    $req_sel_nat=$pdo->query("SELECT * FROM ville WHERE ID_Prov=".$province." ORDER BY Design_Ville");
			$list="";
		    while ($req_sel_nats=$req_sel_nat->fetch()){
		    	if($req_sel_nats['ID_Ville']==$req_sel_max_nats['MaxID']){
		    		$list.='<option value="'.$req_sel_nats['ID_Ville'].'" selected>'.stripslashes(strtoupper($req_sel_nats['Design_Ville'])).'</option>';
		    	}else{
			  		$list.='<option value="'.$req_sel_nats['ID_Ville'].'">'.stripslashes(strtoupper($req_sel_nats['Design_Ville'])).'</option>';
		    	}
			}
			echo $list;
	    }    
	}else if($_POST['liste']=="ajoutsecteur"){
		$design=htmlentities($_POST['designsecteur']);
		$ville=htmlentities($_POST['ville']);
	    $req_rech_nat=$pdo->query("SELECT * FROM commune WHERE Design_Commune='".$design."' AND ID_Ville=".$ville);
	    if($req_rech_nats=$req_rech_nat->fetch()){
	    	echo "2";
	    }else{
			$req_insert_nat=$pdo->query("INSERT INTO commune (Design_Commune, ID_Ville, ID_Utilisateur) VALUES ('".$design."',".$ville.",".$_SESSION['user_eteelo_app']['ID_Utilisateur'].")");
			$req_sel_max_nat=$pdo->query("SELECT MAX(ID_Commune) as MaxID FROM commune");
			$req_sel_max_nats=$req_sel_max_nat->fetch();
		    $req_sel_nat=$pdo->query("SELECT * FROM commune WHERE ID_Ville=".$ville." ORDER BY Design_Commune");
			$list="";
		    while ($req_sel_nats=$req_sel_nat->fetch()){
		    	if($req_sel_nats['ID_Commune']==$req_sel_max_nats['MaxID']){
		    		$list.='<option value="'.$req_sel_nats['ID_Commune'].'" selected>'.stripslashes(strtoupper($req_sel_nats['Design_Commune'])).'</option>';
		    	}else{
			  		$list.='<option value="'.$req_sel_nats['ID_Commune'].'">'.stripslashes(strtoupper($req_sel_nats['Design_Commune'])).'</option>';
		    	}
			}
			echo $list;
	    }
		    
	}else if($_POST['liste']=="grand_livre"){
		$Compte=htmlentities($_POST['Compte']);
    	$compte_fin=$pdo->query("SELECT * FROM compte INNER JOIN categorie_compte ON compte.ID_Categorie=categorie_compte.ID_Categorie WHERE categorie_compte.ID_Etablissement=".$_SESSION['user_siges']['ID_Etablissement']." AND compte.ID_Compte!=".$Compte." ORDER BY categorie_compte.Cod_Categorie, compte.Cod_Compte");
		$list="";
		while ($compte_fins=$compte_fin->fetch()){
			$list.='<option value="'.$compte_fins['ID_Compte'].'">'.$compte_fins['Cod_Categorie'].$compte_fins['Cod_Compte'].' '.$compte_fins['Design_Compte'].'</option>';

		}
		echo $list;
		    
	}else if($_POST['liste']=="classe"){
		$Ecole=htmlentities($_POST['Ecole']);
    	$classe=$pdo->query("SELECT classe.*, table_option.Design_Option, niveau.Design_Niveau FROM classe inner join table_option on classe.ID_Option=table_option.ID_Option inner join niveau on classe.ID_Niveau=niveau.ID_Niveau inner join section on table_option.ID_Section=section.ID_Section WHERE section.ID_Etablissement=".$Ecole." order by Design_Classe");
		$list="";
		while ($classes=$classe->fetch()){
			$list.='<option value="'.$classes['ID_Classe'].'">'.$classes['Design_Classe'].'</option>';

		}
		echo $list;
		    
	}else if($_POST['liste']=="journal"){
		$Ecole=htmlentities($_POST['Ecole']);
    	$journal=$pdo->query("SELECT * FROM table_journal WHERE ID_Etablissement=".$Ecole." ORDER BY Code_Journal");
		$list="";
		while ($journals=$journal->fetch()){
			$list.='<option value="'.$journals['ID_Journal'].'">'.$journals['Code_Journal'].'</option>';

		}
		echo $list;
		    
	}else if($_POST['liste']=="compte"){
		$Ecole=htmlentities($_POST['Ecole']);
    	$compte=$pdo->query("SELECT * FROM compte INNER JOIN categorie_compte ON compte.ID_Categorie=categorie_compte.ID_Categorie WHERE categorie_compte.ID_Etablissement=".$Ecole." ORDER BY categorie_compte.Cod_Categorie, compte.Cod_Compte");
		$list="";
		while ($comptes=$compte->fetch()){
			$list.='<option value="'.$comptes['ID_Compte'].'">'.$comptes['Cod_Categorie'].$comptes['Cod_Compte'].' '.$comptes['Design_Compte'].'</option>';

		}
		echo $list;
		    
	}else if($_POST['liste']=="frais"){
		$Ecole=htmlentities($_POST['Ecole']);
    	$rec_type_frais=$pdo->query("select * from type_frais where ID_Etablissement=".$Ecole." order by Libelle_Type_Frais");
		$list="";
		while ($type_frais=$rec_type_frais->fetch()){
			$list.='<option value="'.$type_frais['ID_Type_Frais'].'">'.stripslashes($type_frais['Libelle_Type_Frais']).'</option>';

		}
		echo $list;
		    
	}

	?>
