<?php
    $con= mysqli_connect('localhost','root','','reservation');
    if(!$con){
        echo"connection failed ".mysqli_connect_error();
     }
?>