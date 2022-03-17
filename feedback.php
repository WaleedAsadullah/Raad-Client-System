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
      <tbody><tr><td></td><td></td>';

$col_counter = 2;
       for($si=$col_counter;$si<count($row_data)+2;$si++){
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
$sql = 'INSERT INTO `rd_feedback`(`feedback_id`, `user_id`, `user_date`, `feedback`, `feedback_for`, `feedback_by`) VALUES (NULL,\'';
$sql .= get_curr_user();
$sql .= '\', CURRENT_TIMESTAMP,\''.$_REQUEST['feedback'].'\' ,"raad","company_with_raad")';
// echo $sql;
insert_query($sql);
}

// ------------------------

///edit code
// check_edit("rd_feedback","feedback_id");
// edit_display("rd_feedback","feedback_id");
//end of edit code -shift view below delete

// ------------------------
if(isset($_REQUEST['deleteid']) && is_numeric($_REQUEST['deleteid'])){ $sql = 'DELETE FROM `rd_feedback` WHERE `rd_feedback`.`feedback_id` = '.$_REQUEST['deleteid'];

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

        <title>Feedback</title>

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
                        <h4 class="page-title">Feedback</h4>
                    </div>
                </div>
                
                <!-- <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
                            <div class="m-t-5 m-b-5" style="text-align: center" >
                                 <a  href="feedback.php?insert=insert" > <button type="button" class="btn btn-primary btn w-md waves-effect waves-light"  >+ Give Feedback</button></a>
                                 <a  href="feedback.php" > <button type="button" class="btn btn-primary btn w-md waves-effect waves-light"  >View Feedback</button></a>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-30">Feedbacks</h4>
                            <div class="table-responsive">
                                <table class="table" style="white-space:nowrap;" id="myTable">
                                    <?php
                                    $sql = 'SELECT `feedback_id` , `user_date`, `feedback` FROM `rd_feedback`';
                                    display_query2($sql);
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- end row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="">
                            <!-- <h4 class="header-title m-t-0 m-b-30">Give feedback</h4> -->
                            <form action="feedback.php" method="post" class="card-box">
                                <span class="input-icon icon-right">
                                <textarea name="feedback" rows="2" class="form-control" placeholder="Post a new feedback"></textarea>
                                </span>

                                <div class="p-t-10 pull-right">
                                    <button type="submit" name="submit" class="btn btn-sm btn-primary waves-effect waves-light">
                                        Post
                                    </button>
                                </div>
                                <ul class="nav nav-pills profile-pills m-t-10">
                                    <!--  -->
                                </ul>

                            </form>
                            <?php
                            $sql = 'SELECT `feedback_id`, `company_name`, a.`user_date`"time", `feedback`, `feedback_for`, `feedback_by` FROM `rd_feedback`a,`company_with_raad`b WHERE a.user_id = b.owner_id order by `feedback_id` desc';
                            $result = mysqli_query(connect_db(),$sql);
                            if(mysqli_num_rows($result) > 0){
                                echo '<div class="card-box">';
                                while($row = mysqli_fetch_assoc($result)){
                                    // print_r($row);
                                    date_default_timezone_set("Asia/Karachi");
                                    $start_date = new DateTime($row['time']);
                                    $now = date('Y-m-d H:i:s');
                                    $since_start = $start_date->diff(new DateTime($now));
                                    // echo $since_start->days.' days total<br>';
                                    $timearray = [];

                                    $since_starty = $since_start->y;
                                    $since_startm = $since_start->m;
                                    $since_startd = $since_start->d;
                                    $since_starth = $since_start->h;
                                    $since_starti = $since_start->i;
                                    $since_starts = $since_start->s;
                                    array_push($timearray, $since_starty, $since_startm, $since_startd, $since_starth, $since_starti, $since_starts);
                                    $timearray = array_reverse($timearray);
                                     // echo "<pre>"; print_r($timearray); echo"</pre>";

                                     // echo preg_replace('/[^0-9]/', '', $since_starty);

                                    // echo $since_starty.' years<br>';
                                    // echo $since_startm.' months<br>';
                                    // echo $since_startd.' days<br>';
                                    // echo $since_starth.' hours<br>';
                                    // echo $since_starti.' minutes<br>';
                                    // echo $since_starts.' seconds<br>';
                                     $wording = [' seconds',' minutes',' hours',' days',' months',' years'];

                                     for ($i=0; $i <sizeof($timearray) ; $i++) { 
                                         if($timearray[$i] != 0){
                                            $timeperoid =  $timearray[$i].$wording[$i];
                                         }
                                     }
                                     if(!isset($timeperoid)){
                                        $timeperoid = '0 second';
                                     }

                                    echo '
                                        <div class="comment">
                                            <div class="">
                                                <div class="comment-text">
                                                    <div class="comment-header">
                                                        <a href="#" title="">'.$row['company_name'].'</a><span>'.$timeperoid.'</span>
                                                    </div>'.$row['feedback'].'
                                                </div>
                                                <div class="comment-footer">
                                                    <a><i class="fa fa-thumbs-o-up"></i></a>
                                                    <a ><i class="fa fa-thumbs-o-down"></i></a>
                                                </div>
                                            </div>
                                        </div>';
                                }
                                echo '</div>';
                            }

                            
                        ?>
                    </div>
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