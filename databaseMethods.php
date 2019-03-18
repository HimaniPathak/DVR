<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once $_SERVER["DOCUMENT_ROOT"].'/vendor/autoload.php';
include $_SERVER["DOCUMENT_ROOT"]."/connection.php";

class DatabaseMethod {

	private $conn;

	function __construct(){	}

	public function sendCheckInMail($visitor_id,$token,$apartmentid) {
				
		$flag = false;
		$email = DatabaseMethod::visitorEmailById($visitor_id);
		$name = DatabaseMethod::visitorNameById($visitor_id);
		$apartmentname = DatabaseMethod::apartmentNameById($apartmentid);
		$mail = new PHPMailer(true);       // Passing `true` enables exceptions
		try {
		    //Server settings
		    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
		    $mail->isSMTP();                                      // Set mailer to use SMTP
		    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		    $mail->SMTPAuth = true;                               // Enable SMTP authentication
		    $mail->Username = 'careerdec78';                 // SMTP username
		    $mail->Password = 'devqioullgszilbs';                           // SMTP password
		    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		    $mail->Port = 587;                                    // TCP port to connect to
		
		    //Recipients
		    $mail->setFrom('admin@dvr.careerdec.com', 'DVR Admin');
		    $mail->addAddress($email);     // Add a recipient
		   
		    $mail->addReplyTo('dvr@dvr.careerdec.com', 'Information');
		    
		    //Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = 'Your Checkout Token For Visit : '.$apartmentname;
		    $mail->Body    = "Hello $name, <br><br> Your Checkout Token For Visit : $apartmentname  is <strong>$token</strong> . <br><br> Thank You <br> Team DVR";
		    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
		
		    $mail->send();
		    $flag = true;
		} catch (Exception $e) { }	
		
		return $flag; 
	}
	
	public function sendMail($email,$otp,$apartmentid){
				
		$flag = flase;	
		$apartmentname = DatabaseMethod::apartmentNameById($apartmentid);
		$mail = new PHPMailer(true);       // Passing `true` enables exceptions
		try {
		    //Server settings
		    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
		    $mail->isSMTP();                                      // Set mailer to use SMTP
		    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		    $mail->SMTPAuth = true;                               // Enable SMTP authentication
		    $mail->Username = 'careerdec78';                 // SMTP username
		    $mail->Password = 'devqioullgszilbs';                           // SMTP password
		    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		    $mail->Port = 587;                                    // TCP port to connect to
		
		    //Recipients
		    $mail->setFrom('admin@dvr.careerdec.com', 'DVR Admin');
		    $mail->addAddress($email);     // Add a recipient
		   
		    $mail->addReplyTo('dvr@dvr.careerdec.com', 'Information');
		    
		   
		    //Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = 'Your One Time Password To Visit : '.$apartmentname;
		    $mail->Body    = "Hello $name, <br><br> Your One Time Password To Visit : $apartmentname  is <strong>$otp</strong> . <br><br> Thank You <br> Team DVR";
		    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
		
		    $mail->send();
		    $flag = true;
		} catch (Exception $e) { }	
		
		return $flag; 
	}
	
	public function addApartment($no,$name){

		$connectionInstant = DtabaseConnection::connectDB();

		$sql = "INSERT INTO `apartment`(`apartment_no`,`name`) VALUES ('$no','$name')";
		
		$result = $connectionInstant->query($sql);
		$connectionInstant->close();

		return true;
		
	} 

	public function addRoom($apartmentNo,$roomNo,$name){

		$connectionInstant = DtabaseConnection::connectDB();

		$sql = "INSERT INTO `rooms`(`apartment_id`,`room_number`,`person_name`) VALUES ('$apartmentNo','$roomNo','$name')";
		
		$result = $connectionInstant->query($sql);
		$connectionInstant->close();

		return true;
	}

	public function updateapartment($id,$no,$name){

		$connectionInstant = DtabaseConnection::connectDB();

		$sql = "UPDATE `apartment` SET `name`='$name',`apartment_no`='$no' WHERE `id`='$id'";
		$result = $connectionInstant->query($sql);
		$connectionInstant->close();

		return true;
	}

	public  function visitorsCount() {
		$connectionInstant = DtabaseConnection::connectDB();
		$sql = "select COUNT(id) as count from t_visitorinformation";
		$result = $connectionInstant->query($sql);
		$connectionInstant->close();
		return  $result->fetch_assoc()['count'];
	}

	public  function apartmentCount() {
		$connectionInstant = DtabaseConnection::connectDB();
		$sql = "select COUNT(id) as count from apartment";
		$result = $connectionInstant->query($sql);
		$connectionInstant->close();
		return  $result->fetch_assoc()['count'];
	}


	public  function visitorsRegisterCount() {
		$connectionInstant = DtabaseConnection::connectDB();
		$sql = "select COUNT(id) as count from t_visitorinformationhist where MONTH(created_at) =  MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";
		$result = $connectionInstant->query($sql);
		$connectionInstant->close();
		return  $result->fetch_assoc()['count'];
	}

	public function visitorsList() {
		$connectionInstant = DtabaseConnection::connectDB();

		$sql = "select * from t_visitorinformation";
		$result = $connectionInstant->query($sql);
		$connectionInstant->close();
		return  $result;
	}
	
	public function roomsList() {
		$connectionInstant = DtabaseConnection::connectDB();
		$sql = "select * from rooms";
		$result = $connectionInstant->query($sql);
		$connectionInstant->close();
		return  $result;
	}
	

	public function visitorsListPreplaned() {
		$connectionInstant = DtabaseConnection::connectDB();

		$sql = "select * from t_visitorinformation where `otp`  IS NOT NULL";
		$result = $connectionInstant->query($sql);
		$connectionInstant->close();
		return  $result;
	}

