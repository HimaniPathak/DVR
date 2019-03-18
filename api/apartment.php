<?php 
include "./apiauth.php";
include "./../connection.php";
/**
 * 
 */
class Apartment
{
	private $conn;

	function __construct( )
	{
		$this->conn = DtabaseConnection::connectDB();
	}

	public function getall(){
		
		$sql = "SELECT * FROM apartment";
		$result = $this->conn->query($sql);
		$apartments = null;
		while($row = $result->fetch_assoc()){
			$apartments[] = $row;	
		}
		return json_encode($apartments);

	}

	public function get($id){
		
		$sql = "SELECT * FROM apartment WHERE `id` = '$id'";
		$result = $this->conn->query($sql);
		if($result->num_rows >0 )
			return json_encode($result->fetch_assoc());
		else
			echo json_encode(['error'=>'No Data Found','code'=>404]);

	}


}



$Apartment = new Apartment();

if( isset( $_POST['id'] ) ) 
	echo $Apartment->get( $_POST['id'] );	
else
	echo $Apartment->getAll();


















