<?php
include "database.php";
if(!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 2)
    header("Location:index.php");

$car_list = true;
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
                <li class="breadcrumb-item active" aria-current="page">My cars</li>
            </ol>
        </nav>
        <!-- Breadcrumb End -->

        <!-- Table -->
        <a href="car_form.php" class="btn btn-success mb-2">Add car</a>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Vehicle Model</th>
                    <th scope="col">Vehicle Number</th>
                    <th scope="col">Seating Capacity</th>
                    <th scope="col">Rent per day</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            
                <?php
                $query = "SELECT
                        `cars`.`car_id`,
                        `cars`.`model`,
                        `cars`.`vehicle_number`,
                        `cars`.`seating_capacity`,
                        `cars`.`rent`
                    FROM
                        `cars`
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
                        <td><?=$value['model'];?></td>
                        <td><?=$value['vehicle_number'];?></td>
                        <td><?=$value['seating_capacity'];?></td>
                        <td><?=$value['rent'];?></td>
                        <td>
                            <a href="car_form.php?car_id=<?=$value['car_id'];?>" class="btn btn-warning btn-sm">Edit car</a>
                        </td>
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