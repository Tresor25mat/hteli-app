<?php
    session_start();
    $_SESSION['last_activity'] = time();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $Prenom=Securite::bdd($_POST['prenom']);
    $Nom=Securite::bdd($_POST['nom']);
    $Tel=htmlentities($_POST['tel']);
    $Mail=Securite::bdd($_POST['mail']);
    $Statut=Securite::bdd($_POST['statut']);
    $rs_statut=$pdo->query("SELECT * FROM statut_user WHERE ID_Statut=".$Statut);
    $statuts=$rs_statut->fetch();
    $Login=Securite::bdd($_POST['login']);
    $Profil=htmlentities($_POST['profil']);
    // echo var_dump($Modules);
    $Inscription=0;
    $Discipline=0;
    $Cotes=0;
    $Compta=0;
    $Paiement=0;
    if(isset($_POST['ID_Etablissement'])){
        $Ecole=htmlentities($_POST['ID_Etablissement']);
    }else{
        $Ecole="";
    }
    if(isset($_POST['modules']) && !empty($_POST['modules'])){
        $Modules = explode(",", $_POST['modules']);
        foreach($Modules as $module) {
            if($module==1){
                $Inscription=1;
            }else if($module==2){
                $Discipline=1;
            }else if($module==3){
                $Cotes=1;
            }else if($module==4){
                $Compta=1;
            }else if($module==5){
                $Paiement=1;
            }
        }
    }
    $Password=sha1($_POST['password']);
    $Image=basename($_FILES['mimg']['name']);
    $dossier_image = 'images/profil/';
    if(!is_dir($dossier_image)){
        mkdir($dossier_image);
    }
    if($Image!=''){
        $extensions_img = array('.JPG', '.JPEG', '.PNG');
        $extension_img = strrchr($_FILES['mimg']['name'], '.');
        $extension_img_maj=strtoupper($extension_img);
        if(!in_array($extension_img_maj, $extensions_img))
        {
            echo "2";
        }else{
            $Time = time().rand(0,9);
            $Time = substr($Time, 3, 8);
            $Image = 'IMG_UTILISATEUR_' . $Time . $extension_img_maj;
            if(move_uploaded_file($_FILES['mimg']['tmp_name'], $dossier_image . $Image)) //Si la fonction renvoie TRUE, c'est
            {
                if($Token==$_SESSION['user_eteelo_app']['token']){
                    $rs=$pdo->prepare("INSERT INTO utilisateur(Prenom, Nom, ID_Profil, ID_Etablissement, ID_Statut, Tel, Email, Login, Password, Photo, Statut, Active, Inscription, Discipline, Cotes, Compta, Paiement) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $params=array($Prenom, $Nom, $Profil, $Ecole, $Statut, $Tel, $Mail, $Login, $Password, $Image, $statuts['Design_Statut'], 1, $Inscription, $Discipline, $Cotes, $Compta, $Paiement);
                    $rs->execute($params);
                    echo "1";
                }
            }else{
                echo "3";
            }
        }
    }else{
        if($Token==$_SESSION['user_eteelo_app']['token']){
            $rs=$pdo->prepare("INSERT INTO utilisateur(Prenom, Nom, ID_Profil, ID_Etablissement, ID_Statut, Tel, Email, Login, Password, Statut, Active, Inscription, Discipline, Cotes, Compta, Paiement) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $params=array($Prenom, $Nom, $Profil, $Ecole, $Statut, $Tel, $Mail, $Login, $Password, $statuts['Design_Statut'], 1, $Inscription, $Discipline, $Cotes, $Compta, $Paiement);
            $rs->execute($params);
            echo "1";
        }
    }
?>