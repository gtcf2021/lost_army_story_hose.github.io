
<?php
/*include("config.php");
function checkSlots($mysqli,$date){
    $stmt = $mysqli->prepare("SELECT SUM(num_of_people) AS total_people FROM test3 WHERE date = ? ");
    $stmt->bind_param('s', $date);
    $totalbookings = 0;
    if($stmt->execute()){ 
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $totalpeople = $row['total_people'];
        }
        $stmt->close();
    }
 return $totalbookings;
}   */


function build_calendar($month, $year) {
    $mysqli = new mysqli('localhost', 'root', '', 'reservation');
     $stmt = $mysqli->prepare("select * from test3 where MONTH(date) = ? AND YEAR(date) = ?");
    $stmt->bind_param('ss', $month, $year);
    $bookings = array();
    if($stmt->execute()){ 
        $result = $stmt->get_result();
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                $bookings[] = $row['date'];
            }
            
            $stmt->close();
        }
    }
    
    
     // Create array containing abbreviations of days of week.
     $daysOfWeek = array('日','一','二','三','四','五','六');

     // What is the first day of the month in question?
     $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

     //一個月的天數
     $numberDays = date('t',$firstDayOfMonth);

     // Retrieve some information about the first day of the
     // month in question.
     $dateComponents = getdate($firstDayOfMonth);

     // What is the name of the month in question?
     $monthName = $dateComponents['month'];

     // What is the index value (0-6) of the first day of the
     // month in question.
     $dayOfWeek = $dateComponents['wday'];

     // Create the table tag opener and day headers
     
    $datetoday = date('Y-m-d');
    

    //上方按鈕
    $calendar = "<table class='table table-bordered'>";
    $calendar .= "<center><h2 class='header text-white'>$monthName $year</h2>";
    $calendar.= "<button class='changemonth btn btn-xs btn-primary' data-month='".date('m', mktime(0, 0, 0, $month-1, 1, $year))."'data-year='".date('Y', mktime(0, 0, 0, $month-1, 1, $year))."'><</button> ";
    
    $calendar.= " <button class='changemonth btn btn-xs btn-primary' data-month='".date('m')."'data-year='".date('Y')."'>today</button> ";
    
    $calendar.= "<button class='changemonth btn btn-xs btn-primary' data-month='".date('m', mktime(0, 0, 0, $month+1, 1, $year))."'data-year='".date('Y', mktime(0, 0, 0, $month+1, 1, $year))."'>></button></center><br>";
    
    
        
      $calendar .= "<tr>";

     // Create the calendar headers

     foreach($daysOfWeek as $day) {
          $calendar .= "<th  class='header text-white' style='background-color:#003d47'>$day</th>";
     } 

     // Create the rest of the calendar

     // Initiate the day counter, starting with the 1st.

     $currentDay = 1;

     $calendar .= "</tr><tr>";

     // The variable $dayOfWeek is used to
     // ensure that the calendar
     // display consists of exactly 7 columns.

     if ($dayOfWeek > 0) { 
         for($k=0;$k<$dayOfWeek;$k++){
                $calendar .= "<td  class='empty' style='background-color:#003d47'></td>"; 
         }
     }
    
     
     $month = str_pad($month, 2, "0", STR_PAD_LEFT);
  
     while ($currentDay <= $numberDays) {

          // Seventh column (Saturday) reached. Start a new row.

          if ($dayOfWeek == 7) {

               $dayOfWeek = 0;
               $calendar .= "</tr><tr>";

          }
          
          $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
          $date = "$year-$month-$currentDayRel";
          
            $dayname = strtolower(date('l', strtotime($date)));
            $eventNum = 0;
            $today = $date==date('Y-m-d')? "today" : "";
         if($date<date('Y-m-d',strtotime('+2 days'))){
            $calendar.="<td class='text-white'style='background-color:#003d47'><h4>$currentDay</h4>";
         }elseif ($date > date('Y-m-d', strtotime('+1 month'))) {
            $calendar .= "<td class='text-white'style='background-color:#003d47'><h4>$currentDay</h4>";
         }else{
            if($dayname =='monday'){
                $calendar.="<td class='text-red' style='background-color:#003d47'><h4>$currentDay</h4> <button class='btn btn-danger btn-xs'>休館</button>";
            }else{
            $calendar .= "<td class='$today text-white'style='background-color:#003d47'><h4>$currentDay</h4> <a href='book.php?date=".$date."' class='btn btn-success btn-xs'>可預約</a>";}}
          $calendar .="</td>";
          // Increment counters
          $currentDay++;
          $dayOfWeek++;

    }
     // Complete the row of the last week in month, if necessary

     if ($dayOfWeek != 7) { 
     
          $remainingDays = 7 - $dayOfWeek;
            for($l=0;$l<$remainingDays;$l++){
                $calendar .= "<td class='empty' style='background-color:#003d47'></td>"; 

         }

     }
     
     $calendar .= "</tr>";

     $calendar .= "</table>";

     echo $calendar;

}

$dateComponents = getdate();
if(isset($_POST['month']) && isset($_POST['year'])){
    $month = $_POST['month']; 			     
    $year = $_POST['year'];
}else{
    $month = $dateComponents['mon']; 			     
    $year = $dateComponents['year'];
}
echo build_calendar($month,$year);
?>






