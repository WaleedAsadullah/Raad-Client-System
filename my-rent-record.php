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
                    <th></th>';
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
              <td>'.$i.'</td>
              <td style="text-align:center;"><a style="color:rgb(120,108,150);" href="rent-invoice.php?slip='.$row[$id_column].'" ><i  class="zmdi zmdi-local-printshop"></i></a></td>';
for($k=0;$k<count($row_data);$k++){ 
    if ($row_data[$k] == "Name") {
        echo '<td><a href="my-employees.php?specific='.$row[$row_data[0]].'">'.$row[$row_data[$k]].'<a></td>';

    }elseif ($row_data[$k] == "Date of Receiving") {
        echo  '<td>'.date('d-M-Y',strtotime($row[$row_data[$k]])).'</td>';

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

        <title>My Rent Record</title>

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
                <div class="col-lg-12">
                    <div class="card-box">
                        <h4 class="header-title m-t-0 m-b-5" style="text-align: center; font-size: 22px; padding: 10px"> Rent Details </h4>
                        <br>

                        <div class="table-responsive">
                            <table id="myTable" class="tablesaw table m-b-0 tablesaw-columntoggle table-bordered " style="white-space:nowrap;">
                                <?php
                                

                                $sql = 'SELECT `rent_detai_id`"Slip No.", user.user_name"Recived By", `month`"Month", `year`"Year" , `receiving_date`"Date of Receiving" , `amount`"Amount",`type`"Type",`cheque_number`"Cheque Number",`bank`"Bank" FROM `rent_detail`a,company_with_raad, user WHERE a.user_id = user.user_id and a.company_with_raad = company_with_raad.owner_id and a.company_with_raad = '.$_SESSION['id'].' ORDER BY rent_detai_id desc';
                                // echo $sql;
                                display_query2($sql);
                                // -----------------------

                                ?>
                            </table>
                        </div>
                    </div>
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