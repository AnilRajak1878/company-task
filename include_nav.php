<!-- Navbar -->
<nav class="navbar navbar-light navbar-expand-sm bg-light justify-content-between navbar-fixed">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">Navbar</a>
    <div class="collapse navbar-collapse" style="justify-content: right;" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item <?=(isset($home) ? 'active' : '');?>">
                <a class="nav-link" href="index.php">Home <?=(isset($home) ? '<span class="sr-only">(current)</span>' : '');?></a>
            </li>

            <?php if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
                if($_SESSION['user_type'] == 2){ ?>

                <li class="nav-item <?=(isset($car_list) ? 'active' : '');?>">
                    <a class="nav-link" href="cars_list.php">My cars <?=(isset($car_list) ? '<span class="sr-only">(current)</span>' : '');?></a>
                </li>
                
                <li class="nav-item <?=(isset($bookings) ? 'active' : '');?>">
                    <a class="nav-link" href="booking.php">Bookings <?=(isset($bookings) ? '<span class="sr-only">(current)</span>' : '');?></a>
                </li>

                <?php } ?>

                <li class="nav-item">
                    <a class="nav-link" href="javascript:;" onclick="logout()">Logout (<?=$_SESSION['name'];?>)</a>
                </li>

            <?php } else{ ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>
<!-- Navbar End -->