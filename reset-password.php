<?php
// Initialize the session - αρχικοποίηση της συνεδρίας
session_start();
 
// Check if the user is logged in, otherwise redirect to login page - έλεγχος αν είναι συνδεδεμένος ο χρήστης αλλιώς προώθηση στη σελίδα σύνδεσης
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file - συμπεριλήψη αρχείου σύνδεσης με βάση δεδομένων
require_once "config.php";
 
// Define variables and initialize with empty values - ορισμός μεταβλητών και αρχικοποίηση με κενές τιμές
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted - επεξεργασία δεδομένων φόρμας όταν αυτή υποβάλλεται 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password, trim space chars, check length at least 6 chars - έλεγχος κρυφού κωδικού, αφαίρεση κενών χαρακτήρων, έλεγχος μεγέθους τουλάχιστον 6 χαρακτήρων
    if(empty(trim($_POST["new_password"]))){
//        $new_password_err = "Please enter the new password.";     
        $new_password_err = "Παρακαλώ εισάγετε το καινούργιο κρυφό κωδικό.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
//        $new_password_err = "Password must have at least 6 characters.";
        $new_password_err = "Ο κρυφός κωδικός πρέπει να αποτελείται τουλάχιστον από έξι (6) χαρακτήρες.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password - έλεγχος επιβεβαίωσης κρυφού κωδικού
    if(empty(trim($_POST["confirm_password"]))){
//        $confirm_password_err = "Please confirm the password.";
        $confirm_password_err = "Παρακαλώ επιβεβαιώστε τον κρυφό κωδικό.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
//            $confirm_password_err = "Password did not match.";
            $confirm_password_err = "Οι κρυφοί κωδικοί δεν είναι ίδιοι.";
        }
    }
        
    // Check input errors before updating the database - έλεγχος για λάθη εισαγωγής κωδικών πριν ενημερωθεί η βάση δεδομένων
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement - προετοιμασία ερωτήματος ενημέρωσης
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters - σύνδεση μεταβλητών με το προετοιμασμένο ερώτημα 
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters - hash password and store it - προετοιμασία παραμέτρων και hash κρυφού κωδικού και αποθήκευσή τους
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement - προσπάθεια εκτέλεσης προετοιμασμένου ερωτήματος
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page - Ολοκληρώθηκε η ενημέρωση του κρυφού κωδικού, καταστροφή συνεδρίας και προώθηση στη σελίδα σύνδεσης
                session_destroy();
                header("location: login.php");
                exit();
            } else{
         //       echo "Oops! Something went wrong. Please try again later.";
                echo "Δυστυχώς δεν ολοκληρώθηκε η αλλαγή. Παρακαλώ προσπαθήστε αργότερα.";
            }
        }
        
        // Close statement - κλείσιμο ερωτήματος
        mysqli_stmt_close($stmt);
    }
    
    // Close connection - κλείσιμο σύνδεσης με βάση δεδομένων
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password - Αλλαγή κρυφού κωδικού</title>
</head>
    
<body>
    
    <div class="header">
        <img src="atei-logo.png" class="logo">
        <h1>ΠΜΣ Ευφυείς Τεχνολογίες Διαδικτύου</h1>
        <h2>Τμήμα Πληροφορικής</h2>
        <p>Μηχανική Λογισμικού για Διαδικτυακές Εφαρμογές</p>
    </div>
    
    <div class="wrapper">
        <h2>Αλλαγή Κωδικού</h2>
        <p>Συμπληρώστε την φόρμα για αλλαγή του κωδικού σας.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>Νέος Κωδικός:</label>
                <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
<!--                <span class="help-block"><?php echo $new_password_err; ?></span> -->
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Επιβεβαίωση Κωδικού:</label>
                <input type="password" name="confirm_password" class="form-control">
<!--                <span class="help-block"><?php echo $confirm_password_err; ?></span> -->
            </div>
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="welcome.php">Cancel</a>
            </div>
            
        </form>
    </div>  
    
    <div class="footer">
        <p>Αντώνης Καραγεώργος - Κώστας Κελεσίδης - Ιωάννης Μαρασλίδης - Μαρία Μαυρίδου</p>
        <p>2018</p>
    </div>
</body>
</html>