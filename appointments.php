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
	#appointments {
		padding-top: 15%;
	}
	#appointments-form {
		padding: 20px;
		background-color: rgba(0,0,0,0.75);
		color: #FFFFFF;
	}
	table {
		margin-top: 30px;
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
PHP: appointments
Bootstrap is used for UI
	 This PHP file is where clients and trainers sign up for workouts.
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
	//Redirects to login if not logged in
	header("location:login.php");	
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
						<a class="nav-link active" href="appointments.php">Make Appointment</a>
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

	<main class="container">
		<div id="appointments" class="col-xs-12 col-sm-10 offset-sm-1 col-md-12 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
			<div class="container" id="appointments-form">
				<h1>Appointments</h1>
				<p>
				<?php
				/*
				ITEC 370
				Author(s): Chris Blankenship, Jacob Miller
				Last Edit: 12/6/2017
				PHP: MakeAppointment
					 This PHP file creates a connection to the database, and pulls and stores data to the Appointments table.
				*/
				
				//Shows different text based on which role is chosen.
				if($_SESSION['Role'] == 'Trainer'){
					echo "Role: Trainer (Enter in full Client Name and Date of Appointment.)<br>";
					echo "To cancel an appointment, enter in full Client Name and Date, then click cancel.<br>";
					echo "To view all appointments for your schedule, simply hit view.";
				}
				if($_SESSION['Role'] == 'Client'){
					echo "Role: Client (Enter in  full Trainer Name and Date of Appointment.)";
					echo "To cancel an appointment, enter in full Trainer Name and Date, then click cancel.<br>";
					echo "To view all appointments for your schedule, simply hit view.";
				}
				if($_SESSION['Role'] == 'Admin'){
					echo "Role: Admin (Enter in Full Names of both Trainer and Client.)";
					echo "To cancel an appointment, enter in full name of both Client and Trainer along with the Date, then click cancel.<br>";
					echo "To view all appointments for your schedule, simply hit view.";
				}
				?>
				</p>
				
				<?php
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
					//store progress data
					if (isset($_POST["cancel"])){

					  // "cancel" clicked, roles change what data is accessed
					  if($_SESSION['Role'] == 'Trainer'){
						  //checking if fields are filled
						  if($_POST["date"] > 01-01-0000 && isset($_POST["cname"])){
							  //cancels the appointment
								$sql_cancel = "UPDATE Appointments SET Status = 'canceled' WHERE CName = '" .$_POST["cname"]. "' and TName = '" . $SESSION['Name'] . "' and Date = '".$_POST["date"]. "';";
							  if ($conn->query($sql_cancel) === TRUE) {
									echo '<div id="validation" class="alert alert-success" role="alert">New record created successfully.</div>';
								} else {	
									echo '<div id="validation" class="alert alert-danger" role="alert">Error: ' . $sql_store . "<br>" . $conn->error . "</div>";
								}
						  }
						  else
							  echo '<div id="validation" class="alert alert-warning" role="alert ">Not all fields filled, please enter Client and Trainer name with a Date.</div>';
						}
						if($_SESSION['Role'] == 'Client'){
							//checking if fields are filled
							if($_POST["date"] > 01-01-0000 && isset($_POST["tname"])){
							//cancels the appointment
							$sql_cancel = "UPDATE Appointments SET Status = 'canceled' WHERE CName = '" . $_SESSION['Name'] . "' and TName = '" . $_POST["tname"] . "' and Date = '" . $_POST["date"] . "';";
							if ($conn->query($sql_cancel) === TRUE) {
									echo '<div id="validation" class="alert alert-success" role="alert">New record created successfully.</div>';
								} else {	
									echo '<div id="validation" class="alert alert-danger" role="alert">Error: ' . $sql_store . "<br>" . $conn->error . "</div>";
								}
							}
							else
								echo '<div id="validation" class="alert alert-warning" role="alert">Not all fields filled, please enter Client and Trainer name with a Date.</div>';
						}
						if($_SESSION['Role'] == 'Admin'){
							//checking if fields are filled
							if($_POST["date"] > 01-01-0000 && isset($_POST["cname"]) && isset($_POST["tname"])){
								 //cancels the appointment
								$sql_cancel = "UPDATE Appointments SET Status = 'canceled' WHERE CName = '" . $_POST["cname"] . "' and TName = '" . $_POST["tname"] . "' and Date = '" . $_POST["date"] . "';";
									if ($conn->query($sql_cancel) === TRUE) {
										echo '<div id="validation" class="alert alert-success" role="alert">New record created successfully.</div>';
									} else {	
										echo '<div id="validation" class="alert alert-danger" role="alert">Error: ' . $sql_store . "<br>" . $conn->error . "</div>";
									}
							}
							else
								echo '<div id="validation" class="alert alert-warning" role="alert">Not all fields filled, please enter Client and Trainer name with a Date.</div>';
						}
					}

					//store progress data
					if (isset($_POST["submit"])){
					  // "submit" clicked, data inputted changes based on role
					  if($_SESSION['Role'] == 'Trainer'){
						  //checking if fields are filled
						  if($_POST["date"] > 01-01-0000 && !empty($_POST["cname"])){
							  //Stores the appointment data
						  $sql_store = "INSERT INTO Appointments values ('".$_POST["cname"]."','" . $_SESSION['Name'] . "','".$_POST["date"]."', 'scheduled');";
							  if ($conn->query($sql_store) === TRUE) {
									echo '<div id="validation" class="alert alert-success" role="alert">New appointment created successfully.</div>';
								} else {	
									echo '<div id="validation" class="alert alert-danger" role="alert">Error: ' . $sql_store . "<br>" . $conn->error . "</div>";
								}
						  }
						  else
							  echo '<div id="validation" class="alert alert-warning" role="alert">Not all fields filled, please enter Client and Trainer name with a Date.</div>';
					  }
					  if($_SESSION['Role'] == 'Client'){
						  //checking if fields are filled
						  if($_POST["date"] > 01-01-0000 && !empty($_POST["tname"])){
							  //stores the appointment data
							$sql_store = "INSERT INTO Appointments values ('" . $_SESSION['Name'] . "','" . $_POST["tname"] . "','" . $_POST["date"] . "', 'scheduled');";
							  if ($conn->query($sql_store) === TRUE) {
									echo '<div id="validation" class="alert alert-success" role="alert">New appointment created successfully.</div>';
								} else {	
									echo '<div id="validation" class="alert alert-danger" role="alert">Error: ' . $sql_store . "<br>" . $conn->error . "</div>";
								}
						  }
						  else
							  echo '<div id="validation" class="alert alert-warning" role="alert">Not all fields filled, please enter Client and Trainer name with a Date.</div>';
						}
						if($_SESSION['Role'] == 'Admin'){
							//checking if fields are filled
							if($_POST["date"] > 01-01-0000 && !empty($_POST["tname"]) && !empty($_POST["cname"])){
								//stores the appointment data
							$sql_store = "INSERT INTO Appointments values ('" . $_POST["cname"] . "','" . $_POST["tname"] . "','" . $_POST["date"] . "', 'scheduled');";
								if ($conn->query($sql_store) === TRUE) {
									echo '<div id="validation" class="alert alert-success" role="alert">New appointment created successfully.</div>';
								} else {	
									echo '<div id="validation" class="alert alert-danger" role="alert">Error: ' . $sql_store . "<br>" . $conn->error . "</div>";
								}
							}
							else
								echo '<div id="validation" class="alert alert-warning" role="alert">Not all fields filled, please enter Client and Trainer name with a Date.</div>';
						}
					}
					?>				
				<!-- form group for the appointments page -->
				<form class="col-6 offset-3" method="post" action="appointments.php">
					<div class="form-group">
						<label for="cname">Client Name</label>
						<input type="text" class="form-control" id="cname" name="cname" placeholder="Enter client's name">
					</div>
					<div class="form-group">
						<label for="tname">Trainer Name</label>
						<input type="text" class="form-control" id="tname" name="tname" placeholder="Enter trainer's name">
					</div>
					<div class="form-group">
						<label for="date">Date</label>
						<input type="date" class="form-control" id="date" name="date" placeholder="Select Date">
					</div>
					<button type="submit" id="submit"  name="submit" class="btn btn-primary">Submit</button>
					<button type="submit" id="view"  name="view" class="btn btn-default">View</button>
					<button type="submit" id="cancel" name="cancel" class="btn btn-default">Cancel</button>
				</form>
				
				<?php
				// View all progress data
					if(isset($_POST["view"])){
						//"view" clicked, Role changes what data can be seen.
						if($_SESSION['Role'] == 'Client'){
							$sql = "SELECT * FROM Appointments WHERE CName =  '" . $_SESSION['Name'] . "' ORDER BY Date DESC;";
						}
						if($_SESSION['Role'] == 'Trainer'){
							$sql = "SELECT * FROM Appointments WHERE TName =  '" . $_SESSION['Name'] . "' ORDER BY Date DESC;";
						}
						//Admins have more options to see which appointments are on specific days or users
						if($_SESSION['Role'] == 'Admin'){
							$vtname = $_POST['tname'];
							$vcname = $_POST['cname'];
							$vdate = $_POST[date]; 
							if($vtname == '' && $vcname == '' && $vdate == ''){
								$sql = "SELECT * FROM Appointments ORDER BY Date DESC;";
							} else if ($vtname == '' && $vdate == '') {
								$sql = "SELECT * FROM Appointments WHERE CName = '$vcname' ORDER BY Date DESC;";
							}else if ($vcname == '' && $vdate == '') {
								$sql = "SELECT * FROM Appointmen ts WHERE TName =  $vtname ORDER BY Date DESC;";
							} else if($vtname == '' && $vcname == ''){
								$sql = "SELECT * FROM Appointments WHERE Date = '" . $_POST['date'] . "' ORDER BY Date DESC;";
							} else if ($_POST['tname'] == '') {
								$sql = "SELECT * FROM Appointments WHERE CName =  '" . $_POST['cname'] . "' WHERE Date = '" . $_POST['date'] . "' ORDER BY Date DESC;";
							} else if ($_POST['cname'] == '') {
								$sql = "SELECT * FROM Appointments WHERE TName =  '" . $_POST['tname'] . "' AND Date = '" . $_POST['date'] . "' ORDER BY Date DESC;";
							} else if ($_POST['date'] == '') {
								$sql = "SELECT * FROM Appointments WHERE TName =  '" . $_POST['tname'] . "' AND CName == '" . $_POST['cname'] . "' ORDER BY Date DESC;";
							} else {
								$sql = "SELECT * FROM Appointments WHERE TName =  '" . $_POST['tname'] . "' AND CName == '" . $_POST['cname'] . "' AND Date = '" . $_POST['date'] . "' ORDER BY Date DESC;";
							}
						}
						//saves table from query to $result
						$result = $conn->query($sql);


						if ($result->num_rows > 0) {
							//sets up table
							echo '<table class="table table-striped table-dark"><thead><tr><th scope="col">Client Name</th><th scope="col">Date</th><th scope="col">Trainer Name</th><th scope="col">Status</th></tr></thead><tbody>';
							// Loop to output data of each row
							while($row = $result->fetch_assoc()) {
								echo "<tr> <td>" . $row["CName"]. "</td> <td>" . $row["Date"] . "</td> <td>" . $row["TName"] . "</td> <td>" . $row["Status"] ."</td> </tr>";
							}
							echo "</tbody></table>";
						} else {
							echo "<p>No results to display.</p>";
						}
						//Close connection
						$conn->close();


					}
				?>
			</div>
		</div>
	</main>

</body>
</html>