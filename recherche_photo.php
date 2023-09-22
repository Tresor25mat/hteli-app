<?php 
    session_start();
	require_once('connexion.php');
	$Utilisateur=$_POST['Utilisateur'];
	$rs=$pdo->query("SELECT * FROM utilisateur WHERE `ID_Utilisateur`=".$Utilisateur);
	$res=$rs->fetch();
	if($res['Photo']!="" && $res['Photo_Type']==1){
		echo "images/profil/".$res['Photo'];
	}else if($res['Photo']!="" && $res['Photo_Type']==2){
		echo $res['Photo'];
	}else{
		if($res['ID_Profil']==1){
			echo "1";
		}else{
			echo "2";
		}
	}

?>