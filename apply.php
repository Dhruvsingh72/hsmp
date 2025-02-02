<?php
include("include/connection.php");

if (isset($_POST['apply'])) {
    $firstname = $_POST['fname'];
    $surname = $_POST['sname'];
    $username = $_POST['uname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $password = $_POST['pass'];
    $confirm_password = $_POST['con_pass'];
    $error = array();

    if (empty($firstname)) {
        $error['apply'] = "Enter Firstname";
    } else if (empty($surname)) {
        $error['apply'] = "Enter Surname";
    } else if (empty($username)) {
        $error['apply'] = "Enter Username";
    } else if (empty($email)) {
        $error['apply'] = "Enter Email Address";
    } else if ($gender == "") {
        $error['apply'] = "Select Your Gender";
    } else if (empty($phone)) {
        $error['apply'] = "Enter Phone Number";
    } else if ($city == "") {
        $error['apply'] = "Select City";
    } else if (empty($password)) {
        $error['apply'] = "Enter Password";
    } else if ($confirm_password != $password) {
        $error['apply'] = "Both Passwords do not match";
    }

    if (count($error) == 0) {
        $query = "INSERT INTO doctors (firstname, surname, username, email, gender, phone, city, password, salary, data_reg, status, profile) 
                  VALUES ('$firstname', '$surname', '$username', '$email', '$gender', '$phone', '$city', '$password', '0', NOW(), 'Pending', 'doctor.jpg')";
        $result = mysqli_query($connect, $query);

        if ($result) {
            echo "<script>alert('You have Successfully Applied')</script>";
            header("Location: doctorlogin.php");
        } else {
            echo "<script>alert('Failed')</script>";
        }
    }
}

if (isset($error['apply'])) {
    $s = $error['apply'];
    echo "<div class='alert alert-danger'>$s</div>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply Now</title>
    <style>
        body {
            
           
            background-image: url(img/back2.jpg);
            background-size: cover;
            background-repeat: no-repeat;
          
        }

        
    </style>
</head>

<body>
    <?php
    include("include/header.php");
    ?>
    <div class="container">
        <div class="jumbotron">
            <h5 class="text-center text-white">Apply Now!!!</h5>
            <form method="post">
                <div class="form-group">
                    <label class="text-white">Firstname</label>
                    <input type="text" name="fname" class="form-control" autocomplete="off" value=" <?php if(isset($_POST['fname'])) echo $_POST['fname']; ?>">
                </div>
                <div class="form-group">
                    <label class="text-white">Surname</label>
                    <input type="text" name="sname" class="form-control" autocomplete="off" value=" <?php if(isset($_POST['sname'])) echo $_POST['sname']; ?>">
                </div>
                <div class="form-group">
                    <label class="text-white">Username</label>
                    <input type="text" name="uname" class="form-control" autocomplete="off" value=" <?php if(isset($_POST['uname'])) echo $_POST['uname']; ?>">
                </div>
                <div class="form-group">
                    <label class="text-white">Email</label>
                    <input type="email" name="email" class="form-control" autocomplete="off" value=" <?php if(isset($_POST['email'])) echo $_POST['email']; ?>">
                </div>
                <div class="form-group">
                    <label class="text-white">Select Gender</label>
                    <select name="gender" class="form-control">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="text-white">Phone Number</label>
                    <input type="number" name="phone" class="form-control" autocomplete="off" value=" <?php if(isset($_POST['phone'])) echo $_POST['phone']; ?>">
                </div>
                <div class="form-group">
                    <label class="text-white">Select City</label>
                    <select name="city" class="form-control">
                        <option value="">Select City</option>
                        <option value="Delhi">Delhi</option>
                        <option value="Mumbai">Mumbai</option>
                        <option value="Bangalore">Bangalore</option>
                        <option value="Chennai">Chennai</option>
                        <option value="Kolkata">Kolkata</option>
                        <option value="Hyderabad">Hyderabad</option>
                        <option value="Ahmedabad">Ahmedabad</option>
                        <option value="Pune">Pune</option>
                        <option value="Jaipur">Jaipur</option>
                        <option value="Surat">Surat</option>
                        <option value="Lucknow">Lucknow</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="text-white">Password</label>
                    <input type="password" name="pass" class="form-control" autocomplete="off">
                </div>
                <div class="form-group">
                    <label class="text-white">Confirm Password</label>
                    <input type="password" name="con_pass" class="form-control" autocomplete="off">
                </div>
                <input type="submit" name="apply" value="Apply Now" class="btn btn-success">
                <p class="text-white">Already have an account? <a href="doctorlogin.php">Click here</a></p>
            </form>
        </div>
    </div>
</body>

</html>
