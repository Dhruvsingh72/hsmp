<?php
include("include/connection.php");
session_start(); // Start the session

if (isset($_POST['login'])) {
    $uname = $_POST['uname'];
    $password = $_POST['pass'];
    $error = array();

    // Check for empty fields
    if (empty($uname)) {
        $error['login'] = "Enter Username";
    } else if (empty($password)) {
        $error['login'] = "Enter Password";
    } else {
        $q = "SELECT * FROM doctors WHERE username='$uname' AND password='$password'";
        $qq = mysqli_query($connect, $q);
        $row = mysqli_fetch_array($qq);

        if ($row) {
            if ($row['status'] == "Pending") {
                $error['login'] = "Please Wait For the admin to confirm";
            } else if ($row['status'] == "Rejected") {
                $error['login'] = "Try again Later";
            } else {
                $_SESSION['doctor'] = $uname;
                echo "<script>alert('Login successful');</script>";
                // Redirect to doctor dashboard or appropriate page
                header("Location: doctor/index.php");
            }
        } else {
            $error['login'] = "Invalid Username or Password";
        }
    }

    if (isset($error['login'])) {
        $show = "<h5 class='text-center alert alert-danger'>" . $error['login'] . "</h5>";
    } else {
        $show = "";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Login</title>
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .container-fluid {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .row {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .col-md-6 {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn-success {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #28a745;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-success:hover {
            background-color: #218838;
        }
    </style>
</head>

<body style="background-image: url('img/back2.jpg'); background-repeat: no-repeat; background-size: cover;">
    <?php
    include("include/header.php");
    ?>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 jumbotron my-3">
                    <h5 class="text-center my-5">Doctors Login</h5>
                    <div>
                        <?php echo isset($show) ? $show : ''; ?>
                    </div>
                    <form method="post">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="uname" class="form-control" autocomplete="off" placeholder="Enter Username">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="pass" class="form-control" autocomplete="off">
                        </div>
                        <input type="submit" name="login" class="btn btn-success" value="Login">
                        <p>Don't have an account? <a href="apply.php">Apply here</a></p>
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
</body>

</html>
