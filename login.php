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
        <form id="loginForm" class="login-form">
            <div class="form-group">
                <label for="username" class="form-lable">Username</label>
                <input type="text" name="username" id="username" placeholder="Enter username" class="form-control" required validate />
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required validate />
            </div>

            <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>

            <div class="text-center">
                <p>Don't have an account? <a href="register.php">Register</a></p>
            </div>
        </form>
    </div>

    <?php include "include_bottom.php"; ?>

    <script>
        $(() => {
            $(document).on('submit', '#loginForm', function(e){
                e.preventDefault();

                const form = $(document).find("#loginForm");

                if(!form[0].checkValidity()) return alert("All fields are required.");

                $.post('ajax.php',$(form).serialize() + "&action=login",data => {
                    const result = JSON.parse(data);
                    
                    if(!result.success) return alert("Invalid login credentials.")
                    
                    window.location.replace("index.php");
                });
            });
        });
    </script>
    
</body>
</html>