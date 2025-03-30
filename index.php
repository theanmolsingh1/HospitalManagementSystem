<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Status</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
         body {
            background: linear-gradient(135deg, #302b62, #2f2a60, #302b63);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }
        .bubbles {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
        }
        .bubble {
            position: absolute;
            bottom: -50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            opacity: 0.6;
            animation: rise 10s infinite ease-in-out;
        }
        @keyframes rise {
            0% { transform: translateY(0); opacity: 0.6; }
            50% { opacity: 1; }
            100% { transform: translateY(-120vh); opacity: 0; }
        }
        .bubble:nth-child(1) { width: 20px; height: 20px; left: 10%; animation-duration: 6s; }
        .bubble:nth-child(2) { width: 30px; height: 30px; left: 25%; animation-duration: 8s; }
        .bubble:nth-child(3) { width: 40px; height: 40px; left: 50%; animation-duration: 7s; }
        .bubble:nth-child(4) { width: 25px; height: 25px; left: 75%; animation-duration: 9s; }
        .bubble:nth-child(5) { width: 15px; height: 15px; left: 90%; animation-duration: 5s; }
        .container {
            max-width: 400px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }
        .container:hover {
            transform: scale(1.05);
        }
        .btn-primary {
            width: 100%;
            background-color: brown;
            border: none;
        }
        .btn-primary:hover {
            background-color: #8b0000;
        }
        h2 {
            color:rgb(13, 71, 119);
        }

        .btn {
            width: 100%;
            margin-top: 10px;
            transition: all 0.3s ease-in-out;
        }

        .btn-primary {
            background-color: #795548;
            border: none;
        }

        .btn-primary:hover {
            background-color: #4E342E;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
<div class="bubbles">
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
</div>
<div class="container">
    <h2>Submission Status</h2>
    <?php
    $server  = "localhost";
    $username = "root";
    $password  = "";
    $database = "hos_data"; 

    $con = mysqli_connect($server, $username, $password, $database);

    if (!$con) {
        die("<p class='message text-danger'>❌ Connection failed: " . mysqli_connect_error() . "</p>");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST['reciptno']) && !empty($_POST['name']) && !empty($_POST['phone'])) {

            $reciptno = mysqli_real_escape_string($con, $_POST['reciptno']);
            $name = mysqli_real_escape_string($con, $_POST['name']);
            $phone = mysqli_real_escape_string($con, $_POST['phone']);

            $sql = "INSERT INTO `people` (`reciptno`, `name`, `phone`, `appdate`) VALUES (?, ?, ?, CURRENT_DATE())";
            $stmt = mysqli_prepare($con, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "iss", $reciptno, $name, $phone);
                $result = mysqli_stmt_execute($stmt);

                if ($result) {
                    echo "<p class='message text-success'>✅ Record inserted successfully!</p>";

                    // Hidden form to pass data for PDF generation
                    echo "<form action='appointment_details.php' method='GET'>
                        <input type='hidden' name='reciptno' value='$reciptno'>
                        <button type='submit' class='btn btn-primary'>See Details</button>
                    </form>";
                } else {
                    echo "<p class='message text-danger'>❌ Error inserting record: " . mysqli_error($con) . "</p>";
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "<p class='message text-danger'>❌ Statement preparation failed: " . mysqli_error($con) . "</p>";
            }
        } else {
            echo "<p class='message text-warning'>⚠️ Please fill in all required fields!</p>";
        }
    }

    mysqli_close($con);
    ?>

    <a href="landingpage.html" class="btn btn-primary">Go Back</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
