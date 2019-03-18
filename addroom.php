<?php 
// Start the session
session_start();

include './databaseMethods.php';
if(!isset( $_SESSION["userid"]))
    header("location:index.php");

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $roomNo = $_POST['roomNo'];
    $apartmentNo = $_POST['apartmentNo'];
    if( $apartmentNo == 0 )
        $msj ="Please Select Apartment";   
    if( DatabaseMethod::checkRoomAllocation( $apartmentNo, $roomNo ) )
        $msj ="Room Already Allocated";
    else if( DatabaseMethod::addRoom( $apartmentNo, $roomNo, $name ) )
        $msj =" Recoard Added Successfully .";
    else
        $msj =" Error to Add Recoard.";
}

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
                    <h1 class="page-header">New Room</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
           

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Add New Room
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
                                            <label>Select Apartment</label>
                                            <select class="form-control" id="apartment" name="apartmentNo">
                                                <option value="0">Select Apartment</option>
                                             <?php while($row = $result->fetch_assoc()) { ?>
                                                <option value="<?php echo $row['id'];?>"><?php echo $row['id'];?> : <?php echo $row['name'];?></option>
                                             <?php } ?>   
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Room Number</label>
                                            <input class="form-control" name="roomNo">
                                            <p class="help-block">Room Number.</p>
                                        </div>
                                        <div class="form-group">
                                            <label>Person Name</label>
                                            <input class="form-control" name="name">
                                            <p class="help-block">Person Name.</p>
                                        </div>
                                        <input type="hidden" name="submit">
                                        <button type="submit" class="btn btn-default">Add</button>
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

</body>

</html>
