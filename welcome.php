<?php

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Καλώς ήρθες!</title>
    <link rel="stylesheet" href="format.css" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="omdbapi.js"></script>
</head>
    
<body class="body">
    <div class="header">
        <img src="atei-logo.png" class="logo">
        <h1>ΠΜΣ Ευφυείς Τεχνολογίες Διαδικτύου</h1>
        <h2>Τμήμα Πληροφορικής</h2>
        <p>Μηχανική Λογισμικού για Διαδικτυακές Εφαρμογές</p>
    </div>
    
    <div>
        <h1>Γειά σου <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Καλωσήρθες στην σελίδα μας.</h1>
    </div>
    

    
    <div class="div">
        <form name='frm'  >
            Τίτλος Ταινίας: <input style='width:30%' name=title id='ttl' type=text required/>
            <br>
            Έτος: <input style='width:5%' name=year id='yr' type=text/><br>
            <input style='width:30%' name="sub" onclick="omdbApi()" value="Αναζήτηση" type="button"/>
        </form>
    </div>
    
    <div id="selection_images">
        <!--    edo tha emfanizei ta poster -->
    </div>
    
    <p id="demo">
        <!--    edo tha emfanizei to link tou API -->
    </p>

    <div style="margin:10px">    
        <button class="button" onclick="showUser()" >Η λίστα μου</button>        
    </div> 
    
    <div class="div" id="txtHint">
        <b>Λίστα προτιμήσεων</b>
    </div>
        
    <div style="margin:10px; padding:100px;">
        <p>
            <a class="button" href="reset-password.php">Άλλαξε τον κωδικό σου</a>
            <a class="button" href="logout.php">Έξοδος</a>
        </p>
    </div>
    <div class="footer">
        <p>Αντώνης Καραγεώργος - Κώστας Κελεσίδης - Ιωάννης Μαρασλίδης - Μαρία Μαυρίδου</p>
        <p>2018</p>
    </div>
</body>
</html>