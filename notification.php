<!-- Right Sidebar -->
            <div class="side-bar right-bar">
                <a href="javascript:void(0);" class="right-bar-toggle">
                    <i class="zmdi zmdi-close-circle-o"></i>
                </a>
                <h4 class="">Notifications</h4>
                <div class="notification-list nicescroll">
                    <ul class="list-group list-no-border user-list">
                        <?php
                        $sql = 'SELECT `notification_id`, `user_id`, `user_date`, `send_to`, `type`, `title`, `description` FROM `notification` ORDER BY `notification_id` desc;';
                        $result = mysqli_query(connect_db(),$sql);
                        while ($row = mysqli_fetch_assoc($result)){
                            date_default_timezone_set("Asia/Karachi");
                            $start_date = new DateTime($row['user_date']);
                            // $now = date('Y-m-d h:i:s');
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
                           // echo $timeperoid ;


                    echo'
                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="avatar">
                                    <img src="assets/images/users/avatar-4.jpg" alt="">
                                </div>
                                <div class="user-desc">
                                    <span class="name">'.$row['title'].'</span>
                                    <span class="desc">'.$row['description'].'</span>
                                    <span class="time">'.$timeperoid .' ago</span>
                                </div>
                            </a>
                        </li>';}
                        ?>
                    </ul>
                </div>
            </div>
            <!-- /Right-bar -->