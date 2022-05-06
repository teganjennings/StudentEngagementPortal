<?php
session_start();
include("connection.php");
include("check_login.php");

$user_data = check_login($con);


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //something was posted
    $user_name = $_POST['user_name'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {

        //Check if email exist in DB with email
        $prevQuery = "SELECT * FROM users WHERE email = '". $_POST['email']."'";
        $prevResult = $con->query($prevQuery);


        if ($prevResult->num_rows > 0) {
            //Error if email is already in DB
            echo "Email already exists in Database!";
        } else {
            //Insert data into DB
            $user_id = random_num(20);
            $query = ("INSERT INTO users (user_name, name, email, password, role) VALUES ('" . $user_name . "', '" . $name . "','" . $email . "', '" . $password . "', '" . $role . "')");

            mysqli_query($con, $query);

            header("Location: admin_index.php");
            die;
        }

    } else {
        echo "Please enter some valid information!";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/login_style.css">

</head>
<body>
<?php include 'admin_navbar.php' ?>
<h2 style="text-align: center; margin-top: 10px;">Add a New User</h2>
<form class="modal-content animate" method="post">
    <div class="container" style="font-size: 20px; margin: 10px; padding: 10px">

        <label><b>Username</b></label>
        <input id="text" type="text" name="user_name" placeholder="Enter Username"><br><br>

        <label><b>Name</b></label>
        <input id="text" type="text" name="name" placeholder="Enter Name"><br><br>

        <label><b>Email</b></label>
        <input id="text" type="text" name="email" placeholder="Enter Email"><br><br>

        <label><b>Password</b></label>
        <input id="text" type="password" name="password" placeholder="Enter Temporary Password"><br><br>

        <label for="role">Choose a role for user:</label>
        <select id="role" name="roles">
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>

        <button id="button" type="submit" value="admin_login.php">Create User</button>

    </div>
</form>
</body>
</html>