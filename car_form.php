<?php
include "database.php";
if(!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 2)
    header("Location:index.php");

$model = "";
$vehicle_number = "";
$seating_capacity = "";
$rent = "";

$action = "save_car";

if(isset($_GET['car_id'])){
    $car_id = $_GET['car_id'];
    $action = "update_car&car_id=".$car_id;

    $query = "SELECT * FROM cars WHERE car_id = ? AND user_id = ?;";
    $stmt = $conn -> prepare($query);
    $stmt -> bind_param('ii',$car_id, $_SESSION['user_id']);
    $stmt -> execute();
    $result = $stmt -> get_result();
    if($result -> num_rows != 1) header("Location:cars_list.php");

    $value = $result -> fetch_assoc();

    $model = $value['model'];
    $vehicle_number = $value['vehicle_number'];
    $seating_capacity = $value['seating_capacity'];
    $rent = $value['rent'];

    $stmt -> close();
}


$car_list = true;
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <?php include "include_top.php"; ?>
    
</head>
<body>

        <?php include "include_nav.php"; ?>

        <div class="card">
            <div class="card-body">
                <form id="carForm">

                    <div class="form-group">
                        <label for="model" class="form-label">Vehicle Model</label>
                        <input type="text" name="model" id="model" placeholder="Enter Model" value="<?=$model;?>" class="form-control" required validate />
                    </div>
                    
                    <div class="form-group">
                        <label for="vehicle_number" class="form-label">Vehicle Number</label>
                        <input type="text" name="vehicle_number" id="vehicle_number" placeholder="Enter vehicle number" value="<?=$vehicle_number;?>" class="form-control" required validate />
                    </div>
                    
                    <div class="form-group">
                        <label for="seating_capacity" class="form-label">Seating Capacity</label>
                        <input type="number" name="seating_capacity" id="seating_capacity" placeholder="Enter seating capacity" value="<?=$seating_capacity;?>" class="form-control" required validate />
                    </div>
                    
                    <div class="form-group">
                        <label for="rent" class="form-label">Ren per day</label>
                        <input type="number" name="rent" id="rent" placeholder="Enter rent" value="<?=$rent;?>" class="form-control" required validate />
                    </div>

                    <div class="form-group">
                        <button class="btn btn-success">Save</button>
                    </div>

                </form>
            </div>
        </div>
    

    <?php include "include_bottom.php"; ?>

    <script>
        $(document).on("submit","#carForm",function(e){
            e.preventDefault();

            const form = $(document).find("#carForm");

            if(!form[0].checkValidity()) return alert("All fields are required");
            
            $.post('ajax.php',$(form).serialize() + "&action=<?=$action;?>", data => {
                const result = JSON.parse(data);

                if(!result.success) return alert(result.error);

                window.location.replace('cars_list.php');
            });
        });
    </script>
</body>
</html>