<?php
//προετοιμασία συνεδρίας
session_start();
 
//κατάργηση όλων των μεταβλητών της συνεδρίας
$_SESSION = array();
//session_unset(); 
 
//καταστροφή της συνεδρίας
session_destroy();
 
//προώθηση στην αρχική σελίδα σύνδεσης
header("location: login.php");
exit;
?>