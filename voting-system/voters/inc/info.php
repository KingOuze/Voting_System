<section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-12 col-lg-9 col-xl-7">
        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
          <div class="card-body p-4 p-md-5">
            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Information Personnel</h3>
            <form method="POST">
            <?php
                  $fetchingUser = mysqli_query($db, "SELECT * FROM users WHERE id='".$_SESSION['user_id']."'") or die(mysqli_error());
                  $data = mysqli_fetch_assoc($fetchingUser);
                  $nom = $data['nom'];
                  $prenom = $data['prenom'];
                  $address = $data['address'];
                  $email = $data['email'];
                  
                ?>
              <div class="row">
                <div class="col-md-6 mb-4">

                  <div class="form-outline">
                    <input type="text" name="firstName" class="form-control form-control-lg" value="<?php echo $prenom ?>"/>
                    <label class="form-label" for="firstName">First Name</label>
                  </div>

                </div>
                <div class="col-md-6 mb-4">

                  <div class="form-outline">
                    <input type="text" name="lastName" class="form-control form-control-lg" value="<?php echo $nom ?>"/>
                    <label class="form-label" for="lastName">Last Name</label>
                  </div>

                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-4 d-flex align-items-center">

                  <div class="form-outline datepicker w-100">
                    <input type="text" class="form-control form-control-lg" name="address" value="<?php echo $address ?>" />
                    <label for="address" class="form-label">address</label>
                  </div>

                </div>
                <div class="col-md-6 mb-4">

                <div class="form-outline">
                    <input type="email" name="email" class="form-control form-control-lg" value="<?php echo $email ?>" />
                    <label class="form-label" for="email">Email</label>
                  </div>

                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-4 pb-2">

                  <div class="form-outline">
                    <input type="password" name="password" class="form-control form-control-lg" required/>
                    <label class="form-label" for="password">Password</label>
                  </div>

                </div>
                <div class="col-md-6 mb-4 pb-2">

                  <div class="form-outline">
                    <input type="password" name="su_retype_password" class="form-control form-control-lg" required />
                    <label class="form-label" for="su_retype_password">Confirmation Password</label>
                  </div>

                </div>
              </div>

              <div class="mt-4 pt-2">
                <input class="btn btn-primary btn-lg" name="sign_up_btn" type="submit" value="Valider" />
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php 

    if(isset($_POST['sign_up_btn']))
    {
        $nom = mysqli_real_escape_string($db, $_POST['firstName']);
        $prenom = mysqli_real_escape_string($db, $_POST['lastName']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $address = mysqli_real_escape_string($db, $_POST['address']);
        $su_password = mysqli_real_escape_string($db, md5($_POST['password']));
        $su_retype_password = mysqli_real_escape_string($db, md5($_POST['su_retype_password']));
      

        if($su_password == $su_retype_password)
        {
            mysqli_query($db, "UPDATE users SET nom='". $nom ."', prenom='". $prenom ."', email='". $email ."', address='". $address ."', password='". $su_password ."' WHERE id='".$_SESSION['user_id']."'") or die(mysqli_error($db));

        }else
        {
          ?>
          <script> alert("Erreur lors de l'enrigistrement des données") </script>
      <?php
        }
        ?>
            <script> location.assign("index.php?homePage=1&update=1"); </script>
        <?php

    }
      ?> 