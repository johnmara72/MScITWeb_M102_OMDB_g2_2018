<?php
// Initialize the session - προετοιμασία συνεδρίας
session_start();
 
// Unset all of the session variables - κατάργηση όλων των μεταβλητών της συνεδρίας
$_SESSION = array();
//session_unset(); 
 
// Destroy the session - καταστροφή της συνεδρίας
session_destroy();
 
// Redirect to login page - προώθηση στην αρχική σελίδα σύνδεσης
header("location: login.php");
exit;
?>