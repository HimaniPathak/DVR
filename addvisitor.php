<?php 
// Start the session
session_start();

include './databaseMethods.php';
if( !isset( $_SESSION["userid"] ) )
    header("location:index.php");

if( isset( $_POST['submit'] ) ) {
    
    $name	= $_POST['name'];
    $email	= $_POST['email'];
    $mobile = $_POST['mobile'];
    $city	= $_POST['city'];
    $address = $_POST['address'];
    $apartmentNo = $_POST['apartmentNo'];
    $roomid = $_POST['room'];  
    
    $otp = DatabaseMethod::prePlanedVisitor($name,$email,$city,$mobile,$address,$apartmentNo,$roomid);
    
    if( $otp )
        $msj ="Visitor Added To Preplaned Visit. Visitor OTP : '$otp'";
    else
        $msj =" Error to Add Recoard";
    
}

$rooms      = DatabaseMethod::roomsList();

$result = DatabaseMethod::apartmentList();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>DVR | Admin Panel</title>

   <?php include "./layouts/style.php"; ?>

</head>

<body>

    <div id="wrapper">

        <?php include "./layouts/navbar.php"; ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Plan Visitor</h1>
                </div>
            </div>
           

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Add New Visitor
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <?php if(isset($msj) ){ ?>
                                <p class="alert alert-success">
                                       <?php echo $msj ;?>
                                       </p>
                                   <?php } ?>
                                    <form role="form" method="post">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input class="form-control" name="name">
                                            <p class="help-block">Name.</p>
                                        </div>
                                        <div class="form-group">
                                            <label>E-mail</label>
                                            <input type="email" class="form-control" name="email">
                                            <p class="help-block">E-mail.</p>
                                        </div>
                                        <div class="form-group">
                                            <label>Mobile</label>
                                            <input class="form-control" name="mobile">
                                            <p class="help-block">Mobile.</p>
                                        </div>
                                        <div class="form-group">
                                            <label>City</label>
                                            <input class="form-control" name="city">
                                            <p class="help-block">City.</p>
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input class="form-control" name="address">
                                            <p class="help-block">Address.</p>
                                        </div>
                                        <div class="form-group">
                                            <label>Modify Apartment</label>
                                            <select class="form-control" id="apartment" name="apartmentNo">
                                                <option value="0">Select Apartment</option>
                                             <?php while($row = $result->fetch_assoc()) { ?>
                                                <option value="<?php echo $row['id'];?>"><?php echo $row['id'];?> : <?php echo $row['name'];?></option>
                                             <?php } ?>   
                                            </select>
                                        </div>
                                        <div class="form-group">
                                        <label>Modify Room</label>
                                        <select class="form-control" id="room" name="room">
                                            <option value="0">Select Room</option>
                                        </select>
                                    </div>
                                        
                                        <input type="hidden" name="submit">
                                        <button type="submit" class="btn btn-default">Add</button>
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            
        </div>
    </div>

    <?php include "./layouts/script.php"; ?>
<script>

        $('#room').on('change',function(){
            var roomId = $('#room').val();
            $("#roomId").val(roomId);
            $.get('/databaseMethods.php',{roomId:roomId,service:"roomsdatabyid"},function(data){
                responceObject = JSON.parse(data);
                $("#personName").val(responceObject.person_name);
            });
            
        })



        $('#apartment').on('change',function(){  
            var apartmentId = $('#apartment').val(); // get selected apartment id 
            $("#roomId").val(''); // blank  rooms list if already filled 
            $("#personName").val('');
            $.get('/databaseMethods.php',{apartmentId:apartmentId,service:"roomsbyapartment"},function(data){ 
                responceObject = JSON.parse(data);
                var roomslist = "<option value='0'>Select Room</option>";
                if( responceObject.istrue != 1 ){
                  $.each(responceObject.data, function (key,val) {
                    roomslist += "<option value='"+val.id+"'>"+val.room_number+" : "+val.person_name+"</option>";
                });  

                }
                $("#room").html(roomslist);                
            });
        })
    </script>
</body>

</html>
