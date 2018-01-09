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
	table {
		margin-top: 30px;
	}
	#appointments {
		padding-top: 15%;
	}
	#appointments-form {
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
PHP: data
Bootstrap is used for UI
	 This PHP file is where users log their workout data.
*/

//Variables to determine logged in user and role.
$isLoggedIn = false;
$isClient = false;
$isTrainer = false;
$isAdmin = false;

//Starts session and checks for Role, returns to login if not logged in.
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
} else {
	//Redirects to appointments if not logged in
	header("location:appointments.php");	
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
						<a class="nav-link active" href="data.php">Data</a>
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

	<main class="container">
		<div id="appointments" class="col-12">
			<div class="container" id="appointments-form">
				<h1>Data</h1>
				<p>
				<?php
					/*
					ITEC 370
					Author(s): Chris Blankenship, Jacob Miller
					Last Edit: 12/6/2017
					PHP: TH_
						 This PHP file creates a connection to the database, and pulls and stores data to the Progress table.
					*/

					// Database connection variables
					$servername = "localhost";
					$username = "team02";
					$password = "thunderscore";
					$dbname = "team02";

					// Create connection
					$conn = new mysqli($servername, $username, $password, $dbname);

					// Check connection
					if ($conn -> connect_error) {
						die("Connection failed: " . $conn->connect_error);
					} 

					// Grab Progress table data for logged in user
					// ***Possible change for readability: SELECT * rather than SELECT ... ... would need to retest to make sure code behaves the same
					$sql = "SELECT Name, Date, HRStart, HRDuring, HRAfter, BPressure, weight, height, BMI, Thigh, Upper, Arm, Shoulder, Waist, Hip, WHRatio, Flexibility, Squat, Bench, Deadlift, Notes FROM Progress WHERE Name = '" . $_SESSION["Name"] . "';";



					// store progress data on submit click
					if (isset($_POST["submit"])){
						// Validate date
						if($_POST["date"] > 01-01-0000){
							// Store data from webpage if the role is client. Name will come from session info.
							if($_SESSION['Role'] == 'Client'){
								$sql_store = "INSERT INTO Progress (Name, Date, HRStart, HRDuring, HRAfter, BPressure, weight, height, BMI, Thigh, Upper, Arm, Shoulder, Waist, Hip, WHRatio, Flexibility, Squat, Bench, Deadlift, Notes)
								values ('" . $_SESSION['Name'] . "','" . $_POST["date"] . "','" . $_POST["hrstart"] . "','" . $_POST["hrduring"] . "','" .  $_POST["hrafter"] .
								"','" .  $_POST["bp"] . "','"  .  $_POST["weight"] . "','" .  $_POST["height"] . "','" .  $_POST["BMI"] . "','" .  $_POST["thigh"] . "','" .  $_POST["upper"] . "'
								,'" .  $_POST["arm"] . "','" .  $_POST["shoulder"] . "','" .  $_POST["waist"] . "','" .  $_POST["hip"] . "','" .  $_POST["whratio"] . "','" . $_POST["flex"] . "','" .  $_POST["squat"] . "'
								,'" .  $_POST["bench"] . "','" .  $_POST["dl"] . "','" .  $_POST["notes"] . "');";
							}
							// Store data from webpage if the role is Admin or Trainer. Name will come from user input.
							else{
								$sql_store = "INSERT INTO Progress (Name, Date, HRStart, HRDuring, HRAfter, BPressure, weight, height, BMI, Thigh, Upper, Arm, Shoulder, Waist, Hip, WHRatio, Flexibility, Squat, Bench, Deadlift, Notes)
								values ('" . $_POST["name"] . "','" . $_POST["date"] . "','" . $_POST[hrstart] . "','" . $_POST["hrduring"] . "','" .  $_POST["hrafter"] .
								"','" .  $_POST["bp"] . "','"  .  $_POST["weight"] . "','" .  $_POST["height"] . "','" .  $_POST["BMI"] . "','" .  $_POST["thigh"] . "','" .  $_POST["upper"] . "'
								,'" .  $_POST["arm"] . "','" .  $_POST["shoulder"] . "','" .  $_POST["waist"] . "','" .  $_POST["hip"] . "','" .  $_POST["whratio"] . "','" . $_POST["flex"] . "','" .  $_POST["squat"] . "'
								,'" .  $_POST["bench"] . "','" .  $_POST["dl"] . "','" .  $_POST["notes"] . "');";
							}

							// Feedback on store
							if ($conn->query($sql_store) === TRUE) {
								echo '<div id="validation" class="alert alert-danger" role="alert">New Progress Sheet created successfully.</div>';
							} else {	
								echo '<div id="validation" class="alert alert-danger" role="alert">Error: ' . $sql_store . "<br>" . $conn->error . "</div>";
								// ***Possible cleanup for better user debug: Give output rather than database error.
							}
						}
						else{ 
							echo '<div id="validation" class="alert alert-danger" role="alert">Incorrect Date';
						}
					}
				?>
				<!-- Lots of table rows and columns with form-->
				<form class="row" method="post" action="data.php">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
						</div>
						<div class="form-group">
							<label for="date">Date</label>
							<input type="date" class="form-control" id="date" name="date" placeholder="Select Date">
						</div><br/>
						<div class="form-group">
							<label for="hrstart">Initial Heart Rate</label>
							<input type="text" class="form-control" id="hrstart" name="hrstart" placeholder="Initial Heart Rate">
						</div>
						<div class="form-group">
							<label for="hrduring">Exercise Heart Rate</label>
							<input type="text" class="form-control" id="hrduring" name="hrduring" placeholder="Heart Rate while Exercising">
						</div>
						<div class="form-group">
							<label for="hrafter">Recovery Heart Rate</label>
							<input type="text" class="form-control" id="hrafter" name="hrafter" placeholder="Heart Rate while Recovering">
						</div><br/>
						<div class="form-group">
							<label for="bp">Blood Pressure</label>
							<input type="text" class="form-control" id="bp" name="bp" placeholder="Blood Pressure">
						</div><br/>
						<div class="form-group">
							<label for="height">Height</label>
							<input type="text" class="form-control" id="height" name="height" placeholder="Height">
						</div>
						<div class="form-group">
							<label for="weight">Weight</label>
							<input type="text" class="form-control" id="weight" name="weight" placeholder="Weight">
						</div>
						<div class="form-group">
							<label for="BMI">BMI</label>
							<input type="text" class="form-control" id="BMI" name="BMI" placeholder="BMI">
						</div>
						<div class="form-group">
							<label for="flex">Flexibility</label>
							<input type="text" class="form-control" id="flex" name="flex" placeholder="Flexibility">
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
						<div class="form-group">
							<label for="thigh">Thigh Circumference</label>
							<input type="text" class="form-control" id="thigh" name="thigh" placeholder="Thigh Circumference">
						</div>
						<div class="form-group">
							<label for="upper">Upper Circumference</label>
							<input type="text" class="form-control" id="upper" name="upper" placeholder="Upper Circumference">
						</div>
						<div class="form-group">
							<label for="arm">Arm Circumference</label>
							<input type="text" class="form-control" id="arm" name="arm" placeholder="Arm Circumference">
						</div>
						<div class="form-group">
							<label for="shoulder">Shoulder Circumference</label>
							<input type="text" class="form-control" id="shoulder" name="shoulder" placeholder="Shoulder Circumference">
						</div>
						<div class="form-group">
							<label for="waist">Waist Circumference</label>
							<input type="text" class="form-control" id="waist" name="waist" placeholder="Waist Circumference">
						</div>
						<div class="form-group">
							<label for="hip">Hip Circumference</label>
							<input type="text" class="form-control" id="hip" name="hip" placeholder="Hip Circumference">
						</div>
						<div class="form-group">
							<label for="whratio">W/H Ratio</label>
							<input type="text" class="form-control" id="whratio" name="whratio" placeholder="W/H Ratio">
						</div><br/>
						<div class="form-group">
							<label for="squat">Squat</label>
							<input type="text" class="form-control" id="squat" name="squat" placeholder="Squat">
						</div>
						<div class="form-group">
							<label for="bench">Bench</label>
							<input type="text" class="form-control" id="bench" name="bench" placeholder="Bench">
						</div>
						<div class="form-group">
							<label for="dl">Deadlift</label>
							<input type="text" class="form-control" id="dl" name="dl" placeholder="Deadlift">
						</div>
					</div>
					<div class="col-12">
						<div class="form-group">
							<label for="notes">Notes</label>
							<textarea class="form-control" id="notes" name="notes" rows="4"></textarea>
						</div>
					</div>
					<div class="col-12" style="text-align: center">
						<button type="submit" id="submit"  name="submit" class="btn btn-primary">Submit</button>
						<button type="submit" id="view"  name="view" value="View" class="btn btn-default">View</button>
						<button type="button" id="home" name="home" onClick="location.href='index.php'" class="btn btn-default">Cancel</button>
					</div>
				</form>
				
				<?php
					// View all progress data
					if(isset($_POST["view"])){

						// Create SQL statement based on role
						// If client role, grab name from session, otherwise grab from user input.
						if($_SESSION['Role'] == 'Client'){
							$sql = "SELECT * FROM Progress WHERE Name = '" . $_SESSION['Name'] . "';";
						}
						else
						{
							$sql = "SELECT * FROM Progress WHERE Name = '" . $_POST["name"] . "';";
						}

						// Perform pull
						$result = $conn->query($sql);

						if ($result->num_rows > 0) {	
							//Echoes a table in HTML with headers
							echo '<div style="overflow-x: scroll;"><table class="table table-striped table-dark"><thead><tr><th scope="col">Name</th><th scope="col">Date</th><th scope="col">Heart Rate Initial</th><th scope="col">Heart Rate During</th>'.
							'<th scope="col">Heart Rate Recovery</th><th scope="col">Blood Pressure</th><th scope="col">Weight</th><th scope="col">Height</th><th scope="col">BMI</th>'.
							'<th scope="col">Thigh Circumference</th><th scope="col">Upper Body Circumference</th><th scope="col">Arm Circumference</th><th scope="col">Shoulder'.
							'Circumference</th><th scope="col">Waist Circumference</th><th scope="col">Hip Circumference</th><th scope="col">Waist to Hip Ratio</th>'.
							'<th scope="col">Flexibility</th><th scope="col">Bench Press</th><th scope="col">Squat</th><th scope="col">Deadlift</th><th scope="col">Notes</th></tr></thead><tbody>';
							// Output data of each row
							while($row = $result->fetch_assoc()) {
								//Echoes output data in columns under the labels for each
								echo "<tr><td>" . $row["Name"]. "</td> <td>" . $row["Date"] . "</td><td>" . numOut($row["HRStart"]) .  
								"</td><td>" . numOut($row["HRDuring"]) .  "</td><td>" . numOut($row["HRAfter"]) . 
								 "</td><td>" . numOut($row["BPressure"]) .  "</td><td>" . numOut($row["Weight"]) .  " lbs</td><td>" . numOut($row["Height"]) . 
								  " in</td><td>" . numOut($row["BMI"]) . "</td><td>" . numOut($row["Thigh"]) . " </td><td> " . numOut($row["Upper"]) .
								  " </td><td>" . numOut($row["Arm"]) . "</td><td> " . numOut($row["Shoulder"]) . "</td><td>" .
								  numOut($row["Waist"]) . "</td><td>" . numOut($row["Hip"]) . "</td><td>" . numOut($row["WHRatio"]) . 
								  " </td><td> " . numOut($row["Flexibility"]) . "</td><td>" . numOut($row["Bench"]) . "</td><td> " . numOut($row["Squat"]) . 
								  " </td><td>" . numOut($row["Deadlift"]) . "</td><td> " . $row["Notes"] . "<br>";
							}
							echo "</tbody></table></div>";
						} else {
							echo "<p>No Results to Display.</p>";
						}
						//Close connection
						$conn->close();
					}
					//Function to output N/A instead of 0 if no data is inputted
					function numOut($input)
					{
						if ($input == 0){
							$output = 'N/A';
						} else {
							$output = $input;
						}
						return $output;
					}
				?>
			</div>
		</div>
	</main>

</body>
</html>