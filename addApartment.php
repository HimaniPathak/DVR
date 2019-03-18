<?php 
// Start the session
session_start();

include './databaseMethods.php';
if(!isset( $_SESSION["userid"]))
    header("location:index.php");

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $apartmentNo = $_POST['apartmentNo'];
    if( DatabaseMethod::checkApartmentAllocation($apartmentNo) )
    {
        $msj ="Apartment Already Allocated";
    }else if( DatabaseMethod::addApartment($apartmentNo,$name) )
        $msj =" Recoard Added Successfully .";
    else
        $msj =" Error to Add Recoard.";
}



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
                    <h1 class="page-header">New Apartment</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
           

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Add New Apartment
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
                                            <label>Apartment Number</label>
                                            <input class="form-control" name="apartmentNo">
                                            <p class="help-block">Apartment Number.</p>
                                        </div>
                                        <div class="form-group">
                                            <label>Apartment Name</label>
                                            <input class="form-control" name="name">
                                            <p class="help-block">Input Apartment Name.</p>
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
