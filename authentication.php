<?php 

include "./connection.php";
/**
 * 
 */
class AdminAuth 
{
	
	function __construct()
	{
		# code...
	}

	static public function getLogin($username,$password) {

		$connectionInstant = DtabaseConnection::connectDB();

		$sql = "SELECT * FROM users where `username` = '$username' and `password`='$password'";
		$result = $connectionInstant->query($sql);
		$connectionInstant->close();
		
		if ($result->num_rows > 0){
			$row = $result->fetch_assoc();
		    $_SESSION["userid"] = $row["id"];
		    return true;
		}
		else
			return false;
	
	}


}


?>