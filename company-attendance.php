<?php
include_once('session.php');
include_once('functions.php');

if(isset($_REQUEST['submit'])){
    $status = "Pending";
    if($_SESSION['account']==0){
        $status = "Approved";
    }
    $sql = 'INSERT INTO `attendance`(`attendance_id`, `user_id`, `user_date`, `depart`, `name`, `no`, `time`, `location_id`, `id_num`, `verify_code`, `card_no`, `type`, `status`) VALUES (NULL,\'';
    $sql .= get_curr_user();
    $sql .= '\', CURRENT_TIMESTAMP,"My Company", \''.idtonames($_REQUEST['no'],'no','name','attendance').'\', \''.$_REQUEST['no'].'\', \''.$_REQUEST['time'].'\',"101",NULL,"Manual",NULL,"Manual","'.$status.'")';
    insert_query($sql);
}
function checkHoilday($date,$emplyee_id){
$sql = 'SELECT `id`, `entry_by`, `date`, `title` FROM `holiday` WHERE `date` = "'.$date.'" and ( type = "Common" OR employe_id = "'.$emplyee_id.'") and status = "Approved"';
// echo $sql;
$result = mysqli_query(connect_db(),$sql);
if(mysqli_num_rows($result)>0){
    $row= mysqli_fetch_assoc($result);

    return ["condition"=>true , "title"=>$row['title']];

}else{
    return ["condition"=>false , "title"=>"not"]; 
}

}
// if(isset($_REQUEST['submit'])){
//     // print_r($_REQUEST);
//     $sql = 'INSERT INTO `attendance`(`attendance_id`, `user_id`, `user_date`, `depart`, `name`, `no`, `time`, `location_id`, `id_num`, `verify_code`, `card_no`) VALUES  (NULL,\'';
//     $sql .= get_curr_user();
//     $sql .= '\', CURRENT_TIMESTAMP,"My Company", \''.$_REQUEST['name'].'\', \''.$_REQUEST['no'].'\', \''.$_REQUEST['time'].'\',"101",NULL,"Manual",NULL)';
//     // echo $sql;
//     insert_query($sql);
// }

// // // ------------------------

// // ///edit code
// check_edit("attendance","attendance_id");
// edit_display("attendance","attendance_id");
// // //end of edit code -shift view below delete

// // // ------------------------
// if(isset($_REQUEST['deleteid']) && is_numeric($_REQUEST['deleteid'])){ $sql = 'DELETE FROM `attendance` WHERE `attendance`.`attendance_id` = '.$_REQUEST['deleteid'];

// insert_query($sql);
// // echo "done deleting";
// }
// // $sql = "SELECT * FROM `ac_annual_appraisal`";

function nameByNo($para){
$new_array = explode(",", $para);
// print_r($new_array);
$name = "";
for($i=0;$i<sizeof($new_array);$i++){
    $name .= idtonames($new_array[$i],"no","name","attendance");
    $name .= " ";
}
return $name;
}


