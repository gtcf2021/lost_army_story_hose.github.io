<?php
 $name=$_POST['name'];
 $phone=$_POST['phone'];
 $note= $_POST['note'];
 $period=$_POST['period'];
 $people=$_POST['people'];
 $date=$_POST['date'];

 $conn= new mysqli('localhost','root','','reservation');
 if($conn->connect_error){
    die('connection failed:'.$conn->connect_error);
 }else{
    $stmt = $conn->prepare("insert into test2(name,phone,note,period,people,date)
      values(?,?,?,?,?,?)");
    $stmt->bind_param("sssiis",$name,$phone,$note,$period,$people,$date);
    $stmt->execute();
    echo"registration successfully...";
    $stmt->close();
    $conn->close();
 }
?>

