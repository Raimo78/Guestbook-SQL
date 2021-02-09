<?php

    $conn = mysqli_connect("localhost","root","","commentsroom");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

?>