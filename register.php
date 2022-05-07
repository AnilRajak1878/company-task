<?php
include "database.php";
if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']))
    header('Location: index.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <?php include "include_top.php"; ?>

</head>
<body>

    <div class="form-container">
        <form id="registerForm" class="login-form">
            <div class="form-group">
                <label for="name" class="form-lable">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter name" class="form-control" required validate />
            </div>
            <div class="form-group">
                <label for="user_type" class="form-lable">Registration type</label>
                <select name="user_type" id="user_type" class="form-control" required validate>
                    <option value="1">Customer</option>
                    <option value="2">Car renting agency</option>
                </select>
            </div>
            <div class="form-group">
                <label for="username" class="form-lable">Username</label>
                <input type="text" name="username" id="username" placeholder="Enter username" class="form-control" required validate />
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required validate />
            </div>

            <button type="submit" class="btn btn-primary btn-block mb-4">Register</button>

            <div class="text-center">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>

    <?php include "include_bottom.php"; ?>
    <script>
        $(() => {
            $(document).on('submit', '#registerForm', function(e){
                e.preventDefault();

                const form = $(document).find("#registerForm");

                if(!form[0].checkValidity()) return alert("All fields are required.");

                $.post('ajax.php',$(form).serialize() + "&action=register",data => {
                    const result = JSON.parse(data);
                    
                    if(!result.success && result.username_exist) return alert("Username taken! Try another usrname.");
                    else if(!result.success) return alert("Some error occured! Try again.");
                    
                    window.location.replace("index.php");
                });
            });
        });
    </script>

</body>
</html>