<?php

ini_set('display_errors', 0);
/*elseif(in_array($date, $bookings)){
             $calendar.="<td class='$today'><h4>$currentDay</h4> <button class='btn btn-danger btn-xs'>名額有限</button>";
         }*/
$mysqli = new mysqli('localhost', 'root', '', 'reservation');
//connect日期改成connect時段
if(isset($_GET['date'])){
    $date = $_GET['date'];
    $stmt = $mysqli->prepare("select * from test3 where date=?");
    $stmt->bind_param('s', $date);
    $bookings = array();
    if($stmt->execute()){ 
        $result = $stmt->get_result();
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                $bookings[] = $row['timeslot'];
            }
            $stmt->close();
        }
    }
}

function checkSlots($mysqli, $date, $timeslot) {
    $stmtt = $mysqli->prepare("SELECT SUM(num_of_people) AS total_people FROM test3 WHERE date = ? AND timeslot = ?");
    $stmtt->bind_param('ss', $date, $timeslot);
    $totalpeople = 0;
    if ($stmtt->execute()) {
        $result = $stmtt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $totalpeople = $row['total_people'];
        }
        $stmtt->close();
    }
    return $totalpeople;
}


$duration = 60;
$cleanup = 0;
$start="10:00";
$end="16:00";
function timeslots($duration,$cleanup,$start,$end){
    $start=new DateTime($start);
    $end=new DateTime($end);
    $interval=new DateInterval("PT".$duration."M");
    $cleanupInterval= new DateInterval("PT".$cleanup."M");
    $slots= array();

    $breakStart = new DateTime("12:00");
    $breakEnd = new DateTime("14:00");

    for($intStart=$start;$intStart<$end;$intStart->add($interval)->add($cleanupInterval)){
        $endPeriod=clone $intStart;
        $endPeriod->add($interval);
        if($intStart >= $breakStart && $endPeriod <= $breakEnd){
           continue;
        }
        $slots[] = $intStart->format("H:iA");
    }
    return $slots;
}

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $timeslot=$_POST['timeslot'];
    $num_of_people = $_POST['num_of_people'];
    $note=$_POST['note'];
    /*$stmt = $mysqli->prepare("select * from test3 where date=? AND timeslot=?");
    $stmt->bind_param('ss', $date,$timeslot);
    if($stmt->execute()){ 
        $result = $stmt->get_result();
        if($result->num_rows>0){
            $msg = "<div class='alert alert-danger'>已預約</div>";
        }else{}}*/
            $stmt = $mysqli->prepare("INSERT INTO test3 (name,timeslot,phone,date,num_of_people,note) VALUES (?,?,?,?,?,?)");
            $stmt->bind_param('ssssis', $name,$timeslot, $phone, $date,$num_of_people,$note);
            $stmt->execute();
            $msg = "<div class='alert alert-success'>預約成功!</div>";
            $bookings[]=$timeslot;
            $stmt->close();
            $mysqli->close();
        }
?>
<!doctype html>
<html lang="zh-Hant-TW">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>預約時段</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="css/custom.css" />
  </head>

  <body>
    <div class="container">
        <h1 class="text-center text-white"> <?php echo date('Y/m/d', strtotime($date)); ?></h1><hr>
        <div class="row">
         <div class="col-md-12">
         <?php echo isset($msg)?$msg:""; ?>
         </div>
           <?php $timeslots= timeslots ($duration,$cleanup,$start,$end);
             foreach($timeslots as $ts){
             $totalbookings=checkSlots($mysqli, $date,$ts);
             $availableslot = 20 - $totalbookings;
             ?> 
             <div class="col-md-2">
             <div class="form-group ">
                
                
                <?php if($totalbookings>=20) {?>
                <center>  <button class="btn btn-danger"><?php echo $ts." 已額滿";?></button> </center>
                <?php } else {?>
                <center>     <button class="btn btn-success book" data-timeslot="<?php echo $ts; ?>" data-availableslot="<?php echo $availableslot; ?>"><?php echo $ts . " 餘" . $availableslot; ?></button></center>
                <?php } ?>
                </div>
                </div>
                <?php } ?>
                
        </div>
    </div>

    <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><span id="slot"></span>預約資訊:</h4><!--可以改掉有點醜-->
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form action=""method="post">
                    <div class="form-group">
                        <label for="">時段</label>
                        <input required type="text" readonly name="timeslot" id="timeslot" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">人數</label>
                        <input required type="number" name="num_of_people" id="num_of_people" class="form-control" min="1" max="<?php echo $availableslot; ?>" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">姓名</label>
                        <input required type="text"name="name" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">電話</label>
                        <input required type="phone"name="phone" class="form-control" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="">備註</label>
                        <input type="note"name="note" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group pull-right">
                        <button class="btn btn-primary" type="submit" name="submit">提交</button>
                    </div>
                </form>
            </div>
        </div>
      </div>
      
    </div>

  </div>
</div>
</body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script>
    $(".book").click(function() {
        var timeslot = $(this).data('timeslot');
        var availableSlot = $(this).data('availableslot'); // 获取 data-availableslot 值
        $("#slot").html(timeslot);
        $("#timeslot").val(timeslot);
        $("#num_of_people").attr("max", availableSlot); // 设置人数输入框的最大值
        $("#myModal").modal("show");
    });
    </script>
</html>