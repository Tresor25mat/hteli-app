<?php
  try{
   $pdo=new PDO('mysql:host=localhost;dbname=bdd_eteelo_app','root','miradie25landu');
   // $pdo=new PDO('mysql:host=91.234.195.182;dbname=c1950075c_bdd_eteelo_app','c1950075c_user_bdd_eteelo_app','miradie25landu');

   $na=$pdo->query("SET NAMES 'utf8'");
   
    class Securite

    {

        // Données entrantes

        public static function bdd($string)

        {

            // On regarde si le type de string est un nombre entier (int)

            if(ctype_digit($string))

            {

                $string = intval($string);

            }

            // Pour tous les autres types

            else

            {

                //$string = htmlspecialchars($string);
 $string=addslashes($string);
  $string=htmlspecialchars($string);
                //$string = addcslashes($string);

               

            }

                

            return $string;


        }

        // Données sortantes

        public static function html($string)

        {

            return htmlentities($string);

        }

    }
   
   
   }catch (exception $e){
	die('Erreur: '.$e->getMessage());
   }
   
   
   
   
   
?>