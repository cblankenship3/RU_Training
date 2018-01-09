<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Helpful Links &bull; Fitness and Wellness</title> <!-- Title for the tab and website -->

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
	#content {
		padding-top: 15%;
	}
	#content-wrapper {
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
Last Edit: 12/6/2017
PHP: links
Bootstrap is used for UI
	 This PHP file is the page for useful links outside of this site.
*/
	
//Variables to determine logged in user and role.
$isLoggedIn = false;
$isClient = false;
$isTrainer = false;
$isAdmin = false;
	
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
					<a class="nav-link active" href="links.php">Helpful Links</a>
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
	<!-- Contains links to other sites -->
	<main class="container">
		<div id="content" class="col-12">
			<div class="container" id="content-wrapper">
				<h1>Helpful Links</h1>
				<p><a href="http://www.radford.edu/content/radfordcore/home.html">Radford University Main Page</a></p>
				<p><a href="https://www.radford.edu/content/recreation/home/facilities/rec-center/hours.html">Student Wellness Center Hours </a></p>
				<p><a href="https://www.radford.edu/content/recreation/home/wellness/group-x-program/fitness-classes.html">Student Wellness Classes </a></p>
				<p><a href="index.php">Home</a></p>
			</div>
		</div>
	</main>

</body>
</html>