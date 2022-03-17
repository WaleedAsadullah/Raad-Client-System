<?php 
include_once('db_connection.php');
$conn = connect_db();

function code_submit()
{

if(isset($_REQUEST['editid']) && is_numeric($_REQUEST['editid'])){ 

echo '<input type="hidden"  name="editid"   value="'.$_REQUEST['editid'].'">';


echo ' <button class="btn btn-primary waves-effect waves-light" type="submit" ';
    echo "name=\"edit\">Edit";}
else {echo ' <button class="btn btn-primary waves-effect waves-light" type="submit" '; echo "name=\"submit\">Submit";}

}

function get_curr_user()

{

  return $_SESSION['id'];
}



function insert_query($sql)
{

if($conn = connect_db()) 
  // echo "Db connected"
;
else echo "db not connected";

 if ($conn->query($sql) === TRUE) {
  // echo "New record created successfully"
  ;
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}


close_db($conn);


}

function check_edit($table_name,$col_id)
{
if(isset($_REQUEST['edit']) && $_REQUEST['editid'] && is_numeric($_REQUEST['editid']) ){
                                           
$arr_key = array_keys($_REQUEST);
for($i=0;$i<count($arr_key);$i++)
    {
        $ak = $arr_key[$i];
        if($ak == "edit" || $ak== "editid" ) continue;
        $sql = "UPDATE `".$table_name."` SET `";
        $sql .= $ak."` = '".$_REQUEST[$ak]."' WHERE `".$table_name."`.`".$col_id."` = ".$_REQUEST['editid'];
        insert_query($sql);
       // echo "sql_edit=";
    }
  }
}

// ---------------------

function transform_edit($array_edit){
$arr_key = array_keys($array_edit[0]);

    for($i=0;$i<count($arr_key);$i++)
    {
        $ak = $arr_key[$i];
        $_REQUEST[$ak] = $array_edit[0][$ak];
    }
return $_REQUEST;
  }

  function edit_display($table_name,$col_id)
{

 if(isset($_REQUEST['editid']) && is_numeric($_REQUEST['editid']) && !(isset($_REQUEST['edit'] ))){ 


//$_REQUEST['editid']


// echo "sql_edit=";
  $sql_edit = "SELECT *  FROM `".$table_name."` where `".$table_name."`.`".$col_id."` =".$_REQUEST['editid'] ;

 transform_edit(query_to_array($sql_edit));
}

}

function display_query($sql)
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
                    <th></th>
                    <th></th>
                    <th></th>';
$row_data = array_keys($row);
$id_column = "";
for($j=0;$j<count($row_data);$j++){

  if($j==0) $id_column = $row_data[$j];

    echo  "<th>".$row_data[$j]."</th>"; }
                                                   
    echo   '</tr>
         </thead>
      <tbody>';

 //echo '';



//print_r($row);



    }
  $i++;
  //  `increment_form_id`, `user_id`, `user_date`, `gr_number`, `salary_increment`, `new_salary`, `comment`
    //echo "id: " . $row["increment_form_id"]. " - user_id: " . $row["user_id"]. " " . $row["gr_number"]." - salary_increment: " . $row["salary_increment"]. " - new_salary: " . $row["new_salary"]. "  - comment: " . $row["comment"]. "<br>";

  
    echo '<tr>
              <td>'.$i.'</td>
              <td style="text-align:center;"><a style="color:rgb(16,196,105);" href="'.$_SERVER['PHP_SELF'].'?editid='.$row[$id_column].'"><i class="zmdi zmdi-edit"></i></a></td>
            
              <td style="text-align:center;"><a style="color:rgb(255,87,90);" href="'.$_SERVER['PHP_SELF'].'?deleteid='.str_replace(" ","___",$row[$id_column]).'"><i class="fa fa-trash-o" onclick="return confirm(\'Are you sure?\')"></i></a></td>
              <td style="text-align:center;"><a style="color:rgb(120,108,150);" href="" ><i  class="zmdi zmdi-local-printshop"></i></a></td>
              <td style="text-align:center;"><a style="color:rgb(30,108,180);" href="" ><i class="zmdi zmdi-copy"></i></a></td>';


for($k=0;$k<count($row_data);$k++){ echo  '<td>'.$row[$row_data[$k]].'</td>';}

   echo  '</tr>';
  }

    echo '   </tbody>';
} else {
  echo "0 results";
}
    

}

function display_query_search($sql)
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
for($k=0;$k<count($row_data);$k++){ echo  '<td>'.$row[$row_data[$k]].'</td>';}

   echo  '</tr>';
  }

    echo '   </tbody>';
} else {
  echo "0 results";
}
    

}

function close_db($conn)
{
$conn->close();
}

