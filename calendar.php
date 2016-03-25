<?php

echo "<html style='font-size: 30px;'>";

$date = "";

header("Access-Control-Allow-Origin: *");
//error_reporting(E_ALL & ~E_NOTICE); 

error_reporting(0);



if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty($_POST["date"])) {
   } else {
       $date = strtotime($_POST["date"]);
   }
}

$year  = (int)date("Y", $date);
$month = (int)date("n", $date);
$monthStr = date("m", $date);
$weakNumber = (int)date("N", mktime(0,0,0,$month,1,$year));

drowCalendar($month, $year, $weakNumber);

function drowCalendar($month, $year, $weakNumber) {
    $day = 1;
    $daysCount = (int)date("t", mktime(0, 0, 0, $month, $day, $year));
    
    $dayInWeek = 1;
    
    echo "<table border='0' cellspacing='0' cellpadding='5' style='font-size: 30px;'>";
    
    echo "<tr>";
    echo "<td>Пн</td>";
    echo "<td>Вт</td>";
    echo "<td>Ср</td>";
    echo "<td>Чт</td>";
    echo "<td>Пт</td>";
    echo "<td>Сб</td>";
    echo "<td>Вс</td>";
    echo "</tr>";
    
    for ($i = 1; $i < $weakNumber; $i++) {
        echo "<td></td>";
        $dayInWeek++;
    }
    
    while ($day <= $daysCount) {
        if ($dayInWeek == 8) {
            $dayInWeek = 1;
            echo "</tr><tr>";
        }
        echo "<td>$day</td>";
        $day++;
        $dayInWeek++;
    }
    echo "</tr>";
    
    echo "</table>";
    echo "<br>";
}

?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
   Date: <input type="month" id="date" name="date" value="<?php echo $year . '-' . $monthStr;?>">
   <input type="submit" name="submit" value="Submit"> 
</form>
</html>