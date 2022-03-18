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

            }elseif($row_data[$k] == "Date"){
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

    <title>My Item Usage</title>

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
                    <div class="col-lg-12" >
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-5" style="text-align: center; font-size: 22px; padding: 10px">Select Date</h4>
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
                <?php
                if(isset($_REQUEST['value'])){
                    $form = date("Y-m-d", strtotime("first day of ".$_REQUEST['month']." ".$_REQUEST['year'].""));
                    $to = date("Y-m-d", strtotime("last day of ".$_REQUEST['month']." ".$_REQUEST['year'].""));
                }else{
                    $form = date("Y-m-d", strtotime("first day of this month"));
                    $to = date("Y-m-d");
                }

                ?>
                <div class="col-lg-12">
                    <div class="card-box">
                        <h4 class="header-title m-t-0 m-b-5" style="text-align: center; font-size: 22px; padding: 10px"> My Item Usage </h4>
                        <br>

                        <div class="table-responsive">
                            <table id="myTable" class="tablesaw table m-b-0 tablesaw-columntoggle table-bordered " style="white-space:nowrap;">
                                <?php
                                



                                // echo $form;
                                // echo "<br>";
                                // echo $to;


                                $sql2 = 'SELECT `date`"Date" ,`type`"Cash/Credit", `title`"Title",`cup_of_tea`"Cup of tea" ,`description`"Description", `amount`"Amount",sum(amount)"total",`date`"Date" FROM `rd_petty_cash`a,`raad_offices`b,user WHERE a.`raad_office_id` = b.office_id and a.user_id = user.user_id and  category = "Company with Raad" and expense_for = '.$_SESSION['id'].' and date >=  "'.$form.'" and date <=  "'.$to.'" order by `date` DESC ';

                                $sql = 'SELECT `date`"Date" ,`type`"Cash/Credit", `title`"Title",`cup_of_tea`"Cup of tea" ,`description`"Description", `amount`"Amount",`date`"Date" FROM `rd_petty_cash`a,`raad_offices`b,user WHERE a.`raad_office_id` = b.office_id and a.user_id = user.user_id and  category = "Company with Raad" and expense_for = '.$_SESSION['id'].' and date >=  "'.$form.'" and date <=  "'.$to.'" order by `date` ';
                                // echo $sql;
                                display_query2($sql);
                                // -----------------------

                                ?>
                                <tfoot>
                                    <tr>
                                        <th colspan="6" >Total</th>
                                        <th><?php echo mysqli_fetch_assoc(mysqli_query(connect_db(),$sql2))['total']; ?></th>
                                    </tr>
                                </tfoot>
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