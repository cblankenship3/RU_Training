<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Login &bull; Fitness and Wellness</title> <!-- Title for the tab and website -->

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
	#login {
		padding-top: 15%;
	}
	#login-form {
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
PHP: login
Bootstrap is used for UI
	 This PHP file is the login page of the website.
*/
	
//Variables to determine logged in user and role.
$isLoggedIn = false;
$isClient = false;
$isTrainer = false;
$isAdmin = false;
	
//Starts session and checks for Role
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
						<a class="nav-link" href="users.php">Create User</a>
					</li>';
				}
				if($isLoggedIn) {
					echo '<li class="nav-item">
						<a class="nav-link" href="logout.php">Logout</a>
					</li>';
				} else {
					echo '<li class="nav-item">
						<a class="nav-link active" href="login.php">Login</a>
					</li>';
				}
			?>
			</ul>
		</div>
	</nav>

	<main class="container">
		<div id="login" class="col-xs-12 col-sm-10 offset-sm-1 col-md-6 offset-md-3 col-lg-4 offset-lg-4 col-xl-4 offset-xl-4">
			<div class="container" id="login-form">
				<h1>Login</h1>
				<p>Please enter your login credentials.</p>
				<?php
				/*
				ITEC 370
				Author(s): Chris Blankenship, Jacob Miller
				Last Edit: 12/6/2017
				PHP: SignIn
					 This PHP file creates a connection to the database, and creates a session if the user can provide valid credentials.
				*/

					// Start Session
					session_start();
					echo $_SESSION['Message'];

					// Database connection variables
					$servername = "localhost";
					$username = "team02";
					$password = "thunderscore";
					$dbname = "team02";

					// Check credentials on submit
					if (isset($_POST["submitLogin"])){
						// Create connection
						$conn = new mysqli($servername, $username, $password, $dbname);

						// Check connection
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						} 

						// Store user input
						$myemail = $_POST["userEmail"];
						$mypassword=$_POST["userPassword"];

						// Grab info for email provided
						$sql = "SELECT * FROM Users WHERE Email = '$myemail';";
						$result	= $conn->query($sql);

						// If the email exists in the database check the password for it.
						IF ($conn && ($result->num_rows > 0))
						{
							// Create variables for user info
							WHILE($row = $result->fetch_assoc())
							{
								$salt = $row["Salt"];
								$checkPassword = $row["Password"];
								$sessName = $row['Name'];
								$sessRole = $row['Role'];
								$sessEmail = $row['Email'];
							}
						}

						// Run user password input through hash function
						$myHpassword = hash('sha256', $salt.$mypassword);

						// Compare user password input (hashed) to Database pass
						if ($myHpassword == $checkPassword) {
							// Successfull login
							// Store user info from database in session and redirect
							session_start();
							echo $sessRole;
							$_SESSION['Name'] = $sessName;
							$_SESSION['Role'] = $sessRole;
							$_SESSION['Email'] = $sessEmail;
							$_SESSION['Message'] = "";
							header("location:index.php");
						}
						else {
							// Bad email or password.
							echo '<div id="validation" class="alert alert-warning" role="alert">Invalid Email / Password</div>';
						}

					}	
				?>
				<!-- form for login -->
				<form method="post" action="login.php">
					<div class="form-group">
						<label for="userEmail">Email</label>
						<input type="email" class="form-control" id="userEmail" name="userEmail" aria-describedby="emailHelp" placeholder="Enter email">
						<small id="emailHelp" class="form-text text-muted">Enter your registered email address.</small>
					</div>
					<div class="form-group">
						<label for="userPassword">Password</label>
						<input type="password" class="form-control" id="userPassword" name="userPassword" aria-describedby="passwordHelp" placeholder="Password">
						<small id="passwordHelp" class="form-text text-muted">Case Sensitive</small>
					</div>
					<button type="submit" id="submitLogin"  name="submitLogin" class="btn btn-primary">Submit</button>
					<button type="button" id="cancelLogin" class="btn btn-default" onClick="location.href='index.php'">Cancel</button>
				</form>
			</div>
		</div>
	</main>

</body>
</html>