<?php
	// credentials needed to connect to database
	$server = "localhost";
	$username = "cxnsxle";
	$password = "cxnsxle0206";
	$database = "cxnsxledb";

	// control connection to database
	$conn = new mysqli($server, $username, $password, $database);

	// enabling scaping feature
	$id = mysqli_real_escape_string($conn, $_GET['id']);

	// retrieving data from database
	$data = mysqli_query($conn, "select username from users where id=$id");
	// formatting query response
	$response = mysqli_fetch_array($data);

	// verifying response content in the 'username' column
	if (!isset($response['username'])) {
		http_response_code(404);
	}

?>
