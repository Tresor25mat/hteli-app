<?php
	session_start();
    require_once ("connexion.php");
	$design=htmlentities($_POST['Design']);
	$req_rech_nat=$pdo->query("SELECT * FROM lieu WHERE Design_Lieu='".$design."'");
	if($req_rech_nats=$req_rech_nat->fetch()){
	    echo "2";
	}else{
		$req_insert_nat=$pdo->query("INSERT INTO lieu (Design_Lieu) VALUES ('".$design."')");
		$req_sel_max_nat=$pdo->query("SELECT MAX(ID_Lieu) as MaxID FROM lieu");
		$req_sel_max_nats=$req_sel_max_nat->fetch();
		$req_sel_nat=$pdo->query("SELECT * FROM lieu ORDER BY Design_Lieu");
		$list="";
		while ($req_sel_nats=$req_sel_nat->fetch()){
		    if($req_sel_nats['ID_Lieu']==$req_sel_max_nats['MaxID']){
		    	$list.='<option value="'.$req_sel_nats['ID_Lieu'].'" selected>'.stripslashes(strtoupper($req_sel_nats['Design_Lieu'])).'</option>';
		    }else{
			  	$list.='<option value="'.$req_sel_nats['ID_Lieu'].'">'.stripslashes(strtoupper($req_sel_nats['Design_Lieu'])).'</option>';
		    }
		}
		echo $list;
	}

?>