<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "./apiauth.php";
include "./../connection.php";

class Room {
	
	private $conn;

	function __construct( )
	{
		$this->conn = DtabaseConnection::connectDB();
	}
	
	public function getRoomByApartment( $apartmentId ) {
		
		$sql = "SELECT * FROM rooms WHERE `apartment_id` = '$apartmentId'";
		$result = $this->conn->query($sql);
		$rooms = null;
		while($row = $result->fetch_assoc()){
			$rooms[] = $row;	
		}
		if( $rooms == null )
			return json_encode(['msj'=>'No Data Found','code'=>404]);
		else 
			return json_encode($rooms);
	}

}

$roomObject = new Room();

if ( isset($_POST['apartment_id']) )
	echo $roomObject->getRoomByApartment($_POST['apartment_id']);
else
	echo json_encode(['error'=>'no method found ','code'=>404]);