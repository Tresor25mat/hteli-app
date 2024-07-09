<?php session_start();

  require_once ("connexion.php");
   
   // Cette page authentifie un utilisateur et lui crée sa session de travail
  
  try{
	  
	  	define ('HASH_1', 'CervLiKCpOF5E' );
      	define ('HASH_2', 'CposiTih' );
	  
    	$cmpt=Securite::bdd($_POST['login']);
		$mdp=Securite::bdd($_POST['password']);
	 
		// $cmpt=$_POST['cmpt'];
		// $mdp=$_POST['mdp'];
	 

		$token = time().rand(0,9);
    	$token = HASH_1.$token.HASH_2;
    	/*$req_con=$con->query("SELECT user.numtel,user.iduser,user.nom,user.privillege,user.agent,confrere.photo FROM user inner join confrere on confrere.idconfrere=user.agent WHERE  numtel='$cmpt' and passw=SHA1('$password')");*/
		if(!empty($_SESSION['log_time']) && $_SESSION['log_time'] < time()){
			unset($_SESSION['log_time']);
			unset($_SESSION['log_fail']);
		}
		if(!empty($_SESSION['log_fail']) && $_SESSION['log_fail'] >= 5)
		{
			echo "Vous avez rentré des mauvais identifiants 5 fois de suite. Veuillez attendre ".date("H\hi", $_SESSION['log_time'])." pour pouvoir retenter de vous connecter.";
		}
		elseif(!empty($cmpt) && !empty($mdp))
		{
		    	$rs=$pdo->prepare("SELECT *  FROM utilisateur WHERE Login=? AND Password=?");
		    	$params=array($cmpt, sha1($mdp));
		    	$rs->execute($params);
		    	if ($user=$rs->fetch()){
					if($user['Active']==1){
						if($user['Statut']!='Admin'){
							$rec=$pdo->query("UPDATE utilisateur SET Etat=1, Loged=1, Logged=1 WHERE ID_Utilisateur=".$user['ID_Utilisateur']);
						}else{
							$rec=$pdo->query("UPDATE utilisateur SET Etat=1 WHERE ID_Utilisateur=".$user['ID_Utilisateur']);
						}
						$_SESSION['user_eteelo_app']=$user;
						$_SESSION['user_eteelo_app']['token'] = sha1($token);
						$_SESSION['logged_eteelo_app'] = true;
						$_SESSION['last_activity'] = time();
						$_SESSION['expire_time'] = 10*60;
						echo '1';
					}else{
						echo '3';
					}
		    	}else{
					if(empty($_SESSION['log_fail']))
					{
						$_SESSION['log_fail'] = 1;
						$_SESSION['log_time'] = time() + 60 * 2;
					}
					else
					{
						$_SESSION['log_fail']++;
					}
					echo '2';
		    	}
			}
    }catch (exception $e){
	    die('Erreur: '.$e->getMessage());
    }
?>
