<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "haaletus";
        
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "UPDATE tulemused SET h_alguse_aeg = CURRENT_TIMESTAMP();";

if (mysqli_query($conn, $sql)) {
    echo "Vote Started";
} else {
    echo "Error updating record: " . mysqli_error($conn);
}

$conn->close();

?>