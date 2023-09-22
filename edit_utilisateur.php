<?php
    session_start();
    $_SESSION['last_activity'] = time();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $ID=htmlentities($_POST['id_user']);
    $Prenom=Securite::bdd($_POST['prenom']);
    $Nom=Securite::bdd($_POST['nom']);
    $Tel=htmlentities($_POST['tel']);
    $Mail=Securite::bdd($_POST['mail']);
    $Statut=Securite::bdd($_POST['statut']);
    $rs_statut=$pdo->query("SELECT * FROM statut_user WHERE ID_Statut=".$Statut);
    $statuts=$rs_statut->fetch();
    $Login=Securite::bdd($_POST['login']);
    $Profil=htmlentities($_POST['profil']);
    $Type_Photo=htmlentities($_POST['type_photo']);
    $Photo_Data=htmlentities($_POST['photo_data']);
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
    $Password=$_POST['password'];
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
                    if($Password!=''){
                        $Password=sha1($Password);
                        $rs=$pdo->prepare("UPDATE utilisateur SET Prenom=?, Nom=?, ID_Profil=?, ID_Etablissement=?, ID_Statut=?, Tel=?, Email=?, Login=?, Password=?, Photo=?, Photo_Type=?, Statut=?, Inscription=?, Discipline=?, Cotes=?, Compta=?, Paiement=? WHERE ID_Utilisateur=?");
                        $params=array($Prenom, $Nom, $Profil, $Ecole, $Statut, $Tel, $Mail, $Login, $Password, $Image, $Type_Photo, $statuts['Design_Statut'], $Inscription, $Discipline, $Cotes, $Compta, $Paiement, $ID);
                        $rs->execute($params);
                    }else{
                        $rs=$pdo->prepare("UPDATE utilisateur SET Prenom=?, Nom=?, ID_Profil=?, ID_Etablissement=?, ID_Statut=?, Tel=?, Email=?, Login=?, Photo=?, Photo_Type=?, Statut=?, Inscription=?, Discipline=?, Cotes=?, Compta=?, Paiement=? WHERE ID_Utilisateur=?");
                        $params=array($Prenom, $Nom, $Profil, $Ecole, $Statut, $Tel, $Mail, $Login, $Image, $Type_Photo, $statuts['Design_Statut'], $Inscription, $Discipline, $Cotes, $Compta, $Paiement, $ID);
                        $rs->execute($params);
                    }
                    echo "1";
                }
            }else{
                echo "3";
            }
        }
    }else if($Photo_Data!=''){
        if($Token==$_SESSION['user_eteelo_app']['token']){
            if($Password!=''){
                $Password=sha1($Password);
                $rs=$pdo->prepare("UPDATE utilisateur SET Prenom=?, Nom=?, ID_Profil=?, ID_Etablissement=?, ID_Statut=?, Tel=?, Email=?, Login=?, Password=?, Photo=?, Photo_Type=?, Statut=?, Inscription=?, Discipline=?, Cotes=?, Compta=?, Paiement=? WHERE ID_Utilisateur=?");
                $params=array($Prenom, $Nom, $Profil, $Ecole, $Statut, $Tel, $Mail, $Login, $Password, $Photo_Data, $Type_Photo, $statuts['Design_Statut'], $Inscription, $Discipline, $Cotes, $Compta, $Paiement, $ID);
                $rs->execute($params);
            }else{
                $rs=$pdo->prepare("UPDATE utilisateur SET Prenom=?, Nom=?, ID_Profil=?, ID_Etablissement=?, ID_Statut=?, Tel=?, Email=?, Login=?, Photo=?, Photo_Type=?, Statut=?, Inscription=?, Discipline=?, Cotes=?, Compta=?, Paiement=? WHERE ID_Utilisateur=?");
                $params=array($Prenom, $Nom, $Profil, $Ecole, $Statut, $Tel, $Mail, $Login, $Photo_Data, $Type_Photo, $statuts['Design_Statut'], $Inscription, $Discipline, $Cotes, $Compta, $Paiement, $ID);
                $rs->execute($params);
            }
            echo "1";
        }
    }else{
        if($Token==$_SESSION['user_eteelo_app']['token']){
            if($Password!=''){
                $Password=sha1($Password);
                $rs=$pdo->prepare("UPDATE utilisateur SET Prenom=?, Nom=?, ID_Profil=?, ID_Etablissement=?, ID_Statut=?, Tel=?, Email=?, Login=?, Password=?, Statut=?, Inscription=?, Discipline=?, Cotes=?, Compta=?, Paiement=? WHERE ID_Utilisateur=?");
                $params=array($Prenom, $Nom, $Profil, $Ecole, $Statut, $Tel, $Mail, $Login, $Password, $statuts['Design_Statut'], $Inscription, $Discipline, $Cotes, $Compta, $Paiement, $ID);
                $rs->execute($params);
            }else{
                $rs=$pdo->prepare("UPDATE utilisateur SET Prenom=?, Nom=?, ID_Profil=?, ID_Etablissement=?, ID_Statut=?, Tel=?, Email=?, Login=?, Statut=?, Inscription=?, Discipline=?, Cotes=?, Compta=?, Paiement=? WHERE ID_Utilisateur=?");
                $params=array($Prenom, $Nom, $Profil, $Ecole, $Statut, $Tel, $Mail, $Login, $statuts['Design_Statut'], $Inscription, $Discipline, $Cotes, $Compta, $Paiement, $ID);
                $rs->execute($params);
            }
            echo "1";
        }
    }
?>