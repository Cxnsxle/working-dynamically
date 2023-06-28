<?php
	// credentials needed to connect to database
	$server = "localhost";
	$username = "cxnsxle";
	$password = "cxnsxle0206";
	$database = "cxnsxledb";

	// control connection to database
	$conn = new mysqli($server, $username, $password, $database);

	$id = $_GET['id'];

	// retrieving data from database
	$data = mysqli_query($conn, "select username from users where id='$id'") or die(mysqli_error($conn));
	// formatting query response
	$response = mysqli_fetch_array($data);
	echo $response['username'];
?>
