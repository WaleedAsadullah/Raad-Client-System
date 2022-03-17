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
                    <th>S.No</th>';
$row_data = array_keys($row);
$id_column = "";
for($j=0;$j<count($row_data);$j++){

  if($j==0) $id_column = $row_data[$j];

    echo  "<th>".$row_data[$j]."</th>"; }
                                                   
    echo   '</tr>
         </thead>
      <tbody>';



    }
  $i++; 
      echo '<tr>
              <td>'.$i.'</td>';
for($k=0;$k<count($row_data);$k++){ 
    if ($row_data[$k] == "Name") {
        echo '<td><a href="my-employees.php?specific='.$row[$row_data[0]].'">'.$row[$row_data[$k]].'<a></td>';

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




?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <link rel="shortcut icon" href="assets/images/favicon.png">

        <title>My Employees</title>

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
                <br>
                <div class="row">
                    <?php if (!isset($_GET['specific'])) {
                     ?>
                    <div class="col-sm-12">
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-30">Wifi Details</h4>
                            <div class="table-responsive">
                                <table class="table" style="white-space:nowrap;" id="myTable">
                                    <?php
                                    $sql = 'SELECT `customer_employee_id`"Employees ID", `name`"Name", `phone`"Phone", `email`"E-mail", `address`"Address", `comments`"Comments" FROM `customer_employee_data`';
                                    display_query2($sql);
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div><!-- end col -->
                <?php } ?>
                    <?php if (isset($_GET['specific'])) { 
                              $sql_employee = 'SELECT `customer_employee_id`, `user_id`, `user_date`, `owner_id`, `name`"Name", `phone`, `email`, `address`, `nic`, `picture`, `comments`,`salary`"Salary" FROM `customer_employee_data` WHERE `customer_employee_id` = '.$_GET['specific'].'';
                              // echo $sql_employee;
                              $result_employee = mysqli_query(connect_db(),$sql_employee);
                              $row_employee = mysqli_fetch_assoc($result_employee);

                              
                              ?>

                            <div class="col-lg-12">
                              <div class="card-box task-detail">
                                    <div class="media m-b-20 m-t-0">
                                        <!-- <div class="media-left">
                                            <a href="#"> <img class="media-object img-circle" alt="64x64" src="assets/images/users/avatar-2.jpg" style="width: 48px; height: 48px;"> </a>
                                        </div> -->
                                        <div class="media-body">

                                            
                                            <h1 class="label-inverse" style="text-align: center; padding:0.25em; border-radius:0.75em; color: White"><?php
                                             // print_r($row_employee); 
                                            echo $row_employee['Name']; ?></h1>
                                    </div>

                                    <ul class="list-inline task-dates m-b-0 m-t-20">
                                      <li>
                                            <h5 class="font-600 m-b-5">Contact Details</h5>
                                            <p class="m-b-0"> <?php
                                            echo ("Phone : ".$row_employee['phone']); ?></p>
                                            <p class="m-b-0"> <?php
                                            echo ("E-mail : ".$row_employee['email']); ?></p>
                                            <p class="m-b-0"> <?php
                                            echo ("Address : ".$row_employee['address']); ?></p>
                                            <p class="m-b-0"> <?php
                                            echo ("Salary : ".$row_employee['Salary']); ?></p>
                                        </li>
                                        <li>
                                            <h5 class="font-700 m-b-5" style="color: white">asda</h5>
                                            <p style="color: white">sdf</p>
                                        </li>
                                     </ul>
                                    <div class="clearfix"></div>

                                    <div class="attached-files m-t-30">
                                        <h5 class="font-600">Attached Files </h5>
                                        <div style="display: flex;">
                                            <div class="file-box">
                                                <a href="<?php echo $row_employee['nic'] ?>"><img width="25%" src="<?php echo $row_employee['nic'] ?>" class="img-responsive img-thumbnail" alt="attached-img"></a>
                                                <p class="font-13 m-b-5 text-muted"><small>Cnic</small></p>
                                            </div>
                                            <div class="file-box">
                                                <a href="<?php echo $row_employee['picture'] ?>"><img width="25%" src="<?php echo $row_employee['picture'] ?>" class="img-responsive img-thumbnail" alt="attached-img"></a>
                                                <p class="font-13 m-b-5 text-muted"><small>Picture</small></p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                
                            </div>
                          </div>
                            <?php } ?>
                </div>


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