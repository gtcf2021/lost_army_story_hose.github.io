
<?php

$server = "localhost:3306";    //your ip and port
$user = "root";                            //username by default give it root
$pass = "";                                   // default password is empty
$databse="reservation";             // database name 

$conn=mysqli_connect($server,$user,$pass,$databse);

if($conn){
	echo "";
}else{
	echo "Not Connected";
}


?>
