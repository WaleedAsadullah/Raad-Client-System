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



if(isset($_REQUEST['submit'])){

    // for ($i=1; $i<$_REQUEST['no_of_rows'];$i++){
      // echo "<script>
      //         alert('".$_REQUEST['no_of_rows']."')
      //       </script>";

        if(isset($_FILES['nic'])){
            $target_dir = "uploads/".rand(10,1000000)."_";
            $target_file = $target_dir. basename($_FILES["nic"]["name"]);

            $target_file = str_replace(" ","",$target_file);

            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
        if(isset($_REQUEST["submit"])) {
          $check = getimagesize($_FILES["nic"]["tmp_name"]);
          if($check !== false) {
            // echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
          } else {
            // echo "File is not an image.";
            $uploadOk = 0;
          }
        }

// Check if file already exists
        if (file_exists($target_file)) {
            // echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["nic"]["size"] > 20000000) {
          // echo "Sorry, your file is too large.";
          $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
          // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
          $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
          // echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
          if (move_uploaded_file($_FILES["nic"]["tmp_name"], $target_file)) {
            // echo "The file ". basename( $_FILES["nic"]["name"]). " has been uploaded.";
            $uploadedok = true;
          } else {
             $uploadedok = false;
            // echo "Sorry, there was an error uploading your file.";
          }
        }
        $nic = $target_file ;
        }


        if(isset($_FILES['picture'])){
            $target_dir = "uploads/".rand(10,1000000)."_";
            $target_file = $target_dir. basename($_FILES["picture"]["name"]);

            // $target_file = trim(basename(stripslashes($target_file)), ".\x00..\x20");
            $target_file = str_replace(" ","",$target_file);

            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            if(isset($_REQUEST["submit"])) {
              $check = getimagesize($_FILES["picture"]["tmp_name"]);
              if($check !== false) {
                // echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
              } else {
                // echo "File is not an image.";
                $uploadOk = 0;
              }
            }

            // Check if file already exists
            if (file_exists($target_file)) {
              // echo "Sorry, file already exists.";
              $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["picture"]["size"] > 20000000) {
              // echo "Sorry, your file is too large.";
              $uploadOk = 0;
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
              // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
              $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
              // echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
              if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
                // echo "The file ". basename( $_FILES["picture"]["name"]). " has been uploaded.";
                $uploadedok = true;
              } else {
                 $uploadedok = false;
                // echo "Sorry, there was an error uploading your file.";
              }
            }
            $Picture = $target_file ;
            }

            $sql = 'INSERT INTO `customer_employee_data`(`customer_employee_id`, `user_id`, `user_date`, `owner_id`, `name`, `phone`, `email`, `address`, `nic`, `picture`, `comments`,`salary`) VALUES (NULL,\'';
            $sql .= get_curr_user();
            $sql .= '\', CURRENT_TIMESTAMP, \''.get_curr_user().'\', \''.$_REQUEST['name'].'\', \''.$_REQUEST['phone'].'\', \''.$_REQUEST['email'].'\', \''.$_REQUEST['address'].'\', \''.$nic.'\', \''.$Picture.'\', \''.$_REQUEST['comments'].'\', \''.$_REQUEST['salary'].'\')';

            insert_query($sql);
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
        <!-- form Uploads -->
        <link href="assets/plugins/fileuploads/css/dropify.min.css" rel="stylesheet" type="text/css" />

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
                    <div class="col-sm-12">
                        <div class="card-box">
                            <div class="m-t-5 m-b-5" style="text-align: center" >
                                 <a  href="my-employees.php?insert=insert" > <button type="button" class="btn btn-primary btn w-md waves-effect waves-light"  >+ Add Employee</button></a>
                                 <a  href="my-employees.php" > <button type="button" class="btn btn-primary btn w-md waves-effect waves-light"  >View Employee</button></a>
                            </div>
                        </div>
                    </div>
                
                    <?php if (!isset($_GET['specific']) && !isset($_GET['insert'])) {
                     ?>
                    <div class="col-sm-12">
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-30">Employee Details</h4>
                            <div class="table-responsive">
                                <table class="table" style="white-space:nowrap;" id="myTable">
                                    <?php
                                    $sql = 'SELECT `customer_employee_id`"Employees ID", `name`"Name", `phone`"Phone", `email`"E-mail", `address`"Address", `comments`"Comments" FROM `customer_employee_data` WHERE owner_id = '.$_SESSION['id'];
                                    display_query2($sql);
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div><!-- end col -->
                <?php } ?>
                    <?php 
                    if (isset($_GET['specific'])) { 
                    $sql_employee = 'SELECT `customer_employee_id`, `user_id`, `user_date`, `owner_id`, `name`"Name", `phone`, `email`, `address`, `nic`, `picture`, `comments`,`salary`"Salary" FROM `customer_employee_data` WHERE `customer_employee_id` = '.$_GET['specific'].'';
                    $result_employee = mysqli_query(connect_db(),$sql_employee);
                    $row_employee = mysqli_fetch_assoc($result_employee);
                            ?>
                            <div class="col-lg-12">
                              <div class="card-box task-detail">
                                    <div class="media m-b-20 m-t-0">
                                        <div class="media-body">
                                            <h1 class="label-inverse" style="text-align: center; padding:0.25em; border-radius:0.75em; color: White"><?php
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
                            <?php if (isset($_GET['insert']) || isset($_GET['editid'])) {?>
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <h4 class="header-title m-t-0 m-b-5" style="text-align: center; font-size: 22px; padding: 10px"> Add Employee</h4>
                                    <form action="my-employees.php" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="">Name</label>
                                            <input type="text" name="name" required="" placeholder="Enter name" class="form-control" value="<?php if(isset($_REQUEST['name'])) echo $_REQUEST['name']?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Phone</label>
                                            <input type="number" name="phone" required="" placeholder="Enter Phone " class="form-control" value="<?php if(isset($_REQUEST['phone'])) echo $_REQUEST['phone']?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="email" name="email" placeholder="Enter E-mail" class="form-control" value="<?php if(isset($_REQUEST['email'])) echo $_REQUEST['email']?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Address</label>
                                            <input type="text" name="address"  placeholder="Enter Address" class="form-control" value="<?php if(isset($_REQUEST['address'])) echo $_REQUEST['address']?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Salary</label>
                                            <input type="text" name="salary"  placeholder="Enter salary" class="form-control" value="<?php if(isset($_REQUEST['salary'])) echo $_REQUEST['salary']?>">
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div style="align-content: center;">
                                                    <h4 class="header-title m-t-0 m-b-10">CNIC</h4>
                                                    <?php if(isset($_REQUEST['nic'])){
                                                      echo'<img width="100px" class="editimg" src="'.$_REQUEST['nic'].'">';
                                                    } ?>
                                                    <input id="nic" name="nic" type="file" class="dropify" data-max-file-size="10M" <?php if (!isset($_REQUEST['editid'])) {
                                                      echo "required";
                                                    } ?> />
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div style="align-content: center;">
                                                    <h4 class="header-title m-t-0 m-b-10">Picture (must be in sqaure dimension)</h4>
                                                    <?php if(isset($_REQUEST['picture'])){
                                                      echo'<img width="100px" class="editimg" src="'.$_REQUEST['picture'].'">';
                                                    } ?>
                                                    <input id="profile_picture" name="picture" type="file" class="dropify" data-max-file-size="10M" <?php if (!isset($_REQUEST['editid'])) {
                                                      echo "required";
                                                    } ?> />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Comment</label>
                                            <textarea class="form-control" name="comments" placeholder="Enter Comments..."><?php if(isset($_REQUEST['comments'])) echo $_REQUEST['comments']?></textarea>
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
                          <?php }?>


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
                             <!-- file uploads js -->
        <script src="assets/plugins/fileuploads/js/dropify.min.js"></script>

        <script type="text/javascript">
            $('.dropify').dropify({
                messages: {
                    'default': 'Drag and drop a file here or click',
                    'replace': 'Drag and drop or click to replace',
                    'remove': 'Remove',
                    'error': 'Ooops, something wrong appended.'
                },
                error: {
                    'fileSize': 'The file size is too big (1M max).'
                }
            });
        </script>

    </body>
</html>