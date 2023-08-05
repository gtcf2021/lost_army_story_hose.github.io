<?php
include("config.php");
?>

<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>search</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container" style="max-width:50%;">
            <div class="text-center mt_5 mb_4">
                <h2>預約查詢</h2>
            </div>
        <form method="post">
        <input type="text" class="form-control" id="live_search" autocomplete="off" name="search" placeholder="請輸入電話號碼">
        <button class="btn btn-dark btn-sm" name="submit" >搜尋</button>
        </form>
    </div>
    <div id="searchresult">
   
    <?php
        if(isset($_POST['submit'])){
        $search=$_POST['search'];
        $query = "SELECT * FROM test2 WHERE phone='$search'";
        $result = mysqli_query($con,$query);

        if(mysqli_num_rows($result)>0){?>
        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th>姓名</th>
                    <th>電話</th>
                    <th>預約日期</th>
                    <th>預約時段</th>
                    <th>預約人數</th>
                    <th>備註</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($row=mysqli_fetch_assoc($result)){
                    $name=$row['name'];
                    $phone=$row['phone'];
                    $note= $row['note'];
                    $period=$row['period'];
                    $people=$row['people'];
                    $date=$row['date'];
                    ?>
                    <tr>
                        <td><?php echo $name;?></td>
                        <td><?php echo $phone;?></td>
                        <td><?php echo $date;?></td>
                        <td><?php echo $period;?></td>
                        <td><?php echo $people;?></td>
                        <td><?php echo $note;?></td>
                        
                    </tr>
                    <?php
                }
            ?>
        </tbody>
    </table>
    <?php
    }else{
        echo"<h6 class='text-danger text-center mt-3'>沒此筆預約</h6>";
        }
    }
    ?> 
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</body>
</html>


   






