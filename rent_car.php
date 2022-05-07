<?php
include "database.php";
$home = true;

$car_id = $_GET['car_id'];
$query = "SELECT * FROM cars WHERE car_id = ?;";
$stmt = $conn -> prepare($query);
$stmt -> bind_param('i', $car_id);
$stmt -> execute();
$result = $stmt -> get_result();
if($result -> num_rows != 1)
    header("Location:login.php");
$car = $result -> fetch_assoc();
$stmt -> close();

if(!isset($_SESSION['user_id']) && empty($_SESSION['user_id']))
    header("Location:login.php");

if($_SESSION['user_type'] == 2){
    ?>
    <script>
        alert("You are not allowed to book a car. You are an agency");
        window.location.replace("index.php");
    </script>
    <?php
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <?php include "include_top.php"; ?>
    
</head>
<body>

        <?php include "include_nav.php"; ?>
        
        <div class="container">
            <div class="card mt-2">
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Vehicle Model</th>
                            <td><?=$car['model'];?></td>
                            <th>Vehicle Number</th>
                            <td><?=$car['vehicle_number'];?></td>
                        </tr>
                        <tr>
                            <th>Seating Capacity</th>
                            <td><?=$car['seating_capacity'];?></td>
                            <th>Rent per day</th>
                            <td><?=$car['rent'];?></td>
                        </tr>
                    </table>

                    <form id="bookingForm">

                        <input type="hidden" name="car_id" value="<?=$car_id;?>" id="car_id">
                        
                        <div class="form-group">
                            <label for="days" class="form-label">Number of days</label>
                            <input type="number" name="days" id="day" placeholder="Enter no of days" class="form-control" required validate />
                        </div>

                        <div class="form-group">
                            <label for="starting_from" class="form-label">Starting from</label>
                            <input type="date" name="starting_from" id="starting_from" class="form-control" required validate />
                        </div>

                        <div class="form-group">
                            <button class="btn btn-success">Book</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>


    <?php include "include_bottom.php"; ?>

    <script>
        $(document).on("submit","#bookingForm",function(e){
            e.preventDefault();

            const form = $(document).find("#bookingForm");

            if(!form[0].checkValidity()) return alert("All fields are required.");

            $.post('ajax.php', $(form).serialize() + "&action=book_car", data => {
                const result = JSON.parse(data);

                if(!result.success) return alert("Some error occured! Try again.");
                alert("Booking successful");
                window.location.replace("index.php");
            });
        });
    </script>

</body>
</html>