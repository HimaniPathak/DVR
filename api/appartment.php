<?php 
include "./apiauth.php";
include "./../connection.php";
/**
 * 
 */
class Appartment
{
	private $conn;

	function __construct( )
	{
		$this->conn = DtabaseConnection::connectDB();
	}

	public function getall(){
		
		$sql = "SELECT * FROM appartment";
		$result = $this->conn->query($sql);
		$appartmets = null;
		while($row = $result->fetch_assoc()){
			$appartmets[] = $row;	
		}
		return json_encode($appartmets);

	}

	public function get($id){
		
		$sql = "SELECT * FROM appartment WHERE `id` = '$id'";
		$result = $this->conn->query($sql);
		if($result->num_rows >0 )
			return json_encode($result->fetch_assoc());
		else
			echo json_encode(['error'=>'No Data Found','code'=>404]);

	}


}



$Appartment = new Appartment();

if( isset( $_POST['id'] ) ) 
	echo $Appartment->get( $_POST['id'] );	
else
	echo $Appartment->getAll();


















