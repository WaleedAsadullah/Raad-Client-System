<?php 
session_start();
if (!isset($_SESSION['nameclient'])){ 
echo '<script>
        location.replace(\'index.php\');
    </script>';
	
}
?>