<?php
  try{
    $pdo=new PDO('mysql:host=localhost;dbname=dbb_gest_hteli','root','miradie25landu');
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
