<?php
$server  = "localhost";
$username = "root";
$password  = "";
$database = "hos_data";

// Establish connection
$con = mysqli_connect($server, $username, $password, $database);

if (!$con) {
    exit();
}

// Check if `reciptno` is provided
if (isset($_POST['reciptno'])) {
    $reciptno = mysqli_real_escape_string($con, $_POST['reciptno']);

    // Delete the record from `people` table
    $sql = "DELETE FROM people WHERE reciptno = ?";
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $reciptno);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($con);
exit();
?>
