<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Home &bull; Fitness and Wellness</title> <!-- Title for the tab and website -->

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
		background-image:url(Weights.jpg);
		background-position: center;
		background-size: cover;
		font-family: "Lato", sans-serif;
	}
	h1,h2,h3,h4,h5,h6 {
		font-family: "Montserrat", sans-serif;
	}
	#welcome {
		margin-top: 30%;
		background-color: rgba(0,0,0,0.75);
		color: #FFFFFF;
		padding-top: 15px;
		padding-bottom: 15px;
	}
</style>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

<?php
/*
ITEC 370
Author(s): Chris Blankenship, Jacob Miller
Last Edit: 12/6/2017
PHP: index
Bootstrap is used for UI
	 This PHP file is this homepage of the website.
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
					<a class="nav-link active" href="index.php">Home</a>
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
						<a class="nav-link" href="login.php">Login</a>
					</li>';
				}
			?>
			</ul>
		</div>
	</nav>
	<!-- Nothing special in here just some welcome text-->
	<main>
		<div id="welcome" class="col-xs-12 col-sm-12 col-md-8 col-lg-6 col-xl-6">
			<h1>Welcome to Radford University Personal Training!</h1>
			<p>This system will be used to store the data of your appointments for your personal trainer. They will be able to manage your appointments and data points (height, weight, body mass index, etc.). This will help keep track of your progress throughout your journey.</p>
		</div>
	</main>

</body>
</html>