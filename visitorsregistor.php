<?php 
// Start the session
session_start();

include './databaseMethods.php';
if(!isset( $_SESSION["userid"]))
    header("location:index.php");

$result = DatabaseMethod::visitorsRegistorList();

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
   <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <?php include "./layouts/navbar.php"; ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Visitors Registor Entry</h1>
                </div>
            </div>
           

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            All Visitors List
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Visitor Name</th>
                                        <th>Apartment Name</th>
                                        <th>Room No</th>
                                        <th>Visit To</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = $result->fetch_assoc()) { ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo DatabaseMethod::visitorNameById($row['visitor_id']); ?></td>
                                        <td><?php echo DatabaseMethod::apartmentNameById($row['apartment_id']); ?></td>
                                        <td><?php 
                                        echo DatabaseMethod::getRoomById($row['room_id'])['room_number'];
                                         ?></td>
                                         <td><?php 
                                        echo DatabaseMethod::getRoomById($row['room_id'])['person_name'];
                                         ?></td>
                                        <td class="center"><?php echo $row['check_in']!=null? date("j F, Y, g:i a", strtotime( $row['check_in'] ) ):"Not Checkin Yet"; ?></td>
                                        <td class="center"><?php 
                                            echo $row['check_out']==null? "Not Check Out Yet": date("j F, Y, g:i a", strtotime( $row['check_out'] ) );
                                        ?></td>
                                    </tr>
                                   <?php } ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                           
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
     <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>

</body>

</html>
