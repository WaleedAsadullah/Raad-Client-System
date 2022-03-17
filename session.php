<?php 
session_start();
if (!isset($_SESSION['name'])){ 
echo '<script>
        location.replace(\'index.php\');
    </script>';
	
}
?>