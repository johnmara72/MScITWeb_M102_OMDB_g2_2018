
<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
</head>
<body>

<?php
    
// ανοίγω το session
session_start();
 
// έλεγχος αν είναι συνδεμένος ο χρήστης
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}    

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'admin');
define('DB_PASSWORD', 'admin');
define('DB_NAME', 'omdb');    

$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"userMovies");
/* $sql="insert into userMovies (id_user,id_movie) values  (".$_SESSION["id"].",'".$_POST["movie_id"]."');"; */
$sql="insert into userMovies (id_user,id_movie) values  (".$_SESSION["id"].",'".$_POST["movie_title"]."');";       
$result = mysqli_query($con,$sql);

mysqli_close($con);
     echo 'done';
?>
</body>
</html>