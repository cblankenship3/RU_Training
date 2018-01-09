<?php 
//Checks if user role is Admin else returns them to the index
session_start();
if($_SESSION['Role'] == 'Admin'){
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>User Management &bull; Fitness and Wellness</title> <!-- Title for the tab and website -->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Here is the imported stylesheet and a few style changes for personalized changes to make mobile friendly. -->
<style>
	html {
		height: 100%;
		width: 100%;
	}
	body {
        padding-top: 40px;
        background-image:url(Weights.jpg);
        background-position: top;
        background-size: 100% auto;
        background-repeat: no-repeat;
        background-color: #DDDDDD;
        font-family: "Lato", sans-serif;
    }
	h1,h2,h3,h4,h5,h6 {
		font-family: "Montserrat", sans-serif;
	}
	#users {
		padding-top: 15%;
	}
	#users-form {
		padding: 20px;
		background-color: rgba(0,0,0,0.75);
		color: #FFFFFF;
	}
</style>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

<?php
/*
ITEC 370
Author(s): Chris Blankenship, Jacob Miller, Chris Gibson
Last Edit: 12/7/2017
PHP: users
Bootstrap is used for UI
	 This PHP file is the file to change users and permissions
*/
	
//Variables to determine logged in user and role.
$isLoggedIn = false;
$isClient = false;
$isTrainer = false;
$isAdmin = false;
	
//Starts session and checks for Role, returns to login if not logged in to an admin account.
session_start();
if(isset($_SESSION['Role'])){
	if($_SESSION['Role'] == 'Trainer'){
		$isLoggedIn = true;
		$isTrainer = true;
	}
	if($_SESSION['Role'] == 'Client'){
		$isLoggedIn = true;
		$isClient = true;
	}
	if($_SESSION['Role'] == 'Admin'){
		$isLoggedIn = true;
		$isAdmin = true;
	}
}
?>

</head>

<body>

	<!-- HTML and PHP for menu bar, shows different options based on login and role status. -->
	<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
		<a class="navbar-brand" href="#">Fitness and Wellness</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
			<?php
				echo '<li class="nav-item">
					<a class="nav-link" href="index.php">Home</a>
				</li>';			
				if($isLoggedIn) {
					echo '<li class="nav-item">
						<a class="nav-link" href="appointments.php">Make Appointment</a>
					</li>';
					echo '<li class="nav-item">
						<a class="nav-link" href="data.php">Data</a>
					</li>';
				}
				echo '<li class="nav-item">
					<a class="nav-link" href="links.php">Helpful Links</a>
				</li>';
				if($isAdmin) {
					echo '<li class="nav-item">
						<a class="nav-link active" href="users.php">Create User</a>
					</li>';
				}
				if($isLoggedIn) {
					echo '<li class="nav-item">
						<a class="nav-link" href="logout.php">Logout</a>
					</li>';
				} else {
					echo '<li class="nav-item">
						<a class="nav-link" href="login.php">Login</a>
					</li>';
				}
			?>
			</ul>
		</div>
	</nav>

	<main class="container">
		<div id="users" class="col-xs-12 col-sm-10 offset-sm-1 col-md-6 offset-md-3 col-lg-4 offset-lg-4 col-xl-4 offset-xl-4">
			<div class="container" id="users-form">
				<h1>Create User</h1>
				<?php

					//server info
					$servername = "localhost";
					$username = "team02";
					$password = "thunderscore";
					$dbname = "team02";




					//store progress data
					if (isset($_POST["addUser"])){
					  // "submit" clicked
						// Create connection
						$conn = new mysqli($servername, $username, $password, $dbname);
						// Check connection
						if ($conn -> connect_error) {
							die("Connection failed: " . $conn->connect_error);
						} 
						//create a random salt with 10 digits
						$salt = mcrypt_create_iv(10, MCRYPT_DEV_RANDOM);
						//add salt to start of string on user made input
						$password = hash ( 'sha256', $salt.$_POST["userPassword"]);
						//stores variables for easy storage and editing
						$name = $_POST["userName"];
						$email = $_POST["userEmail"];
						$role = $_POST["userRole"];
						//sql to insert new user if email hasnt been used, and update old user if email has been used
						$sql_store = "INSERT INTO Users (Name, Email, Password, Salt, Role)
							values ('$name','$email','$password','$salt','$role') ON DUPLICATE KEY UPDATE Password = '$password', Salt = '$salt', Role = '$role';";
						//runs sql
						if ($conn->query($sql_store) === TRUE) {
							echo '<div id="validation" class="alert alert-success" role="alert">New Account created successfully.</div>';
						} else {	
							echo '<div id="validation" class="alert alert-warning" role="alert">Error: ' . $sql_store . "<br>" . $conn->error . "<br>";
						}
					}
					elseif (isset($_POST["delUser"])){
						// "delete" clicked
						// Create connection
						$conn = new mysqli($servername, $username, $password, $dbname);
						// Check connection
						if ($conn -> connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}
						$email = $_POST["userEmail"];
						//SQL to delete user
						$sql_store = "DELETE FROM Users WHERE Email = '$email';";
						if ($conn->query($sql_store) === TRUE) {
							echo '<div id="validation" class="alert alert-success" role="alert">' . $email . "'s account was deleted successfully.</div>";
						} else {	
							echo '<div id="validation" class="alert alert-warning" role="alert">Error: ' . $sql_store . "<br>" . $conn->error . "</div>";
						}
					}
				?>
				<!-- form for input of Users data -->
				<form method="post" action="users.php">
					<div class="form-group">
						<label for="userName">Name</label>
						<input type="text" class="form-control" id="userName" name="userName" placeholder="Enter user's name">
					</div>
					<div class="form-group">
						<label for="userPassword">Password</label>
						<input type="password" class="form-control" id="userPassword" name="userPassword" aria-describedby="passwordHelp" placeholder="Password">
						<small id="passwordHelp" class="form-text text-muted">Case Sensitive</small>
					</div>
					<div class="form-group">
						<label for="userEmail">Email</label>
						<input type="email" class="form-control" id="userEmail" name="userEmail" placeholder="Enter user's email">
					</div>
					<div class="form-group">
					<label for="exampleFormControlSelect1">Example select</label>
						<select class="form-control" id="userRole" name="userRole">
							<option value="Admin">Admin</option>
							<option value="Trainer">Trainer</option>
							<option value="Client">Client</option>
						</select>
					</div>
					<button type="submit" id="addUser"  name="addUser" class="btn btn-primary">Submit</button>
					<button type="submit" id="delUser" name="delUser" class="btn btn-default">Delete</button>
				</form>				
			</div>
		</div>
	</main>

</body>
</html>
<?php
} else { header("location:index.php"); }
?>