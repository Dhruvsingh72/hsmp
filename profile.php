<?php session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin profile</title>
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
            flex-direction: column;
        }

        .row {
            flex: 1;
            display: flex;
            flex-direction: row;
            justify-content: stretch;
        }

        .col-md-2 {
            flex: 0 0 20%;
            background-color: #f8f9fa;
            padding: 20px;
        }

        .col-md-10 {
            flex: 1;
            padding: 20px;
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
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }

        .btn-info {
            background-color: #17a2b8;
            color: white;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php
    include("../include/header.php");
    include("../include/connection.php");
    $ad = $_SESSION['admin'];
    $query = "SELECT * from admin WHERE username='$ad'";
    $res = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_array($res)) {
        $username = $row['username'];
        $profile = $row['profile'];
    }
    ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <?php
                include("sidenav.php");
                ?>
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-6">
                        <h4><?php echo $username; ?> Profile</h4>
                        <?php
                        if (isset($_POST['update'])) {
                            $profile = $_FILES['profile']['name'];
                            $tmp_name = $_FILES['profile']['tmp_name'];
                            if (!empty($profile)) {
                                $query = "UPDATE admin SET profile='$profile' WHERE username='$ad'";
                                $result = mysqli_query($connect, $query);
                                if ($result) {
                                    move_uploaded_file($tmp_name, "../img/$profile");
                                    echo "<script>alert('Profile updated successfully')</script>";
                                } else {
                                    echo "<script>alert('Failed to update profile')</script>";
                                }
                            }
                        }
                        ?>

                        <form method="post" enctype="multipart/form-data">
                            <?php echo "<img src='../img/$profile' class='col-md-12' style='height: 240px; width: 30%;'>";
                            ?>
                            <br><br>
                            <div class="form-group">
                                <label for="">Update profile</label>
                                <input type="file" name="profile" class="form-control">
                            </div>
                            <br>
                            <input type="submit" name="update" value="UPDATE" class="btn btn-success">
                        </form>
                    </div>
                    <div class="col-md-6">
                        <?php
                        if (isset($_POST['change'])) {
                            $uname = $_POST['uname'];
                            if (!empty($uname)) {
                                $query = "UPDATE admin SET username='$uname' WHERE username='$ad'";
                                $res = mysqli_query($connect, $query);
                                if ($res) {
                                    $_SESSION['admin'] = $uname;
                                }
                            }
                        }
                        ?>
                        <form method="post">
                            <label>Change Username</label>
                            <input type="text" name="uname" class="form-control" autocomplete="off"><br>
                            <input type="submit" name="change" class="btn btn-success" value="Change">
                        </form>
                        <br>
                        <?php
                        if (isset($_POST['update_pass'])) {
                            $old_pass = $_POST['old_pass'];
                            $new_pass = $_POST['new_pass'];
                            $con_pass = $_POST['con_pass'];
                            $error = array();
                            $old = mysqli_query($connect, "SELECT * FROM admin WHERE username='$ad'");
                            $row = mysqli_fetch_array($old);
                            $pass = $row['password'];
                            if (empty($old_pass)) {
                                $error['p'] = "Enter old password";
                            } else if (empty($new_pass)) {
                                $error['p'] = "Enter New Password";
                            } else if (empty($con_pass)) {
                                $error['p'] = "Confirm Password";
                            } else if ($old_pass != $pass) {
                                $error['p'] = "Invalid password";
                            } elseif ($new_pass != $con_pass) {
                                $error['p'] = "Passwords do not match";
                            }

                            if (count($error) == 0) {
                                $query = "UPDATE admin SET password='$new_pass' WHERE username='$ad'";
                                mysqli_query($connect, $query);
                                echo "<script>alert('Password updated successfully')</script>";
                            }

                            if (isset($error['p'])) {
                                $e = $error['p'];
                                $show = "<h5 class='text-center alert alert-danger'>$e</h5>";
                            } else {
                                $show = "";
                            }
                        }
                    
                        ?>

                        <?php echo isset($show) ? $show : ''; ?>

                        <form method="post">
                            <h5 class="text-center my-4">Change Password</h5>
                            <div class="form-group">
                                <label>Old Password</label>
                                <input type="password" name="old_pass" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" name="new_pass" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="con_pass" class="form-control">
                            </div>
                            <input type="submit" name="update_pass" value="Update Password" class="btn btn-info">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
