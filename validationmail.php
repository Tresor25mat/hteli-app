<?php 
	$Mail=htmlentities($_POST['Mail']);
	if (filter_var($Mail, FILTER_VALIDATE_EMAIL)) { 
            echo "1";
    	}else{
            echo "2";
        }
	
?>