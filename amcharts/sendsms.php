<?php
require_once("connexion.php");
if(isset($_GET['u']) && isset($_GET['h']) && isset($_GET['to']) && isset($_GET['sender']) && isset($_GET['msg'])){
    $user=htmlentities($_GET['u']);
    $token=htmlentities($_GET['h']);
    $numbers=htmlentities($_GET['to']);
    $content=$_GET['msg'];
    $sender=$_GET['sender'];
    $utilisateur=$pdo->query("SELECT * FROM utilisateur WHERE Login='".$user."'");
    if(!$utilisateurs=$utilisateur->fetch()){
        echo "Cet utilisateur n'existe pas";
    }else{

        if($utilisateurs['Active']==0){
            echo "Cet utilisateur est désactivé";
        }else{

          $val1_conversation=rand();
          $val2_conversation=rand();
          $ID_Conversation=sha1($val1_conversation.$val2_conversation);
          $val1_Message=rand();
          $val2_Message=rand();
          $ID_Message=sha1($val1_Message.$val2_Message);
          $val1_Participer=rand();
          $val2_Participer=rand();
          $ID_Participer=sha1($val1_Participer.$val2_Participer);
          $val1_Telephone=rand();
          $val2_Telephone=rand();
          $ID_Telephone=sha1($val1_Telephone.$val2_Telephone);
          $sender = strtr($sender,
            'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
            'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
          $sender = preg_replace('/([^.a-z0-9]+)/i', '-', $sender);
          // $content = iconv("UTF-8", "ISO-8859-15", $content);
          $postdata = array(
              'from' => $sender,
              'to' => $numbers,
              'text' => $content
              // 'date' => "2020-01-20 15:45:00"
          );

          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, "http://197.242.157.206/sms/single");
          curl_setopt($ch, CURLOPT_HEADER, FALSE );
          curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
          curl_setopt($ch, CURLOPT_PORT, 8086);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));
          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json', 'Authorization: Basic ' . $token));
          $response = curl_exec($ch);
          $responses = explode('"', $response);
          // var_dump($response);
           $err = curl_error($ch);
           curl_close($ch);

           if ($err) {
            echo "cURL Error #:" . $err;
           } else {
            $response=Securite::bdd($response);
            $content=Securite::bdd($content);
            $sel_tel=$pdo->query("SELECT * FROM telephone WHERE Num_Telephone='".$numbers."'");
            $smsCount = substr($responses[22], 1, 1);
            if($tel=$sel_tel->fetch()){
              $insert=$pdo->query("INSERT INTO conversation (ID_Conversation, Date_Envoie, ID_Utilisateur) VALUES ('".$ID_Conversation."', Now(), ".$utilisateurs['ID_Utilisateur'].")");
              // $insert=$pdo->query("INSERT INTO conversation (ID_Conversation, ID_Utilisateur) VALUES ('".$ID_Conversation."', ".$_SESSION['user_courrier']['ID_Utilisateur'].")");
                $insert_message=$pdo->query("INSERT INTO message (ID_Message, ID_Conversation, Emetteur, Texte, ID_Utilisateur) VALUES ('".$ID_Message."', '".$ID_Conversation."', '".$sender."', '".$content."', ".$utilisateurs['ID_Utilisateur'].")");

                $insert_participer=$pdo->query("INSERT INTO participer (ID_Participer, ID_Conversation, ID_Telephone, Reponse, smsCount, Command, ID_Utilisateur) VALUES ('".$ID_Participer."', '".$ID_Conversation."', '".$tel['ID_Telephone']."', '".$response."',".$smsCount.", 1, ".$utilisateurs['ID_Utilisateur'].")");
            }else{
                $insert_telephone=$pdo->query("INSERT INTO telephone (ID_Telephone, Num_Telephone, ID_Utilisateur) VALUES ('".$ID_Telephone."', '".$numbers."', ".$utilisateurs['ID_Utilisateur'].")");
              $insert=$pdo->query("INSERT INTO conversation (ID_Conversation, Date_Envoie, ID_Utilisateur) VALUES ('".$ID_Conversation."', Now(), ".$utilisateurs['ID_Utilisateur'].")");

                $insert_message=$pdo->query("INSERT INTO message (ID_Message, ID_Conversation, Emetteur, Texte, ID_Utilisateur) VALUES ('".$ID_Message."', '".$ID_Conversation."', '".$sender."', '".$content."', ".$utilisateurs['ID_Utilisateur'].")");
                
                $insert_participer=$pdo->query("INSERT INTO participer (ID_Participer, ID_Conversation, ID_Telephone, Reponse, smsCount, Command, ID_Utilisateur) VALUES ('".$ID_Participer."', '".$ID_Conversation."', '".$ID_Telephone."', '".$response."',".$smsCount.", 1, ".$utilisateurs['ID_Utilisateur'].")");
            }
            echo "Message envoyé avec succès";
             // echo $response;
           }
        }
    }

}else{
    echo "requête incomplète";
}

 ?>