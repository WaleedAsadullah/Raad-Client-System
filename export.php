<?php  

include_once('db_connection.php');
$conn = connect_db();
 if(isset($_GET["Export"])) 
 {  
            
          header('Content-Type: text/csv; charset=utf-8');  
          header('Content-Disposition: attachment; filename='.$_GET['name_file'].'.csv');  
          $output = fopen("php://output", "w"); 
          $title = explode("|",$_GET['title']);
         
          fputcsv($output, $title);  
          $query = $_GET["Export"];  
          $result = mysqli_query($conn, $query);  
          while($row = mysqli_fetch_assoc($result))  
          {  
               fputcsv($output, $row);  
          }  
          fclose($output);  
          // header('location : C:\xampp\htdocs\school\Admin-mod-section.php');
     }
 ?>  