function display_query_atten($sql)
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
      <input type="text" style="width:100%" id="myInput'.$col_counter.'" onkeyup="myFunction('.$col_counter.')" placeholder="Search..." title="Type in a word" class="form-control" >
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

    if(($row_data[$k]=="status")){
      if($row[$row_data[$k]] =="Approved"){
        $class = "label label-success";
      }elseif ($row[$row_data[$k]] =="Rejected") {
        $class = "label label-danger";
      }else{
        $class = "label label-warning";
      }
       echo '<td data-name="'.$row_data[$k].'" class="'.$row_data[$k].'" data-type="select" data-pk="'.$row[$row_data[0]].'"><span class="'.$class.'">'.$row[$row_data[$k]].'</span></td>';

      // echo '<td><span class="'.$class.'">'.$row[$row_data[$k]].'</span></td>';
    }else{
    echo  '<td>'.$row[$row_data[$k]].'</td>';
    }
}

   echo  '</tr>';
  }

    echo '   </tbody>';
} else {
  echo "0 results";
}
    

}
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

        <title>Attendance</title>

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
        <div class="content-page">
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-box">
                                             
                                <div class="m-t-5 m-b-5" style="text-align: center" >
                                 <a  href="company-attendance.php?insert=true" > <button type="button" class="btn btn-primary btn w-md waves-effect waves-light"  >+ Add</button></a>
                                 <a  href="company-attendance.php" > <button type="button" class="btn btn-primary btn w-md waves-effect waves-light"  >View </button></a>
                                 <?php 
                                 $title = "ID|Depart|Name|Employee_ID|Time|Locattion_ID|ID Number|Verify Code|Card No";

                                 $Export = 'SELECT `attendance_id`, `depart`, `name`, `no`, `time`, `location_id`, `id_num`, `verify_code`, `card_no` FROM `attendance`';
                                 $name_file = "Attendance";

                                 $exportLink = "export.php?title=".$title."&Export=".$Export."&name_file=".$name_file."";
                                 ?>
                                 <a href="<?php echo $exportLink ?>"> <button type="button" class="btn btn-info btn w-md waves-effect waves-light" > Export  </button></a>
                                 <a  href="company-attendance.php?details=true" > <button type="button" class="btn btn-primary btn w-md waves-effect waves-light"  >Details</button></a>
                                 <!-- <a>
                                    <button type="button" class="btn btn-purple btn w-md waves-effect waves-light"  data-toggle="modal" data-target="#con-close-modal" > Import </button>
                                </a> -->
                                <a href="attendance-configuration.php">
                                    <button type="button" class="btn btn-purple btn w-md waves-effect waves-light"   > Employee Timing </button>
                                </a>
                                <!-- <a href="holiday.php">
                                    <button type="button" class="btn btn-info btn w-md waves-effect waves-light"   > Add Holiday </button>
                                </a> -->

                            </div>
                        </div>
                    </div>
                    <?php if(!isset($_GET['insert'])){ ?>
                    <div class="col-lg-12" >
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-5" style="text-align: center; font-size: 22px; padding: 10px">Set Values</h4>
                            <br>
                            <form action="" method="get">
                                <?php
                                if (isset($_GET['id_no'])) {
                                    echo'<input type="hidden" name="id_no" value="'.$_GET['id_no'].'">
                                    <input type="hidden" name="name" value="'.$_GET['name'].'">';
                                }

                                ?>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Month </label>
                                            <select class="form-control select2" name="month">

                                                <option value="January" <?php if(isset($_REQUEST['month']) && $_REQUEST['month'] == "January"){echo "selected";}elseif(!isset($_REQUEST['month']) && date('F')=="January"){echo "selected";}else{} ?>>January</option>

                                             <option value="February" <?php if(isset($_REQUEST['month']) && $_REQUEST['month'] == "February"){echo "selected";}elseif(!isset($_REQUEST['month']) && date('F')=="February"){echo "selected";}else{} ?> >February</option>
                                             <option value="March" <?php if(isset($_REQUEST['month']) && $_REQUEST['month'] == "March"){echo "selected";}elseif(!isset($_REQUEST['month']) && date('F')=="March"){echo "selected";}else{} ?> >March</option>

                                             <option value="April" <?php if(isset($_REQUEST['month']) && $_REQUEST['month'] == "April"){echo "selected";}elseif(!isset($_REQUEST['month']) && date('F')=="April"){echo "selected";}else{} ?> >April</option>

                                             <option value="May" <?php if(isset($_REQUEST['month']) && $_REQUEST['month'] == "May"){echo "selected";}elseif(!isset($_REQUEST['month']) && date('F')=="May"){echo "selected";}else{} ?>>May</option>

                                             <option value="June" <?php if(isset($_REQUEST['month']) && $_REQUEST['month'] == "June"){echo "selected";}elseif(!isset($_REQUEST['month']) && date('F')=="June"){echo "selected";}else{} ?>>June</option>

                                             <option value="July" <?php if(isset($_REQUEST['month']) && $_REQUEST['month'] == "July"){echo "selected";}elseif(!isset($_REQUEST['month']) && date('F')=="July"){echo "selected";}else{} ?>>July</option>

                                             <option value="August" <?php if(isset($_REQUEST['month']) && $_REQUEST['month'] == "August"){echo "selected";}elseif(!isset($_REQUEST['month']) && date('F')=="August"){echo "selected";}else{} ?>>August</option>

                                             <option value="September" <?php if(isset($_REQUEST['month']) && $_REQUEST['month'] == "September"){echo "selected";}elseif(!isset($_REQUEST['month']) && date('F')=="September"){echo "selected";}else{} ?>>September</option>

                                             <option value="October" <?php if(isset($_REQUEST['month']) && $_REQUEST['month'] == "October"){echo "selected";}elseif(!isset($_REQUEST['month']) && date('F')=="October"){echo "selected";}else{} ?>>October</option>

                                             <option value="November" <?php if(isset($_REQUEST['month']) && $_REQUEST['month'] == "November"){echo "selected";}elseif(!isset($_REQUEST['month']) && date('F')=="November"){echo "selected";}else{} ?>>November</option>

                                             <option value="December" <?php if(isset($_REQUEST['month']) && $_REQUEST['month'] == "December"){echo "selected";}elseif(!isset($_REQUEST['month']) && date('F')=="December"){echo "selected";}else{} ?>>December</option>

                                         </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Year </label>
                                            <input type="number" name="year" class="form-control" value="<?php if(isset($_REQUEST['year'])) { echo $_REQUEST['year'];}else {echo  date("Y"); }?>">
                                        </div>
                                    </div>
                                    <input type="hidden" name="value" value="value">
                                </div>


                                <div class="form-group text-right m-b-0">
                                    <button type="submit" name="value" class="btn btn-primary waves-effect waves-light m-l-5">
                                        Set Values
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                  <?php } ?>

                    <?php if(isset($_GET['details'])){ ?>
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-5" style="text-align: center; font-size: 22px; padding: 10px">Item List </h4>
                            <br>

                            <div class="table-responsive">
                                <table id="myTable" class="tablesaw table m-b-0 tablesaw-columntoggle table-bordered ">
                                    <?php
                                    $sql = 'SELECT `attendance_id`"ID", `user`.`user_name`"Entry By",`name`"Employee Name", `no`"Employee ID", `time`"Timing", `type` "Type", `status` FROM `attendance`,`user` where no in ('.employeOfCompany().') and `attendance`.`user_id` = `user`.`user_id` Order by `attendance`.`attendance_id` desc';
                                    display_query_atten($sql);
                                    // -----------------------

                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                    <?php 
                    if (isset($_GET['id_no'])) {
                        ?>
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
                                                <th>Working Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php






if(isset($_REQUEST['value'])){



$sql = 'SELECT `confi_id`, `user_id`, `user_date`, `attendance_no`, `type`, `work_type`, `entry_time`, `exit_time`, `work_hour` FROM `user_attendance_configuration` WHERE  `attendance_no` = "'.$_GET['id_no'].'" order by `confi_id` DESC';


$row = mysqli_fetch_assoc(mysqli_query(connect_db(),$sql));

// print_r($row);
// print_r($_REQUEST);
$form = date("Y-m-d", strtotime("first day of ".$_REQUEST['month']." ".$_REQUEST['year'].""));
// echo $form;
$to = date("Y-m-d", strtotime("last day of ".$_REQUEST['month']." ".$_REQUEST['year'].""));
$to = date("Y-m-d", strtotime($to." +1 days"));
$chech_in = $row['entry_time'];

$check_out = $row['exit_time'];
$grace_entry = "15";
$half_day_entry_1 = "180";
$grace_exit = "15";
$half_day_exit_1 =  "180";
$work_hour = $row['work_hour'];

}else{
$sql = 'SELECT `confi_id`, `user_id`, `user_date`, `attendance_no`, `type`, `work_type`, `entry_time`, `exit_time`, `work_hour` FROM `user_attendance_configuration` WHERE  `attendance_no` = "'.$_GET['id_no'].'" order by `confi_id` DESC';

$row = mysqli_fetch_assoc(mysqli_query(connect_db(),$sql));
$form = date("Y-m-d", strtotime("first day of this month"));
$to = date("Y-m-d");
$to = date("Y-m-d", strtotime($to." +1 days"));
$chech_in = $row['entry_time'];

$check_out = $row['exit_time'];
$grace_entry = "15";
$half_day_entry_1 = "180";
$grace_exit = "15";
$half_day_exit_1 =  "180";
$work_hour = $row['work_hour'];
}

$late_entry = 0;
$late_and_penalty_entry = 0;
$half_day_entry = 0;
$not_punch = 0;
$early_exit = 0;
$early_and_pentaly_exit = 0;
$half_day_exit = 0;
$absent = 0;

$period = new DatePeriod(
new DateTime($form),
new DateInterval('P1D'),
new DateTime($to)
);
if($row['type']=="Day"){
foreach ($period as $key => $value) {
    $date =  $value->format('Y-m-d')." 00:00:00";
    $date2 =  $value->format('Y-m-d')." 23:59:59";
// echo $date;
    $day = date('l',strtotime($date));
// echo "<br>---".$daycounter."---<br>";
    $firstid = '';
    $entryTime = '00:00';
    $secondid = '';
    $exitTime = '00:00';
    $checkpresent = 0;
    $working_hours = '';
    $working_hours_status = "<span class='label label-danger'>Not Completed</span>";
    $sql01 = 'SELECT `attendance_id`"ID",`time`"Time",`type` FROM `attendance`  where `no`= '.$_GET['id_no'].' and time > "'.$date.'" and time < "'.$date2.'" and status = "Approved" order by `time` ASC limit 1';
    $result01 = mysqli_query(connect_db(),$sql01);
    while($row01 = mysqli_fetch_assoc($result01)){
     // print_r($row01);
     $firstid = $row01['ID'];
     $entryTime = $row01['Time'];
     $attendanceTypeEntryTime = $row01['type'];

     // echo "<br>";
     $checkpresent = 1;   
 }
 $sql02 = 'SELECT `attendance_id`"ID",`time`"Time",`type` FROM `attendance`  where `no`= '.$_GET['id_no'].' and time > "'.$date.'" and time < "'.$date2.'" and status = "Approved" order by `time` DESC limit 1';
 $result02 = mysqli_query(connect_db(),$sql02);
 while($row02 = mysqli_fetch_assoc($result02)){
     // print_r($row02);
     $secondid = $row02['ID'];
     $exitTime = $row02['Time'];
     $attendanceTypeExitTime = $row02['type'];
     // echo "<br>";
     $checkpresent = 1;   
 }
 if($firstid==$secondid && strlen($firstid)>0){
    // echo "Present But Single Punch<br>";
    $not_punch++;
    $entry_status = "Single Punch";
    $exit_status = "Single Punch";
    $entry_status_class = "primary";
    $exit_status_class = "primary";
}
elseif($checkpresent){
    $entry_time_with_15 = strtotime("+".$grace_entry." minutes", strtotime($chech_in));
    $entry_time_with_15 = date('H:i:s', $entry_time_with_15);

    $entry_time_with_180 = strtotime("+".$half_day_entry_1." minutes", strtotime($chech_in));
    $entry_time_with_180 = date('H:i:s', $entry_time_with_180);



    $exit_time_with_15 = strtotime("-".$grace_exit." minutes", strtotime($check_out));
    $exit_time_with_15 = date('H:i:s', $exit_time_with_15);

    $exit_time_with_180 = strtotime("-".$half_day_exit_1." minutes", strtotime($check_out));
    $exit_time_with_180 = date('H:i:s', $exit_time_with_180);

    // echo "Present ".date('H:i:s',strtotime($entryTime))."  ".date('H:i:s',strtotime($exitTime))."<br>";



    if(strtotime($chech_in) >= strtotime(date('H:i:s',strtotime($entryTime)))){
        // echo "On Time<br>";
        $entry_status = "On Time";
        $entry_status_class = "success";
    }elseif(strtotime($entry_time_with_15) >= strtotime(date('H:i:s',strtotime($entryTime)))){
        // echo "Late<br>";
        $late_entry++;
        $entry_status = "Late";
        $entry_status_class = "info";
    }elseif(strtotime($entry_time_with_180) >= strtotime(date('H:i:s',strtotime($entryTime)))){
        // echo "Too Late<br>";
        $entry_status = "Too Late";
        $late_and_penalty_entry++;
        $entry_status_class = "pink";
    }else{
        // echo"Half Day<br>";
        $half_day_entry++;
        $entry_status = "Half Day";
        $entry_status_class = "warning";
    }

    if(strtotime($check_out) <= strtotime(date('H:i:s',strtotime($exitTime)))){
        // echo "On Time<br>";
        $exit_status = "On Time";
        $exit_status_class = "success";
    }elseif(strtotime($exit_time_with_15) <= strtotime(date('H:i:s',strtotime($exitTime)))){
        // echo "Early leave<br>";
        $early_exit++;
        $exit_status = "Early leave";
        $exit_status_class = "info";
    }elseif(strtotime($exit_time_with_180) <= strtotime(date('H:i:s',strtotime($exitTime)))){
        // echo "Too Early Leave<br>";
        $early_and_pentaly_exit++;
        $exit_status = "Too Early Leave";
        $exit_status_class = "pink";
    }else{
        // echo"Half Day Leave<br>";
        $half_day_exit++;
        $exit_status = "Half Day Leave";
        $exit_status_class = "warning";
    }
    $gmdate = strtotime($exitTime) - strtotime($entryTime);
    $working_hours = gmdate('H:i:s',$gmdate);

    // echo "Working Hours ".$working_hours;
    // echo "<br>";

}else{
    // echo "Absent<br>";

    $entry_status = "Absent";
    $exit_status = "Absent";
    $entry_status_class = "danger";
    $exit_status_class = "danger";
    $absent ++;
    // echo "<h1>".checkHoilday($value->format('Y-m-d'))['condition']."</h1>";
    if(checkHoilday($value->format('Y-m-d'),$_GET['id_no'])['condition']){

        $entry_status = checkHoilday($value->format('Y-m-d'),$_GET['id_no'])['title'];
        $exit_status = checkHoilday($value->format('Y-m-d'),$_GET['id_no'])['title'];
        $entry_status_class = "inverse";
        $exit_status_class = "inverse";
        $absent --;
        $working_hours_status = "<span class='label label-inverse'>Holiday</span>";
    }
}


if($entry_status=="Absent" && $day=="Sunday"){
    $entry_status = "Weekend";
    $exit_status = "Weekend";
    $entry_status_class = "inverse";
    $exit_status_class = "inverse";
    $working_hours_status = "<span class='label label-inverse'>Weekend</span>";
    $absent--;
}
if(strtotime($working_hours)>=strtotime($work_hour)){
    $working_hours_status = "<span class='label label-success'>Completed</span>";
}
// echo "-----------------------------------------<br>";

echo "<tr>
<td>".$value->format('d-M-y')."</td>
<td>".$day."</td>";
if($attendanceTypeEntryTime=="Auto"){
echo"
<td>".date('h:i:A',strtotime($entryTime))."</td>";
}else{

echo"
<td><span class='label label-danger' >".date('h:i:A',strtotime($entryTime))."</span></td>";
}


if($attendanceTypeExitTime=="Auto"){
echo"
<td>".date('h:i:A',strtotime($exitTime))."</td>";
}else{

echo"
<td><span class='label label-danger' >".date('h:i:A',strtotime($exitTime))."</span></td>";
}

echo"
<td><span class='label label-".$entry_status_class."'>".$entry_status."</span></td>
<td><span class='label label-".$exit_status_class."'>".$exit_status."</span></td>
<td>".$working_hours."</td>
<td>".$working_hours_status."</td>
</tr>";



}}elseif ($row['type']=="Night") {
foreach ($period as $key => $value) {
    $date =  $value->format('Y-m-d')." 00:00:00";
    $date2 =  $value->format('Y-m-d')." 23:59:59";

    $date0 = strtotime("+1 day", strtotime($value->format('Y-m-d')));
    $date01 = date('Y-m-d', $date0)." 00:00:00";
    $date02 = date('Y-m-d', $date0)." 23:59:59";

// echo $date;
    $day = date('l',strtotime($date));
// echo "<br>---".$daycounter."---<br>";
    $firstid = '';
    $entryTime = '00:00';
    // $secondid = '';
    // $exitTime = '00:00';
    $checkpresent = 0;
    $working_hours = '';
    $working_hours_status = "<span class='label label-danger'>Not Completed</span>";
    $sql01 = 'SELECT `attendance_id`"ID",`time`"Time" FROM `attendance`  where `no`= '.$_GET['id_no'].' and time > "'.$date.'" and time < "'.$date2.'" and status = "Approved" order by `time` DESC limit 1';
    $result01 = mysqli_query(connect_db(),$sql01);
    while($row01 = mysqli_fetch_assoc($result01)){
     // print_r($row01);
     $firstid = $row01['ID'];
     $entryTime = $row01['Time'];

     // echo "<br>";
     $checkpresent = 1;   
 }
 if($firstid==$secondid && strlen($firstid)>0){
    $absent++;
echo "<tr>
<td>".$value->format('d-M-y')."</td>
<td>".$day."</td>
<td>".date('h:i:A',strtotime($entryTime))."</td>
<td>".date('h:i:A',strtotime($exitTime))."</td>
<td><span class='label label-danger'>Absent</span></td>
<td><span class='label label-danger'>Absent</span></td>
<td></td>
<td>".$working_hours_status."</td>
</tr>";
    continue;
 }
 $sql02 = 'SELECT `attendance_id`"ID",`time`"Time" FROM `attendance`  where `no`= '.$_GET['id_no'].' and time > "'.$date01.'" and time < "'.$date02.'" and status = "Approved" order by `time` ASC limit 1';
 $result02 = mysqli_query(connect_db(),$sql02);
 while($row02 = mysqli_fetch_assoc($result02)){
     // print_r($row02);
     $secondid = $row02['ID'];
     $exitTime = $row02['Time'];
     // echo "<br>";
     $checkpresent = 1;   
 }
 if($firstid==$secondid && strlen($firstid)>0){
    // echo "Present But Single Punch<br>";
    $not_punch++;
    $entry_status = "Single Punch";
    $exit_status = "Single Punch";
    $entry_status_class = "primary";
    $exit_status_class = "primary";
}
elseif($checkpresent){
    $entry_time_with_15 = strtotime("+".$grace_entry." minutes", strtotime($chech_in));
    $entry_time_with_15 = date('H:i:s', $entry_time_with_15);

    $entry_time_with_180 = strtotime("+".$half_day_entry_1." minutes", strtotime($chech_in));
    $entry_time_with_180 = date('H:i:s', $entry_time_with_180);



    $exit_time_with_15 = strtotime("-".$grace_exit." minutes", strtotime($check_out));
    $exit_time_with_15 = date('H:i:s', $exit_time_with_15);

    $exit_time_with_180 = strtotime("-".$half_day_exit_1." minutes", strtotime($check_out));
    $exit_time_with_180 = date('H:i:s', $exit_time_with_180);

    // echo "Present ".date('H:i:s',strtotime($entryTime))."  ".date('H:i:s',strtotime($exitTime))."<br>";

    

    if(strtotime($chech_in) >= strtotime(date('H:i:s',strtotime($entryTime)))){
        // echo "On Time<br>";
        $entry_status = "On Time";
        $entry_status_class = "success";
    }elseif(strtotime($entry_time_with_15) >= strtotime(date('H:i:s',strtotime($entryTime)))){
        // echo "Late<br>";
        $late_entry++;
        $entry_status = "Late";
        $entry_status_class = "info";
    }elseif(strtotime($entry_time_with_180) >= strtotime(date('H:i:s',strtotime($entryTime)))){
        // echo "Too Late<br>";
        $entry_status = "Too Late";
        $late_and_penalty_entry++;
        $entry_status_class = "pink";
    }else{
        // echo"Half Day<br>";
        $half_day_entry++;
        $entry_status = "Half Day";
        $entry_status_class = "warning";
    }

    if(strtotime($check_out) <= strtotime(date('H:i:s',strtotime($exitTime)))){
        // echo "On Time<br>";
        $exit_status = "On Time";
        $exit_status_class = "success";
    }elseif(strtotime($exit_time_with_15) <= strtotime(date('H:i:s',strtotime($exitTime)))){
        // echo "Early leave<br>";
        $early_exit++;
        $exit_status = "Early leave";
        $exit_status_class = "info";
    }elseif(strtotime($exit_time_with_180) <= strtotime(date('H:i:s',strtotime($exitTime)))){
        // echo "Too Early Leave<br>";
        $early_and_pentaly_exit++;
        $exit_status = "Too Early Leave";
        $exit_status_class = "pink";
    }else{
        // echo"Half Day Leave<br>";
        $half_day_exit++;
        $exit_status = "Half Day Leave";
        $exit_status_class = "warning";
    }
    $gmdate = strtotime($exitTime) - strtotime($entryTime);
    $working_hours = gmdate('H:i:s',$gmdate);

    // echo "Working Hours ".$working_hours;
    // echo "<br>";

}else{
    // echo "Absent<br>";

    $entry_status = "Absent";
    $exit_status = "Absent";
    $entry_status_class = "danger";
    $exit_status_class = "danger";
    $absent ++;
    // echo "<h1>".checkHoilday($value->format('Y-m-d'))['condition']."</h1>";
    if(checkHoilday($value->format('Y-m-d'),$_GET['id_no'])['condition']){

        $entry_status = checkHoilday($value->format('Y-m-d'),$_GET['id_no'])['title'];
        $exit_status = checkHoilday($value->format('Y-m-d'),$_GET['id_no'])['title'];
        $entry_status_class = "inverse";
        $exit_status_class = "inverse";
        $absent --;
        $working_hours_status = "<span class='label label-inverse'>Holiday</span>";
    }
}


if($entry_status=="Absent" && $day=="Sunday"){
    $entry_status = "Weekend";
    $exit_status = "Weekend";
    $entry_status_class = "inverse";
    $exit_status_class = "inverse";
    $working_hours_status = "<span class='label label-inverse'>Weekend</span>";
    $absent--;
}
if(strtotime($working_hours)>=strtotime($work_hour)){
    $working_hours_status = "<span class='label label-success'>Completed</span>";
}
// echo "-----------------------------------------<br>";

echo "<tr>
<td>".$value->format('d-M-y')."</td>
<td>".$day."</td>
<td>".date('h:i:A',strtotime($entryTime))."</td>
<td>".date('h:i:A',strtotime($exitTime))."</td>
<td><span class='label label-".$entry_status_class."'>".$entry_status."</span></td>
<td><span class='label label-".$exit_status_class."'>".$exit_status."</span></td>
<td>".$working_hours."</td>
<td>".$working_hours_status."</td>
</tr>";



}
}
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
                                                <th>Absent</th>
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
                                            <td>".$absent."</td>
                                            </tr>";
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-responsive">
                                    <h4 class="header-title m-t-0 m-b-5" style="text-align: center; font-size: 22px; padding: 10px">Salary Detail</h4>
                                    <table class="tablesaw table m-b-0 tablesaw-columntoggle table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Salary</th>
                                                <th>Penalty on Late</th>
                                                <th>Penalty on Half Day</th>
                                                <th>Penalty on Early Exit</th>
                                                <th>Penalty on Half Exit</th>
                                                <th>Penalty on Not Punch</th>
                                                <th>Penalty on Absent</th>
                                                <th>Deducted Salary</th>
                                                <th>Wave Deduction Salary</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT `confi_id`, `user_id`, `user_date`, `attendance_no`, `type`, `work_type`, `entry_time`, `exit_time`, `work_hour`, `salary` FROM `user_attendance_configuration` WHERE `attendance_no` = ".$_GET['id_no']." order by confi_id desc";
                                            // echo $sql;
                                            $salary = mysqli_fetch_assoc(mysqli_query(connect_db(),$sql))['salary'];

                                            $perday = round($salary/30);


                                            $late_and_penalty_entry_deduction = round(($late_and_penalty_entry*0.33)*$perday);
                                            $half_day_entry_deduction = round(($half_day_entry*0.5)*$perday);
                                            $early_and_pentaly_exit_deduction = round(($early_and_pentaly_exit*0.33)*$perday);
                                            $half_day_exit_deduction = round(($half_day_exit*0.5)*$perday);
                                            $absent_deduction = (($absent*1)*$perday);
                                            $not_punch_deduction = round(($not_punch*0.5)*$perday);
                                            $deducted_salary = round($salary-$late_and_penalty_entry_deduction-$half_day_entry_deduction-$early_and_pentaly_exit_deduction-$half_day_exit_deduction-$absent_deduction-$not_punch_deduction);
                                            echo "<tr>
                                            <td>".$salary."</td>
                                            <td>".$late_and_penalty_entry_deduction."</td>
                                            <td>".$half_day_entry_deduction."</td>
                                            <td>".$early_and_pentaly_exit_deduction."</td>
                                            <td>".$half_day_exit_deduction."</td>
                                            <td>".$not_punch_deduction."</td>
                                            <td>".$absent_deduction."</td>
                                            <td><b>".$deducted_salary."</b><form method='POST' ><input type='hidden' name='salary' value = '".$deducted_salary."'> 
                                            <input type='hidden' name='location_id' value = '".$_GET['id_no']."'>
                                            <input type='hidden' name='comment' value = '".$_GET['name']." salary'>
                                            <button type='submit' class='label label-inverse' name='salaryPiad' >Paid</button>
                                            </form></td>

                                            <td><b>".$salary."</b><form method='POST' ><input type='hidden' name='salary' value = '".$salary."'> 
                                             <input type='hidden' name='location_id' value = '".$_GET['id_no']."'>
                                            <input type='hidden' name='comment' value = '".$_GET['name']." salary'>
                                            <button type='submit' class='label label-inverse' name='salaryPiad' >Paid</button>
                                            </form></td>
                                            </tr>";
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php if(!isset($_GET['id_no']) && !isset($_GET['insert']) && !isset($_GET['details'])){ ?>

    <div class="content-page">
        <div class="">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-5" style="text-align: center; font-size: 22px; padding: 10px"> Employee Attendance </h4>
                            <br>

                            <?php 
if(isset($_REQUEST['value'])){

// print_r($row);

 $form = date('Y-m-d',strtotime(''.$_REQUEST['year'].'-'.$_REQUEST['month'].' first day of this month'));
 // "<br>";
 $to = date('Y-m-d',strtotime(''.$_REQUEST['year'].'-'.$_REQUEST['month'].' last day of this month'));



}else{
$form = date("Y-m-d", strtotime("first day of this month"));
$to = date("Y-m-d");
}

echo '<h4 class="header-title m-t-0 m-b-5" style="text-align: center; font-size: 22px; padding: 10px"><i>'.date('d-F-Y',strtotime($form)).' to '.date('d-F-Y',strtotime($to)).'</i></h4>';

                            ?>

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
                                            <th>Absent</th>
                                        </tr>
                                    </thead>
                                    <?php

                                    $sql_no = 'SELECT `attendance_no` FROM `user_attendance_configuration` where  attendance_no in ('.employeOfCompany().') GROUP BY `attendance_no`';
                                    // echo $sql_no;
                                    // = 
                                    $result_no = mysqli_query(connect_db(),$sql_no);
                                    while ($row_no = mysqli_fetch_assoc($result_no)) {


$row_no['name']  = nameByNo($row_no['attendance_no']);

if(isset($_REQUEST['value'])){


$sql = 'SELECT `confi_id`, `user_id`, `user_date`, `attendance_no`, `type`, `work_type`, `entry_time`, `exit_time`, `work_hour` FROM `user_attendance_configuration` WHERE  `attendance_no` in ('.$row_no['attendance_no'].') order by `confi_id` DESC';


$row = mysqli_fetch_assoc(mysqli_query(connect_db(),$sql));

// print_r($row);

 $form = date('Y-m-d',strtotime(''.$_REQUEST['year'].'-'.$_REQUEST['month'].' first day of this month'));
 // "<br>";
 $to = date('Y-m-d',strtotime(''.$_REQUEST['year'].'-'.$_REQUEST['month'].' last day of this month'));
 // "<br>";
$chech_in = $row['entry_time'];

$check_out = $row['exit_time'];
$grace_entry = "15";
$half_day_entry_1 = "180";
$grace_exit = "15";
$half_day_exit_1 =  "180";
$work_hour = $row['work_hour'];


}else{
$sql = 'SELECT `confi_id`, `user_id`, `user_date`, `attendance_no`, `type`, `work_type`, `entry_time`, `exit_time`, `work_hour` FROM `user_attendance_configuration` WHERE  `attendance_no` = "'.$row_no['attendance_no'].'" order by `confi_id` DESC';

$row = mysqli_fetch_assoc(mysqli_query(connect_db(),$sql));
$form = date("Y-m-d", strtotime("first day of this month"));
$to = date("Y-m-d");
$chech_in = $row['entry_time'];

$check_out = $row['exit_time'];
$grace_entry = "15";
$half_day_entry_1 = "180";
$grace_exit = "15";
$half_day_exit_1 =  "180";
$work_hour = $row['work_hour'];
}

$late_entry = 0;
$late_and_penalty_entry = 0;
$half_day_entry = 0;
$not_punch = 0;
$early_exit = 0;
$early_and_pentaly_exit = 0;
$half_day_exit = 0;
$absent = 0;
$notcompleted = 0;

$period = new DatePeriod(
new DateTime($form),
new DateInterval('P1D'),
new DateTime($to)
);
if($row['type']=="Day"){
foreach ($period as $key => $value) {
    $date =  $value->format('Y-m-d')." 00:00:00";
    $date2 =  $value->format('Y-m-d')." 23:59:59";
// echo $date;
    $day = date('l',strtotime($date));
// echo "<br>---".$daycounter."---<br>";
    $firstid = '';
    $entryTime = '00:00';
    $secondid = '';
    $exitTime = '00:00';
    $checkpresent = 0;
    $working_hours = '';
    $working_hours_status = "<span class='label label-danger'>Not Completed</span>";
    $sql01 = 'SELECT `attendance_id`"ID",`time`"Time" FROM `attendance`  where `no` in ('.$row_no['attendance_no'].') and time > "'.$date.'" and time < "'.$date2.'" and status = "Approved" order by `time` ASC limit 1';
    // echo $sql01;
    $result01 = mysqli_query(connect_db(),$sql01);
    while($row01 = mysqli_fetch_assoc($result01)){
     // print_r($row01);
     $firstid = $row01['ID'];
     $entryTime = $row01['Time'];

     // echo "<br>";
     $checkpresent = 1;   
 }
 $sql02 = 'SELECT `attendance_id`"ID",`time`"Time" FROM `attendance`  where `no` in ('.$row_no['attendance_no'].') and time > "'.$date.'" and time < "'.$date2.'" and status = "Approved" order by `time` DESC limit 1';
 // echo $sql02;
 $result02 = mysqli_query(connect_db(),$sql02);
 while($row02 = mysqli_fetch_assoc($result02)){
     // print_r($row02);
     $secondid = $row02['ID'];
     $exitTime = $row02['Time'];
     // echo "<br>";
     $checkpresent = 1;   
 }
 if($firstid==$secondid && strlen($firstid)>0){
    // echo "Present But Single Punch<br>";
    $not_punch++;
    $entry_status = "Single Punch";
    $exit_status = "Single Punch";
    $entry_status_class = "primary";
    $exit_status_class = "primary";
}
elseif($checkpresent){
    $entry_time_with_15 = strtotime("+".$grace_entry." minutes", strtotime($chech_in));
    $entry_time_with_15 = date('H:i:s', $entry_time_with_15);

    $entry_time_with_180 = strtotime("+".$half_day_entry_1." minutes", strtotime($chech_in));
    $entry_time_with_180 = date('H:i:s', $entry_time_with_180);



    $exit_time_with_15 = strtotime("-".$grace_exit." minutes", strtotime($check_out));
    $exit_time_with_15 = date('H:i:s', $exit_time_with_15);

    $exit_time_with_180 = strtotime("-".$half_day_exit_1." minutes", strtotime($check_out));
    $exit_time_with_180 = date('H:i:s', $exit_time_with_180);

    // echo "Present ".date('H:i:s',strtotime($entryTime))."  ".date('H:i:s',strtotime($exitTime))."<br>";



    if(strtotime($chech_in) >= strtotime(date('H:i:s',strtotime($entryTime)))){
        // echo "On Time<br>";
        $entry_status = "On Time";
        $entry_status_class = "success";
    }elseif(strtotime($entry_time_with_15) >= strtotime(date('H:i:s',strtotime($entryTime)))){
        // echo "Late<br>";
        $late_entry++;
        $entry_status = "Late";
        $entry_status_class = "info";
    }elseif(strtotime($entry_time_with_180) >= strtotime(date('H:i:s',strtotime($entryTime)))){
        // echo "Too Late<br>";
        $entry_status = "Too Late";
        $late_and_penalty_entry++;
        $entry_status_class = "pink";
    }else{
        // echo"Half Day<br>";
        $half_day_entry++;
        $entry_status = "Half Day";
        $entry_status_class = "warning";
    }

    if(strtotime($check_out) <= strtotime(date('H:i:s',strtotime($exitTime)))){
        // echo "On Time<br>";
        $exit_status = "On Time";
        $exit_status_class = "success";
    }elseif(strtotime($exit_time_with_15) <= strtotime(date('H:i:s',strtotime($exitTime)))){
        // echo "Early leave<br>";
        $early_exit++;
        $exit_status = "Early leave";
        $exit_status_class = "info";
    }elseif(strtotime($exit_time_with_180) <= strtotime(date('H:i:s',strtotime($exitTime)))){
        // echo "Too Early Leave<br>";
        $early_and_pentaly_exit++;
        $exit_status = "Too Early Leave";
        $exit_status_class = "pink";
    }else{
        // echo"Half Day Leave<br>";
        $half_day_exit++;
        $exit_status = "Half Day Leave";
        $exit_status_class = "warning";
    }
    $gmdate = strtotime($exitTime) - strtotime($entryTime);
    $working_hours = gmdate('H:i:s',$gmdate);

    // echo "Working Hours ".$working_hours;
    // echo "<br>";

}else{
    // echo "Absent<br>";

    $entry_status = "Absent";
    $exit_status = "Absent";
    $entry_status_class = "danger";
    $exit_status_class = "danger";
    $absent ++;
    // echo "<h1>".checkHoilday($value->format('Y-m-d'))['condition']."</h1>";
    if(checkHoilday($value->format('Y-m-d'),$row_no['attendance_no'])['condition']){

        $entry_status = checkHoilday($value->format('Y-m-d'),$row_no['attendance_no'])['title'];
        $exit_status = checkHoilday($value->format('Y-m-d'),$row_no['attendance_no'])['title'];
        $entry_status_class = "inverse";
        $exit_status_class = "inverse";
        $absent --;
        $working_hours_status = "<span class='label label-inverse'>Holiday</span>";
    }
}


if($entry_status=="Absent" && $day=="Sunday"){
    $entry_status = "Weekend";
    $exit_status = "Weekend";
    $entry_status_class = "inverse";
    $exit_status_class = "inverse";
    $working_hours_status = "<span class='label label-inverse'>Weekend</span>";
    $absent--;
}
if(strtotime($working_hours)>=strtotime($work_hour)){
    $working_hours_status = "<span class='label label-success'>Completed</span>";
}
// echo "-----------------------------------------<br>";





}}elseif ($row['type']=="Night") {
foreach ($period as $key => $value) {
    $date =  $value->format('Y-m-d')." 00:00:00";
    $date2 =  $value->format('Y-m-d')." 23:59:59";

    $date0 = strtotime("+1 day", strtotime($value->format('Y-m-d')));
    $date01 = date('Y-m-d', $date0)." 00:00:00";
    $date02 = date('Y-m-d', $date0)." 23:59:59";

// echo $date;
    $day = date('l',strtotime($date));
// echo "<br>---".$daycounter."---<br>";
    $firstid = '';
    $entryTime = '00:00';
    // $secondid = '';
    // $exitTime = '00:00';
    $checkpresent = 0;
    $working_hours = '';
    $working_hours_status = "<span class='label label-danger'>Not Completed</span>";
    $sql01 = 'SELECT `attendance_id`"ID",`time`"Time" FROM `attendance`  where `no` in ('.$row_no['attendance_no'].') and time > "'.$date.'" and time < "'.$date2.'" and status = "Approved" order by `time` DESC limit 1';
    $result01 = mysqli_query(connect_db(),$sql01);
    while($row01 = mysqli_fetch_assoc($result01)){
     // print_r($row01);
     $firstid = $row01['ID'];
     $entryTime = $row01['Time'];

     // echo "<br>";
     $checkpresent = 1;   
 }
 if($firstid==$secondid && strlen($firstid)>0){
    $absent++;

    continue;
 }
 $sql02 = 'SELECT `attendance_id`"ID",`time`"Time" FROM `attendance`  where `no`in ('.$row_no['attendance_no'].') and time > "'.$date01.'" and time < "'.$date02.'" and status = "Approved" order by `time` ASC limit 1';
 $result02 = mysqli_query(connect_db(),$sql02);
 while($row02 = mysqli_fetch_assoc($result02)){
     // print_r($row02);
     $secondid = $row02['ID'];
     $exitTime = $row02['Time'];
     // echo "<br>";
     $checkpresent = 1;   
 }
 if($firstid==$secondid && strlen($firstid)>0){
    // echo "Present But Single Punch<br>";
    $not_punch++;
    $entry_status = "Single Punch";
    $exit_status = "Single Punch";
    $entry_status_class = "primary";
    $exit_status_class = "primary";
}
elseif($checkpresent){
    $entry_time_with_15 = strtotime("+".$grace_entry." minutes", strtotime($chech_in));
    $entry_time_with_15 = date('H:i:s', $entry_time_with_15);

    $entry_time_with_180 = strtotime("+".$half_day_entry_1." minutes", strtotime($chech_in));
    $entry_time_with_180 = date('H:i:s', $entry_time_with_180);



    $exit_time_with_15 = strtotime("-".$grace_exit." minutes", strtotime($check_out));
    $exit_time_with_15 = date('H:i:s', $exit_time_with_15);

    $exit_time_with_180 = strtotime("-".$half_day_exit_1." minutes", strtotime($check_out));
    $exit_time_with_180 = date('H:i:s', $exit_time_with_180);

    // echo "Present ".date('H:i:s',strtotime($entryTime))."  ".date('H:i:s',strtotime($exitTime))."<br>";

    

    if(strtotime($chech_in) >= strtotime(date('H:i:s',strtotime($entryTime)))){
        // echo "On Time<br>";
        $entry_status = "On Time";
        $entry_status_class = "success";
    }elseif(strtotime($entry_time_with_15) >= strtotime(date('H:i:s',strtotime($entryTime)))){
        // echo "Late<br>";
        $late_entry++;
        $entry_status = "Late";
        $entry_status_class = "info";
    }elseif(strtotime($entry_time_with_180) >= strtotime(date('H:i:s',strtotime($entryTime)))){
        // echo "Too Late<br>";
        $entry_status = "Too Late";
        $late_and_penalty_entry++;
        $entry_status_class = "pink";
    }else{
        // echo"Half Day<br>";
        $half_day_entry++;
        $entry_status = "Half Day";
        $entry_status_class = "warning";
    }

    if(strtotime($check_out) <= strtotime(date('H:i:s',strtotime($exitTime)))){
        // echo "On Time<br>";
        $exit_status = "On Time";
        $exit_status_class = "success";
    }elseif(strtotime($exit_time_with_15) <= strtotime(date('H:i:s',strtotime($exitTime)))){
        // echo "Early leave<br>";
        $early_exit++;
        $exit_status = "Early leave";
        $exit_status_class = "info";
    }elseif(strtotime($exit_time_with_180) <= strtotime(date('H:i:s',strtotime($exitTime)))){
        // echo "Too Early Leave<br>";
        $early_and_pentaly_exit++;
        $exit_status = "Too Early Leave";
        $exit_status_class = "pink";
    }else{
        // echo"Half Day Leave<br>";
        $half_day_exit++;
        $exit_status = "Half Day Leave";
        $exit_status_class = "warning";
    }
    $gmdate = strtotime($exitTime) - strtotime($entryTime);
    $working_hours = gmdate('H:i:s',$gmdate);

    // echo "Working Hours ".$working_hours;
    // echo "<br>";

}else{
    // echo "Absent<br>";

    $entry_status = "Absent";
    $exit_status = "Absent";
    $entry_status_class = "danger";
    $exit_status_class = "danger";
    $absent ++;
    // echo "<h1>".checkHoilday($value->format('Y-m-d'),$row_no['attendance_no'])['condition']."</h1>";
    if(checkHoilday($value->format('Y-m-d'),$row_no['attendance_no'])['condition']){

        $entry_status = checkHoilday($value->format('Y-m-d'),$row_no['attendance_no'])['title'];
        $exit_status = checkHoilday($value->format('Y-m-d'),$row_no['attendance_no'])['title'];
        $entry_status_class = "inverse";
        $exit_status_class = "inverse";
        $absent --;
        $working_hours_status = "<span class='label label-inverse'>Holiday</span>";
    }
}


if($entry_status=="Absent" && $day=="Sunday"){
    $entry_status = "Weekend";
    $exit_status = "Weekend";
    $entry_status_class = "inverse";
    $exit_status_class = "inverse";
    $working_hours_status = "<span class='label label-inverse'>Weekend</span>";
    $absent--;
}
if(strtotime($working_hours)>=strtotime($work_hour)){
    $working_hours_status = "<span class='label label-success'>Completed</span>";
}
// echo "-----------------------------------------<br>";





}
}
                                      echo "<tr>
                                      <td><a href='company-attendance.php?id_no=".$row_no['attendance_no']."&name=".$row_no['name']."&form=".$form."&to=".$to."&value=value&year=".date('Y',strtotime($form))."&month=".date('F',strtotime($form))."'>".$row_no['attendance_no']."</a></td>
                                      <td><a href='company-attendance.php?id_no=".$row_no['attendance_no']."&name=".$row_no['name']."&form=".$form."&to=".$to."&value=value&year=".date('Y',strtotime($form))."&month=".date('F',strtotime($form))."'>".$row_no['name']."</a></td>

                                            <td>".$late_entry."</td>
                                            <td>".$late_and_penalty_entry."</td>
                                            <td>".$half_day_entry."</td>
                                            <td>".$early_exit."</td>
                                            <td>".$early_and_pentaly_exit."</td>
                                            <td>".$half_day_exit."</td>
                                            <td>".$not_punch."</td>
                                            <td>".$absent."</td>
                                            </tr>";
                                    }

?>
</table>
<?php   
?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>   
<?php }?>   
<!-- Form -->
<?php if (isset($_GET['insert'])) { ?>
    <div class="content-page">
        <div class="">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-5" style="text-align: center; font-size: 22px; padding: 10px"> Employee Entery Form </h4>
                            <br>
                            <form action="company-attendance.php" method="post">


                                <?php 
                                dropDownConditionalUnsumit("Employee","no","no","name","attendance","GROUP BY no"); 
                                ?>

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
            </div>
        </div>
        </div> <?php } ?>
        <?php include_once('footer.php'); ?>

    </div>
    <!-- END wrapper -->

                   
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