<?php
$server  = "localhost";
$username = "root";
$password  = "";
$database = "hos_data";

$con = mysqli_connect($server, $username, $password, $database);
if (!$con) {
    die("❌ Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['reciptno'])) {
    $reciptno = mysqli_real_escape_string($con, $_GET['reciptno']);
    $sql = "SELECT * FROM people WHERE reciptno = ?";
    $stmt = mysqli_prepare($con, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $reciptno);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $appointment = mysqli_fetch_assoc($result);

        if ($appointment) {
            echo "<div class='container'>";
            echo "<h2>Appointment Details</h2>";
            echo "<p><strong>Receipt No:</strong> " . $appointment['reciptno'] . "</p>";
            echo "<p><strong>Name:</strong> " . $appointment['name'] . "</p>";
            echo "<p><strong>Phone:</strong> " . $appointment['phone'] . "</p>";
            echo "<p><strong>Appointment Date:</strong> " . $appointment['appdate'] . "</p>";

            echo "<button id='gen'>Download PDF</button>";
            echo "</div>";
        } else {
            echo "<p class='text-danger'>❌ No appointment found!</p>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<p class='text-danger'>❌ Error fetching details!</p>";
    }
} else {
    echo "<p class='text-warning'>⚠️ Invalid Request!</p>";
}

mysqli_close($con);
?>

<style>
    .container {
        max-width: 500px;
        margin: auto;
        padding: 20px;
        text-align: center;
        font-size: 40px;
        background: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    }
    h2 {
        font-size: 50px;
        color: #333;
    }
    p {
        font-size: 40px;
    }
    button {
        font-size: 24px;
        padding: 10px 20px;
        margin-top: 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s ease-in-out;
    }
    button:hover {
        background-color: #0056b3;
        transform: scale(1.1);
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('gen').addEventListener('click', function () {
            window.print();
        });
    });
</script>
