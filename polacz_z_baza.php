<?php
    $conn = mysqli_connect("localhost", "root", "", "Baza");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>
