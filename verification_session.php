<?php
    session_start();
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $_SESSION['expire_time']){
        echo "1";
    }
?>