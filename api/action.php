<?php

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
include $_SERVER["DOCUMENT_ROOT"]."/api/apiauth.php";
include $_SERVER["DOCUMENT_ROOT"]."/databaseMethods.php";

Class Action {

	private $conn;

	function __construct( )
	{ $this->conn = DtabaseConnection::connectDB(); }

	public function createVisitorProfile ($email,$name,$city,$mobile,$address) { // this will create new visitor and return its id  
		$sql = "INSERT INTO t_visitorinformation(`email`,`name`,`city`,`mobile`,`address`) VALUES('$email','$name','$city','$mobile','$address')";
		
		$result = $this->conn->query($sql);
		return $this->conn->insert_id;
	}

	public function checkIn($visitor_id, $apartment, $room_id) {
		
		$checkInAt = date("Y-m-d H:i:s");

		$sql ="INSERT INTO t_visitorinformationhist(`visitor_id`,`apartment_id`,`room_id`,`check_in`) VALUES('$visitor_id','$apartment','$room_id','$checkInAt')";

		$result = $this->conn->query($sql);
		
		$token = $this->conn->insert_id;
		$databasemethod = new DatabaseMethod();
		$databasemethod->sendCheckInMail($visitor_id,$token,$apartment);
		return json_encode( ['success'=>'Check In Done','code'=>200,'checkouttoken'=>$token,'visitor_id'=>$visitor_id] );
	}
	
	
	public function checkinViaOtp($otp) {
		
		$checkInAt = date("Y-m-d H:i:s");
		
		$sql = "SELECT * FROM `t_visitorinformation` WHERE `otp` = '$otp'";		
		$result = $this->conn->query($sql);
		$result = $result->fetch_assoc();
		$visitor_id = $result['id'];
		
		$sql = "SELECT * FROM `t_visitorinformationhist` WHERE `checkout_status` = 0 and `visitor_id`= '$visitor_id'";
		$result = $this->conn->query($sql);
		$result = $result->fetch_assoc();
		$token = $result['id'];
		$apartment = $result['apartment_id'];
		
		$sql = "UPDATE `t_visitorinformationhist` SET `check_in`='$checkInAt' WHERE `checkout_status` = 0 and `visitor_id`= '$visitor_id'";
		$result = $this->conn->query($sql);
		$databasemethod = new DatabaseMethod();
		$databasemethod->sendCheckInMail($visitor_id,$token,$apartment);
		return json_encode( ['success'=>'Check In Done','code'=>200,'checkouttoken'=>$token,'visitor_id'=>$visitor_id] );
		
	}
	

	public function checkOut ( $entryid ) {
		
		$sql = "SELECT * FROM `t_visitorinformationhist` WHERE `id` = '$entryid' ";
		$result = $this->conn->query($sql);
		$result = $result->fetch_assoc();
		
		if( $result['checkout_status'] ) 
			return json_encode( ['success'=>'Already Check Out','check_out'=>$result['check_out'],'code'=>201] );
		else{
			$checkOutAt = date("Y-m-d H:i:s");
			$sql = "UPDATE `t_visitorinformationhist` SET `check_out`='$checkOutAt',`checkout_status`=1 WHERE `id` = '$entryid' ";
			$result = $this->conn->query($sql);
			return json_encode( ['success'=>'Check Out Done','code'=>200] );
		}
		
	}

}



if ( isset($_POST['action']) ) {
	
	$object = new Action();
	
	if( $_POST['action'] == "checkin" )
	{
		
		$apartment = $_POST['apartment'];
		$room_id = $_POST['room_id'];
		if( isset( $_POST['check_in_otp'] ) ) {
		  	
		  	$otp = $_POST['check_in_otp'];
		  	echo $object->checkinViaOtp($otp);
		  	
		}else if( isset( $_POST['visitor_id'] ) ) {
			
			$visitor_id =  $_POST['visitor_id'];
			echo $object->checkIn($visitor_id, $apartment, $room_id);
			
		} else { // if data not exits or new visitor entry 
			
			$email 		= $_POST['email'];
			$mobile 	= $_POST['mobile'];
			$name  		= $_POST['name'];
			$city  		= $_POST['city'];
			$address 	= $_POST['address'];
			
			$visitor_id = $object->createVisitorProfile($email,$name,$city,$mobile,$address);
			
			if( $visitor_id  )
				echo $object->checkIn($visitor_id, $apartment, $room_id); // check in newly created visitor 
			else
			    echo json_encode(['error' => "Unable To Create Profile",'code'=>404]);
		}
		
		
	}else if ( $_POST['action'] = 'checkout' )
	{
		
		$entryid = $_POST['token'];
		echo $object->checkOut($entryid);
		
	}

}else
{
	echo json_encode(['error'=>"Invalid Request",'code'=>404]);
}



