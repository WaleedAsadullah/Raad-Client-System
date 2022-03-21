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
                        <!-- <h4 class="page-title">Service Request</h4> -->
                    </div>
                </div>
                
                <div class="row">
                    <?php if (isset($_SESSION['id'])) { 
                              $sql = 'SELECT `owner_id`"Owner ID", `user_name` "Entry By", a.`user_date`"Entry Time", `office_name`"Raad Center", `room_name`"Room", `seats`"Seats", `company_name`"Company Name", a.`owner_name`"Owner Name", a.`phone`"Phone", a.`email`"E-mail", a.`address`"Address", `user`.`user_name`"Assign By", `start_date_of_rent`"Start Rent", `end_date_of_rent`"End Rent", `sign_date`"Signature Date", `rent_amount`"Rent Amount", `additional_service_name1`"Additional Service(1)", `additional_service_amount1`"This Amount(1)", `additional_service_name2`"Additional Service(2)", `additional_service_amount2`"This Amount(2)", a.`comment`"Comment",`cnic_scan`, `bill_can`, `agreement_scan`, `undertaking_scan`,`deposit`,`total` FROM `company_with_raad`a,`user`,`raad_offices`,`room_center` where `raad_offices`.`office_id` = a.`raad_office_id` and a.`room_id` = `room_center`.`room_id` and `user`.`user_id` = a.`staff_assign_id` and `owner_id`= '.$_SESSION['id'].' order by `owner_id` DESC';
                              // echo $sql;
                              $result = mysqli_query(connect_db(),$sql);
                              $row = mysqli_fetch_assoc($result);
                              
                              ?>

                            <div class="col-lg-12">
                              <div class="card-box task-detail">
                                    <div class="media m-b-20 m-t-0">
                                        <div class="media-body">                                            
                                            <h1 class="label-inverse" style="text-align: center; padding:0.25em; border-radius:0.75em; color:white"><?php echo $row['Company Name'] ?></h1>
                                        </div>
                                    <ul class="list-inline task-dates m-b-0 m-t-20">
                                      <li>
                                            <h5 class="font-600 m-b-5">Owner Name</h5>
                                            <p> <?php
                                            echo ($row['Owner Name']);
                                             ?></p>
                                        </li>
                                        <li>
                                            <h5 class="font-600 m-b-5">Start Agreement Date</h5>
                                            <p> <?php
                                            $date=date_create($row['Start Rent']);
                                            echo date_format($date,"d F Y"); ?></p>
                                        </li>

                                        <li>
                                            <h5 class="font-600 m-b-5">Center Name</h5>
                                            <p> <?php
                                            echo ($row['Raad Center']);?></p>
                                        </li>

                                        <li>
                                            <h5 class="font-600 m-b-5">Room Name</h5>
                                            <p> <?php
                                            echo ($row['Room']); ?></p>
                                        </li>
                                        <li>
                                            <h5 class="font-600 m-b-5">No. of Seats</h5>
                                            <p> <?php
                                            echo ($row['Seats']);?></p>
                                        </li>

                                        <li>
                                            <h5 class="font-700 m-b-5" style="color: white">asda</h5>
                                            <p style="color: white">sdf</p>
                                        </li>
                                     </ul>
                                    <div class="clearfix"></div>

                                </div>
                                
                            </div>
                          </div>
                            <?php } ?>
                </div>
                
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