<?php

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "amore"; 

$conn = mysqli_connect($servername, $username, $password, $dbname);
$conn2 = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!$conn2) {
    die("Connection failed: " . mysqli_connect_error());
}


/*
switch ($_SERVER['SERVER_NAME']) {
	case "amore.negoit.net":
		$conn = mysqli_connect('localhost', 'negodev_dbuser', 'dev&T2180', 'hotel_amore');
		$conn2 = mysqli_connect('localhost', 'negodev_dbuser', 'dev&T2180', 'hotel_amore');
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		break;
	
	case "amorebeach.com":
		$conn = mysqli_connect('localhost', 'negodev_dbuser', 'dev&T2180', 'hotel_amore');
		$conn2 = mysqli_connect('localhost', 'negodev_dbuser', 'dev&T2180', 'hotel_amore');
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		break;
	
	case "www.amorebeach.com":
		$conn = mysqli_connect('localhost', 'negodev_dbuser', 'dev&T2180', 'hotel_amore');
		$conn2 = mysqli_connect('localhost', 'negodev_dbuser', 'dev&T2180', 'hotel_amore');
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		break;	

	case "dev.amorebeach.com":
		$conn = mysqli_connect('localhost', 'negodev_dbuser', 'dev&T2180', 'hotel_amore');
		$conn2 = mysqli_connect('localhost', 'negodev_dbuser', 'dev&T2180', 'hotel_amore');
		if (mysqli_connect_errno()) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		break;
}
*/
?>