<?php
$link = mysqli_connect("localhost", "abhikshi_handynotes", "Caprio#styen01", "abhikshi_handynotes");
if(mysqli_connect_error()){
    die('ERROR: Unable to connect:' . mysqli_connect_error()); 
    echo "<script>window.alert('Hi!')</script>";
}
?>