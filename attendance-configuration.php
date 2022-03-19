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
            ';
            $row_data = array_keys($row);
            $id_column = "";
            for($j=0;$j<count($row_data);$j++){

              if($j==0) $id_column = $row_data[$j];

              echo  "<th>".$row_data[$j]."</th>"; }

              echo   '</tr>
              </thead>
              <tbody><tr><td></td>';

              $col_counter = 1;
              for($si=$col_counter;$si<count($row_data)+1;$si++){
                  echo '
                  <th style="font-weight: normal">
                  <input class="form-control" type="text" style="width:100%" id="myInput'.$col_counter.'" onkeyup="myFunction('.$col_counter.')" placeholder="Search..." title="Type in a word">
                  </th>';
                  $col_counter++;
              }
              echo"</tr>";



          }
          $i++;  
          echo '<tr>
          <td>'.$i.'</td>';
              // echo'
              // <td style="text-align:center;"><a style="color:rgb(16,196,105);" href="'.$_SERVER['PHP_SELF'].'?editid='.$row[$id_column].'"><i class="zmdi zmdi-edit"></i></a></td>

              // <td style="text-align:center;"><a style="color:rgb(255,87,90);" href="'.$_SERVER['PHP_SELF'].'?deleteid='.str_replace(" ","___",$row[$id_column]).'"><i class="fa fa-trash-o" onclick="return confirm(\'Are you sure?\')"></i></a></td>';
          for($k=0;$k<count($row_data);$k++){ 
            if ($row_data[$k] == "Status") {

                if($row[$row_data[$k]]=="Solved"){
                    echo '<td><span class="label label-success">'.$row[$row_data[$k]].'<span></td>';
                }else{
                    echo '<td><span class="label label-danger">'.$row[$row_data[$k]].'<span></td>';
                }
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
if(isset($_REQUEST['deleteid']) && is_numeric($_REQUEST['deleteid'])){ $sql = 'DELETE FROM `rd_services_request` WHERE status = "Pending"  and  `rd_services_request`.`request_id` = '.$_REQUEST['deleteid'];

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
                <div class="container" >

                    <!-- Page-Title -->
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="page-title">Attendance Configuration</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box">
                                <div class="m-t-5 m-b-5" style="text-align: center" >


                                   <a  href="attendance-configuration.php?insert=insert" > <button type="button" class="btn btn-primary btn w-md waves-effect waves-light"  >+ Add Attendance Configuration</button></a>
                                   <a  href="attendance-configuration.php" > <button type="button" class="btn btn-primary btn w-md waves-effect waves-light"  >View Attendance Configuration</button></a>
                               </div>
                           </div>
                       </div>
                   </div>
                   <?php if (!isset($_GET['insert']) && !isset($_GET['editid'])) { ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box">
                                <h4 class="header-title m-t-0 m-b-30">Attendance Configuration</h4>
                                <div class="table-responsive">
                                    <table class="table" style="white-space:nowrap;" id="myTable">
                                        <?php

                                        $sql = 'SELECT `request_id`"Request No.", `user_date`"Date of Apply", `title`"Title", `description`"Description" FROM `rd_services_request`  ';
                                        $sql = 'SELECT `confi_id`"ID", `attendance_no`"Name", `type`"Type", `work_type`"Work Type", `entry_time`"Enter Time", `exit_time`"Exit Time", `work_hour`"Working Hours", `user_name`"Entry By", `user_attendance_configuration`.`user_date`"Entry Time" FROM `user_attendance_configuration`,`user` where `user_attendance_configuration`.`user_id` =`user`.`user_id` and attendance_no in ('.employeOfCompany().') order by confi_id desc';
                                    // echo $sql;
                                        display_query2($sql);
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div><!-- end col -->
                    </div>
                <?php } ?>
                <!-- end row -->
                <?php if (isset($_GET['insert']) || isset($_GET['editid'])) { ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box">
                                <h4 class="header-title m-t-0 m-b-30">Apply request</h4>
                                <form action="attendance-configuration.php" method="post" enctype="multipart/form-data" class="form" >


                                    <?php 
                                            // dropDownConditionalUnsumit("Name","attendance_no","no","name","attendance","GROUP BY `no`");
                                    ?>

                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <select class="form-control select2" name="attendance_no">
                                            <?php dropDownOption("no","name","attendance"," WHERE no in (".employeOfCompany().") GROUP BY `no`"); ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Duty</label>
                                        <select required="" class="form-control select2"  name="type">
                                          <option value="">-Select</option>
                                          <option value="Day">Day</option>
                                          <option value="Night">Night</option>
                                      </select>
                                  </div>

                                  <div class="form-group">
                                    <label for="">Category</label>
                                    <select name="work_type" required="" class="form-control select2"  >
                                      <option value="">-Select</option>
                                      <option value="Timing Base">Timing Base</option>
                                      <option value="Working Hours">Working Hours</option>
                                      <option value="Remote Days">Remote Days</option>
                                  </select>
                              </div>

                              <div class="form-group">
                                <label for="">Entry Time</label>
                                <input type="time" name="entry_time" class="form-control" value="<?php if(isset($_REQUEST['entry_time'])) echo $_REQUEST['entry_time']?>" id="entry_time">
                            </div>

                            <div class="form-group">
                                <label for="">Exit Time</label>
                                <input type="time" name="exit_time" class="form-control" value="<?php if(isset($_REQUEST['exit_time'])) echo $_REQUEST['exit_time']?>" id="exit_time">
                            </div>

                            <div class="form-group">
                                <label for="">Working Hour</label>
                                <input type="text" name="work_hour" class="form-control" required="" pattern="[0-2]{1}[0-9]{1}[:]{1}[0-5]{1}[0-9]{1}"  placeholder="08:30">
                            </div>     

                            <div class="form-group">
                                <label for="">Salary</label>
                                <input type="number" name="salary" class="form-control" value="<?php if(isset($_REQUEST['salary'])) echo $_REQUEST['salary']?>" >
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
                </div><!-- end col-->
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