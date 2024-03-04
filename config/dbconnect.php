<?php
    $cn=mysqli_connect('localhost','root','','bd_gym2023');
    mysqli_set_charset($cn, "utf8");
    if (!$cn) {
        echo 'Connection Error : '. mysqli_connect_error(); 
    }
    else{
    }

?>