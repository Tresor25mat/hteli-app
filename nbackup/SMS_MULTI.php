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
$smsCount = $_POST['nbr_sms'];
$ID_Conversation = htmlentities($_POST['conversation']);
$val1_Message=rand();
$val2_Message=rand();
$ID_Message=sha1($val1_Message.$val2_Message);
$sender = strtr($sender,
      'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
      'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
$sender = preg_replace('/([^.a-z0-9]+)/i', '-', $sender);
$content2=Securite::bdd($content);
$insert=$pdo->query("INSERT INTO conversation (ID_Conversation, Date_Envoie, ID_Utilisateur) VALUES ('".$ID_Conversation."', Now(), ".$_SESSION['user_courrier']['ID_Utilisateur'].")");
$insert_message=$pdo->query("INSERT INTO message (ID_Message, ID_Conversation, Emetteur, Texte, ID_Utilisateur) VALUES ('".$ID_Message."', '".$ID_Conversation."', '".$sender."', '".$content2."', ".$_SESSION['user_courrier']['ID_Utilisateur'].")");
if(isset($_POST['temp_envoi']) && $_POST['temp_envoi']!=''){
    $temp_envoi=date('Y-m-d H:i:s', strtotime($_POST['temp_envoi']));
    $sel_tel=$pdo->query("SELECT telephone.*, participer.*  FROM telephone INNER JOIN participer ON telephone.ID_Telephone=participer.ID_Telephone WHERE participer.ID_Conversation='".$ID_Conversation."'");
    while ($tel=$sel_tel->fetch()) {
        $insert_planing=$pdo->query("INSERT INTO planing (ID_Participer, ID_Conversation, ID_Telephone, Command, smsCount, ID_Utilisateur, Temps_Envoi) VALUES ('".$tel['ID_Participer']."', '".$ID_Conversation."', '".$tel['ID_Telephone']."', 1, ".$smsCount.", ".$_SESSION['user_courrier']['ID_Utilisateur'].", '".$temp_envoi."')");
    }
    echo "2";
}else{
    $update_particip=$pdo->query("UPDATE participer SET Command=1, smsCount=".$smsCount." WHERE ID_Conversation='".$ID_Conversation."'");
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
        curl_setopt($ch, CURLOPT_URL, "http://197.242.157.206/sms/multi");
        curl_setopt($ch, CURLOPT_HEADER, FALSE );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_PORT, 8086);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json', 'Authorization: Basic ' . $token));
        $response = curl_exec($ch);
         $err = curl_error($ch);
         curl_close($ch);

         if ($err) {
             echo "cURL Error #:" . $err;
         } else {
            $res_numero=$pdo->query("SELECT telephone.* FROM telephone INNER JOIN participer ON telephone.ID_Telephone=participer.ID_Telephone WHERE participer.ID_Conversation='".$ID_Conversation."'");
            while ($numeros=$res_numero->fetch()) {
                $pos = strpos($response, $numeros['Num_Telephone']);
                $mystring = '{"messages":['.substr($response, $pos-7, 189).']}';
                $pos_smscount = strpos($response, "smsCount");
                $smsCount2 = substr($response, $pos_smscount+10, 1);

                if($smsCount2!=""){
                    $update_participer=$pdo->query("UPDATE participer SET Reponse='".$mystring."', smsCount=".$smsCount2." WHERE ID_Conversation='".$ID_Conversation."' AND ID_Telephone='".$numeros['ID_Telephone']."'");
                }else{
                    $update_participer=$pdo->query("UPDATE participer SET Reponse='".$mystring."' WHERE ID_Conversation='".$ID_Conversation."' AND ID_Telephone='".$numeros['ID_Telephone']."'");
                }
                // $update_participer=$pdo->query("UPDATE participer SET Reponse='".$mystring."' WHERE ID_Conversation='".$ID_Conversation."' AND ID_Telephone='".$numeros['ID_Telephone']."'");
            }
        }
        echo "1";

}

?>