<?php
/*
ITEC 370
Author(s): Jacob Miller, Christopher Blankenship
Last Edit: 12/6/2017
PHP: logout
	 This PHP destroys the session, essentially logging the user out of the system. It redirects to the sign in page after.
*/
session_start();
session_destroy();
header("location:login.php");
?>