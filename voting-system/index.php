<?php 
    require_once("admin/inc/config.php");

    $fetchingElections = mysqli_query($db, "SELECT * FROM elections") OR die(mysqli_error($db));
    while($data = mysqli_fetch_assoc($fetchingElections))
    {
        $starting_date = $data['starting_date'];
        $ending_date = $data['ending_date'];
        $curr_date = date("Y-m-d");
        $election_id = $data['id'];
        $status = $data['status'];

        

        if($status == "pending")
        {
            $date1=date_create($curr_date);
            $date2=date_create($starting_date);
            
            if($date1 >= $date2)
            {
                // Update! 
                mysqli_query($db, "UPDATE elections SET status = 'start' WHERE id = '". $election_id ."'") OR die(mysqli_error($db));
            }
        }
        else if($status == "start")
        {
            $date1=date_create($curr_date);
            $date2=date_create($ending_date);
            
            if($date1 >= $date2)
            {
                // Update! 
                mysqli_query($db, "UPDATE elections SET status = 'closed' WHERE id = '". $election_id ."'") OR die(mysqli_error($db));
            }
        }
        

    }
?>


<!DOCTYPE html>
<html>
<head>
	<title>Login - Online Voting System</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
	<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="user_card">
				<div class="d-flex justify-content-center">
					<div class="brand_logo_container">
						<img src="assets/images/logo.gif" class="brand_logo" alt="Logo">
					</div>
				</div>

                <?php 
                    if(isset($_GET['sign-up']))
                    {
                ?>
                        <div class="d-flex  form_container">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" name="nom" class="form-control input_user" placeholder="Nom" required />
                                </div>
                                <div class="input-group mb-2">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" name="prenom" class="form-control input_user" placeholder="Prenom" required />
                                </div>
                                <div class="input-group mb-2">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="Email" name="su_username" class="form-control input_user" placeholder="Email" required />
                                </div>
                                <div class="input-group mb-2">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="bi bi-camera-fill"></i></span>
                                    </div>
                                    <input type="file" name="user_photo" class="form-control" required />
                                </div>
                                <div class="input-group mb-2">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="bi bi-house-door-fill"></i></span>
                                    </div>
                                    <input type="text" name="su_contact_no" class="form-control input_pass" placeholder="Address" required />
                                </div>
                                <div class="input-group mb-2">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" name="su_password" class="form-control input_pass" placeholder="Password" required />
                                </div>     
                                <div class="input-group mb-2">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" name="su_retype_password" class="form-control input_pass" placeholder="Retype Password" required />
                                </div>
                                
                                <div class="d-flex justify-content-center mt-3 login_container">
                                    <button type="submit" name="sign_up_btn" class="btn login_btn">Sign Up</button>
                                </div>
                            </form>
                        </div>
                
                        <div class="mt-4">
                            <div class="d-flex justify-content-center links text-white">
                                Already Created Account? <a href="index.php" class="ml-2 text-white">Sign In</a>
                            </div>
                        </div>
                <?php
                    }else {
                ?>
                        <div class="d-flex justify-content-center form_container">
                            <form method="POST">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="email" name="contact_no" class="form-control input_user" placeholder="Email" required />
                                </div>
                                <div class="input-group mb-2">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" name="password" class="form-control input_pass" placeholder="Password" required />
                                </div>
                                    <div class="d-flex justify-content-center mt-3 login_container">
                            <button type="submit" name="loginBtn" class="btn login_btn">Login</button>
                        </div>
                            </form>   
                        </div>
                
                        <div class="mt-4">
                            <div class="d-flex justify-content-center links text-white">
                                Don't have an account? <a href="?sign-up=1" class="ml-2 text-white">Sign Up</a>
                            </div>
                            <div class="d-flex justify-content-center links">
                                <a href="#" class="text-white">Forgot your password?</a>
                            </div>
                        </div>
                <?php
                    }
                    
                ?>
                <?php 
                    if(isset($_GET['added']))
                    {
                ?>
                        <div class="alert alert-success my-3" role="alert">
                            User has been added successfully.
                        </div>
                <?php 
                    }else if(isset($_GET['largeFile'])) {
                ?>
                        <div class="alert alert-danger my-3" role="alert">
                            User image is too large, please upload small file (you can upload any image upto 2mbs.).
                        </div>
                <?php
                    }else if(isset($_GET['invalidFile']))
                    {
                ?>
                        <div class="alert alert-danger my-3" role="alert">
                            Invalid image type (Only .jpg, .png files are allowed) .
                        </div>
                <?php
                    }else if(isset($_GET['failed']))
                    {
                ?>
                        <div class="alert alert-danger my-3" role="alert">
                            Image uploading failed, please try again.
                        </div>
                <?php
                    }

                ?>

                <?php 
                    if(isset($_GET['registered']))
                    {
                ?>
                        <span class="bg-white text-success text-center my-3"> Your account has been created successfully! </span>
                <?php
                    }else if(isset($_GET['invalid'])) {
                ?>
                        <span class="bg-white text-danger text-center my-3"> Passwords mismatched, please try again! </span>
                <?php
                    }else if(isset($_GET['not_registered'])) {
                ?>
                        <span class="bg-white text-warning text-center my-3"> Sorry, you are not registered! </span>
                <?php
                    }else if(isset($_GET['invalid_access'])) {
                ?>
                        <span class="bg-white text-danger text-center my-3"> Invalid username or password! </span>
                <?php
                    }
                ?>
                       
			</div>
		</div>
	</div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

