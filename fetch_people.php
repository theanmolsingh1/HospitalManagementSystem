<?php
$server  = "localhost";
$username = "root";
$password  = "";
$database = "hos_data"; 

// Establish connection
$con = mysqli_connect($server, $username, $password, $database);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all records from `people` table
$sql = "SELECT reciptno, name, phone, appdate FROM people ORDER BY appdate DESC";
$result = mysqli_query($con, $sql);

$people = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $people[] = $row;
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($people);

mysqli_close($con);
?>
