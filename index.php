<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Грaфік чергування</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="wrapper">
    <form action="graf.php" method="POST">
      <table class="table">
          <thead class="thead">
              <tr>
                <th rowspan="2">Ім’я</th>
                <th rowspan="2">Група</th>
                <th colspan="5">Грaфік</th>
                <th rowspan="2">bye</th>
              </tr>
              <tr>
                <th>понеділок</th>
                <th>вівторок</th>
                <th>середа</th>
                <th>четвер</th>
                <th>п'ятниця</th>
              </tr>
            </thead>
            <tbody class="tbody">
              <?php
                  session_start();
                  //session_unset();
                  if (isset($_SESSION["students"])){
                    $students = json_decode($_SESSION["students"]);
                  } else {
                    $students = [
                      ["Петро", "пцб"],
                      ["Данііл", "бо"],
                      ["Назар", "еу"],
                      ["Оксана", "пцб"],
                      ["Андрій", "бо"],
                      ["Діана", "еу"],
                      ["Олексій", "пцб"],
                      ["Жанна", "бо"],
                      ["Людмила", "еу"],
                      ["Валентина", "пцб"],
                    ];
                  }
                  
                  if (isset($_POST["add"])){
                    $newStudent = [];
                    array_push($newStudent, $_POST["name"], $_POST["group"]);
                    array_push($students, $newStudent);
                    header('Location: graf.php');
                  }
                  if (isset($_POST["delete"])) {
                    //unset($students[$_POST["delete"]]);
                    array_splice ($students, $_POST["delete"], 1);
                    header('Location: graf.php');
                  }
                  $countDays = 5;
                  $schedule1Start =9;
                  $schedule2Start =18;
                  $schedule1 = [];
                  $schedule2 = [];
                  $schedule3 = [];
                  for ($i = 0, $k = $schedule1Start, $m = $schedule2Start; $i < $countDays; $i++, $k++, $m--){
                      $schedule3Start = rand(9,18);
                      $isNotOk = true;
                      if ($schedule3Start != $k || $schedule3Start != $m){
                        $isNotOk = false;
                        for ($j = 0; $j < count($schedule3); $j++) {
                          $test = $schedule3[$j][0] . $schedule3[$j][1];
                          
                          if ($schedule3[$j][0] == $schedule3Start || $schedule3[$j][1] == $schedule3Start || $test == $schedule3Start){
                            $isNotOk = true;
                            break;
                          }
                        }
                      }
                      while ($schedule3Start == $k || $schedule3Start == $m || $isNotOk){
                        if (count($schedule3) == 0){
                          $isNotOk = false;
                        }
                        for ($j = 0; $j < count($schedule3); $j++) {
                          $test = $schedule3[$j][0] . $schedule3[$j][1];
                          if ($schedule3[$j][0] == $schedule3Start || $schedule3[$j][1] == $schedule3Start || $test == $schedule3Start){
                            $isNotOk = true;
                            
                            break;
                          }
                            if (($j + 1) == count($schedule3)) {
                              $isNotOk = false;
                            }
                        }
                        if ($schedule3Start == $k || $schedule3Start == $m || $isNotOk) {
                          $schedule3Start = rand(9,18);
                          $isNotOk = true;
                        }
                      }
                      $time1 = "";
                      $time2 = "";
                      $time3 = "";
                      if ($k < 10){
                          $time1 .=0;
                      }
                      if ($m < 10){
                          $time2 .=0;
                      }
                      if ($schedule3Start < 10){
                        $time3 .=0;
                      }
                      $time1 .= $k .":00";
                      $time2 .= $m .":00";
                      $time3 .= $schedule3Start .":00";
                      $schedule1[] .= $time1;
                      $schedule2[] .= $time2;
                      $schedule3[] .= $time3;

                      //array_push($schedule1, $time);
                  }
                  for ($i = 0; $i < count($students); $i++){
                    echo "<tr>";
                    echo "<td>".$students[$i][0]."</td>";
                    echo "<td>".$students[$i][1]."</td>";
                    for ($j = 0; $j < count($schedule1); $j++){
                      if ($students[$i][1] == "пцб"){
                      echo "<td>".$schedule1[$j]."</td>";
                      } else if ($students[$i][1] == "бо"){
                      echo "<td>".$schedule2[$j]."</td>";
                      } else if ($students[$i][1] == "еу"){
                      echo "<td>".$schedule3[$j]."</td>";
                      }
                    }
                    echo "<td><button type='submit' name='delete' value='$i'>-</td>";
                    echo "</tr>";
                  }
                  $_SESSION["students"] = json_encode($students);
              ?>
        </tbody>    
      </table>
        <p>
          <label>
            <input type="text" name="name" placeholder="Ім'я">
          </label>
          <label class="select">
            <select name="group">
              
              <option value="еу" select desibled>Група</option>
              <option value="бо">бо</option>
              <option value="пцб">пцб</option>
              <option value="еу">еу</option>
          </label>
          <label>
            <input type="submit" name="add" value="+">
          </label>
        </p>  
    </form>   
  </div>
</body>
</html>