</body>
</html>

<?php 
    require_once("admin/inc/config.php");

    if(isset($_POST['sign_up_btn']))
    {
        $nom = mysqli_real_escape_string($db, $_POST['nom']);
        $prenom = mysqli_real_escape_string($db, $_POST['prenom']);
        $su_username = mysqli_real_escape_string($db, $_POST['su_username']);
        $su_contact_no = mysqli_real_escape_string($db, $_POST['su_contact_no']);
        $su_password = mysqli_real_escape_string($db, md5($_POST['su_password']));
        $su_retype_password = mysqli_real_escape_string($db, md5($_POST['su_retype_password']));
        $user_role = "Voter"; 
        
        //Logical Image
        
        $targetted_folder = "/assets/images/user_photos/";
        $user_photo = $targetted_folder.rand(11111111, 99999999). $_FILES['user_photo']['name'];
        $user_photo_tmp_name = $_FILES['user_photo']['tmp_name'];
        $user_photo_type = strtolower(pathinfo($user_photo, PATHINFO_EXTENSION));
        $allowed_types = array("jpg", "png", "jpeg");        
        $image_size = $_FILES['user_photo']['size'];

        //echo "<script> console.log('".$user_photo_tmp_name."'); </script>";
       
        if($su_password == $su_retype_password)
        {
           
             
            if($image_size < 2000000) // 2 MB
            {

                
                if(in_array($user_photo_type, $allowed_types))
                {
                    if(move_uploaded_file($user_photo_tmp_name, __DIR__ .$user_photo))
                    {
                        // inserting into db
                        mysqli_query($db, "INSERT INTO users(nom, prenom, email, address, password, user_photo, user_role) 
                        VALUES('". $nom ."','". $prenom ."','". $su_username ."', '". $su_contact_no ."', '". $su_password ."','". $user_photo ."','". $user_role ."')") or die(mysqli_error($db));

                        echo "<script> location.assign('?added=1'); </script>";


                    }else {
                        //echo "<script> location.assign('?failed=1'); </script>";                    
                    }
                }else {
                   echo "<script> location.assign('?invalidFile=1'); </script>";
                }
            }else {
                echo "<script> location.assign('?largeFile=1'); </script>";
                }
        }
             
    }else if(isset($_POST['loginBtn']))
    {

        $contact_no = mysqli_real_escape_string($db, $_POST['contact_no']);
        $password = mysqli_real_escape_string($db, md5($_POST['password']));
        

        // Query Fetch / SELECT
        $fetchingData = mysqli_query($db, "SELECT * FROM users WHERE email = '". $contact_no ."'") or die(mysqli_error($db));
    
        
        if(mysqli_num_rows($fetchingData) > 0)
        {
            $data = mysqli_fetch_assoc($fetchingData);

            if($contact_no == $data['email'] AND $password == $data['password'])
            {
                session_start();
                $_SESSION['user_role'] = $data['user_role'];
                $_SESSION['username'] = $data['prenom'];
                $_SESSION['nom'] = $data['nom'];
                $_SESSION['user_id'] = $data['id'];
                
                if($data['user_role'] == "Admin")
                {
                    $_SESSION['key'] = "AdminKey";
            ?>
                    <script> location.assign("admin/index.php?homepage=1"); </script>
            <?php
                }else {
                    $_SESSION['key'] = "VotersKey";
            ?>
                    <script> location.assign("voters/index.php?homePage=1"); </script>
            <?php
                }

            }else {
        ?>
                <script> location.assign("index.php?invalid_access=1"); </script>
        <?php
            }


        }else {
    ?>
            <script> location.assign("index.php?sign-up=1&not_registered=1"); </script>
    <?php

        }

    }

?>