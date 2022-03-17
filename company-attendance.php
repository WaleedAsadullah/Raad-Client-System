<?php
include_once('session.php');
include_once('functions.php');
function display_query2($sql)
{

 $conn = connect_db();
 $result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row

  
//get_current_form();
                                               
   $i = 0;                                     
  while($row = $result->fetch_assoc()) {
    if($i==0)
    {
echo '
                <thead>
                  <tr>
                    <th>S.No</th>
                    <th></th>
                    <th></th>';
$row_data = array_keys($row);
$id_column = "";
for($j=0;$j<count($row_data);$j++){

  if($j==0) $id_column = $row_data[$j];

    echo  "<th>".$row_data[$j]."</th>"; }
                                                   
    echo   '</tr>
         </thead>
      <tbody><tr><td></td><td></td><td></td>';

$col_counter = 3;
       for($si=$col_counter;$si<count($row_data)+3;$si++){
      echo '
      <th style="font-weight: normal">
      <input type="text" style="width:100%" id="myInput'.$col_counter.'" onkeyup="myFunction('.$col_counter.')" placeholder="Search..." title="Type in a word">
      </th>';
      $col_counter++;
      }
      echo"</tr>";



    }
  $i++;  
    echo '<tr>
              <td>'.$i.'</td>
              <td style="text-align:center;"><a style="color:rgb(16,196,105);" href="'.$_SERVER['PHP_SELF'].'?editid='.$row[$id_column].'"><i class="zmdi zmdi-edit"></i></a></td>
            
              <td style="text-align:center;"><a style="color:rgb(255,87,90);" href="'.$_SERVER['PHP_SELF'].'?deleteid='.str_replace(" ","___",$row[$id_column]).'"><i class="fa fa-trash-o" onclick="return confirm(\'Are you sure?\')"></i></a></td>';
for($k=0;$k<count($row_data);$k++){ 
    if ($row_data[$k] == "Task Title") {
        echo '<td><a href="task-track.php?specific='.$row[$row_data[0]].'">'.$row[$row_data[$k]].'<a></td>';

    }
    else{
    echo  '<td>'.$row[$row_data[$k]].'</td>';}}

   echo  '</tr>';
  }

    echo '   </tbody>';
} else {
  echo "You don't have data.";
}
    

}
// ------------------------
if(isset($_REQUEST['submit'])){
// print_r($_REQUEST);
$task_assigned_by = get_curr_user();
$sql = 'INSERT INTO `rd_services_request`(`request_id`, `user_id`, `user_date` ,`user_type`, `title`, `description`) VALUES (NULL,\'';
$sql .= get_curr_user();
$sql .= '\', CURRENT_TIMESTAMP,"Client", \''.$_REQUEST['title'].'\', \''.$_REQUEST['description'].'\')';
// echo $sql;
insert_query($sql);
}

// ------------------------

///edit code
check_edit("rd_services_request","request_id");
edit_display("rd_services_request","request_id");
//end of edit code -shift view below delete

