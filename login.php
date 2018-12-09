<?php
// anoigo to session
session_start();
 
// elegxo an to $_SESSION["loggedin"] exei oristei kai exei timi. 
// an einai sundemenos anakateuthino stin selida welcome.php
// an den einai sundemenos sunexizo gia to login
// to isset elegxei an i metavliti exei oristei kai den einai null
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: welcome.php");
  exit;
}
 
// kano include to arxeio me ta stoixeia tis sundesis stin vasi
require_once "config.php";
 
// orismos kai arxikopoiisi metavliton tou login
$username = "";
$password = "";
$username_err = ""; 
$password_err = "";
 
// elegxos ton dedomenon tis formas sto submit
// to trim afairei ta kena prin kai meta to string
// to empty elegxei an i metavliti exei timi i einai null
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Elegxos an sumplirothike to username
    if(empty(trim($_POST["username"]))){ // elegxo an to username einai keno
        $username_err = "Παρακαλώ εισάγετε το username!";
    } else{
        $username = trim($_POST["username"]); // kataxoro tin timi apo to POST sto username.
    }
    
    // Elegxos an sumplirothike to password
    if(empty(trim($_POST["password"]))){ // elegxo an to password einai keno
        $password_err = "Παρακαλώ εισάγετε το password!";
    } else{
        $password = trim($_POST["password"]); // kataxoro tin timi apo to POST sto password
    }
    
    // elegxos an uparxoun ta diapisteutiria stin vasi
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql_query = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($sql_exet = mysqli_prepare($link, $sql_query)){
            
            // kano Bind tin metavliti sto query san parametro
            mysqli_stmt_bind_param($sql_exet, "s", $param_username);
            
            // orizo to $username os timi tis parametrou
            $param_username = $username;
            
            // ektelo to query
            if(mysqli_stmt_execute($sql_exet)){
                
                // apothikeuo to apotelesma
                mysqli_stmt_store_result($sql_exet);
                
                // elegxo an to username uparxei kai einai monadiko. an uparxei elegxo to password
                if(mysqli_stmt_num_rows($sql_exet) == 1){                    
                    
                    // kataxoro tis times pou mou epistrefei to query stis metavlites $id, $username, $hashed_password
                    mysqli_stmt_bind_result($sql_exet, $id, $username, $hashed_password);
                    
                    if(mysqli_stmt_fetch($sql_exet)){
                    
                        // elegxo an to password pou edose stin forma einai auto pou antistoixei sto username pou exo stin vasi
                        if(password_verify($password, $hashed_password)){
                            
                            // apo tin stigmi pou to password sunexizo sto session
                            session_start();
                            
                            // pernao times ston pinaka Session
                            $_SESSION["loggedin"] = true; // katastasi login
                            $_SESSION["id"] = $id; // to id tou xristi
                            $_SESSION["username"] = $username; // to onoma tou xristi                             
                            
                            // tora pou to $_SESSION["loggedin"] egine true kano tin anakateuthinsi sto welcome.php
                            header("location: welcome.php");
                        } else{
                            // an to password einai lathos vgazo minima
                            $password_err = "Λάθος password!";
                        }
                    }
                } else{
                    // an den yparxei to username vgazo minima
                    $username_err = "Δεν υπάρχει τέτοιος χρήστης...";
                }
            } else{
                // an den ektelestei gia kapoio logo to query vgazo minima
                echo "Κάτι πήγε στραβά";
            }
        }
        
        // kleino to query
        mysqli_stmt_close($sql_exet);
    }
    
    // kleino tin sundesi stin vasi
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Είσοδος</title>

</head>
<body class="body">
    <div class="header">
        <img src="atei-logo.png" class="logo">
        <h1>ΠΜΣ Ευφυείς Τεχνολογίες Διαδικτύου</h1>
        <h2>Τμήμα Πληροφορικής</h2>
        <p>Μηχανική Λογισμικού για Διαδικτυακές Εφαρμογές</p>
    </div>
    
    <div class="wrapper">
        <h2>Είσοδος</h2>
        <p>Συμπληρώστε τα στοιχεία εισόδου σας.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Όνομα χρήστη</label>
                <br>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <br>
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Κωδικός</label>
                <br>
                <input type="password" name="password" class="form-control">
                <br>
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Είσοδος">
            </div>
            <p>Δεν έχεις λογαριασμό; <a href="register.php">Κάνε εγγραφή τώρα</a>.</p>
        </form>
    </div>  
   
    <div class="footer">
        <p>Αντώνης Καραγεώργος - Κώστας Κελεσίδης - Ιωάννης Μαρασλίδης - Μαρία Μαυρίδου</p>
        <p>2018</p>
    </div>
</body>
</html>