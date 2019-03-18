<?php 
include "./apiauth.php";
include "./../connection.php";

class Visitors {

	private $conn;

	function __construct( )
	{
		$this->conn = DtabaseConnection::connectDB();
	}


	public function getByEmail($email) {
		
		$sql = "SELECT * FROM t_visitorinformation WHERE `email` = '$email'";
		$result = $this->conn->query($sql);
		if($result->num_rows >0 )
			return json_encode($result->fetch_assoc());
		else
			echo json_encode(['error'=>'No Data Found','code'=>404]);

	}

	public function getByMobile($mobile) {
		
		$sql = "SELECT * FROM t_visitorinformation WHERE `mobile` = '$mobile'";
		$result = $this->conn->query($sql);
		if($result->num_rows >0 )
			return json_encode($result->fetch_assoc());
		else
			echo json_encode(['error'=>'No Data Found','code'=>404]);

	}


}

$Visitor  = new Visitors();

if ( isset($_POST['email']) )
	echo $Visitor->getByEmail($_POST['email']);
else if( isset($_POST['mobile']))
	echo $Visitor->getByMobile($_POST['mobile']);
else
	echo json_encode(['error'=>'no method found ','code'=>404]);







