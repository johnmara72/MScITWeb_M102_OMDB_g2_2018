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
$sql="SELECT * FROM userMovies WHERE id_user = '".$_SESSION["id"]."'";
$result = mysqli_query($con,$sql);

echo "<table>
<tr>
<th>id_user</th>
<th>id_movie</th>
<th>created_at</th>
</tr>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td style='width:10%;'>" . $row['id_user'] . "</td>";
    echo "<td style='width:30%;'>" . $row['id_movie'] . "</td>";
    echo "<td style='width:10%;'>" . $row['created_at'] . "</td>";
    echo "</tr>";
}

echo "</table>";
mysqli_close($con);
?>
</body>
</html>