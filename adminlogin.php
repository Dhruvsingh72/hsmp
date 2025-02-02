<?php
session_start();
include("include/connection.php");

if (isset($_POST['login'])) {
    $username = $_POST['uname'];
    $password = $_POST['pass'];

    $error = array();
    if (empty($username)) {
        $error['admin'] = "Enter Username";
    } else if (empty($password)) {
        $error['admin'] = "Enter Password";
    }
    if (count($error) == 0) {
        $query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($connect, $query);

        if (!$result) {
            die("Query failed: " . mysqli_error($connect));
        }

        if (mysqli_num_rows($result) == 1) {
            echo "<script>alert('You have logged in as an admin')</script>";
            $_SESSION['admin'] = $username;

            header("Location:admin/index.php");
            exit();

        } else {
            echo "<script>alert('Invalid Username or Password')</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin login</title>

    <style>
        body {
            font-size: 18px;
            margin: 20px;
        }

        @media(max-width: 768px) {
            body {
                font-size: 16px;
                margin: 15px;
            }
        }

        @media(max-width: 480px) {
            body {
                font-size: 14px;
                margin: 10px;
            }
        }

        body,
        html {
            height: 100%;
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: rgba(40, 167, 69, 0.3);
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .jumbotron {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 400px;
            height: auto;
            text-align: center;
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
            margin: 10px 0;
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

    <div style="margin-top: 50px;"></div>

    <div class="container" style="width: 864px; height: 650px;">

        <div class="col-md-12">

            <div class="row">

                <div class="col-md-3"></div>
                <div class="col-md-6 jumbotron">
                <h5 class="text-center my-5">Admin Login</h5>

                    <form method="post" class="my-2">
                        <div>
                            <?php
                            if (isset($error['admin'])) {
                                $sh = $error['admin'];
                                $show = "<h5 class='alert alert-danger'>$sh</h5>";
                            } else {
                                $show = "";
                            }
                            echo $show;
                            ?>
                        </div>

                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" name="uname" class="form-control" autocomplete="off"
                                placeholder="Username">
                        </div>

                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="pass" class="form-control" placeholder="Password">
                        </div>
                        <input type="submit" name="login" class="btn btn-success" value="Login">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>