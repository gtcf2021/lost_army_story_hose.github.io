<?php
include("config.php");

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = mysqli_query($con, "DELETE FROM `test3` WHERE `id`='$id'");
}

?>

<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>search</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css" />
</head>
<body>
    <div class="container" style="max-width:50%;">
        <div class="text-center mt-5 mb-4">
            <h2 class="text-white">預約查詢</h2>
        </div>
        <form method="post">
            <input type="text" class="form-control" id="live_search" autocomplete="off" name="search" placeholder="請輸入電話號碼">
            <button class="btn btn-dark btn-sm" name="submit">搜尋</button>
        </form>
    </div>
    <div id="searchresult">
        <?php
        if(isset($_POST['submit'])){
            $search = $_POST['search'];
            $query = "SELECT * FROM test3 WHERE phone='$search'";
            $result = mysqli_query($con, $query);

            if(mysqli_num_rows($result) > 0){
        ?>
            <table class="table table-bordered table-striped mt-4">
                <thead>
                    <tr>
                        
                        <th>預約日期</th>
                        <th>預約時段</th>
                        <th>預約人數</th>
                        <th>姓名</th>
                        <th>電話</th>
                        <th>備註</th>
                        <th>刪除此預約</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while($row = mysqli_fetch_assoc($result)){
                        $name = $row['name'];
                        $phone = $row['phone'];
                        $timeslot = $row['timeslot'];
                        $num_of_people = $row['num_of_people'];
                        $date = $row['date'];
                        $id = $row['id'];
                        $note = $row['note'];
                    ?>
                        <tr>
                            
                            <td><?php echo $date; ?></td>
                            <td><?php echo $timeslot; ?></td>
                            <td><?php echo $num_of_people; ?></td>
                            <td><?php echo $name; ?></td>
                            <td><?php echo $phone; ?></td>
                            <td><?php echo $note; ?></td>
                            <td><a href='search.php?id=<?php echo $row['id']; ?>' class='btn-delete'>刪除</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        <?php
            } else {
                echo "<h6 class='text-danger text-center mt-3'>沒此筆預約</h6>";
            }
        }
        ?> 
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</body>
</html>
