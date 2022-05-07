<?php
include "database.php";
if(!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 2)
    header("Location:index.php");

$bookings = true;
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <?php include "include_top.php"; ?>
    
</head>
<body>

        <?php include "include_nav.php"; ?>

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Bookings</li>
            </ol>
        </nav>
        <!-- Breadcrumb End -->

        <!-- Table -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Vehicle Model</th>
                    <th scope="col">Vehicle Number</th>
                    <th scope="col">Number of days</th>
                    <th scope="col">Starting from</th>
                </tr>
            </thead>
            <tbody>
            
                <?php
                $query = "SELECT
                            `cars`.`model`,
                            `cars`.`vehicle_number`,
                            `users`.`name`,
                            `bookings`.`days`,
                            `bookings`.`starting_from`
                        FROM
                            `bookings`
                            INNER JOIN `cars` ON `bookings`.`car_id` = `cars`.`car_id`
                            INNER JOIN `users` ON `bookings`.`user_id` = `users`.`user_id`
                        WHERE `cars`.`user_id` = ?;";
                $stmt = $conn -> prepare($query);
                $stmt -> bind_param('i',$_SESSION['user_id']);
                $stmt -> execute();
                $result = $stmt -> get_result();
                $i = 1;
                while($value = $result -> fetch_assoc()){
                    ?>

                    <tr>
                        <td><?=$i++;?></td>
                        <td><?=$value['name'];?></td>
                        <td><?=$value['model'];?></td>
                        <td><?=$value['vehicle_number'];?></td>
                        <td><?=$value['days'];?></td>
                        <td><?=date('d-m-Y',strtotime($value['starting_from']));?></td>
                    </tr>

                    <?php
                }
                $stmt -> close();
                ?>

            </tbody>
        </table>
        <!-- Table End -->

    <?php include "include_bottom.php"; ?>
</body>
</html>