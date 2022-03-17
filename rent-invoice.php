<?php
include_once('session.php');
include_once('functions.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <link rel="shortcut icon" href="assets/images/favicon.png">

        <title>Rent Invoive</title>

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
         $sql = 'SELECT `rent_detai_id`"Slip No.", user.user_name"Recived By", `month`"Month", `year`"Year" , `receiving_date`"Date of Receiving" , `amount`"Amount",`type`"Type",`cheque_number`"Cheque Number",`bank`"Bank", a.`comment`"Comments" FROM `rent_detail`a,company_with_raad, user WHERE a.user_id = user.user_id and a.company_with_raad = company_with_raad.owner_id and rent_detai_id = '.$_GET['slip'].'';
        $result = mysqli_query(connect_db(),$sql);
        $row = mysqli_fetch_assoc($result);
        ?>

        <div class="wrapper">
            <div class="container">

                <!-- Page-Title -->
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <!-- <div class="panel-heading">
                                <h4>Invoice</h4>
                            </div> -->
                            <div class="panel-body">
                                <div class="clearfix">
                                    <div class="pull-left">
                                        <h3 class="logo invoice-logo">Raad</h3>
                                    </div>
                                    <div class="pull-right">
                                        <h4>Invoice # 
                                            <strong><?php echo $row['Slip No.'] ?></strong>
                                        </h4>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="pull-left m-t-30">
                                            <address>
                                              <strong>Raad CSO.</strong><br>
                                              Al-syed Arcade<br>
                                              Gulshan-e-Iqbal, Block 5, Karachi<br>
                                              <abbr title="Phone">Ph:</abbr> 0336-7223276
                                              </address>
                                        </div>
                                        <div class="pull-right m-t-30">
                                            <p><strong>Date of Paid: </strong> <?php echo date('d-F-Y',strtotime($row['Date of Receiving'])); ?></p>
                                           <!--  <p class="m-t-10"><strong>Status: </strong> <span class="label label-pink">Pending</span></p> -->
                                            <p class="m-t-10"><strong>Rent Of: </strong><?php echo $row['Month']." ".$row['Year'] ?> </p>
                                        </div>
                                    </div><!-- end col -->
                                </div>
                                <!-- end row -->

                                <div class="m-h-50"></div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table m-t-30">
                                                <thead>
                                                    <tr>
                                                        <!-- <th>#</th> -->
                                                    <th>Rent Of:</th>
                                                    <th>Amount</th>
                                                </tr></thead>
                                                <tbody>
                                                    <?php
                                                   
                                                    echo'
                                                    <tr>
                                                        
                                                        <td>'.$row['Month'].' '.$row['Year'].'</td>
                                                        <td>$'.$row['Amount'].'</td>
                                                    </tr>';
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <div class="clearfix m-t-40">
                                            <h5 class="small text-inverse font-600">PAYMENT TERMS AND POLICIES</h5>

                                            <small>
                                                All accounts are to be paid within 7 days from receipt of
                                                invoice. To be paid by cheque or credit card or direct payment
                                                online. If account is not paid within 7 days the credits details
                                                supplied as confirmation of work undertaken will be charged the
                                                agreed quoted fee noted above.
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-6 col-md-offset-3">
                                        <p class="text-right"><b>Sub-total:</b><?php echo $row['Amount']; ?></p>
                                        <!-- <p class="text-right">Discout: 12.9%</p> -->
                                        <!-- <p class="text-right">VAT: 12.9%</p> -->
                                        <hr>
                                        <h3 class="text-right">Rs. <?php echo $row['Amount']; ?></h3>
                                    </div>
                                </div>
                                <hr>
                                <div class="hidden-print">
                                    <div class="pull-right">
                                        <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-print"></i></a>
                                    </div>
                                </div>
                            </div>
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