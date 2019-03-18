<?php 
// Start the session
session_start();

include './databaseMethods.php';
if(!isset( $_SESSION["userid"]))
    header("location:index.php");

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $id = $_POST['roomId'];
    
    if( DatabaseMethod::updateRoom($id, $name) )
        $msj ="Recoard Updated Successfully";
    else
        $msj =" Error to Add Recoard.";
}

/* List of Apartments and rooms */
//$rooms      = DatabaseMethod::roomsList();
$apartments = DatabaseMethod::apartmentList();

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
                    <h1 class="page-header">Modify Room</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
           

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Modify Room
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <?php if(isset($msj) ){ ?>
                                <p class="alert alert-success">
                                       <?php echo $msj ;?>
                                       </p>
                                   <?php } ?>
                                   <div class="form-group">
                                        <label>Select Apartment</label>
                                        <select class="form-control" id="apartment">
                                            <option value="0">Select Apartment</option>
                                         <?php while($row = $apartments->fetch_assoc()) { ?>
                                            <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                                         <?php } ?>   
                                        </select>
                                    </div>
                                   <div class="form-group">
                                        <label>Modify Room</label>
                                        <select class="form-control" id="room">
                                            <option value="0">Select Room</option>
                                        </select>
                                    </div>
                                    <form role="form" method="post">
                                        <div class="form-group">
                                            <label>Person Name</label>
                                            <input class="form-control" name="name" id="personName">
                                            <p class="help-block">Person Name.</p>
                                        </div>
                                        <input type="hidden" name="submit">
                                        <input type="hidden" name="roomId" id="roomId">
                                        <button type="submit" class="btn btn-default">Update</button>
                                    </form>
                                </div>
                                
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
           
            
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

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
            var apartmentId = $('#apartment').val();
            $("#roomId").val('');
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
