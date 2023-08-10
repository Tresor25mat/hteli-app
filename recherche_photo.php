<?php 
    session_start();
	require_once('connexion.php');
	$Utilisateur=$_POST['Utilisateur'];
	$rs=$pdo->query("SELECT * FROM utilisateur WHERE `ID_Utilisateur`=".$Utilisateur);
	$res=$rs->fetch();
	if($res['Photo']==""){
		if($res['ID_Profil']==1){
			echo "1";
		}else{
			echo "2";
		}
	}else{
		echo $res['Photo'];
	}

?>