<?php
require_once "config.php";
 
// orizo metavlites me keno periexomeno
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// epeksergazomai tin forma otan tin kanoun Post
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Elegxo an edose username
    if(empty(trim($_POST["username"]))){
        $username_err = "Παρακαλώ εισάγετε όνομα χρήστη.";
    } else{
        // Elegxo an to username uparx3ei stin db
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Theto timi sto username
            $param_username = trim($_POST["username"]);
            
            // diadiakasia kataxorisis username
            if(mysqli_stmt_execute($stmt)){
                
                mysqli_stmt_store_result($stmt);
                // elegxo an to username uparxei 
                if(mysqli_stmt_num_rows($stmt) == 1){ 
                    $username_err = "Το όνομα χρήστη υπάρχει ήδη.";
                }
                // to userame den uparxei
                else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Κάτι πήγε λάθος! Παρακαλώ δοκιμάστε ξανά.";
            }
        }
         
        
        mysqli_stmt_close($stmt);
    }
    
    // Elegxos password
    if(empty(trim($_POST["password"]))){
        $password_err = "Παρακαλώ εισάγετε κωδικό.";     
    } 
    // na exei toulaxiston 6 xaraktires
    elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Ο κωδικός πρέπει να έχει τουλάχιστον 6 χαρακτήρες.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Elegxos epivevaiosis password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Παρακαλώ εισάγετε ξανά τον κωδικό.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Οι κωδικοί δεν ταιριάζουν.";
        }
    }
    
    // elegxos gia eggrafi stin db
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Insert
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // kano to password hash
            
            // Ektelesi tou querry
            if(mysqli_stmt_execute($stmt)){
                // epistrofi sto login
                header("location: login.php");
            } else{
                echo "Κάτι πήγε λάθος! Παρακαλώ δοκιμάστε ξανά.";
            }
        }
         
        mysqli_stmt_close($stmt);
    }
    
    // kleino tin sundesi stin db
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Εγγραφή νέου χρήστη</title>
    <link rel="stylesheet" href="format.css" >
</head>
<body class="body">
    
    <div class="header">
        <img src="atei-logo.png" class="logo">
        <h1>ΠΜΣ Ευφυείς Τεχνολογίες Διαδικτύου</h1>
        <h2>Τμήμα Πληροφορικής</h2>
        <p>Μηχανική Λογισμικού για Διαδικτυακές Εφαρμογές</p>
    </div>
    
    <div class="wrapper">
        <h2>Εγγραφή νέου χρήστη</h2>
        <p>Παρακαλώ συμπληρώστε την φόρμα για να δημιουργήσετε Λογαριασμό.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label><strong>Όνομα χρήστη</strong></label><br>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <br>
            
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label><strong>Κωδικός</strong></label><br>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <br>
            
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label><strong>Επαναληψη Κωδικού</strong></label><br>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Υποβολή">
                <a class="button" href="login.php">Ακύρωση</a>
            </div>
            <p>Έχεις ήδη λογαριαμό; <a href="login.php">Κάνε Login εδώ</a>.</p>
        </form>
    </div>    
    
    <div class="footer">
        <p>Αντώνης Καραγεώργος - Κώστας Κελεσίδης - Ιωάννης Μαρασλίδης - Μαρία Μαυρίδου</p>
        <p>2018</p>
    </div>
    
</body>
</html>