<?php
include "database.php";

function login($conn,$username,$password){
    $query = "SELECT
            `users`.`user_id`,
            `users`.`user_type`,
            `users`.`name`
        FROM
            `users`
        WHERE
            `users`.`username` = ? AND
            `users`.`password` = ?;";
    $stmt = $conn -> prepare($query);
    $stmt -> bind_param('ss', $username, $password);
    $stmt -> execute();
    $result = $stmt -> get_result();
    if($result -> num_rows == 1){
        $value = $result -> fetch_assoc();
        $_SESSION['user_id'] = $value['user_id'];
        $_SESSION['name'] = $value['name'];
        $_SESSION['user_type'] = $value['user_type'];
        return true;
    }
    return false;
}

$data = ['success' => false];

if(isset($_POST['action']) && $_POST['action'] != ""){

    if($_POST['action'] == "login")
        $data['success'] = login($conn,$_POST['username'], $_POST['password']);
        
    else if($_POST['action'] == "register"){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $user_type = $_POST['user_type'];

        $query = "SELECT * FROM users WHERE username = ?;";
        $stmt = $conn -> prepare($query);
        $stmt -> bind_param('s', $username);
        $stmt -> execute();
        $result = $stmt -> get_result();
        if($result -> num_rows > 0) $data['username_exist'] = true;
        else{
            $register_query = "INSERT INTO users(user_type,username,password,name) VALUES(?,?,?,?);";
            $register_stmt = $conn -> prepare($register_query);
            $register_stmt -> bind_param('isss',$user_type,$username,$password,$name);
            $register_stmt -> execute();
            $register_stmt -> close();

            $data['success'] = login($conn,$username,$password);
        }
        $stmt -> close();
    }

    else if($_POST['action'] == "logout") session_destroy();

    else if($_POST['action'] == "save_car" && isset($_SESSION['user_type']) && $_SESSION['user_type'] == 2){
        $user_id = $_SESSION['user_id'];
        $model = $_POST['model'];
        $vehicle_number = $_POST['vehicle_number'];
        $seating_capacity = $_POST['seating_capacity'];
        $rent = $_POST['rent'];

        $query = "INSERT INTO cars(model,vehicle_number,seating_capacity,rent,user_id) VALUES(?,?,?,?,?);";
        $stmt = $conn -> prepare($query);
        $stmt -> bind_param('ssidi',$model,$vehicle_number,$seating_capacity,$rent,$user_id);
        $stmt -> execute();
        if($stmt -> affected_rows == 1) $data['success'] = true;
        else $data['error'] = "Some error occured! Try again.";
        $stmt -> close();
    }

    else if($_POST['action'] == "update_car" && isset($_SESSION['user_type']) && $_SESSION['user_type'] == 2){
        $user_id = $_SESSION['user_id'];
        $model = $_POST['model'];
        $vehicle_number = $_POST['vehicle_number'];
        $seating_capacity = $_POST['seating_capacity'];
        $rent = $_POST['rent'];
        $car_id = $_POST['car_id'];

        $query = "UPDATE cars SET model = ?, vehicle_number = ?, seating_capacity = ?, rent =  ?
                WHERE user_id = ? AND car_id = ?;";
        $stmt = $conn -> prepare($query);
        $stmt -> bind_param('ssidii',$model,$vehicle_number,$seating_capacity,$rent,$user_id,$car_id);
        $stmt -> execute();
        if($stmt -> affected_rows == 1) $data['success'] = true;
        else $data['error'] = "Car not found! Try again.";
        $stmt -> close();
    }

    else if($_POST['action'] == "book_car" && isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1){
        $user_id = $_SESSION['user_id'];
        $car_id = $_POST['car_id'];
        $starting_from = $_POST['starting_from'];
        $days = $_POST['days'];

        $query = "INSERT INTO bookings(user_id,car_id,days,starting_from) VALUES(?,?,?,?);";
        $stmt = $conn -> prepare($query);
        $stmt -> bind_param('iiis',$user_id,$car_id,$days,$starting_from);
        $stmt -> execute();
        if($stmt -> affected_rows == 1) $data['success'] = true;

        $stmt -> close();
    }

}

echo json_encode($data);