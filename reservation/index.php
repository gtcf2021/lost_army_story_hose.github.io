<!DOCTYPE html>
<html lang="zh-Hant-TW">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>異域故事館預約系統</title>
    <link rel="shortcut icon" href="css/img/lost_army_story_house.png" type="image/png" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  
  </head>

  


<header>
  <nav class="navbar navbar-expand-lg navbar-dark  fixed-top">
  <div class="container-fluid">

    <a class="navbar-brand justify-content-center" href="#"><img src="css/img/lost_army_story_house.png" alt="異域故事館" title="異域故事館logo" class="logo"></a>

    <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="side offcanvas offcanvas-start " tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header text-white border-bottom">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">預約系統</h5>
        <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="offcanvas" ria-label="Close"></button>
      </div>
      <div class="offcanvas-body ">
        <ul class="navbar-nav justify-content-center align-items-center flex-grow-1 pe-3 fs-5">
          <li class="nav-item mx-2">
            <a class="nav-link js-scroll-trigger" aria-current="page" href="#" >首頁</a>
          </li>
          <li class="nav-item">
            <a class="nav-link mx-2 js-scroll-trigger" href="#reserve" >我要預約</a>
          </li>
          <li class="nav-item">
            <a class="nav-link mx-2 js-scroll-trigger" href="#search" >預約查詢/取消</a>
          </li>
          
        </ul>
      </div>
    </div>
  </div>
</nav>
</header>

<body>
    <div class="container" style="max-width:100%;">
      <div class="form" id="reserve">
<!-------------------------左半邊-------------------------------------------------->
        <div class="contact-form">

          <form  method="post">
            <h3 class="title">預約資料</h3>


            <div class="input-container">
              <input type="text" name="name" class="input" required="required" name="name" autocomplete="off"/>
              <label for="name">姓名</label>
              <span>姓名</span>
            </div>
            <div class="input-container">
              <input type="tel" name="phone" class="input" required="required" autocomplete="off"/>
              <label for="phone">電話</label>
              <span>背景</span>
            </div>

              <fieldset>
                <legend>預約時刻</legend>

              <div class="containerr">
                <label for="date">預約日期:</label>
                <input type="date" name="date" id="demo" class="txtDate" required="required" />
                <br/><br>

                <label for="period">預約時段:</label>
                <input type="radio" name="period" value="1" checked="checked"> 早上10點
                <input type="radio" name="period" value="2"> 早上11點
                <input type="radio" name="period" value="3"> 下午14點
                <input type="radio" name="period" value="4"> 下午15點
                 </br><br/>

                <label for="people" name="people">預約人數:</label>
                <select name="people">
                    <option  value="1"selected="selected">1</option>
                    <option  value="2" >2</option>
                    <option  value="3">3</option>
                    <option  value= "4">4</option>
                </select>
                <p>(15人以上團體參觀)請致電故事館預約(電話：03-4650736)</p>
              </div>
            </fieldset>

            <div class="input-container">
              <input type="text" name="note" class="input" />
              <label for="note">備註</label>
              <span>備註</span>
            </div>

            <input  value="送出" type="submit" name="submit" class="btn" />
            
          </form>
        </div>
<!-------------------------預約彈出視窗-------------------------------------------------->
<?php

include("config.php");

 if(isset($_POST['submit'])){
  
    $name=$_POST['name'];
    $phone=$_POST['phone'];
    $note= $_POST['note'];
    $period=$_POST['period'];
    $people=$_POST['people'];
    $date=$_POST['date'];


    $insert = " insert into test2(name,phone,note,period,people,date)values('$name','$phone','$note','$period','$people','$date')";

    $query= mysqli_query($con,$insert);

    if($query){
    	?>
      <script>
         swal({title: "【預約及報到說明】",
         text:"1. 預約系統24小時開放，提供二日後至次月底參觀時段預約\n2. 請依預約人數入場\n3. 各場次皆準時開始，請提前5分鐘至遊客中心報到",
         button: "了解",
         })
         .then((value) => {
         swal(`預約成功`);
      });
      </script>
      <?php
    }
 }
 ?>

<!-------------------------右半邊-------------------------------------------------->
        <div class="contact-info">
          <h4 class="title"><img src="img/location.png" class="icon" alt="" />故事館位置</h4>
          <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3618.1219777350757!2d121.25181227371445!3d24.927914242558234!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3468230fc42c5657%3A0xe76ecbebfa3dc070!2z55Ww5Z-f5pWF5LqL6aSoKOmgkOe0hOWItik!5e0!3m2!1szh-TW!2stw!4v1690444828235!5m2!1szh-TW!2stw" width="250" height="150" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
    
          <div class="info">
            <div class="informationn">
              <h3><img src="img/location.png" class="icon" alt=""/>停車資訊(皆為收費停車場)</h3></div>
              <p><a href="https://goo.gl/maps/WqezyUefVihVPmtW9" target="_blank" >中正一路停車場</a></p>
              <p><a href="https://goo.gl/maps/yevpAvT8d2LLocGH6" target="_blank" >CITY PARKING 城市車旅停車場</a></p>
              <p><a href="https://goo.gl/maps/kLw8UUDUEaN9fQAA8" target="_blank" >雲南文化公園停車場</a></p>
            
            
            <div class="information">
              <img src="img/phone.png" class="icon" alt="" />
              <p>03-4650736</p>
            </div>
          </div>

          <div class="social-media">
            <p>Connect with us :</p>
            <div class="social-icons">
              <a href="#">
                <i class="fab fa-facebook-f"></i>
              </a>
           <!--缺一個line的圖片-->
            </div>
          </div>
        </div>
<!-------------------------右半邊end-------------------------------------------------->
      </div>
    </div>
<!-------------------------查詢-------------------------------------------------->
<div class="container" id="search"style="max-width:100%;">
            <div class="text-center mt_5 mb_4">
                <h2>預約查詢</h2>
            </div>
        <form method="post">
        <input type="text" class="form-control" id="live_search" autocomplete="off" name="search" placeholder="請輸入電話號碼">
        <button class="btn btn-dark btn-sm" name="search" type="search">搜尋</button>
        </form>
    </div> 
    <!-------------------------查詢表格-------------------------------------------------->
    <div id="searchresult">
    <?php
    include("connection.php");
        if(isset($_POST['search'])){
        $search=$_POST['search'];
        $query = "SELECT * FROM test2 WHERE phone='$search'";
        $result = mysqli_query($conn,$query);

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
   

<!-------------------------關閉navbar---------------------------------------------------->
<script type="text/javascript">    
           $('.js-scroll-trigger').click(function() {
    $('.side').collapse('hide');
  });
      </script>

<!-------------------------日期最大最小值-------------------------------------------------->
    <script src="app.js"></script>
  </body>
  <script>
    var date = new Date(); 
    var tdate=date.getDate();
    var mindate=date.getDate()+2;
    var month = date.getMonth()+1;
    var maxmonth = date.getMonth()+2;
    if(mindate<10){
        mindate='0'+mindate;
    }
    if(tdate<10){
        tdate='0'+tdate;
    }
    if(month<10){
        month='0'+month;
    }
    if(maxmonth<10){
        maxmonth='0'+maxmonth;
    }
    var year = date.getUTCFullYear();
    var minDate=year + '-' + month + '-' + mindate;
    var maxDate=year + '-' + maxmonth + '-' + tdate;
    document.getElementById("demo").setAttribute('min',minDate);
    document.getElementById("demo").setAttribute('max',maxDate);
    console.log(minDate);
</script>
</html>



