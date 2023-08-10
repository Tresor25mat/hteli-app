<?php
session_start();
require_once ("connexion.php");
if($_SESSION['user_courrier']['User']==''){
    $token = "dGVzdDE6V2F2ZXNjb20=";
}else{
  $token = base64_encode(stripslashes($_SESSION['user_courrier']['User']).':'.stripslashes($_SESSION['user_courrier']['Pw']));
}
$content = $_POST['message'];
$sender = Securite::bdd($_POST['expediteur']);
$ID_Conversation = htmlentities($_POST['conversation']);
$val1_Message=rand();
$val2_Message=rand();
$ID_Message=sha1($val1_Message.$val2_Message);
$sender = strtr($sender,
      'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
      'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
$sender = preg_replace('/([^.a-z0-9]+)/i', '-', $sender);
if($_SESSION['user_courrier']['Statut']=='Admin'){
    $sel_num=$pdo->query("SELECT telephone.* FROM telephone INNER JOIN participer ON telephone.ID_Telephone=participer.ID_Telephone WHERE participer.ID_Conversation='".$ID_Conversation."'");
    // $content = iconv("UTF-8", "ISO-8859-15", $content);
    $messages=array();
    while ($numbers=$sel_num->fetch()) {
        $messages[] = array(
            'from' => $sender,
            'to' => $numbers['Num_Telephone'],
            'text' => $content
            // 'date' => "2020-01-20 15:45:00"
        );
    }
    $postdata = array(
        'messages' => $messages
    );
    // echo json_encode($postdata);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://197.242.157.206:8086/sms/multi");
    curl_setopt($ch, CURLOPT_HEADER, FALSE );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json', 'Authorization: Basic ' . $token));
    $response = curl_exec($ch);
     $err = curl_error($ch);
     curl_close($ch);

     if ($err) {
         echo "cURL Error #:" . $err;
     } else {
        $content=Securite::bdd($content);
        $insert=$pdo->query("INSERT INTO conversation (ID_Conversation, Date_Envoie, ID_Utilisateur) VALUES ('".$ID_Conversation."', Now(), ".$_SESSION['user_courrier']['ID_Utilisateur'].")");
          $insert_message=$pdo->query("INSERT INTO message (ID_Message, ID_Conversation, Emetteur, Texte, ID_Utilisateur) VALUES ('".$ID_Message."', '".$ID_Conversation."', '".$sender."', '".$content."', ".$_SESSION['user_courrier']['ID_Utilisateur'].")");
        $res_numero=$pdo->query("SELECT telephone.* FROM telephone INNER JOIN participer ON telephone.ID_Telephone=participer.ID_Telephone WHERE participer.ID_Conversation='".$ID_Conversation."'");
        while ($numeros=$res_numero->fetch()) {
            $pos = strpos($response, $numeros['Num_Telephone']);
            $mystring = '{"messages":['.substr($response, $pos-7, 189).']}';
            $pos_smsCount = strpos($response, 'smsCount');
            $smsCount = substr($response, $pos_smsCount+10, 1);
            $pos_desc = strpos($mystring, 'description');
            $mydesc= substr($mystring, $pos_desc+14, 8);
            if($mydesc=='ESME_ROK'){
                $statut="Delivered";
            }else{
                $statut="Undelivered";
            }


            $update_participer=$pdo->query("UPDATE participer SET Reponse='".$mystring."', smsCount=".$smsCount.", Command=1, Statut='".$statut."' WHERE ID_Conversation='".$ID_Conversation."' AND ID_Telephone='".$numeros['ID_Telephone']."'");
        }
    }
    echo "1";
}else{
    $rs_queue=$pdo->query("SELECT Queue from utilisateur WHERE ID_Utilisateur=".$_SESSION['user_courrier']['ID_Utilisateur']);
    $Queue=$rs_queue->fetch();
    if($Queue['Queue']==0 || $Queue['Queue']==''){

        $sel_num=$pdo->query("SELECT telephone.* FROM telephone INNER JOIN participer ON telephone.ID_Telephone=participer.ID_Telephone WHERE participer.ID_Conversation='".$ID_Conversation."'");
        // $content = iconv("UTF-8", "ISO-8859-15", $content);
        $messages=array();
        while ($numbers=$sel_num->fetch()) {
            $messages[] = array(
                'from' => $sender,
                'to' => $numbers['Num_Telephone'],
                'text' => $content
                // 'date' => "2020-01-20 15:45:00"
            );
        }
        $postdata = array(
            'messages' => $messages
        );
        // echo json_encode($postdata);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://197.242.157.206:8086/sms/multi");
        curl_setopt($ch, CURLOPT_HEADER, FALSE );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json', 'Authorization: Basic ' . $token));
        $response = curl_exec($ch);
         $err = curl_error($ch);
         curl_close($ch);

         if ($err) {
             echo "cURL Error #:" . $err;
         } else {
            $content=Securite::bdd($content);
            $insert=$pdo->query("INSERT INTO conversation (ID_Conversation, Date_Envoie, ID_Utilisateur) VALUES ('".$ID_Conversation."', Now(), ".$_SESSION['user_courrier']['ID_Utilisateur'].")");
              $insert_message=$pdo->query("INSERT INTO message (ID_Message, ID_Conversation, Emetteur, Texte, ID_Utilisateur) VALUES ('".$ID_Message."', '".$ID_Conversation."', '".$sender."', '".$content."', ".$_SESSION['user_courrier']['ID_Utilisateur'].")");
            $res_numero=$pdo->query("SELECT telephone.* FROM telephone INNER JOIN participer ON telephone.ID_Telephone=participer.ID_Telephone WHERE participer.ID_Conversation='".$ID_Conversation."'");
            while ($numeros=$res_numero->fetch()) {
                $pos = strpos($response, $numeros['Num_Telephone']);
                $mystring = '{"messages":['.substr($response, $pos-7, 189).']}';
                $pos_smsCount = strpos($response, 'smsCount');
                $smsCount = substr($response, $pos_smsCount+10, 1);
                $pos_desc = strpos($mystring, 'description');
                $mydesc= substr($mystring, $pos_desc+14, 8);
                if($mydesc=='ESME_ROK'){
                    $statut="Delivered";
                }else{
                    $statut="Undelivered";
                }


                $update_participer=$pdo->query("UPDATE participer SET Reponse='".$mystring."', smsCount=".$smsCount.", Command=1, Statut='".$statut."' WHERE ID_Conversation='".$ID_Conversation."' AND ID_Telephone='".$numeros['ID_Telephone']."'");
            }
        }
        echo "1";


    }else{
        $aig=true;
        $nbr=0;
        $rs_count=$pdo->query("SELECT count(telephone.Num_Telephone) AS Nbr FROM telephone INNER JOIN participer ON telephone.ID_Telephone=participer.ID_Telephone WHERE participer.ID_Conversation='".$ID_Conversation."'");
        $count=$rs_count->fetch();
        $Nbr_Enreg=0;
        $content2=Securite::bdd($content);
        $insert=$pdo->query("INSERT INTO conversation (ID_Conversation, Date_Envoie, ID_Utilisateur) VALUES ('".$ID_Conversation."', Now(), ".$_SESSION['user_courrier']['ID_Utilisateur'].")");
        $insert_message=$pdo->query("INSERT INTO message (ID_Message, ID_Conversation, Emetteur, Texte, ID_Utilisateur) VALUES ('".$ID_Message."', '".$ID_Conversation."', '".$sender."', '".$content2."', ".$_SESSION['user_courrier']['ID_Utilisateur'].")");
        while ($aig=true) {
            $sel_num=$pdo->query("SELECT telephone.* FROM telephone INNER JOIN participer ON telephone.ID_Telephone=participer.ID_Telephone WHERE participer.ID_Conversation='".$ID_Conversation."' LIMIT ".$nbr.",".$Queue['Queue']);
            $messages=array();
            while ($numbers=$sel_num->fetch()) {
                $Nbr_Enreg++;
                $messages[] = array(
                    'from' => $sender,
                    'to' => $numbers['Num_Telephone'],
                    'text' => $content
                    // 'date' => "2020-01-20 15:45:00"
                );
            }
            $postdata = array(
                'messages' => $messages
            );
            // echo json_encode($postdata);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://197.242.157.206:8086/sms/multi");
            curl_setopt($ch, CURLOPT_HEADER, FALSE );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json', 'Authorization: Basic ' . $token));
            $response = curl_exec($ch);
             $err = curl_error($ch);
             curl_close($ch);

             if ($err) {
                 echo "cURL Error #:" . $err;
                 $aig=false;
             } else {
                $res_numero=$pdo->query("SELECT telephone.* FROM telephone INNER JOIN participer ON telephone.ID_Telephone=participer.ID_Telephone WHERE participer.ID_Conversation='".$ID_Conversation."' LIMIT ".$nbr.",".$Queue['Queue']);
                while ($numeros=$res_numero->fetch()) {
                    $pos = strpos($response, $numeros['Num_Telephone']);
                    $mystring = '{"messages":['.substr($response, $pos-7, 189).']}';
                    $pos_smsCount = strpos($response, 'smsCount');
                    $smsCount = substr($response, $pos_smsCount+10, 1);
                    $pos_desc = strpos($mystring, 'description');
                    $mydesc= substr($mystring, $pos_desc+14, 8);
                    if($mydesc=='ESME_ROK'){
                        $statut="Delivered";
                    }else{
                        $statut="Undelivered";
                    }


                    $update_participer=$pdo->query("UPDATE participer SET Reponse='".$mystring."', smsCount=".$smsCount.", Command=1, Statut='".$statut."' WHERE ID_Conversation='".$ID_Conversation."' AND ID_Telephone='".$numeros['ID_Telephone']."'");
                }
            }
            $nbr=$nbr+$Queue['Queue'];
            if($Nbr_Enreg==$count['Nbr']){
                $aig=false;
            }
            sleep(1000);
        }
        echo "1";
    }

}


?>