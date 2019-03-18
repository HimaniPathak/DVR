<?php 

class DtabaseConnection {

	var $servername = "localhost";
	var $username = "dvr_user";
	var $password = "dvruser";

	static public function connectDB($dbname = "dvr") {
		// Create connection
		return new mysqli("localhost", "dvr_user", "dvruser",$dbname);
 
	}


}