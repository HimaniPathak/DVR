<?php 
// Start the session
session_start();

if(isset( $_SESSION["userid"]))
	header("location:admin.php");

include "./authentication.php";

if(isset($_POST['submit'])) {
	$username = $_POST['userName'];
	$password = $_POST['userPassword'];
	if(AdminAuth::getLogin($username,$password))
		header("location:admin.php");
	else
	 $msj = "invalid Login";
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>DVR | Admin</title>
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
	<link href="./css/style.css" rel="stylesheet">
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	<!------ Include the above in your HEAD tag ---------->

	<!--Pulling Awesome Font -->
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

</head>
<body>

<div class="container">
    <div class="row">
        <form method="post">
	        <div class="col-md-offset-5 col-md-3">
	            <div class="form-login">
	            <h4>Welcome back.</h4>
	            <p style="color: #F44336; text-align: center; text-transform: capitalize; font-weight: 600;"><?php if(isset($msj)) { echo $msj;} ?></p> 
	            <input type="text" name="userName" required class="form-control input-sm chat-input" placeholder="username" />
	            </br>
	            <input type="password" name="userPassword" required class="form-control input-sm chat-input" placeholder="password" />
	            </br>
	            <div class="wrapper">
	            <span class="group-btn">
	            <input type="hidden" name="submit">     
	                <button type="submit" class="btn btn-primary btn-md">login <i class="fa fa-sign-in"></i></button>
	            </span>
	            </div>
	            </div>
	        
	        </div>
        </form>
    </div>
</div>
</body>
</html>