// ------------------------
if(isset($_REQUEST['deleteid']) && is_numeric($_REQUEST['deleteid'])){ $sql = 'DELETE FROM `rd_services_request` WHERE `rd_services_request`.`request_id` = '.$_REQUEST['deleteid'];

insert_query($sql);
// echo "done deleting";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <link rel="shortcut icon" href="assets/images/favicon.png">

        <title>Services Requests</title>

        <!--Chartist Chart CSS -->
        <link rel="stylesheet" href="assets/plugins/chartist/dist/chartist.min.css">

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!-- [if lt IE 9]> -->
        <!-- <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script> -->
        <!-- <![endif] -->

        <script src="assets/js/modernizr.min.js"></script>


    </head>


    <body>
        <?php
        
        include_once('header.php');
        ?>

        <div class="wrapper">
            <div class="container">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">Attendance Record</h4>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
                            <div class="m-t-5 m-b-5" style="text-align: center" >
                                 <a  href="company-attendance.php?insert=insert" > <button type="button" class="btn btn-primary btn w-md waves-effect waves-light"  >+ Add Manual Attendance</button></a>
                                 <a  href="company-attendance.php" > <button type="button" class="btn btn-primary btn w-md waves-effect waves-light"  >View Attendance</button></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ===================== -->
                <?php if(!isset($_GET['id_no']) && !isset($_GET['insert'])){ ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <h4 class="header-title m-t-0 m-b-5" style="text-align: center; font-size: 22px; padding: 10px"> Employee Attendance </h4>
                                    <br>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Late Entry</th>
                                                    <th>Late and Penalty</th>
                                                    <th>Half Day Entry</th>
                                                    <th>Early Exit</th>
                                                    <th>Early and Penalty Exit</th>
                                                    <th>Half Exit</th>
                                                    <th>Not Punch</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $sql_no = 'SELECT `no` FROM `attendance` GROUP BY `no`';
                                            $result_no = mysqli_query(connect_db(),$sql_no);
                                            $no = [];
                                            while ($row_no = mysqli_fetch_assoc($result_no)) {
                                                array_push($no,$row_no['no']);
                                            }
                                            for($n=0;$n<sizeof($no);$n++){
                                            // $sql = "SELECT * FROM `ac_annual_appraisal`";

                                            $sql = 'SELECT `attendance_id`"ID", `name`"Name", `no`"No.", `time`"Time", `verify_code`"Verify Code" FROM `attendance` order by `attendance_id`  DESC';


                                            $sql2 = 'SELECT `attendance_id`"ID", `name`"Name", `no`"No.", `time`"Time", `verify_code`"Verify Code" FROM `attendance`  where `no`= '.$no[$n].' order by `time` ASC';
                                            // display_query($sql2);

                                            $late_entry2 = 0;
                                            $late_and_penalty_entry2 = 0;
                                            $half_day_entry2 = 0;
                                            $not_punch2 = 0;
                                            $early_exit2 = 0;
                                            $early_and_pentaly_exit2 = 0;
                                            $half_day_exit2 = 0;



                                                // Declare two dates 
                                                $Date1 = '01-12-2020'; 
                                                $Date2 = '31-12-2020'; 

                                                // Declare an empty array 
                                                $array = [];

                                                // Use strtotime function 
                                                $Variable1 = strtotime($Date1); 
                                                $Variable2 = strtotime($Date2); 

                                                // Use for loop to store dates into array 
                                                // 86400 sec = 24 hrs = 60*60*24 = 1 day 
                                                for ($currentDate = $Variable1; $currentDate <= $Variable2; 
                                                                                $currentDate += (86400)) { 
                                                                                    
                                                $Store = date('Y-m-d', $currentDate); 
                                                $array[] = $Store; 
                                                } 

                                                // // Display the dates in array format 
                                                // echo "<pre>";
                                                // print_r($array); 
                                                // echo "</pre>";



                                            $result = mysqli_query(connect_db(),$sql2);
                                            $row_name = mysqli_fetch_assoc($result);
                                            $all_data = [];
                                            while($row = mysqli_fetch_assoc($result)){
                                                array_push($all_data,explode(" ",$row['Time']) );

                                            }
                                            // echo "<pre>";
                                            // print_r($all_data); 
                                            // echo "</pre>";
$daycounter = 0;
$last_day = (int)date("t", strtotime($all_data[0][0]));
                                            for($i=0;$i<sizeof($all_data);$i++){
  
 $arr_split_date = explode("-",$all_data[$i][0]);

 $daycounter++;
// echo "last day of month=". $last_day;
//  echo "<br>";
 $date_made = $arr_split_date[0]."-".$arr_split_date[1]."-".$daycounter;
 $dt1 = strtotime($date_made);
$dt2 = date("l", $dt1);
$dt3 = strtolower($dt2);
// echo $dt3;
// echo "<br>";


 if($arr_split_date[2] > $daycounter)  { 
$date_made = $arr_split_date[0]."-".$arr_split_date[1]."-".$daycounter;

//$dt='2011-01-04';
        $dt1 = strtotime($date_made);
        $dt2 = date("l", $dt1);
        $dt3 = strtolower($dt2);
        // echo $dt3;
    // if($dt3 == "sunday") echo "sunday<br>";
    // else echo "$dt3<br>";
        

//$datetime = 
//echo "date made = $date_made | day=".date("D",strtotime($date_made))."<br>";
if($dt3 == "sunday");
    // echo "<tr><td>".$date_made."</td><td>".$dt3."</td><td>Sunday </td><td>Sunday </td><td><span class='label label-pink'>Sunday</span></td><td><span class='label label-pink'>Sunday</span></td><td>Sunday</td></tr>";
                                                    else{
    // echo "<tr><td>".$date_made."</td><td>".$dt3."</td><td>Not Punch </td><td>Not Punch </td><td><span class='label label-primary'>Not Punch</span></td><td><span class='label label-primary'>Not Punch</span></td><td>Not Punch</td></tr>";
                                                    $i--;
                                                    $not_punch2 ++;}
                                                }
 if($arr_split_date[2] > $daycounter) continue;
                                                if(isset($all_data[$i+1][0]) && $all_data[$i][0] == $all_data[$i+1][0] ){

                                                    //echo date("D",$all_data[$i+1][0])."<br>";
                                                    $j=1;
                                                    $skip = 0;
                                                    while($j){
                                                        //isset($all_data[$i+1][0]) 
                                                    if($all_data[$i+1][0] == $all_data[$i+$j+1][0] ){
                                                      //  echo "start".$all_data[$i+1][1]." end= ".$all_data[$i+$j+1][1]."<br>";
                                                        if( strtotime($all_data[$i+1][1]) < strtotime($all_data[$i+$j+1][1]))
                                                        $all_data[$i+1][1] = $all_data[$i+$j+1][1];
                                                      //  else "more";
                                                        $j++;
                                                       $skip++;
                                                    }
                                                    else $j=-1;
                                                }

                                                // ----- Entry Time
                                                $input_entry_time = "09:00:00";
                                                $entry_time = date('G:i:s',strtotime($input_entry_time));

                                               $entry_time_with_15 = strtotime("+15 minutes", strtotime($entry_time));
                                               $entry_time_with_15 = date('G:i:s', $entry_time_with_15);

                                               $entry_time_with_3hr = strtotime("+180 minutes", strtotime($entry_time));
                                               $entry_time_with_3hr = date('G:i:s', $entry_time_with_3hr);

                                               // ----- Exit Time 
                                               $input_exit_time = "19:00:00";
                                               $exit_time = date('G:i:s',strtotime($input_exit_time));

                                               $exit_time_with_15 = strtotime("-15 minutes", strtotime($exit_time));
                                               $exit_time_with_15 = date('G:i:s', $exit_time_with_15);

                                               $exit_time_with_3hr = strtotime("-180 minutes", strtotime($exit_time));
                                               $exit_time_with_3hr = date('G:i:s', $exit_time_with_3hr);

                                               // =--- entery

                                                if(strtotime($all_data[$i][1]) <= strtotime($entry_time)){
                                                    $status = "On Time";
                                                    $class = "label label-success";
                                                }
                                                if(strtotime($all_data[$i][1]) > strtotime($entry_time) && strtotime($all_data[$i][1]) < strtotime($entry_time_with_15)){
                                                    $status = "Late";
                                                    $class = "label label-default";
                                                    $late_entry2 ++;
                                                }
                                                if(strtotime($all_data[$i][1]) > strtotime($entry_time) && strtotime($all_data[$i][1]) > strtotime($entry_time_with_15)){
                                                    $status = "Late + Penalty";
                                                    $class = "label label-warning";
                                                    $late_and_penalty_entry2 ++;
                                                }

                                                if(strtotime($all_data[$i][1]) > strtotime($entry_time) && strtotime($all_data[$i][1]) > strtotime($entry_time_with_15) && strtotime($all_data[$i][1]) > strtotime($entry_time_with_3hr)){
                                                    $status = "Half Day";
                                                    $class= "label label-danger";
                                                    $half_day_entry2 ++;
                                                }

                                                // =---- Exit

                                                if(strtotime($all_data[$i+1][1]) >= strtotime($exit_time)){
                                                    $status2 = "On Time";
                                                    $class2 = "label label-success";
                                                }
                                                if(strtotime($all_data[$i+1][1]) < strtotime($exit_time) && strtotime($all_data[$i+1][1]) > strtotime($exit_time_with_15)){
                                                    $status2 = "Early";
                                                    $class2 = "label label-default";
                                                    $early_exit2 ++;
                                                }
                                                if(strtotime($all_data[$i+1][1]) < strtotime($exit_time) && strtotime($all_data[$i+1][1]) < strtotime($exit_time_with_15)){
                                                    $status2 = "Early + Penalty";
                                                    $class2 = "label label-warning";
                                                    $early_and_pentaly_exit2 ++;
                                                }

                                                if(strtotime($all_data[$i+1][1]) < strtotime($exit_time) && strtotime($all_data[$i+1][1]) < strtotime($exit_time_with_15) && strtotime($all_data[$i+1][1]) < strtotime($exit_time_with_3hr)){
                                                    $status2 = "Half Day";
                                                    $class2= "label label-danger";
                                                    $half_day_exit2 ++;
                                                }
                                                

                                                $working_hours = strtotime($all_data[$i+1][1]) - strtotime($all_data[$i][1]);
                                                $working_hours = gmdate("H:i", $working_hours);





                                                    // echo "<tr><td>".$all_data[$i][0]."</td><td>".$dt3."</td><td>".$all_data[$i][1]. "</td><td>" .$all_data[$i+1][1]."</td><td><span class = '".$class."' >".$status."</span></td><td><span class = '".$class2."' >".$status2."</span></td><td>".$working_hours."</td></tr>";

                                                    if($skip) $i += $skip;

                                                }
                                                elseif($all_data[$i][0] != $all_data[$i+1][0] && $all_data[$i][0] != $all_data[$i-1][0]){
                                                    // echo "<tr><td>".$all_data[$i][0]."</td><td>".$dt3."</td><td>".$all_data[$i][1]. "</td><td>Not Punch </td><td><span class='label label-primary'>Not Punch</span></td><td><span class='label label-primary'>Not Punch</span></td><td>Not Punch</td></tr>";
                                                }
                                            }
                                        //    echo "day counter = $daycounter , last day =  $last_day <br>";
                                             if($daycounter< $last_day) {
for($daycounter++;$daycounter<= $last_day;$daycounter++) {
     // echo "day counter = $daycounter , last day =  $last_day <br>";
                                                // echo "<tr><td>".$arr_split_date[0]."-".$arr_split_date[1]."-".$daycounter."</td><td>".$dt3."</td><td>Not Punch </td><td>Not Punch </td><td><span class='label label-primary'>Not Punch</span></td><td><span class='label label-primary'>Not Punch</span></td><td>Not Punch</td></tr>";
                                             }
}
                                                
                                            // if(in_array($array,$date[0])){

                                            // display_query_attendance($sql);
                                            // $result = mysqli_query(connect_db(),$sql);

                                            // while($row = mysqli_fetch_assoc($result)){
                                            //     $row_data = array_keys($row);
                                            //     $id_column = "";
                                            //     for($j=0;$j<count($row_data);$j++){
                                            //          if($j==0) $id_column = $row_data[$j];
                                            //          print_r($row[$row_data[0]]);
                                            //     }
                                            // }
                                            // -----------------------
                                            // echo $exit_time_with_15;
echo "<tr><td>".$row_name['No.']."</td><td><a href='company-attendance.php?id_no=".$row_name['No.']."&name=".$row_name['Name']."'>".$row_name['Name']."</a></td><td>".$late_entry2."</td><td>".$late_and_penalty_entry2."</td><td>".$half_day_entry2."</td><td>".$early_exit2."</td><td>".$early_and_pentaly_exit2."</td><td>".$half_day_exit2."</td><td>".$not_punch2."</td></tr>";
}#array no loop end

                                            ?>
                                        </table>
                                            <?php   
                                            ?>
                                    </div>
                                </div>
                            </div>
                        </div>   
            <?php }?> 
                <!-- ===================== -->
                <?php if (isset($_GET['id_no'])) {
                            ?>
                            <div class="row" >
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <h3 class="header-title m-t-0 m-b-5" style="text-align: center; font-size: 22px; padding: 10px"> <?php echo $_GET['name']?>  </h3>
                                    <br>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Day</th>
                                                    <th>Entry Time</th>
                                                    <th>Exit Time</th>
                                                    <th>Entry Status</th>
                                                    <th>Exit Status</th>
                                                    <th>Working Hours</th>
                                                </tr>
                                            </thead>
                                            <?php


                                            if(isset($_REQUEST['submit'])){
                                                // print_r($_REQUEST);
                                                $sql = 'INSERT INTO `attendance`(`attendance_id`, `user_id`, `user_date`, `depart`, `name`, `no`, `time`, `location_id`, `id_num`, `verify_code`, `card_no`) VALUES  (NULL,\'';
                                                $sql .= get_curr_user();
                                                $sql .= '\', CURRENT_TIMESTAMP,"My Company", \''.$_REQUEST['name'].'\', \''.$_REQUEST['no'].'\', \''.$_REQUEST['time'].'\',"101",NULL,"Manual",NULL)';
                                                // echo $sql;
                                                insert_query($sql);
                                            }

                                            // // ------------------------

                                            // ///edit code
                                            check_edit("attendance","attendance_id");
                                            edit_display("attendance","attendance_id");
                                            // //end of edit code -shift view below delete

                                            // // ------------------------
                                            if(isset($_REQUEST['deleteid']) && is_numeric($_REQUEST['deleteid'])){ $sql = 'DELETE FROM `attendance` WHERE `attendance`.`attendance_id` = '.$_REQUEST['deleteid'];

                                            insert_query($sql);
                                            // echo "done deleting";
                                                }
                                            // $sql = "SELECT * FROM `ac_annual_appraisal`";

                                            $sql = 'SELECT `attendance_id`"ID", `name`"Name", `no`"No.", `time`"Time", `verify_code`"Verify Code" FROM `attendance` order by `attendance_id`  DESC';


                                            $sql2 = 'SELECT `attendance_id`"ID", `name`"Name", `no`"No.", `time`"Time", `verify_code`"Verify Code" FROM `attendance`  where `no`= '.$_GET['id_no'].' order by `time` ASC';
                                            // display_query($sql2);

                                            $late_entry = 0;
                                            $late_and_penalty_entry = 0;
                                            $half_day_entry = 0;
                                            $not_punch = 0;
                                            $early_exit = 0;
                                            $early_and_pentaly_exit = 0;
                                            $half_day_exit = 0;



                                                // Declare two dates 
                                                $Date1 = '01-12-2020'; 
                                                $Date2 = '31-12-2020'; 

                                                // Declare an empty array 
                                                $array = [];

                                                // Use strtotime function 
                                                $Variable1 = strtotime($Date1); 
                                                $Variable2 = strtotime($Date2); 

                                                // Use for loop to store dates into array 
                                                // 86400 sec = 24 hrs = 60*60*24 = 1 day 
                                                for ($currentDate = $Variable1; $currentDate <= $Variable2; 
                                                                                $currentDate += (86400)) { 
                                                                                    
                                                $Store = date('Y-m-d', $currentDate); 
                                                $array[] = $Store; 
                                                } 

                                                // // Display the dates in array format 
                                                // echo "<pre>";
                                                // print_r($array); 
                                                // echo "</pre>";



                                            $result = mysqli_query(connect_db(),$sql2);
                                            $all_data = [];
                                            while($row = mysqli_fetch_assoc($result)){
                                                array_push($all_data,explode(" ",$row['Time']) );

                                            }
                                            // echo "<pre>";
                                            // print_r($all_data); 
                                            // echo "</pre>";
$daycounter = 0;
$last_day = (int)date("t", strtotime($all_data[0][0]));
                                            for($i=0;$i<sizeof($all_data);$i++){
  
 $arr_split_date = explode("-",$all_data[$i][0]);

 $daycounter++;
// echo "last day of month=". $last_day;
//  echo "<br>";
 $date_made = $arr_split_date[0]."-".$arr_split_date[1]."-".$daycounter;
 $dt1 = strtotime($date_made);
$dt2 = date("l", $dt1);
$dt3 = strtolower($dt2);
// echo $dt3;
// echo "<br>";


 if($arr_split_date[2] > $daycounter)  { 
$date_made = $arr_split_date[0]."-".$arr_split_date[1]."-".$daycounter;

//$dt='2011-01-04';
        $dt1 = strtotime($date_made);
        $dt2 = date("l", $dt1);
        $dt3 = strtolower($dt2);
        // echo $dt3;
    // if($dt3 == "sunday") echo "sunday<br>";
    // else echo "$dt3<br>";
        

//$datetime = 
//echo "date made = $date_made | day=".date("D",strtotime($date_made))."<br>";
if($dt3 == "sunday") { echo "<tr><td>".$date_made."</td><td>".$dt3."</td><td>Sunday </td><td>Sunday </td><td><span class='label label-pink'>Sunday</span></td>
                                                    <td><span class='label label-pink'>Sunday</span></td><td>Sunday</td></tr>";}
                                                    else{
    echo "<tr><td>".$date_made."</td><td>".$dt3."</td><td>Not Punch </td><td>Not Punch </td><td><span class='label label-primary'>Not Punch</span></td>
                                                    <td><span class='label label-primary'>Not Punch</span></td><td>Not Punch</td></tr>";
                                                    $i--;
                                                    $not_punch ++;}
                                                }
 if($arr_split_date[2] > $daycounter) continue;
                                                if(isset($all_data[$i+1][0]) && $all_data[$i][0] == $all_data[$i+1][0] ){

                                                    //echo date("D",$all_data[$i+1][0])."<br>";
                                                    $j=1;
                                                    $skip = 0;
                                                    while($j){
                                                    // if(!isset($all_data[$i+1][0])){
                                                    //     break;
                                                    // }
                                                    // if(!isset($all_data[$i+$j+1][0])){
                                                    //     break;
                                                    // }
                                                    if($all_data[$i+1][0] == $all_data[$i+$j+1][0] ){
                                                      //  echo "start".$all_data[$i+1][1]." end= ".$all_data[$i+$j+1][1]."<br>";
                                                        if( strtotime($all_data[$i+1][1]) < strtotime($all_data[$i+$j+1][1]))
                                                        $all_data[$i+1][1] = $all_data[$i+$j+1][1];
                                                      //  else "more";
                                                        $j++;
                                                       $skip++;
                                                    }
                                                    else $j=-1;
                                                }

                                                // ----- Entry Time
                                                $input_entry_time = "09:00:00";
                                                $entry_time = date('G:i:s',strtotime($input_entry_time));
                                                // echo "<h1>".$entry_time."</h1>";

                                               $entry_time_with_15 = strtotime("+15 minutes", strtotime($entry_time));
                                               $entry_time_with_15 = date('G:i:s', $entry_time_with_15);

                                               $entry_time_with_3hr = strtotime("+180 minutes", strtotime($entry_time));
                                               $entry_time_with_3hr = date('G:i:s', $entry_time_with_3hr);

                                               // ----- Exit Time 
                                               $input_exit_time = "19:00:00";
                                               $exit_time = date('G:i:s',strtotime($input_exit_time));

                                               $exit_time_with_15 = strtotime("-15 minutes", strtotime($exit_time));
                                               $exit_time_with_15 = date('G:i:s', $exit_time_with_15);

                                               $exit_time_with_3hr = strtotime("-180 minutes", strtotime($exit_time));
                                               $exit_time_with_3hr = date('G:i:s', $exit_time_with_3hr);

                                               // =--- entery

                                                if(strtotime($all_data[$i][1]) <= strtotime($entry_time)){
                                                    $status = "On Time";
                                                    $class = "label label-success";
                                                }
                                                if(strtotime($all_data[$i][1]) > strtotime($entry_time) && strtotime($all_data[$i][1]) < strtotime($entry_time_with_15)){
                                                    $late_entry ++;
                                                    $status = "Late";
                                                    $class = "label label-default";
                                                }
                                                if(strtotime($all_data[$i][1]) > strtotime($entry_time) && strtotime($all_data[$i][1]) > strtotime($entry_time_with_15)){
                                                    $status = "Late + Penalty";
                                                    $class = "label label-warning";
                                                    $late_and_penalty_entry ++;
                                                }

                                                if(strtotime($all_data[$i][1]) > strtotime($entry_time) && strtotime($all_data[$i][1]) > strtotime($entry_time_with_15) && strtotime($all_data[$i][1]) > strtotime($entry_time_with_3hr)){
                                                    $status = "Half Day";
                                                    $class= "label label-danger";
                                                    $half_day_entry ++;
                                                }

                                                // =---- Exit

                                                if(strtotime($all_data[$i+1][1]) >= strtotime($exit_time)){
                                                    $status2 = "On Time";
                                                    $class2 = "label label-success";
                                                }
                                                if(strtotime($all_data[$i+1][1]) < strtotime($exit_time) && strtotime($all_data[$i+1][1]) > strtotime($exit_time_with_15)){
                                                    $status2 = "Early";
                                                    $class2 = "label label-default";
                                                    $early_exit ++;
                                                }
                                                if(strtotime($all_data[$i+1][1]) < strtotime($exit_time) && strtotime($all_data[$i+1][1]) < strtotime($exit_time_with_15)){
                                                    $status2 = "Early + Penalty";
                                                    $class2 = "label label-warning";
                                                    $early_and_pentaly_exit ++;
                                                }

                                                if(strtotime($all_data[$i+1][1]) < strtotime($exit_time) && strtotime($all_data[$i+1][1]) < strtotime($exit_time_with_15) && strtotime($all_data[$i+1][1]) < strtotime($exit_time_with_3hr)){
                                                    $status2 = "Half Day";
                                                    $class2= "label label-danger";
                                                    $half_day_exit ++;
                                                }
                                                
                                                $working_hours = strtotime($all_data[$i+1][1]) - strtotime($all_data[$i][1]);
                                                $working_hours = gmdate("H:i", $working_hours);





                                                    echo "<tr><td>".$all_data[$i][0]."</td><td>".$dt3."</td><td>".$all_data[$i][1]. "</td><td>" .$all_data[$i+1][1]."</td>
                                                    <td><span class = '".$class."' >".$status."</span></td>
                                                    <td><span class = '".$class2."' >".$status2."</span></td>
                                                    <td>".$working_hours."</td></tr>";
                                                    if($skip) $i += $skip;

                                                }
                                                elseif($all_data[$i][0] != $all_data[$i+1][0] && $all_data[$i][0] != $all_data[$i-1][0]){
                                                    echo "<tr><td>".$all_data[$i][0]."</td><td>".$dt3."</td><td>".$all_data[$i][1]. "</td><td>Not Punch </td><td><span class='label label-primary'>Not Punch</span></td>
                                                    <td><span class='label label-primary'>Not Punch</span></td><td>Not Punch</td></tr>";
                                                }
                                            }
                                        //    echo "day counter = $daycounter , last day =  $last_day <br>";
                                             if($daycounter< $last_day) {
for($daycounter++;$daycounter<= $last_day;$daycounter++) {
     // echo "day counter = $daycounter , last day =  $last_day <br>";
                                                echo "<tr><td>".$arr_split_date[0]."-".$arr_split_date[1]."-".$daycounter."</td><td>".$dt3."</td><td>Not Punch </td><td>Not Punch </td><td><span class='label label-primary'>Not Punch</span></td>
                                                    <td><span class='label label-primary'>Not Punch</span></td><td>Not Punch</td></tr>";
                                             }
}
                                                
                                            // if(in_array($array,$date[0])){

                                            // display_query_attendance($sql);
                                            // $result = mysqli_query(connect_db(),$sql);

                                            // while($row = mysqli_fetch_assoc($result)){
                                            //     $row_data = array_keys($row);
                                            //     $id_column = "";
                                            //     for($j=0;$j<count($row_data);$j++){
                                            //          if($j==0) $id_column = $row_data[$j];
                                            //          print_r($row[$row_data[0]]);
                                            //     }
                                            // }
                                            // -----------------------
                                            // echo $exit_time_with_15;

                                            ?>
                                        </table>
                                        <div class="table-responsive">
                                            <table class="tablesaw table m-b-0 tablesaw-columntoggle table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Late Entry</th>
                                                        <th>Late and Penalty</th>
                                                        <th>Half Day Entry</th>
                                                        <th>Early Exit</th>
                                                        <th>Early and Penalty Exit</th>
                                                        <th>Half Exit</th>
                                                        <th>Not Punch</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                            <?php

                                            echo "<tr>
                                                <td>".$late_entry."</td>
                                                <td>".$late_and_penalty_entry."</td>
                                                <td>".$half_day_entry."</td>
                                                <td>".$early_exit."</td>
                                                <td>".$early_and_pentaly_exit."</td>
                                                <td>".$half_day_exit."</td>
                                                <td>".$not_punch."</td>
                                                </tr>";
                                                    // echo "late entry".$late_entry;
                                                    // echo "<br>";
                                                    // echo "late and penalty entry".$late_and_penalty_entry;
                                                    // echo "<br>";
                                                    // echo "half day entry".$half_day_entry;
                                                    // echo "<br>";
                                                    // echo "not punch entry".$not_punch ;
                                                    // echo "<br>";
                                                    // echo "early exit".$early_exit;
                                                    // echo "<br>";
                                                    // echo "early and penalty exit".$early_and_pentaly_exit;
                                                    // echo "<br>";
                                                    // echo "half exit".$half_day_exit;
                                            ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        <?php } ?>
                        
                <!-- ===================== -->
                <!-- end row -->
                <?php if (isset($_GET['insert'])) { ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <h4 class="header-title m-t-0 m-b-5" style="text-align: center; font-size: 22px; padding: 10px"> Employee Entery Form </h4>
                                    <br>
                                    <form action="attendance.php" method="post">


                                        <div class="form-group">
                                            <label for="">Name</label>
                                            <input type="text" name="name" required="" placeholder="Enter name" class="form-control" value="<?php if(isset($_REQUEST['name'])) echo $_REQUEST['name']?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">No.</label>
                                            <input type="number" name="no" required="" placeholder="Enter No" class="form-control" value="<?php if(isset($_REQUEST['no'])) echo $_REQUEST['no']?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="">Date Time</label>
                                            <input type="datetime-local" name="time" required="" placeholder="" class="form-control" value="<?php if(isset($_REQUEST['time'])) echo $_REQUEST['time']?>">
                                        </div>

                                        <div class="form-group text-right m-b-0">
                                            <?php 
                                            code_submit();
                                            ?>
                                            <button type="reset" class="btn btn-default waves-effect waves-light m-l-5">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                   
                <!-- end row -->


                <!-- Footer -->
                <?php
                include_once('footer.php') 
                ?>
                <!-- End Footer -->

            </div>
            <!-- end container -->



            <!-- Right Sidebar -->
            <?php
            include_once('notification.php');
            ?>
            <!-- /Right-bar -->

        </div>



        <!-- jQuery  -->
        <?php
        include_once('script.php');
        ?>

    </body>
</html>