function query_to_array($sql)
{

 $conn = connect_db();
  $result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row

  
//get_current_form();
                                                
   $i = 0;                                     
  while($row = $result->fetch_assoc()) {
    $newdata[]=$row;
    if($i==0)
    {

$row_data = array_keys($row);
$id_column = "";
for($j=0;$j<count($row_data);$j++){

  if($j==0) $id_column = $row_data[$j];

    $query_results[$j] = $row_data[$j]; }
                                                   
   



    }
  $i++;
  

for($k=0;$k<count($row_data);$k++){ $query_results[$j][$k] =  $row[$row_data[$k]];}

   
  }

   
} else {
  return "no result";
}
    
   // print_r($query_results);

   // echo "<br>new print<br>";
   // print_r($newdata);
return $newdata;
}


function dropDownCustomer($label,$name,$select,$select2,$select3,$from,$condition){
        $conn = connect_db();
        $sql_id = 'SELECT `'.$select.'`,`'.$select2.'`,`'.$select3.'` FROM `'.$from.'`'.$condition.'';

        echo'
            <div class="form-group">
              <label for="">'.$label.'</label>
              <select id="themes" type="text"  name="'.$name.'"  required="" class="form-control select2">';
         $result_id = mysqli_query($conn ,$sql_id);
          
          while($row_id = mysqli_fetch_assoc($result_id)) {
          // print_r($row_id);

            if (isset($_REQUEST[$name]) && $_REQUEST[$name]==$row_id[$select]) {$selected = "selected";}else $selected = ""; 

            echo'
                    <option '.$selected.'
                    value="'.$row_id[$select].'">'.$row_id[$select2].'</option>';
          }
                    echo'
                </select>
        </div>';
}

function dropDownConditionalUnsumit($label,$name,$select,$select2,$from,$condition){
        $conn = connect_db();
        $sql_id = 'SELECT `'.$select.'`,`'.$select2.'` FROM `'.$from.'`'.$condition.''; 

        echo'
            <div class="form-group">
              <label for="">'.$label.'</label>
              <select  name="'.$name.'"  class="form-control select2" id="office">
              <option>-Select </option>';
         $result_id = mysqli_query($conn ,$sql_id);
          
          while($row_id = mysqli_fetch_assoc($result_id)) {
          // print_r($row_id);

            if (isset($_REQUEST[$name]) && $_REQUEST[$name]==$row_id[$select]) {$selected = "selected";}else $selected = ""; 

            echo'
                    <option '.$selected.'
                    value="'.$row_id[$select].'">'.$row_id[$select2].'</option>';
          }
                    echo'
                </select></div>'
                

        ;
}
function dropDownConditionalUnsumitForJs($label,$name,$select,$select2,$from,$condition){
        $conn = connect_db();
        $sql_id = 'SELECT `'.$select.'`,`'.$select2.'` FROM `'.$from.'`'.$condition.''; 

        $js = '
            <div class="form-group">
              <select  name="'.$name.'AA1"  class="form-control select2" id="office">
              <option>-Select </option>';
         $result_id = mysqli_query($conn ,$sql_id);
          
          while($row_id = mysqli_fetch_assoc($result_id)) {
          // print_r($row_id);

            if (isset($_REQUEST[$name]) && $_REQUEST[$name]==$row_id[$select]) {$selected = "selected";}else $selected = ""; 

            $js .='
                    <option '.$selected.'
                    value="'.$row_id[$select].'">'.$row_id[$select2].'</option>';
          }
                    $js .='
                </select></div>' ;
                return $js;
}
function dropDownConditionalWithID($label,$name,$id,$select,$select2,$from,$condition){
  // html id
        $conn = connect_db();
        $sql_id = 'SELECT `'.$select.'`,`'.$select2.'` FROM `'.$from.'`'.$condition.''; 

        echo'
            <div class="form-group">
              <label for="">'.$label.'</label>
              <select  name="'.$name.'"  class="form-control select2" id="'.$id.'">
              <option>-Select </option>';
         $result_id = mysqli_query($conn ,$sql_id);
          
          while($row_id = mysqli_fetch_assoc($result_id)) {
          // print_r($row_id);

            if (isset($_REQUEST[$name]) && $_REQUEST[$name]==$row_id[$select]) {$selected = "selected";}else $selected = ""; 

            echo'
                    <option '.$selected.'
                    value="'.$row_id[$select].'">'.$row_id[$select2].'</option>';
          }
                    echo'
                </select><br>'
                

        ;
}
function dropDownConditional2($label,$name,$select,$select2,$select3,$from,$condition){
        $conn = connect_db();
        $sql_id = 'SELECT '.$select.','.$select2.','.$select3.' FROM '.$from.' '.$condition.''; 
        echo'
            <div class="form-group">
              <label for="">'.$label.'</label>
              <select  name="'.$name.'"  class="form-control select2" id="office">
              <option>-Select </option>';
         $result_id = mysqli_query($conn ,$sql_id);
          
          while($row_id = mysqli_fetch_assoc($result_id)) {
          // print_r($row_id);

            if (isset($_REQUEST[$name]) && $_REQUEST[$name]==$row_id[$select]) {$selected = "selected";}else $selected = ""; 

            echo'
                    <option '.$selected.'
                    value="'.$row_id[$select].'">'.$row_id[$select2].' '.$row_id[$select3].'</option>';
          }
                    echo'
                </select></div>'
                

        ;
}

?>