	public function visitorsRegistorList() {
		$connectionInstant = DtabaseConnection::connectDB();

		$sql = "select * from t_visitorinformationhist";
		$result = $connectionInstant->query($sql);
		$connectionInstant->close();
		return  $result;
	}

	public function apartmentList() {
		$connectionInstant = DtabaseConnection::connectDB();

		$sql = "select * from apartment";
		$result = $connectionInstant->query($sql);
		$connectionInstant->close();
		return  $result;
	}

	public function visitorNameById($id) {
		$connectionInstant = DtabaseConnection::connectDB();

		$sql = "select * from t_visitorinformation where `id`='$id'";
		$result = $connectionInstant->query($sql);
		$connectionInstant->close();
		return $result->fetch_assoc()['name'];
	}
	
	public function visitorEmailById($id) {
		$connectionInstant = DtabaseConnection::connectDB();

		$sql = "select * from t_visitorinformation where `id`='$id'";
		$result = $connectionInstant->query($sql);
		$connectionInstant->close();
		return $result->fetch_assoc()['email'];
	}
	public function apartmentNameById($id) {
		$connectionInstant = DtabaseConnection::connectDB();

		$sql = "select * from apartment where `id`='$id'";
		$result = $connectionInstant->query($sql);
		$connectionInstant->close();
		return $result->fetch_assoc()['name'];
	}
	
	public function apartmentNumberById($id) {
		$connectionInstant = DtabaseConnection::connectDB();

		$sql = "select * from apartment where `id`='$id'";
		$result = $connectionInstant->query($sql);
		$connectionInstant->close();
		return $result->fetch_assoc()['apartment_no'];
	}

	public function getapartment($id) {
		$connectionInstant = DtabaseConnection::connectDB();

		$sql = "select * from apartment where `id`='$id'";
		$result = $connectionInstant->query($sql);
		$connectionInstant->close();
		return json_encode($result->fetch_assoc());	
	}

	

	public function checkApartmentAllocation($number) {
		$connectionInstant = DtabaseConnection::connectDB();

		$sql = "SELECT * FROM apartment where `apartment_no` = '$number' LIMIT 1";
		$result = $connectionInstant->query($sql);
		$connectionInstant->close();
		
		if ($result->num_rows > 0)
		    return true;
		else
			return false;
	}
	
	public function checkRoomAllocation($apartmentNo,$roomNo) {

		$connectionInstant = DtabaseConnection::connectDB();

		$sql = "SELECT * FROM rooms where `apartment_id` = '$apartmentNo' AND `room_number` = '$roomNo' LIMIT 1";
		$result = $connectionInstant->query($sql);
		$connectionInstant->close();
		
		if ($result->num_rows > 0)
		    return true;
		else
			return false;

	}
	public function prePlanedVisitor($name,$email,$city,$mobile,$address,$apartment,$roomid ) {
		
		$connectionInstant = DtabaseConnection::connectDB();
		$otp = rand(0,999); // random integer between 0 and 999
		$sql = "INSERT INTO t_visitorinformation(`email`,`name`,`city`,`mobile`,`address`,`otp`) VALUES('$email','$name','$city','$mobile','$address','$otp')";
		$result = $connectionInstant->query($sql);
		$visitor_id =  $connectionInstant->insert_id;
		
		$sql ="INSERT INTO t_visitorinformationhist(`visitor_id`,`apartment_id`,`room_id`) VALUES('$visitor_id','$apartment','$roomid')";
		
		$result = $connectionInstant->query($sql);
		$connectionInstant->close();
		
		// here we have to send genrated otp on mail 
		
		
		if ( DatabaseMethod::sendMail($email,$otp,$apartment) )
			
			return $otp;
		 else 
			return $otp." | Error in sending mail ";
		

	}

	public function getRoomsByApartment( $id ) {
		$connectionInstant = DtabaseConnection::connectDB();
		$sql = "SELECT * FROM `rooms` WHERE `apartment_id` = '$id'";
		$result = $connectionInstant->query($sql);
		$connectionInstant->close();
		$resResult['istrue'] = 0;
		if( isset($result->num_rows) && $result->num_rows > 0 ) {
			while( $row = $result->fetch_assoc() ) {
				$resResult['data'][] = $row;
			}
		}
		else{
			$resResult['istrue'] = 1;
		}	
		return  json_encode($resResult);		
	}

	public function getRoomById($id) {
		$connectionInstant = DtabaseConnection::connectDB();
		$sql = "SELECT * FROM `rooms` WHERE `id` = '$id'";
		$result = $connectionInstant->query($sql);
		$connectionInstant->close();
		$resResult = $result->fetch_assoc();  
		return  json_encode($resResult);	
	}
	
	public function updateRoom($id, $name) {
		$connectionInstant = DtabaseConnection::connectDB();
		$sql = "UPDATE `rooms` SET `person_name`='$name' WHERE `id` = '$id'";
		$result = $connectionInstant->query($sql);
		$connectionInstant->close();
		return  true;	
	}
}

/* Services Routes  */
if( isset( $_GET['service'] ) ) {
	switch ($_GET['service']) {
		case 'roomsbyapartment':
			$id = $_GET['apartmentId'];
			echo  DatabaseMethod::getRoomsByApartment($id);	
			break;
		case 'roomsdatabyid':
			$id = $_GET['roomId'];
			echo  DatabaseMethod::getRoomById($id);	
			break;
		default:
			# code...
			break;
	}
	
}else if( isset( $_GET['apartmentId'] ) ) {
	$id = $_GET['apartmentId'];
	$apartment =  DatabaseMethod::getapartment($id);
	echo $apartment;
}
